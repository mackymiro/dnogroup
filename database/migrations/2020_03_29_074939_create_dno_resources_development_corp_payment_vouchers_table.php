<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDnoResourcesDevelopmentCorpPaymentVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dno_resources_development_corp_payment_vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('pv_id')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('date')->nullable();
            $table->string('paid_to')->nullable();
            $table->string('account_no')->nullable();
            $table->string('particulars')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->string('method_of_payment')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('date_apprroved')->nullable();
            $table->string('received_by_date')->nullable();
            $table->string('voucher_ref_number');
            $table->string('issued_date')->nullable();
            $table->decimal('amount_due', 15,2)->nullable();
            $table->string('status')->nullable();
            $table->string('cheque_number')->nullable();
            $table->decimal('cheque_amount', 15,2)->nullable();
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
        Schema::dropIfExists('dno_resources_development_corp_payment_vouchers');
    }
}
