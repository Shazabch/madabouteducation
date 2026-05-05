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
            $table->text('name_of_school_attending')->nullable();
            $table->string('current_grade_in_school')->nullable();
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
            $table->dropColumn(['name_of_school_attending','current_grade_in_school']);
        });
    }
};
