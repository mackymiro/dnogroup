<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDnoFoodVenturesBillingStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dno_food_ventures_billing_statements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('billing_statement_id')->nullable();
            $table->string('bill_to')->nullable();
            $table->string('address')->nullable();
            $table->string('date')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('period_cover')->nullable();
            $table->string('terms')->nullable();
            $table->string('date_of_transaction')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('order')->nullable();
            $table->string('dr_no')->nullable();
            $table->integer('dr_list_id')->nullable();
            $table->string('product_id')->nullable();
            $table->string('qty')->nullable();
            $table->decimal('unit_price', 15,2)->nullable();
            $table->string('unit')->nullable();
            $table->decimal('total_kls')->nullable();
            $table->integer('invoice_list_id')->nullable();
            $table->string('description');
            $table->decimal('amount', 15,2);
            $table->decimal('total_amount', 15,2)->nullable();
            $table->string('branch')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->decimal('paid_amount', 15,2)->nullable();
            $table->string('payment_method')->nullable();
            $table->string('status')->nullable();
            $table->string('collection_date')->nullable();
            $table->string('check_number')->nullable();
            $table->string('or_number')->nullable();
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
        Schema::dropIfExists('dno_food_ventures_billing_statements');
    }
}
