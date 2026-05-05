<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;
    protected $fillable=[
        			'title',
			'questions',

    ];

  public function getQuestions(){
    $questions= json_decode($this->questions ?? '[]',true);
    foreach ($questions as $index=>$question){
      $questions[$index]['options_array']=explode(',',$question['options']);
    }
		return $questions; 
	}

  public function programs(){
    return $this->hasMany(Program::class);
  }
}
