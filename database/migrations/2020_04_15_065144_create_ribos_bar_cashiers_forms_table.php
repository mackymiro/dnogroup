<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRibosBarCashiersFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ribos_bar_cashiers_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('date');
            $table->string('cashier_name');
            $table->string('bar_tender_name');
            $table->string('shifting_schedule');
            $table->string('starting_os');
            $table->decimal('cash_sales', 15,2);
            $table->decimal('credi_card_sales', 15, 2);
            $table->string('signing_privilage_sales');
            $table->string('closing_os');
            $table->string('items');
            $table->string('opening_inventory');
            $table->string('sold');
            $table->string('closing');
            $table->decimal('total');
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
        Schema::dropIfExists('ribos_bar_cashiers_forms');
    }
}
