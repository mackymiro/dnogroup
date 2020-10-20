<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewfieldsToRibosBarBillingStatements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ribos_bar_billing_statements', function(Blueprint $table){
            $table->string('order')->after('terms')->nullable();
            $table->string('dr_no')->after('order')->nullable();
            $table->integer('dr_list_id')->after('dr_no')->nullable();
            $table->string('product_id')->after('dr_list_id')->nullable();
            $table->string('qty')->after('product_id')->nullable();
            $table->string('unit')->after('qty')->nullable();
            $table->decimal('unit_price', 15,2)->after('unit')->nullable();
            $table->decimal('total_kls', 15,2)->after('unit_price')->nullable();
            $table->integer('invoice_list_id')->after('total_kls')->nullable();
            $table->string('branch')->after('invoice_list_id')->nullable();
            $table->decimal('paid_amount', 15, 2)->after('branch')->nullable();
            $table->string('check_number')->after('paid_amount')->nulable();
            $table->decimal('check_amount', 15,2)->after('check_number')->nullable();
            $table->string('or_number')->after('check_amount')->nullable();      
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
