<?php

namespace App\Providers;

use App\Models\Program;
use App\Models\ProgramCategory;
use App\Models\ProgramGroup;
use App\Models\ProgramOrder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $program_categories = ProgramCategory::active()->get();

            $view->with('vc_program_categories', $program_categories);

            $programs = Program::active()
                ->orderBy(
                    ProgramGroup::select('start_date')
                        ->whereColumn('program_id', 'programs.id')
                        ->orderBy('start_date')
                        ->limit(1)
                )
                ->get();


            $view->with('vc_programs', $programs);

            $overnightCampCategory = $program_categories
                ->where('slug', 'overnight-camps')
                ->first();

            $view->with('vc_overnight_camp_category', $overnightCampCategory);
        });
    }
}
