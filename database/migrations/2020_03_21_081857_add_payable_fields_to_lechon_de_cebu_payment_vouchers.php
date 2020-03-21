<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPayableFieldsToLechonDeCebuPaymentVouchers extends Migration
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
            $table->string('invoice_number');
            $table->string('voucher_ref_number');
            $table->string('issued_date');
            $table->decimal('amount_due', 15,2);
            $table->string('delivered_date');
            $table->string('status');
            $table->string('cheque_number');
            $table->decimal('cheque_amount', 15,2);
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
            //$table->dropColumn('invoice_number');
        });
    }
}
