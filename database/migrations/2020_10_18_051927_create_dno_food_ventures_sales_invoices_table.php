<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDnoFoodVenturesSalesInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dno_food_ventures_sales_invoices', function (Blueprint $table) {
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
            $table->decimal('amout', 15,2);
            $table->decimal('total_amount', 15,2)->nullable();
            $table->string('created_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dno_food_ventures_sales_invoices');
    }
}
