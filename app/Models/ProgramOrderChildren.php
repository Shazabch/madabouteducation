<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramOrderChildren extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function order(){
        return $this->belongsTo(ProgramOrder::class,'program_order_id')->withDefault();
    }

    public function guardianDetails()
    {
        return (object) json_decode($this->guardian ?? '{}');
    }

    public function guardian2Details()
    {
        return (object) json_decode($this->guardian2 ?? '{}');
    }

    public function questionDetails()
    {
        $questions=json_decode($this->questions ?? '{}', true);
        foreach ($questions as $index=>$q){
            if(isset($q['answer'])){
                $questions[$index]['answer']=is_array($q['answer']) ? implode(',',$q['answer']):$q['answer'];
            }else{
                $questions[$index]['answer']='';
            }
        }
        return $questions;
    }
}
