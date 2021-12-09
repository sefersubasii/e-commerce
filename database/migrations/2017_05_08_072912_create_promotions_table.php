<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->tinyInteger('selectedDate');
            $table->tinyInteger('type');
            $table->integer('totalUsage');
            $table->integer('maxUsage');
            $table->smallInteger('memberGroupId');
            $table->text('memberIds')->nullable();
            $table->string('promotionDiscountType');
            $table->integer('promotionValue');
            $table->integer('basePriceLimit');
            $table->text('affectedProducts')->nullable();
            $table->integer('affectedCount');
            $table->text('baseProducts')->nullable();
            $table->tinyInteger('baseProductsOperator')->nullable();
            $table->smallInteger('baseCount')->nullable();
            $table->integer('baseCategoryId')->nullable();
            $table->integer('baseBrandId')->nullable();
            $table->text('description');
            $table->date('startDate');
            $table->date('stopDate');
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
        Schema::drop('promotions');
    }
}
