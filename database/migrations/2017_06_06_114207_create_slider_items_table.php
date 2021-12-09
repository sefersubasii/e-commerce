<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSliderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slider_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('slider_id')->unsigned()->index();
            $table->foreign('slider_id')->references('id')->on('sliders')->onDelete('cascade');
            $table->string('name');
            $table->tinyInteger('status');
            $table->smallInteger('sort');
            $table->string('image');
            $table->string('imageCover');
            $table->string('link');
            $table->text('content');
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
        Schema::drop('slider_items');
    }
}
