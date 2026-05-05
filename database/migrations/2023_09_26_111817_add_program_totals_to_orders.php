<?php

use App\Models\Order;
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
            $table->float('programs_net_total')->default(0);
            $table->float('grand_sub_total')->default(0);
            $table->float('grand_net_total')->default(0);
            $table->float('grand_discount')->default(0);
        });

        foreach (Order::all() as $order){
            try{
                $order->update([
                    'grand_sub_total'=>$order->sub_total,
                    'grand_net_total'=>$order->net_total,
                    'grand_discount'=>$order->discount
                ]);
            }catch(\Exception $e){
                // ignore
            }
        }

        Schema::table('program_orders', function (Blueprint $table) {
            $table->string('shop_order_id')->nullable();
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
            $table->dropColumn(['programs_net_total','grand_net_total','grand_discount','grand_sub_total']);
        });

        Schema::table('program_orders', function (Blueprint $table) {
            $table->dropColumn('shop_order_id');
        });
    }
};
