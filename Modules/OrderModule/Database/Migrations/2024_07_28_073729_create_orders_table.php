<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->bigInteger('order_nu')->index();
            $table->bigInteger('status_id')->default(1);
            $table->bigInteger('user_id')->unsigned();


            $table->decimal('total_amount', 10, 2)->default('0');
            $table->decimal('delivery_fees', 10, 2)->default('0');
         

            $table->decimal('net_amount', 10, 2)->default('0');

            
     
            $table->bigInteger('shipping_address_id')->default(0);
          
            
            
            $table->bigInteger('payment_method_id')->default(0)->index();
            $table->boolean('is_paid')->default(0)->index();
            $table->string('transaction_id')->default(0);
            $table->text('notes')->nullable();
          
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
