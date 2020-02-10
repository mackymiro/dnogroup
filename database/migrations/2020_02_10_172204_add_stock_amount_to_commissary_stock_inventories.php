<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStockAmountToCommissaryStockInventories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('commissary_stock_inventories', function(Blueprint $table) {
            $table->decimal('stock_amount', 15,2)->after('out');
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
        Schema::table('commissary_stock_inventories', function($table) {
            $table->dropColumn('stock_amount');
        });
    }
}
