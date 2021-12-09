<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique()->index();
            $table->smallInteger('maxUse');
            $table->smallInteger('PersonUseLimit');
            $table->date('startDate');
            $table->date('stopDate');
            $table->tinyInteger('value_type');
            $table->integer('value');
            $table->tinyInteger('freeShip');
            $table->tinyInteger('discounted');
            $table->smallInteger('special')->default(0);
            $table->text('specialValues');
            $table->integer('usageLimit');
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
        Schema::drop('campaigns');
    }
}
