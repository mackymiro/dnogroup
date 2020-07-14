<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalGroundPaymentVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('local_ground_payment_vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('pv_id')->nullable();
            $table->string('date')->nullable();
            $table->string('paid_to')->nullable();
            $table->string('account_no')->nullable();
            $table->string('account_name')->nullable();
            $table->string('particulars')->nullable();
            $table->decimal('amount', 15,2)->nullable();
            $table->string('method_of_payment')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('date_approved')->nullable();
            $table->string('received_by_date')->nullable();
            $table->string('created_by');
            $table->string('invoice_number')->nullable();
            $table->string('voucher_ref_number')->nullable();
            $table->string('issued_date')->nullable();
            $table->string('category')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('sub_category_account_id')->nullable();
            $table->decimal('amount_due', 15,2)->nullable();
            $table->string('delivered_date')->nullable();
            $table->string('status')->nullable();
            $table->string('cheque_number')->nullable();
            $table->decimal('cheque_amount', 15,2)->nullable();
            $table->decimal('cheque_total_amount', 15,2)->nullable();   
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('local_ground_payment_vouchers');
    }
}
