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
            $table->renameColumn('date','start_date');
            $table->after('pick_and_drop',function(Blueprint $table){
                $table->date('end_date')->nullable();
                $table->string('total_slots')->default('0');
                $table->string('booked_slots')->default('0');
            });
            $table->text('age_group_extra_info')->after('age_group');
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
            $table->renameColumn('start_date','date');
            $table->dropColumn(['end_date','total_slots','booked_slots','age_group_extra_info']);
        });
    }
};
