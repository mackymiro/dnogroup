<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoloPinoyGrillBranchesStockInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lolo_pinoy_grill_branches_stock_inventories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('date');
            $table->string('product_name');
            $table->decimal('price', 15,2);
            $table->string('opening_stock');
            $table->decimal('product_in', 15,2);
            $table->decimal('product_out', 15,2);
            $table->decimal('sold', 15,2);
            $table->decimal('remaining_stock', 15, 2);
            $table->decimal('amount', 15, 2);
            $table->string('flag');
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
        Schema::dropIfExists('lolo_pinoy_grill_branches_stock_inventories');
    }
}
