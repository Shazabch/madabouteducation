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
        Schema::table('media', function (Blueprint $table) {
            $table->boolean('status')->default(1);
        });
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('status')->default(1);
        });
        Schema::table('programs', function (Blueprint $table) {
            $table->boolean('status')->default(1);
        });
        Schema::table('program_categories', function (Blueprint $table) {
            $table->boolean('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
    */
    public function down()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('program_categories', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
