<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->boolean('is_free_gift')->default(false)->after('total');
            $table->unsignedBigInteger('promotion_id')->nullable()->after('is_free_gift');
            $table->string('promotion_name')->nullable()->after('promotion_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['is_free_gift', 'promotion_id', 'promotion_name']);
        });
    }
};
