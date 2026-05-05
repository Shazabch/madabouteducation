<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\WithActiveStatus;

class ProductCategory extends Model
{
    use HasFactory, WithActiveStatus;

    protected $fillable = ['name', 'slug', 'description', 'status', 'image'];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function getImage()
    {
        return $this->image ?? 'no-image';
    }
}
