<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRibosBarBillingStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ribos_bar_billing_statements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('billing_statement_id')->nullable();
            $table->string('bill_to')->nullable();
            $table->string('address')->nullable();
            $table->string('date')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('p_o_number')->nullable();
            $table->string('period_cover')->nullable();
            $table->string('terms')->nullable();
            $table->string('date_of_transaction');
            $table->string('invoice_number');
            $table->decimal('whole_lechon', 15,2);
            $table->string('description');
            $table->decimal('amount', 15,2);
            $table->string('prepared_by')->nullable();
            $table->string('approved_by')->nullable();
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
        Schema::dropIfExists('ribos_bar_billing_statements');
    }
}
