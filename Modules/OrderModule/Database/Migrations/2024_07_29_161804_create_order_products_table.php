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
        Schema::create('order_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id')->default(0);
            $table->bigInteger('product_id')->default(0);
            $table->text('product_name')->nullable();
            $table->decimal('item_price', 10, 2)->default('0');
            $table->integer('quantity')->default(1);
            $table->decimal('total_price', 10, 2)->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_products');
    }
};
