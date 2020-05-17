<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoloPinoyGrillBranchesSalesFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lolo_pinoy_grill_branches_sales_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('sf_id')->nullable();
            $table->string('ordered_by')->nullable();
            $table->string('table_no')->nullable();
            $table->string('date')->nullable();
            $table->string('branch')->nullable();
            $table->string('qty');
            $table->string('item_description');
            $table->decimal('amount', 15,2);
            $table->decimal('total_discounts_seniors_pwds', 15, 2)->nullable();
            $table->decimal('total_amount_of_sales', 15, 2)->nullable();
            $table->decimal('gift_cert', 15, 2)->nullable();
            $table->decimal('cash_amount', 15, 2)->nullable();
            $table->decimal('change', 15, 2)->nullable();
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
        Schema::dropIfExists('lolo_pinoy_grill_branches_sales_forms');
    }
}
