<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Sale;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Halaman kasir — catat belanja + poin
     */
    public function create()
    {
        return view('sales.create');
    }

    /**
     * Proses transaksi → hitung & tambah poin
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'member_id' => 'required|exists:members,id',
            'amount' => 'required|integer|min:1000',
            'invoice_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:255',
        ]);

        $member = Member::with('tier')->findOrFail($data['member_id']);

        if ($member->status->value !== 'active') {
            return back()->with('error', 'Member tidak aktif.')->withInput();
        }

        $rupiahPerPoint = (int) (Setting::get('rupiah_per_point', 10000));
        $multiplier = (float) ($member->tier?->point_multiplier ?? 1);
        $points = Sale::calculatePoints($data['amount'], $multiplier, $rupiahPerPoint);

        $sale = DB::transaction(function () use ($data, $member, $points, $request) {
            $sale = Sale::create([
                'member_id' => $member->id,
                'invoice_number' => $data['invoice_number'] ?? null,
                'amount' => $data['amount'],
                'points_earned' => $points,
                'notes' => $data['notes'] ?? null,
                'user_id' => $request->user()?->id,
            ]);

            if ($points > 0) {
                $member->addPoints(
                    $points,
                    "Belanja Rp " . number_format($data['amount'], 0, ',', '.') .
                        ($data['invoice_number'] ? " ({$data['invoice_number']})" : ''),
                    $sale->id,
                    $request->user()?->id
                );
            }

            return $sale;
        });

        $member->refresh();

        return redirect()
            ->route('sales.create')
            ->with('success', "Poin +{$points} untuk {$member->name}. Saldo: {$member->points_balance}");
    }

    public function index(Request $request)
    {
        $sales = Sale::with(['member.tier'])
            ->when($request->member_id, fn ($q) => $q->where('member_id', $request->member_id))
            ->latest()
            ->paginate(20);

        return view('sales.index', compact('sales'));
    }
}
