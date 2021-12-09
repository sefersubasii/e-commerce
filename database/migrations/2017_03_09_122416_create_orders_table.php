<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_no')->index();
            $table->integer('member_id')->unsigned()->index()->nullable();
            $table->foreign('member_id')->references('id')->on('members');
            $table->string('customer_email')->nullable();
            $table->text('customer_note')->nullable();
            $table->tinyInteger('status');
            $table->tinyInteger('payment_type');
            $table->integer('bank_id')->unsigned()->index()->nullable();
            $table->foreign('bank_id')->references('id')->on('banks');
            $table->integer('shipping_id')->unsigned()->index()->nullable();
            $table->foreign('shipping_id')->references('id')->on('shippings');
            $table->string('shipping_no')->nullable();
            $table->string('billing_no')->nullable();
            $table->integer('billing_address_id')->nullable();
            $table->integer('shipping_address_id')->nullable();
            $table->decimal('subtotal', 15, 4);
            $table->decimal('grand_total', 15, 4);
            $table->decimal('tax_amount', 15, 4);
            $table->decimal('shipping_amount', 15, 4);
            $table->decimal('pdAmount', 15, 4)->nullable()->default(0);
            $table->decimal('discount_amount', 15, 4);
            $table->text('promotionProducts')->nullable();
            $table->string('coupon_code');
            $table->unsignedSmallInteger('billOutput')->nullable()->default(0);
            $table->text('note')->nullable();
            $table->text('statusMessage')->nullable();
            $table->string('ip')->nullable();
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('orders');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
