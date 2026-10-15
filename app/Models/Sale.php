<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $fillable = [
        'member_id',
        'invoice_number',
        'amount',
        'points_earned',
        'notes',
        'user_id',
    ];

    protected $casts = [
        'amount' => 'integer',
        'points_earned' => 'integer',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function pointTransactions(): HasMany
    {
        return $this->hasMany(PointTransaction::class);
    }

    /**
     * Hitung poin dari nominal (rupiah).
     * Default: setiap Rp 10.000 = 1 poin, dikali multiplier tier.
     */
    public static function calculatePoints(int $amountRupiah, float $multiplier = 1.0, int $rupiahPerPoint = 10000): int
    {
        if ($rupiahPerPoint <= 0) {
            return 0;
        }

        return (int) floor(($amountRupiah / $rupiahPerPoint) * $multiplier);
    }
}
