<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldsToWlgCorporationInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('wlg_corporation_invoices',function(Blueprint $table){
            $table->string('kg_cbm')->after('total_amount')->nullable();
            $table->string('gross_weight')->after('kg_cbm')->nullable();
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
        Schema::table('wlg_corporation_invoices', function($table){

        });
    }
}
