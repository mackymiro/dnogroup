<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConsigneeContactNumToLechonDeCebuDeliveryRecepipts extends Migration
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
            $table->string('consignee_contact_num')->nullable()->after('consignee_name');
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
            $table->dropColumn('consignee_contact_num');
        });
    }
}
