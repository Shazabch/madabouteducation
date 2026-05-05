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
        Schema::table('program_orders', function (Blueprint $table) {
            $table->string('transaction_id')->nullable()->after('payment_status');
            $table->string('invoice')->nullable();
        });
        
        Schema::table('orders', function (Blueprint $table) {
            $table->string('transaction_id')->nullable()->after('payment_status');
            $table->string('invoice')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_orders', function (Blueprint $table) {
            $table->dropColumn('transaction_id');
            $table->dropColumn('invoice');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('transaction_id');
            $table->dropColumn('invoice');
        });
    }
};
