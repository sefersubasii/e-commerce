<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('brand_id');
            $table->string('stock_code');
            $table->tinyInteger('stock_type');
            $table->smallInteger('stock');
            $table->string('barcode')->nullable();
            $table->decimal('price', 15, 4);
            $table->integer('maximum')->nullable();
            $table->smallInteger('package')->default(0);
            $table->tinyInteger('tax_status');
            $table->smallInteger('tax');
            $table->tinyInteger('discount_type')->default(0);
            $table->smallInteger('discount')->default(0);
            $table->text('content')->nullable();
            $table->text('seo')->nullable();
            $table->tinyInteger('status');
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
        Schema::drop('products');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
