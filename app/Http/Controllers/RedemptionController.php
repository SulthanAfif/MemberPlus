<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Redemption;
use App\Models\Reward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RedemptionController extends Controller
{
    /**
     * Form tukar reward (kasir / admin)
     */
    public function create(Request $request)
    {
        $rewards = Reward::available()->orderBy('sort_order')->orderBy('points_cost')->get();
        $member = $request->member_id
            ? Member::with('tier')->find($request->member_id)
            : null;

        return view('redemptions.create', compact('rewards', 'member'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'member_id' => 'required|exists:members,id',
            'reward_id' => 'required|exists:rewards,id',
            'notes' => 'nullable|string|max:255',
        ]);

        $member = Member::findOrFail($data['member_id']);
        $reward = Reward::findOrFail($data['reward_id']);

        if ($member->status->value !== 'active') {
            return back()->with('error', 'Member tidak aktif.')->withInput();
        }

        if (!$reward->is_active || !$reward->hasStock()) {
            return back()->with('error', 'Reward tidak tersedia.')->withInput();
        }

        if ($member->points_balance < $reward->points_cost) {
            return back()->with('error', 'Poin member tidak cukup.')->withInput();
        }

        DB::transaction(function () use ($member, $reward, $data, $request) {
            $member->redeemPoints(
                $reward->points_cost,
                "Tukar reward: {$reward->name}",
                $reward->id,
                $request->user()?->id
            );

            if ($reward->stock !== null) {
                $reward->decrement('stock');
            }

            Redemption::create([
                'member_id' => $member->id,
                'reward_id' => $reward->id,
                'points_spent' => $reward->points_cost,
                'status' => 'completed',
                'notes' => $data['notes'] ?? null,
                'user_id' => $request->user()?->id,
                'redeemed_at' => now(),
            ]);
        });

        $member->refresh();

        return redirect()
            ->route('redemptions.create', ['member_id' => $member->id])
            ->with('success', "Berhasil tukar \"{$reward->name}\". Sisa poin: {$member->points_balance}");
    }

    public function index()
    {
        $redemptions = Redemption::with(['member', 'reward'])
            ->latest()
            ->paginate(20);

        return view('redemptions.index', compact('redemptions'));
    }
}
