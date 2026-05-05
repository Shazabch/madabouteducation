<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function children(){
        return $this->hasMany(Children::class,'guardian_id');
    }
}
