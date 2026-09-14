<?php

namespace App\Models;

use Carbon\Carbon;
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

    protected static function booted()
    {
        // keep the stored age in sync with the date of birth
        static::saving(function ($child) {
            if ($child->date_of_birth) {
                $child->age = Carbon::parse($child->date_of_birth)->age;
            }
        });
    }

    // age is always calculated from the date of birth so it never goes stale
    public function getAgeAttribute($value)
    {
        if ($this->date_of_birth) {
            return Carbon::parse($this->date_of_birth)->age;
        }
        return $value;
    }

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
