<?php

namespace App\Models;

use App\Enums\MemberStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Member extends Model
{
    protected $fillable = [
        'code',
        'name',
        'phone',
        'email',
        'tier_id',
        'points_balance',
        'lifetime_points',
        'status',
        'joined_at',
        'notes',
    ];

    protected $casts = [
        'points_balance' => 'integer',
        'lifetime_points' => 'integer',
        'status' => MemberStatus::class,
        'joined_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Member $member) {
            if (empty($member->code)) {
                $member->code = self::generateCode();
            }
            if (empty($member->joined_at)) {
                $member->joined_at = now();
            }
        });
    }

    public static function generateCode(): string
    {
        do {
            $code = 'MP' . strtoupper(Str::random(6));
        } while (self::where('code', $code)->exists());

        return $code;
    }

    public function tier(): BelongsTo
    {
        return $this->belongsTo(MembershipTier::class, 'tier_id');
    }

    public function pointTransactions(): HasMany
    {
        return $this->hasMany(PointTransaction::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function redemptions(): HasMany
    {
        return $this->hasMany(Redemption::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', MemberStatus::Active);
    }

    public function addPoints(int $points, string $description, ?int $saleId = null, ?int $userId = null): PointTransaction
    {
        $this->increment('points_balance', $points);
        $this->increment('lifetime_points', $points);
        $this->refreshTier();

        return $this->pointTransactions()->create([
            'type' => 'earn',
            'points' => $points,
            'balance_after' => $this->points_balance,
            'description' => $description,
            'sale_id' => $saleId,
            'user_id' => $userId,
        ]);
    }

    public function redeemPoints(int $points, string $description, ?int $rewardId = null, ?int $userId = null): PointTransaction
    {
        if ($this->points_balance < $points) {
            throw new \RuntimeException('Poin tidak cukup.');
        }

        $this->decrement('points_balance', $points);

        return $this->pointTransactions()->create([
            'type' => 'redeem',
            'points' => -$points,
            'balance_after' => $this->points_balance,
            'description' => $description,
            'reward_id' => $rewardId,
            'user_id' => $userId,
        ]);
    }

    public function refreshTier(): void
    {
        $tier = MembershipTier::active()
            ->where('min_lifetime_points', '<=', $this->lifetime_points)
            ->orderByDesc('min_lifetime_points')
            ->first();

        if ($tier && $this->tier_id !== $tier->id) {
            $this->update(['tier_id' => $tier->id]);
        }
    }
}
