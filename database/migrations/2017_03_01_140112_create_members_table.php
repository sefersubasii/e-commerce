<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identity_number');
            $table->string('name');
            $table->string('surname');
            $table->tinyInteger('gender');
            $table->date('bday');
            $table->string('email')->unique();
            $table->string('company');
            $table->string('tax_office');
            $table->string('tax_number');
            $table->string('password');
            $table->string('phone');
            $table->string('phoneGsm');
            $table->rememberToken();
            $table->integer('group_id');
            $table->tinyInteger('allowed_to_mail');
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
        Schema::drop('members');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
