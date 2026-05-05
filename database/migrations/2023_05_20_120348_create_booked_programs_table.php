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
        Schema::create('booked_programs', function (Blueprint $table) {
            $table->id();
            $table->string('program_id')->nullable();
            $table->string('program_order_id')->nullable();
            $table->string('title')->nullable();
			$table->string('venue')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
			$table->string('age_group')->nullable();
			$table->string('age_group_extra_info')->nullable();
			$table->float('price')->default(0);
			$table->text('pick_and_drop')->nullable();
			$table->text('timetable')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booked_programs');
    }
};
