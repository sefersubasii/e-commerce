<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductToCatPivotTablo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_to_cat', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pid')->unsigned()->index();
            $table->foreign('pid')->references('id')->on('products')->onDelete('cascade');
            $table->integer('cid')->unsigned()->index();
            $table->foreign('cid')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('product_to_cat');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
