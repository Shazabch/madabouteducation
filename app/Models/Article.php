<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\WithActiveStatus;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory,SoftDeletes,WithActiveStatus;
    protected $fillable=[
        	'title',
			'image',
			'meta_title',
			'meta_description',
			'slug',
			'content',
			'published_on',
			'user_id',
			'status',
    ];

    public function user(){
        return $this->belongsTo(User::class)->withDefault();
    }

    public function relatedArticles(){
        return self::active()->where('id','!=',$this->id)->inRandomOrder()->take('6')->get();
    }
}
