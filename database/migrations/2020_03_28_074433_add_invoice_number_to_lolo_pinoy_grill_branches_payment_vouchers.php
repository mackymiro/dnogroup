<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvoiceNumberToLoloPinoyGrillBranchesPaymentVouchers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
          Schema::table('lolo_pinoy_grill_branches_payment_vouchers', function(Blueprint $table) {
            $table->string('invoice_number')->nullable()->after('method_of_payment');
           
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
          Schema::table('lolo_pinoy_grill_branches_payment_vouchers', function($table) {
            $table->dropColumn('invoice_number');
        });
    }
}
