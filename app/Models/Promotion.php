<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'type',
        'value',
        'is_active',
        'start_date',
        'end_date',
        'min_quantity',
        'min_amount',
        'applies_to',
        'is_auto',
        'max_uses',
        'max_uses_per_user',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_auto' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function conditions()
    {
        return $this->hasMany(PromotionCondition::class);
    }

    public function usages()
    {
        ///// Sum of used_count across all users for this promotion
        return $this->hasMany(PromotionUsage::class);
    }

    public function gifts()
    {
        return $this->hasMany(PromotionGift::class);
    }
}
