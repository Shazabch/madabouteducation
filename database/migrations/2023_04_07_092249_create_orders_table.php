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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->float('sub_total')->default(0);
            $table->float('discount')->default(0);
            $table->float('shipping_charges')->default(0);
            $table->float('vat')->default(0);
            $table->float('net_total')->default(0);
            $table->string('payment_status')->default(PaymentStatus::NotPaid);
            $table->dateTime('paid_at')->nullable();
            $table->string('order_status')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->text('street_address')->nullable();
            $table->string('house_name_number')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->text('order_notes')->nullable();
            $table->text('order_notes_admin')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
