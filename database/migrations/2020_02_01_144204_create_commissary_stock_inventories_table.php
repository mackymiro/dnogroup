<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommissaryStockInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('commissary_stock_inventories')) {
            Schema::create('commissary_stock_inventories', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id');
                $table->string('branch');
                $table->string('product_id_no');
                $table->string('product_name');
                $table->decimal('unit_price', 15,2);
                $table->string('unit');
                $table->string('in');
                $table->string('out');
                $table->string('remaining_stock');
                $table->decimal('amount', 15,2);
                $table->string('supplier');
                $table->string('created_by');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commissary_stock_inventories');
    }
}
