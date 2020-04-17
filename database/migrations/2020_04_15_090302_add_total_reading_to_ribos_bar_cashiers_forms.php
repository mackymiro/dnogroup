<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalReadingToRibosBarCashiersForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('ribos_bar_cashiers_forms', function(Blueprint $table) {
            $table->string('total_reading')->after('signing_privilage_sales');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('ribos_bar_cashiers_forms', function($table) {
            $table->dropColumn('total_reading');
        });
    }
}
