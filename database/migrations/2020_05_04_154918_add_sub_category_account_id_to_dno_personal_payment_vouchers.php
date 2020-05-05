<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubCategoryAccountIdToDnoPersonalPaymentVouchers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('dno_personal_payment_vouchers', function(Blueprint $table){
            $table->string('sub_category_account_id')->after('sub_category_bill_name')->nullable();
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
        Schema::table('dno_personal_payment_vouchers', function($table){
            //
        });
    }
}
