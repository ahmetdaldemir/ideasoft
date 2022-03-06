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
        Schema::create('cart_products', function (Blueprint $table) {
            $table->id();
            $table->uuid('cart_id')->index();
            $table->foreign('cart_id')->references('cart_id')->on('carts'); //TODO cascade kullanmıyorum. Diger tablolardaki verilerin silinmemesi için
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products'); //TODO cascade kullanmıyorum. Diger tablolardaki verilerin silinmemesi için
            $table->integer('qty');
            $table->decimal('price',10,2); //TODO decimal oldugu zaman noktadan öncesi ve sonrası integer olarak tutulur. Böylelikle küsürat farkı oluşmaz
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
        Schema::dropIfExists('cart_products');
    }
};
