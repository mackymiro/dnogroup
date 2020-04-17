<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCashiersFormIdToRibosBarCashiersForms extends Migration
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
            $table->integer('cf_id')->after('user_id');
           
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
            $table->dropColumn('cf_id');
        });
    }
}
