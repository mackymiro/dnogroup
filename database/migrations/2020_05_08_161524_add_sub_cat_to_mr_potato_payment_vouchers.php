<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubCatToMrPotatoPaymentVouchers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('mr_potato_payment_vouchers', function(Blueprint $table){
            $table->string('category')->after('issued_date')->nullable();
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
        Schema::table('mr_potato_payment_vouchers', function($table){
            //
        });
    }
}
