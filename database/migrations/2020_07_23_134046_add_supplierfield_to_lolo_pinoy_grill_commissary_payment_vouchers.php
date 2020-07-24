<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSupplierfieldToLoloPinoyGrillCommissaryPaymentVouchers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('lolo_pinoy_grill_commissary_payment_vouchers', function(Blueprint $table){
            $table->string('supplier_id')->after('sub_category_account_id')->nullable();
            $table->string('supplier_name')->after('supplier_id')->nullable();
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
    }
}
