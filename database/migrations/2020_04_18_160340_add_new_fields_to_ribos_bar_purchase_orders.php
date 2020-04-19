<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldsToRibosBarPurchaseOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('ribos_bar_purchase_orders', function(Blueprint $table) {
            $table->string('branch_location')->after('address');
            $table->string('ordered_by');
            $table->string('particulars');
            $table->string('qty');
            $table->decimal('unit', 15, 2);
            $table->decimal('price', 15, 2);
            $table->decimal('subtotal', 15, 2);

           
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
        Schema::table('ribos_bar_purchase_orders', function($table) {
            // $table->dropColumn('cf_id');
         });
    }
}
