<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreatedByToLoloPinoyGrillCommissaryPurchaseOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table('lolo_pinoy_grill_commissary_purchase_orders', function(Blueprint $table) {
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
         Schema::table('lolo_pinoy_grill_commissary_purchase_orders', function($table) {
            $table->dropColumn('created_by');
        });
    }
}
