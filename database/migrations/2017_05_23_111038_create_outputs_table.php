<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outputs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->tinyInteger('status');
            $table->text('categories')->nullable();
            $table->text('brands')->nullable();
            $table->text('selectedColums');
            $table->text('names');
            $table->string('rootElementName');
            $table->string('loopElementName');
            $table->string('permCode');
            $table->text('ipWhiteList')->nullable();
            $table->tinyInteger('type');
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
        Schema::drop('outputs');
    }
}
