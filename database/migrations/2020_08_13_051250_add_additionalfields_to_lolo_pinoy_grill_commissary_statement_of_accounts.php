<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdditionalfieldsToLoloPinoyGrillCommissaryStatementOfAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('lolo_pinoy_grill_commissary_statement_of_accounts', function(Blueprint $table){
            $table->string('bs_no')->after('billing_statement_id')->nullable();
            $table->string('order')->after('description')->nullable();
            $table->string('dr_no')->after('order')->nullable();
            $table->string('dr_list_id')->after('dr_no')->nullable();
            $table->string('product_id')->after('dr_list_id')->nullable();
            $table->string('qty')->after('product_id')->nullable();
            $table->string('unit')->after('unit_price')->nullable();
            $table->integer('invoice_list_id')->after('dr_list_id')->nullable();
            $table->decimal('total_kls', 15,2)->after('invoice_list_id')->nullable();
            $table->decimal('total_amount', 15,2)->after('amount')->nullable();
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
