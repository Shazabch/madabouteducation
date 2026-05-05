<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;

    protected $fillable=['caption','path'];

    protected static function boot(){
        parent::boot();
		
        // When saving (could be create or update) the modal
        static::deleting(function ($image) {
			deleteFile($image->path);
        });
    }

    public function imageable(){
        return $this->morphTo();
    }
}
