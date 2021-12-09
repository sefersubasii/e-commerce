<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariantVariantValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variant_variant_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pv_id')->unsigned()->index();
            $table->foreign('pv_id')->references('id')->on('product_variants')->onDelete('cascade');
            $table->integer('vv_id')->unsigned()->index();
            $table->foreign('vv_id')->references('id')->on('variant_values')->onDelete('cascade');
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
        Schema::drop('product_variant_variant_values');
    }
}
