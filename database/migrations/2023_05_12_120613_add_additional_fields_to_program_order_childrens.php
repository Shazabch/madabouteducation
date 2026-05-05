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
        Schema::table('program_order_childrens', function (Blueprint $table) {
            $table->after('age',function(Blueprint $table){
                $table->string('passport_no')->nullable();
                $table->string('date_of_birth')->nullable();
                $table->string('gender')->nullable();
                $table->mediumText('school_attending')->nullable();
                $table->mediumText('residential_address')->nullable();
                $table->string('household_no')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_order_childrens', function (Blueprint $table) {
            $table->dropColumn([
                'passport_no',
                'date_of_birth',
                'gender',
                'school_attending',
                'household_no',
                'residential_address',
            ]);
        });
    }
};
