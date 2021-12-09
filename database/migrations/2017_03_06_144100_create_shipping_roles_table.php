<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shipping_id')->unsigned()->index();
            $table->foreign('shipping_id')->references('id')->on('shippings')->onDelete('cascade');
            $table->string('name');
            $table->tinyInteger('type');
            $table->text('values');
            $table->decimal('weight_price',9,2);
            $table->decimal('fixed_price',9,2);
            $table->decimal('free_shipping',9,2);
            $table->decimal('weight_limit',9,2);
            $table->text('desi');
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
        Schema::drop('shipping_roles');
    }
}
