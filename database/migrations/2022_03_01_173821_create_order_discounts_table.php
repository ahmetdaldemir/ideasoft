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
        Schema::create('order_discounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("orderId");
            $table->foreign('orderId')->references('id')->on('orders'); //TODO cascade kullanmıyorum. Diger tablolardaki verilerin silinmemesi için
            $table->json('discounts');
            $table->double('totalDiscount',10,2);
            $table->double('discountedTotal',10,2);
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
        Schema::dropIfExists('order_discounts');
    }
};
