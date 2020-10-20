<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewfieldsToRibosBarStatementOfAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('ribos_bar_statement_of_accounts', function(Blueprint $table){
            $table->integer('billing_statement')->after('soa_id')->nullable();
            $table->string('bs_no')->after('billing_statement')->nullable();
            $table->string('bill_to')->after('bs_no')->nullable();
            $table->string('address')->after('bill_to')->nullable();
            $table->string('period_cover')->after('address')->nullable();
            $table->string('date_of_transaction')->after('period_cover')->nullable();
            $table->string('description')->after('date_of_transaction')->nullable();
            $table->string('order')->after('description')->nullable();
            $table->string('dr_no')->after('order')->nullable();
            $table->string('dr_list_id')->after('dr_no')->nullable();
            $table->integer('invoice_list_id')->after('dr_list_id')->nullable();
            $table->decimal('total_kls', 15,2)->after('invoice_list_id')->nullable();
            $table->string('product_id')->after('total_kls')->nullable();
            $table->string('qty')->after('product_id')->nullable();
            $table->string('unit')->after('qty')->nullable();
            $table->decimal('total_amount', 15,2)->after('unit')->nullable();
            $table->decimal('total_remaining_balance')->after('total_amount')->nullable();
            $table->string('terms')->after('total_remaining_balance')->nullable();
        });
       

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
