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
        Schema::create('shipping_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->default(0);
            $table->string('additional_phone')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->text('address')->nullable();
            $table->bigInteger('city_id')->default(1)->index();
            $table->bigInteger('area_id')->default(1)->index();
            $table->string('distinct_mark')->nullable();
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
        Schema::dropIfExists('shipping_address');
    }
};
