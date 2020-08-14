<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdditionalfieldsToLoloPinoyGrillCommissaryBillingStatements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('lolo_pinoy_grill_commissary_billing_statements', function(Blueprint $table){
            $table->string('order')->after('whole_lechon')->nullable();
            $table->string('dr_no')->after('order')->nullable();
            $table->integer('dr_list_id')->after('dr_no')->nullabe();
            $table->integer('invoice_list_id')->after('dr_list_id')->nullable();
            $table->string('product_id')->after('dr_list_id')->nullable();
            $table->string('qty')->after('product_id')->nullable();
            $table->decimal('unit_price', 15,2)->after('qty')->nullable();
            $table->string('unit')->after('unit_price')->nullable();
            $table->decimal('total_kls', 15,2)->after('unit')->nullable();
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
    }
}
