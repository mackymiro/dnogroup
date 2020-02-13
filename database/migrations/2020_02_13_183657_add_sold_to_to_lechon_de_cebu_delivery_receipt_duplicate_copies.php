<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoldToToLechonDeCebuDeliveryReceiptDuplicateCopies extends Migration
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
            $table->string('sold_to')->after('dr_id');
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
            $table->dropColumn('sold_to');
        });
    }
}
