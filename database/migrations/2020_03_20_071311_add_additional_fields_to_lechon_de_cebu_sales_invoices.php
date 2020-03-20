<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdditionalFieldsToLechonDeCebuSalesInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table('lechon_de_cebu_sales_invoices', function(Blueprint $table) {
            $table->decimal('body', 15,2)->after('total_kls');
            $table->decimal('head_and_feet', 15,2)->after('body');
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
         Schema::table('lechon_de_cebu_sales_invoices', function($table) {
            $table->dropColumn('qty');
        });
    }
}
