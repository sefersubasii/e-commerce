<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_shippings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pid')->unsigned()->index();
            $table->foreign('pid')->references('id')->on('products')->onDelete('cascade');
            $table->decimal('desi',15,4);
            $table->decimal('shipping_price',15,4);
            $table->tinyInteger('use_system')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products_shippings');
    }
}
