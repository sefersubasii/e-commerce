<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsBasicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_basics', function (Blueprint $table) {
            $table->increments('id');
            $table->text('basic');
            $table->text('company');
            $table->text('mail');
            $table->text('seo');
            $table->text('sms');
            $table->text('social');
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
        Schema::drop('settings_basics');
    }
}
