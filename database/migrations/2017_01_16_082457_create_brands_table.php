<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('image');
            $table->string('code');
            $table->string('seo_title');
            $table->string('seo_keywords');
            $table->text('seo_description');
            $table->smallInteger('sort');
            $table->tinyInteger('filter_status');

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
        Schema::drop('brands');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
