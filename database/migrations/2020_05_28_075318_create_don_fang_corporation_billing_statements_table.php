<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonFangCorporationBillingStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dong_fang_corporation_billing_statements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('bs_id')->nullable();
            $table->string('date')->nullable();
            $table->string('account_no')->nullable();
            $table->string('company_name')->nullable();
            $table->string('address')->nullable();
            $table->string('billing_statement_no')->nullable();
            $table->string('attention')->nullable();
            $table->string('ref_no')->nullable();
            $table->string('po_no')->nullable();
            $table->string('terms')->nullable();
            $table->string('due_date')->nullable();
            $table->string('date_detail')->nullable();
            $table->string('no_pax')->nullable();
            $table->string('particular')->nullable();
            $table->decimal('price_per_pax', 15, 2)->nullable();
            $table->decimal('amount', 15, 2)->nullable();
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
        Schema::dropIfExists('don_fang_corporation_billing_statements');
    }
}
