<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRibosBarStatementOfAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ribos_bar_statement_of_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('soa_id')->nullable();
            $table->string('date');
            $table->string('branch');
            $table->string('invoice_number');
            $table->decimal('kilos', 15,2);
            $table->decimal('unit_price', 15,2)->nullable();
            $table->string('payment_method');
            $table->decimal('amount', 15,2);
            $table->string('status');
            $table->decimal('paid_amount', 15,2)->nullable();
            $table->string('collection_date')->nullable();
            $table->string('check_number')->nullable();
            $table->decimal('check_amount', 15,2)->nullable();
            $table->string('or_number');
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
        Schema::dropIfExists('ribos_bar_statement_of_accounts');
    }
}
