<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionGift extends Model
{
    use HasFactory;

    protected $fillable = [
        'promotion_id',
        'product_id',
        'trigger_program_id',
        'trigger_product_id',
    ];

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function triggerProgram()
    {
        return $this->belongsTo(Program::class, 'trigger_program_id');
    }

    public function triggerProduct()
    {
        return $this->belongsTo(Product::class, 'trigger_product_id');
    }
}
