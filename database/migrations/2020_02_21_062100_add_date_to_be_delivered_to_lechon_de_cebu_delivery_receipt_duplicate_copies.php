<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateToBeDeliveredToLechonDeCebuDeliveryReceiptDuplicateCopies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table('lechon_de_cebu_delivery_receipt_duplicate_copies', function(Blueprint $table) {
            $table->string('date_to_be_delivered')->after('date');
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
         Schema::table('lechon_de_cebu_delivery_receipt_duplicate_copies', function($table) {
            $table->dropColumn('date_to_be_delivered');
        });
    }
}
