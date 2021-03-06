<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWimpysFoodExpressPaymentVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wimpys_food_express_payment_vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('pv_id')->nullable();
            $table->string('date')->nullable();
            $table->string('paid_to')->nullable();
            $table->string('account_no')->nullable();
            $table->string('account_name')->nullable();
            $table->string('particulars')->nullable();
            $table->decimal('amount', 15,2)->nullable();
            $table->string('currency')->nullable();
            $table->string('method_of_payment')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('date_approved')->nullable();
            $table->string('received_by_date')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('issued_date')->nullable();
            $table->string('category')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('sub_category_id')->nullable();
            $table->string('supplier')->nullable();
            $table->decimal('amount_due', 15,2)->nullable();
            $table->string('delivered_date')->nullable();
            $table->string('status')->nullable();
            $table->string('account_name_no')->nullable();
            $table->string('cheque_number')->nullable();
            $table->decimal('cheque_amount', 15,2)->nullable();
            $table->decimal('cheque_total_amount', 15,2)->nullable();
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
        Schema::dropIfExists('wimpys_food_express_payment_vouchers');
    }
}
