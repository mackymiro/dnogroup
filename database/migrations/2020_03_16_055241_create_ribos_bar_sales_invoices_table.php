<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRibosBarSalesInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ribos_bar_sales_invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('si_id')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('date');
            $table->string('ordered_by')->nullable();
            $table->string('address')->nullable();
            $table->string('qty');
            $table->decimal('total_kls', 15,2);
            $table->string('item_description');
            $table->decimal('unit_price', 15,2);
            $table->decimal('amount', 15, 2);
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
        Schema::dropIfExists('ribos_bar_sales_invoices');
    }
}
