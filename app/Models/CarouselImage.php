<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\WithActiveStatus;

class CarouselImage extends Model
{
    use HasFactory, WithActiveStatus;

    protected $fillable = ['image', 'title', 'description', 'order', 'status'];

    public function getImage()
    {
        return $this->image ?? 'no-image';
    }
}
