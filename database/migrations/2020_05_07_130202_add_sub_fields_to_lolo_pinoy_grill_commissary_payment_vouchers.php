<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubFieldsToLoloPinoyGrillCommissaryPaymentVouchers extends Migration
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
            $table->string('sub_category')->after('category')->nullable();
            $table->string('sub_category_account_id')->after('sub_category')->nullable();
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
        Schema::table('lolo_pinoy_grill_commissary_payment_vouchers', function($table){
            //
        });
    }
}
