<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeliveredDateToDnoResourcesDevelopmentCorpPaymentVouchers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table('dno_resources_development_corp_payment_vouchers', function(Blueprint $table) {
            $table->string('delivered_date')->nullable()->after('amount_due');
           
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
         Schema::table('dno_resources_development_corp_payment_vouchers', function($table) {
            $table->dropColumn('delivered_date');
        });
    }
}
