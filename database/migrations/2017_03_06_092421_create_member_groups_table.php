<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberGroupsTable extends Migration
{
    public function up()
    {
        Schema::create('member_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            //$table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('member_groups');
    }
}
