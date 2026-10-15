<?php

namespace App\Http\Controllers;

use App\Enums\MemberStatus;
use App\Models\Member;
use App\Models\MembershipTier;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::with('tier')->latest();

        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $members = $query->paginate(20)->withQueryString();

        return view('members.index', compact('members'));
    }

    public function create()
    {
        $tiers = MembershipTier::active()->ordered()->get();

        return view('members.form', [
            'member' => new Member(),
            'tiers' => $tiers,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
            'tier_id' => 'nullable|exists:membership_tiers,id',
            'notes' => 'nullable|string',
        ]);

        $data['status'] = MemberStatus::Active;
        $data['joined_at'] = now();

        // Default tier = lowest
        if (empty($data['tier_id'])) {
            $data['tier_id'] = MembershipTier::active()
                ->orderBy('min_lifetime_points')
                ->value('id');
        }

        $member = Member::create($data);

        return redirect()
            ->route('members.show', $member)
            ->with('success', "Member {$member->code} berhasil didaftarkan.");
    }

    public function show(Member $member)
    {
        $member->load(['tier']);

        $pointHistory = $member->pointTransactions()
            ->latest()
            ->limit(30)
            ->get();

        $sales = $member->sales()->latest()->limit(10)->get();
        $redemptions = $member->redemptions()->with('reward')->latest()->limit(10)->get();

        return view('members.show', compact('member', 'pointHistory', 'sales', 'redemptions'));
    }

    public function edit(Member $member)
    {
        $tiers = MembershipTier::active()->ordered()->get();

        return view('members.form', compact('member', 'tiers'));
    }

    public function update(Request $request, Member $member)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
            'tier_id' => 'nullable|exists:membership_tiers,id',
            'status' => 'required|in:active,inactive,suspended',
            'notes' => 'nullable|string',
        ]);

        $member->update($data);

        return redirect()
            ->route('members.show', $member)
            ->with('success', 'Data member diupdate.');
    }

    /**
     * API / AJAX: cari member untuk kasir
     */
    public function search(Request $request)
    {
        $q = $request->get('q', '');

        if (strlen($q) < 2) {
            return response()->json(['data' => []]);
        }

        $members = Member::with('tier')
            ->active()
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%")
                    ->orWhere('code', 'like', "%{$q}%");
            })
            ->limit(10)
            ->get()
            ->map(fn (Member $m) => [
                'id' => $m->id,
                'code' => $m->code,
                'name' => $m->name,
                'phone' => $m->phone,
                'points' => $m->points_balance,
                'tier' => $m->tier?->name,
                'multiplier' => $m->tier?->point_multiplier ?? 1,
            ]);

        return response()->json(['data' => $members]);
    }
}
