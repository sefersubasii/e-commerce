<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('groupId')->unsigned()->index();
            $table->foreign('groupId')->references('id')->on('mail_groups')->onDelete('cascade');
            $table->string('name');
            $table->string('email');
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
        Schema::drop('mail_lists');
    }
}
