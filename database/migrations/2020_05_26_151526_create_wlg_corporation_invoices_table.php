<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWlgCorporationInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wlg_corporation_invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('if_id')->nullable();
            $table->string('date')->nullable();
            $table->string('delivery_terms')->nullable();
            $table->string('transport_by')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('shipper')->nullable();
            $table->string('consignee')->nullable();
            $table->string('notify_party')->nullable();
            $table->string('attention')->nullable();
            $table->string('number_of_goods')->nullable();
            $table->string('description_of_goods')->nullable();
            $table->string('qty')->nullable();
            $table->decimal('unit_price', 15, 2)->nullable();
            $table->decimal('total_amount', 15, 2)->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('wlg_corporation_invoices');
    }
}
