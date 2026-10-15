<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Redemption;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = today();

        $stats = [
            'members_total' => Member::count(),
            'members_active' => Member::active()->count(),
            'points_circulating' => (int) Member::sum('points_balance'),
            'sales_today' => Sale::whereDate('created_at', $today)->count(),
            'sales_today_amount' => (int) Sale::whereDate('created_at', $today)->sum('amount'),
            'points_issued_today' => (int) Sale::whereDate('created_at', $today)->sum('points_earned'),
            'redeems_today' => Redemption::whereDate('created_at', $today)->count(),
        ];

        $recentSales = Sale::with('member')->latest()->limit(8)->get();
        $recentMembers = Member::with('tier')->latest()->limit(5)->get();

        $topMembers = Member::with('tier')
            ->orderByDesc('lifetime_points')
            ->limit(5)
            ->get();

        return view('dashboard', compact('stats', 'recentSales', 'recentMembers', 'topMembers'));
    }
}
