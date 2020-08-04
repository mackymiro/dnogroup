<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToLoloPinoyGrillCommissaryStatementsOfAccounts extends Migration
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
            $table->string('bill_to')->after('branch')->nullable();
            $table->string('period_cover')->after('bill_to')->nullabe();
            $table->string('date_of_transaction')->after('period_cover')->nullable();
            $table->string('description')->after('date_of_transaction')->nullable();
            
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
