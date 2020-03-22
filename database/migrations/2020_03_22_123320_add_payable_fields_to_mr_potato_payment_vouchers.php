<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPayableFieldsToMrPotatoPaymentVouchers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table('mr_potato_payment_vouchers', function(Blueprint $table) {
            $table->string('invoice_number')->nullable()->after('method_of_payment');
            $table->string('voucher_ref_number');
            $table->string('issued_date')->nullable();
            $table->decimal('amount_due', 15,2)->nullable();
            $table->string('delivered_date')->nullable();
            $table->string('status')->nullable();
            $table->string('cheque_number')->nullable();
            $table->decimal('cheque_amount', 15,2)->nullable();
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
         Schema::table('mr_potato_payment_vouchers', function($table) {
            //$table->dropColumn('invoice_number');
        });
    }
}
