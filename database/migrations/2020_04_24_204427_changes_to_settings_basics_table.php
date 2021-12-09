<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangesToSettingsBasicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings_basics', function (Blueprint $table) {
            $this->changeColumnType('basic', 'LONGTEXT');
            $this->changeColumnType('company', 'LONGTEXT');
            $this->changeColumnType('mail', 'LONGTEXT');
            $this->changeColumnType('seo', 'LONGTEXT');
            $this->changeColumnType('sms', 'LONGTEXT');
            $this->changeColumnType('social', 'LONGTEXT');
            $this->changeColumnType('constants', 'LONGTEXT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings_basics', function (Blueprint $table) {
            $this->changeColumnType('basic', 'TEXT');
            $this->changeColumnType('company', 'TEXT');
            $this->changeColumnType('mail', 'TEXT');
            $this->changeColumnType('seo', 'TEXT');
            $this->changeColumnType('sms', 'TEXT');
            $this->changeColumnType('social', 'TEXT');
            $this->changeColumnType('constants', 'TEXT');
        });
    }

    /**
     * Change Column Type
     *
     * @param string $column
     * @param string $type
     * @return void
     */
    public function changeColumnType($column, $type)
    {
        DB::statement(sprintf('ALTER TABLE %s MODIFY %s %s;', 'settings_basics', $column, $type));
    }
}
