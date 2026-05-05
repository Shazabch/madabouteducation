<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\WithActiveStatus;

class Media extends Model
{
    use HasFactory,WithActiveStatus;
    protected $fillable=[
        			'title',
			'image',
			'link',
            'status',

    ];
}
