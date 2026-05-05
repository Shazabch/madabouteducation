<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramGroup extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function date()
    {
        if($this->is_reoccuring){
            // return ordinal(Carbon::parse($this->start_date)->format('d')).  " of every month";
            return Carbon::parse($this->start_date)->format('d-M-Y');
        }else{
            return Carbon::parse($this->start_date)->format('d-M-Y').' - '.Carbon::parse($this->end_date)->format('d-M-Y');
        }
    }

    public function price(){
		return getCurrency().number_format($this->price,'2');
	}
}
