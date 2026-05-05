<?php

namespace App\Http\Controllers;

use App\Api\SenangPay;
use App\Models\Program;
use App\Models\ProgramCategory;
use App\Models\ProgramGroup;
use App\Models\ProgramOrder;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function programs(){
        return view('programs.categories');
    }

    public function programByCategory($categorySlug){
        $category=ProgramCategory::where('slug',$categorySlug)->active()->firstOrFail();
        $activePrograms =Program::active()
        ->where('category_id', $category->id)
        ->orderBy(
            ProgramGroup::select('start_date')
                ->whereColumn('program_id', 'programs.id')
                ->orderBy('start_date')
                ->limit(1)
        )
        ->get();
        return view('programs.list',compact('category','activePrograms'));
    }

    public function programsDetail($categorySlug,$programSlug){
        $program=Program::with('category')->where('slug',$programSlug)->active()->firstOrFail();
        return view('programs.detail',compact('program'));
    }

    public function checkoutDetails($programId,$groupId){
        $program=Program::where('id',$programId)->active()->firstOrFail();
        $group=ProgramGroup::where('program_id',$program->id)->where('id',$groupId)->firstOrFail();
        return view('programs.checkout-details',compact('program','group'));
    }
}
