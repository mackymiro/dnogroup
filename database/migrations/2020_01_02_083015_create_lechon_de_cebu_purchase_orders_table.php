<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLechonDeCebuPurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('lechon_de_cebu_purchase_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('paid_to');
            $table->string('address');
            $table->string('p_o_number');
            $table->string('date');
            $table->integer('quantity');
            $table->string('description');
            $table->decimal('unit_price', 15,2);
            $table->decimal('amount', 15,2);
            $table->decimal('total_price', 15,2);
            $table->string('requested_by');
            $table->string('prepared_by');
            $table->string('checked_by');
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
        Schema::dropIfExists('lechon_de_cebu_purchase_orders');
    }
}
