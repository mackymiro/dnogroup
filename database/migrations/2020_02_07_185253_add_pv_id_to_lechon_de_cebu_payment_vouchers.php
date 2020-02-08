<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPvIdToLechonDeCebuPaymentVouchers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table('lechon_de_cebu_payment_vouchers', function(Blueprint $table) {
            $table->integer('pv_id')->after('user_id');
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
          Schema::table('lechon_de_cebu_payment_vouchers', function($table) {
            $table->dropColumn('pv_id');
        });
    }

}
