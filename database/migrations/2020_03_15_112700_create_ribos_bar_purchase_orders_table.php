<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRibosBarPurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ribos_bar_purchase_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('po_id')->nullable();
            $table->string('paid_to')->nullable();
            $table->string('address')->nullable();
            $table->string('p_o_number')->nullable();
            $table->string('date')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('description')->nullable();
            $table->decimal('unit_price', 15,2)->nullable();
            $table->decimal('amount', 15,2)->nullable();
            $table->decimal('total_price', 15,2)->nullable();
            $table->string('requested_by')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('checked_by')->nullable();
            $table->string('created_by');
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
        Schema::dropIfExists('ribos_bar_purchase_orders');
    }
}
