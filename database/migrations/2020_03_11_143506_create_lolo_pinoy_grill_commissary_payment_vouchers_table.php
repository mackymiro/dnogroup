<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoloPinoyGrillCommissaryPaymentVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lolo_pinoy_grill_commissary_payment_vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('pv_id')->nullable();
            $table->string('reference_number');
            $table->string('date');
            $table->string('paid_to');
            $table->string('account_no');
            $table->string('particulars');
            $table->string('amount');
            $table->string('method_of_payment');
            $table->string('prepared_by');
            $table->string('approved_by');
            $table->string('date_apprroved');
            $table->string('received_by_date');
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lolo_pinoy_grill_commissary_payment_vouchers');
    }
}
