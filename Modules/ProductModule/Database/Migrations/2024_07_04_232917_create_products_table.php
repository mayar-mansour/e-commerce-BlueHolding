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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vendor_id');
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->text('comment')->nullable();
            $table->decimal('average_rating')->default(0);
            $table->integer('stock_quantity')->default(0);
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
};
