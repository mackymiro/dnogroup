<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLechonDeCebuBillingStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lechon_de_cebu_billing_statements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('billing_statement_id');
            $table->string('bill_to');
            $table->string('address');
            $table->string('date');
            $table->string('reference_number');
            $table->string('p_o_number');
            $table->string('period_cover');
            $table->string('terms');
            $table->string('date_of_transaction');
            $table->string('invoice_number');
            $table->decimal('whole_lechon', 15,2);
            $table->string('description');
            $table->decimal('amount', 15,2);
            $table->string('prepared_by');
            $table->string('approved_by');
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
        Schema::dropIfExists('lechon_de_cebu_billing_statements');
    }
}
