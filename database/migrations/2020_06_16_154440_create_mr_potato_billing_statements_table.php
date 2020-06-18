<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMrPotatoBillingStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mr_potato_billing_statements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('billing_statement_id')->nullable();
            $table->string('date')->nullable();
            $table->string('bill_to')->nullable();
            $table->string('address')->nullable();
            $table->string('period_covered')->nullabe();
            $table->string('terms')->nullable();
            $table->string('date_of_transaction')->nullable();
            $table->string('order')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('invoice_list_id')->nullable();
            $table->string('qty')->nullable();
            $table->decimal('total_kls', 15,2)->nullable();
            $table->string('item_description')->nullable();
            $table->decimal('unit_price', 15, 2)->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->string('dr_no')->nullable();
            $table->string('dr_list_id')->nullable();
            $table->string('product_id')->nullable();
            $table->string('unit')->nullable();
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
        Schema::dropIfExists('mr_potato_billing_statements');
    }
}
