<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductButonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_butons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->index();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->tinyInteger('c1');
            $table->tinyInteger('c2');
            $table->tinyInteger('c3');
            $table->tinyInteger('c4');
            $table->tinyInteger('c5');
            $table->tinyInteger('c6');
            $table->tinyInteger('s1');
            $table->tinyInteger('s2');
            $table->tinyInteger('s3');
            $table->tinyInteger('s4');
            $table->tinyInteger('s5');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('product_butons');
    }
}
