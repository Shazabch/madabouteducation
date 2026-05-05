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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable(); // promo code
            $table->string('type'); //percentage //fixed //free_gifts
            $table->decimal('value', 10, 2)->nullable(); // % or fixed amount
            $table->boolean('is_active')->default(true);

            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();

            $table->integer('min_quantity')->nullable(); // e.g. group > 5 kids
            $table->decimal('min_amount')->nullable();

            $table->string('applies_to'); //program , product , both 

            $table->boolean('is_auto')->default(false); // auto vs promo code
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
        Schema::dropIfExists('promotions');
    }
};
