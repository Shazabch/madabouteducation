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
        Schema::create('program_groups', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('program_id')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('age_group')->nullable();
            $table->string('age_group_extra_info')->nullable();
            $table->string('total_slots')->nullable();
            $table->string('booked_slots')->nullable();
            $table->boolean('is_reoccuring')->default('0');
            $table->string('price')->nullable();
            $table->string('time')->nullable();
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
        Schema::dropIfExists('program_groups');
    }
};
