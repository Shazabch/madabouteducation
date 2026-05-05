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
        Schema::table('childrens', function (Blueprint $table) {
            $table->string('nationality')->nullable();
        });

        Schema::table('guardians', function (Blueprint $table) {
            $table->string('nationality')->nullable();
        });

        Schema::table('program_order_childrens', function (Blueprint $table) {
            $table->string('nationality')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('childrens', function (Blueprint $table) {
            $table->dropColumn('nationality');
        });

        Schema::table('guardians', function (Blueprint $table) {
            $table->dropColumn('nationality');
        });

        Schema::table('program_order_childrens', function (Blueprint $table) {
            $table->dropColumn('nationality');
        });
    }
};
