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
        Schema::table('orders', function (Blueprint $table) {
            $table->float('sst')->default(0)->after('invoice');
        });

        Schema::table('program_orders', function (Blueprint $table) {
            $table->float('sst')->default(0)->after('vat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('sst');
        });

        Schema::table('program_orders', function (Blueprint $table) {
            $table->dropColumn('sst');
        });
    }
};
