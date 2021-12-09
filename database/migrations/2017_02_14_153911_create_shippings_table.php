<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shippings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->smallInteger('pay_type');
            $table->string('image');
            $table->smallInteger('sort');
            $table->tinyInteger('status');
            $table->smallInteger('integration');
            $table->decimal('price', 9, 2);
            $table->tinyInteger('pd_status');
            $table->tinyInteger('pdCash_status');
            $table->decimal('pdCash_price', 9, 2);
            $table->tinyInteger('pdCard_status');
            $table->decimal('pdCard_price', 9, 2);

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
        Schema::drop('shippings');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
