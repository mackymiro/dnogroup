<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToDnoResourcesDevelopmentCorpPaymentVouchers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('dno_resources_development_corp_payment_vouchers', function(Blueprint $table){
            $table->string('account_name')->after('account_no')->nullable();
            $table->string('category')->after('account_name')->nullable();
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
    }
}
