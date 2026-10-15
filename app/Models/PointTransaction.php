<?php

namespace App\Models;

use App\Enums\PointType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PointTransaction extends Model
{
    protected $fillable = [
        'member_id',
        'type',
        'points',
        'balance_after',
        'description',
        'sale_id',
        'reward_id',
        'user_id',
    ];

    protected $casts = [
        'type' => PointType::class,
        'points' => 'integer',
        'balance_after' => 'integer',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function reward(): BelongsTo
    {
        return $this->belongsTo(Reward::class);
    }
}
