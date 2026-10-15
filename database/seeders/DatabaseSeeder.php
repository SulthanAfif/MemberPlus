<?php

namespace Database\Seeders;

use App\Enums\MemberStatus;
use App\Models\Member;
use App\Models\MembershipTier;
use App\Models\Reward;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Settings
        Setting::set('rupiah_per_point', '10000');
        Setting::set('app_name', 'MemberPlus Demo');

        // Tiers
        $bronze = MembershipTier::create([
            'name' => 'Bronze',
            'code' => 'bronze',
            'min_lifetime_points' => 0,
            'point_multiplier' => 1.00,
            'color' => '#cd7f32',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        MembershipTier::create([
            'name' => 'Silver',
            'code' => 'silver',
            'min_lifetime_points' => 200,
            'point_multiplier' => 1.25,
            'color' => '#94a3b8',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        MembershipTier::create([
            'name' => 'Gold',
            'code' => 'gold',
            'min_lifetime_points' => 500,
            'point_multiplier' => 1.50,
            'color' => '#eab308',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // Rewards
        Reward::create([
            'name' => 'Kopi gratis',
            'description' => '1 gelas kopi size regular',
            'points_cost' => 50,
            'stock' => 100,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Reward::create([
            'name' => 'Diskon 20%',
            'description' => 'Maksimal potongan Rp 30.000',
            'points_cost' => 100,
            'stock' => null,
            'is_active' => true,
            'sort_order' => 2,
        ]);

        Reward::create([
            'name' => 'Merchandise',
            'description' => 'Tote bag / tumbler',
            'points_cost' => 250,
            'stock' => 20,
            'is_active' => true,
            'sort_order' => 3,
        ]);

        Reward::create([
            'name' => 'Voucher Rp 50.000',
            'description' => 'Min. transaksi Rp 100.000',
            'points_cost' => 400,
            'stock' => 10,
            'is_active' => true,
            'sort_order' => 4,
        ]);

        // Sample members
        Member::create([
            'code' => 'MPDEMO01',
            'name' => 'Rina Wijaya',
            'phone' => '081234567890',
            'email' => 'rina@example.com',
            'tier_id' => $bronze->id,
            'points_balance' => 80,
            'lifetime_points' => 80,
            'status' => MemberStatus::Active,
            'joined_at' => now()->subDays(30),
        ]);

        Member::create([
            'code' => 'MPDEMO02',
            'name' => 'Budi Santoso',
            'phone' => '081298765432',
            'tier_id' => $bronze->id,
            'points_balance' => 0,
            'lifetime_points' => 0,
            'status' => MemberStatus::Active,
            'joined_at' => now()->subDays(7),
        ]);
    }
}
