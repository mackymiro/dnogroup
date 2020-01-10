<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreatedByToLechonDeCebuPurchaseOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table('lechon_de_cebu_purchase_orders', function(Blueprint $table) {
            $table->string('created_by')->after('checked_by');
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
         Schema::table('lechon_de_cebu_purchase_orders', function($table) {
            $table->dropColumn('created_by');
        });
    }
}
