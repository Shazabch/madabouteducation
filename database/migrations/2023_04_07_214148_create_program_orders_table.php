<?php

use App\Enums\PaymentStatus;
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
        Schema::create('program_orders', function (Blueprint $table) {
            $table->id();
            $table->float('program_id')->default(0);
            $table->string('children_count')->default(0);
            $table->string('program_title')->default(0);
            $table->float('sub_total')->default(0);
            $table->float('discount')->default(0);
            $table->float('vat')->default(0);
            $table->float('net_total')->default(0);
            $table->string('payment_status')->default(PaymentStatus::NotPaid);
            $table->dateTime('paid_at')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->text('address')->nullable();
            $table->text('questions')->nullable();
            $table->text('notes')->nullable();
            $table->string('user_id')->nullable();
            $table->text('api_response')->nullable();
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
        Schema::dropIfExists('program_orders');
    }
};
