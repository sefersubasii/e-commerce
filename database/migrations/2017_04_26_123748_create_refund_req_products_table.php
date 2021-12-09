<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundReqProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refund_req_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('refund_request_id')->unsigned()->index();
            $table->foreign('refund_request_id')->references('id')->on('refund_requests')->onDelete('cascade');
            $table->integer('product_id');
            $table->integer('qty');
            $table->tinyInteger('status');
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
        Schema::drop('refund_req_products');
    }
}
