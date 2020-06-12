<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdditionalFieldsToLechonDeCebuBillingStatements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('lechon_de_cebu_billing_statements', function(Blueprint $table){
            $table->decimal('body', 15, 2)->after('qty')->nullable();
            $table->decimal('head_and_feet', 15, 2)->after('body')->nullable();
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
