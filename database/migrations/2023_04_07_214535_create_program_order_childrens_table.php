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
        Schema::create('program_order_childrens', function (Blueprint $table) {
            $table->id();
            $table->string('program_order_id')->nullable();
            $table->string('name')->nullable();
            $table->string('age')->nullable();
            $table->float('sub_total')->default(0);
            $table->float('discount')->default(0);
            $table->string('discount_detail')->nullable();
            $table->float('net_total')->default(0);
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
        Schema::dropIfExists('program_order_childrens');
    }
};
