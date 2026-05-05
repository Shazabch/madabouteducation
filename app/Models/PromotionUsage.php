<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'promotion_id',
        'user_id',
        'used_count',
    ];

    protected $casts = [
        'used_count' => 'integer'
    ];

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
}
