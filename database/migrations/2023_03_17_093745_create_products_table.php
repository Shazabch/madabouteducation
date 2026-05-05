<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id()->from('4000');
            $table->string('title')->nullable();
			$table->float('price')->default(0);
			$table->text('short_description')->nullable();
			$table->text('description')->nullable();
			$table->string('sku')->nullable();
			$table->text('additional_information')->nullable();
			$table->string('main_image')->nullable();
			$table->string('slug')->nullable();
			$table->string('meta_title')->nullable();
			$table->string('meta_description')->nullable();
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
        Schema::dropIfExists('products');
    }
}
