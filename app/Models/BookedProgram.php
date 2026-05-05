<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookedProgram extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function order()
    {
        $this->belongsTo(ProgramOrder::class)->withDefault();
    }

    public function timetables(){
		return json_decode($this->timetable ?? '[]',true);
	}
}
