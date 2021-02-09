<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToWimpysFoodExpressStatementOfAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('wimpys_food_express_statement_of_accounts', function(Blueprint $table){
            $table->string('order')->after('date_of_transaction')->nullable();
            $table->string('date_of_event')->after('order')->nullable();
            $table->string('time_of_event')->after('date_of_event')->nullable();
            $table->string('no_of_people')->after('time_of_event')->nullable();
            $table->string('motiff')->after('no_of_people')->nullable();
            $table->string('type_of_package')->after('motiff')->nullable();
            $table->string('client')->after('type_of_package')->nullable();
            $table->string('place_of_event')->after('client')->nullable();
            $table->string('dr_list_id')->after('place_of_event')->nullable();
            $table->string('qty')->after('dr_list_id')->nullable();
            $table->string('unit')->after('qty')->nullable();
            $table->decimal('price', 15,2)->after('unit')->nullable();
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
