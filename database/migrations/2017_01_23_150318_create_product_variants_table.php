<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pid')->unsigned()->index();
            $table->foreign('pid')->references('id')->on('products')->onDelete('cascade');
            $table->integer('vvid')->unsigned()->index();
            $table->foreign('vvid')->references('id')->on('variant_values')->onDelete('cascade');
            $table->smallInteger('stock');
            $table->decimal('price',15,4);
            $table->decimal('desi',15,4);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('product_variants');
    }
}
