<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMrPotatoStatementOfAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mr_potato_statement_of_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('soa_id')->nullable();
            $table->integer('billing_statement_id')->nullable();
            $table->string('bs_no')->nullable();
            $table->string('date')->nullable();
            $table->string('branch')->nullable();
            $table->string('bill_to')->nullable();
            $table->string('address')->nullable();
            $table->string('period_cover')->nullable();
            $table->string('date_of_transaction')->nullable();
            $table->string('description')->nullable();
            $table->string('order')->nullable();
            $table->string('dr_no')->nullable();
            $table->string('dr_list_id')->nullable();
            $table->integer('invoice_list_id')->nullable();
            $table->decimal('total_kls', 15,2)->nullable();
            $table->string('product_id')->nullable();
            $table->string('qty')->nullable();
            $table->string('invoice_number')->nullable();
            $table->decimal('unit_price', 15,2)->nullable();
            $table->string('unit')->nullable();
            $table->string('payment_method')->nullable();
            $table->decimal('amount', 15,2)->nullable();
            $table->decimal('total_amount', 15,2)->nullable();
            $table->decimal('total_remaining_balance', 15, 2)->nullable();
            $table->string('status')->nullable();
            $table->string('terms')->nullable();
            $table->decimal('paid_amount', 15,2)->nullable();
            $table->string('collection_date')->nullable();
            $table->string('check_number')->nullable();
            $table->decimal('check_amount', 15,2)->nullable();
            $table->string('or_number')->nullable();
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
        Schema::dropIfExists('mr_potato_statement_of_accounts');
    }
}
