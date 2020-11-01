<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDnoFoundationIncBillingStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dno_foundation_inc_billing_statements', function (Blueprint $table) {
            $table->increments('id');   
            $table->integer('user_id');
            $table->integer('billing_statement_id')->nullable();
            $table->string('bill_to')->nullable();
            $table->string('addrress')->nullable();
            $table->string('date')->nullable();
            $table->string('period_cover')->nullable();
            $table->string('terms')->nullable();
            $table->string('date_of_transaction')->nullable();
            $table->string('dr_no')->nullable();
            $table->string('description')->nullable();
            $table->decimal('unit_price', 15,2)->nullable();
            $table->decimal('amount', 15,2)->nullable();
            $table->decimal('total_amount', 15,2)->nullable();
            $table->decimal('paid_amount', 15,2)->nullable();
            $table->string('check_number')->nullable();
            $table->decimal('check_amount', 15,2)->nullable();
            $table->string('or_number')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('approved_by')->nullabe();
            $table->string('created_by');
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
        Schema::dropIfExists('dno_foundation_inc_billing_statements');
    }
}
