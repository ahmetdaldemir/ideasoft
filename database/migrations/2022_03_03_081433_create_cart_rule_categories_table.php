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
        Schema::create('cart_rule_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('cartrule_id')->nullable();
            $table->foreign('cartrule_id')->references('id')->on('cart_rules');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories'); //TODO cascade kullanmıyorum. Diger tablolardaki verilerin silinmemesi için
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
        Schema::dropIfExists('cart_rule_categories');
    }
};
