<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MembershipTier extends Model
{
    protected $fillable = [
        'name',
        'code',
        'min_lifetime_points',
        'point_multiplier',
        'color',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'min_lifetime_points' => 'integer',
        'point_multiplier' => 'float',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function members(): HasMany
    {
        return $this->hasMany(Member::class, 'tier_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('min_lifetime_points');
    }
}
