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
            $table->dropColumn([
                'start_date',
                'end_date',
                'age_group',
                'age_group_extra_info',
                'total_slots',
                'booked_slots',
                'is_reoccuring',
                'price',
                'time'
            ]);
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
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('age_group')->nullable();
            $table->string('age_group_extra_info')->nullable();
            $table->string('total_slots')->nullable();
            $table->string('booked_slots')->nullable();
            $table->boolean('is_reoccuring')->default('0');
            $table->string('price')->nullable();
            $table->string('time')->nullable();
        });
    }
};
