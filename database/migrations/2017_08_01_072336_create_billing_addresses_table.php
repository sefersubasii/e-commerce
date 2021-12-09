<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address_name');
            $table->tinyInteger('type');
            $table->string('name');
            $table->string('surname');
            $table->string('phone');
            $table->string('phoneGsm');
            $table->string('address');
            $table->string('tax_no');
            $table->string('tax_place');
            $table->tinyInteger('is_einvoice');
            $table->integer('member_id')->unsigned()->index();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->string('city');
            $table->string('state');
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
        Schema::drop('billing_addresses');
    }
}
