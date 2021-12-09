<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCustomPricesToShippingRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipping_roles', function (Blueprint $table) {
            $table->text('custom_prices')->nullable()->after('desi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipping_roles', function (Blueprint $table) {
            $table->dropColumn('custom_prices');
        });
    }
}
