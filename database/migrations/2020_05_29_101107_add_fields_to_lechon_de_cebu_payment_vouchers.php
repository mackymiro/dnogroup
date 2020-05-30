<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToLechonDeCebuPaymentVouchers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('lechon_de_cebu_payment_vouchers', function(Blueprint $table){
            $table->string('category')->after('issued_date')->nullable();
            $table->string('sub_category')->affter('category')->nullable();
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
        Schema::table('lechon_de_cebu_payment_vouchers', function($table){

        });
    }
}
