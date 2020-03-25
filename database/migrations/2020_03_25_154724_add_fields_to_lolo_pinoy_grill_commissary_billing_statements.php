<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToLoloPinoyGrillCommissaryBillingStatements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('lolo_pinoy_grill_commissary_billing_statements', function (Blueprint $table) {
             $table->string('branch')->nullable()->after('amount');
             $table->decimal('paid_amout', 15,2)->nullable();
             $table->string('status')->nullable();
             $table->string('collection_date')->nullable();
             $table->string('check_number')->nullable();
             $table->decimal('check_amount', 15,2)->nullable();
             $table->string('or_number')->nullable();
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
        Schema::table('lolo_pinoy_grill_commissary_billing_statements', function($table) {
           
        });
    }
}
