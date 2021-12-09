<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCostpriceanddateToProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('costprice',15,4)->nullable();
            $table->timestamp('discount_start_date')->nullable();
            $table->timestamp('discount_finish_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('costprice'); 
            $table->dropColumn('discount_start_date');
            $table->dropColumn('discount_finish_date');
            
        });
    }
}
