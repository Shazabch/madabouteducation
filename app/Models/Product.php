<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\WithActiveStatus;

class Product extends Model
{
    use HasFactory, WithActiveStatus;

    protected $fillable = ['title', 'price', 'short_description', 'description', 'sku', 'additional_information', 'slug', 'meta_title', 'meta_description', 'main_image', 'status'];

    public function images()
    {
        return $this->morphMany(Images::class, 'imageable');
    }

    public function price()
    {
        return getCurrency() . ' ' . number_format($this->price, 2);
    }

    public function getMainImage()
    {
        return $this->main_image ?? 'no-image';
    }

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'product_program');
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
