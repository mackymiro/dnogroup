<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLechonDeCebuSalesInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lechon_de_cebu_sales_invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('si_id');
            $table->string('invoice_number');
            $table->string('date');
            $table->string('ordered_by');
            $table->string('address');
            $table->string('qty');
            $table->decimal('total_kls', 15,2);
            $table->string('item_description');
            $table->decimal('unit_price', 15,2);
            $table->decimal('amount', 15, 2);
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
        Schema::dropIfExists('lechon_de_cebu_sales_invoices');
    }
}
