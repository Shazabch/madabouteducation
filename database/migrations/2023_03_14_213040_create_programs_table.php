<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id()->from('3000');
            $table->string('title')->nullable();
			$table->date('date')->nullable();
			$table->string('venue')->nullable();
			$table->string('age_group')->nullable();
			$table->float('price')->default(0);
			$table->text('pick_and_drop')->nullable();
			$table->text('content')->nullable();
			$table->string('slug')->nullable();
			$table->string('meta_title')->nullable();
			$table->text('meta_description')->nullable();
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
        Schema::dropIfExists('programs');
    }
}
