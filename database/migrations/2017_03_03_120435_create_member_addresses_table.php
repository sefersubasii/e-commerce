<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->unsigned()->index();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->string('address');
            $table->integer('countries_id')->unsigned()->index();
            $table->foreign('countries_id')->references('id')->on('countries');
            $table->integer('cities_id')->unsigned()->index();
            $table->foreign('cities_id')->references('id')->on('cities');
            $table->integer('districts_id')->unsigned()->index();
            $table->foreign('districts_id')->references('id')->on('districts');
            $table->string('postal_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('member_addresses');
    }
}
