<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConsigneeNameToLechonDeCebuDeliveryReceipts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table('lechon_de_cebu_delivery_receipts', function(Blueprint $table) {
            $table->string('consignee_name')->nullable()->after('special_instruction');
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
         Schema::table('lechon_de_cebu_delivery_receipts', function($table) {
            $table->dropColumn('consignee_name');
        });
    }
}
