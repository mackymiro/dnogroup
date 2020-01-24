<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLechonDeCebuStatementOfAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lechon_de_cebu_statement_of_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('date');
            $table->string('branch');
            $table->string('invoice_number');
            $table->decimal('kilos', 15,2);
            $table->decimal('unit_price', 15,2);
            $table->string('payment_method');
            $table->decimal('amount', 15,2);
            $table->string('status');
            $table->decimal('paid_amount', 15,2);
            $table->string('collection_date');
            $table->string('check_number');
            $table->decimal('check_amount', 15,2);
            $table->string('or_number');
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
        Schema::dropIfExists('lechon_de_cebu_statement_of_accounts');
    }
}
