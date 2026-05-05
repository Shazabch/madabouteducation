<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\WithActiveStatus;

class ProgramCategory extends Model
{
    use HasFactory,WithActiveStatus;
    protected $fillable=[
        	'title',
			'meta_title',
			'meta_description',
			'slug',
			'status',
			'short_desc',

    ];

	public function programs(){
		return $this->hasMany(Program::class,'category_id');
	}

	public function activePrograms(){
		return $this->hasMany(Program::class,'category_id')->active();
	}
}
