<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Children extends Model
{
    use HasFactory;
    protected $fillable=[
        	'name',
			'age',
			'user_id',

    ];

    protected $guarded=[];

    public function parent(){
        return $this->belongsTo(User::class)->withDefault();
    }

    public function guardian(){
        return $this->belongsTo(Guardian::class)->withDefault();
    }

    public function guardian2(){
        return $this->belongsTo(Guardian::class,'guardian_id_2')->withDefault();
    }
}
