<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->text('activities_1')->nullable();
            $table->text('activities_2')->nullable();
            $table->text('activities_3')->nullable();
            $table->text('activities_4')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('programs', function (Blueprint $table) {
                $table->dropColumn('activities_1');
                $table->dropColumn('activities_2');
                $table->dropColumn('activities_3');
                $table->dropColumn('activities_4');
        });
    }
};
