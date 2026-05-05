<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTable extends Model
{
    use HasFactory;
    protected $fillable=[
        			'title',
			'activities',
			'program_id',

    ];

    public function program(){
    return $this->belongsTo(Program::class)->withDefault();
    }

    public function activities(){
		return json_decode($this->activities ?? '[]',true);
	}
}
