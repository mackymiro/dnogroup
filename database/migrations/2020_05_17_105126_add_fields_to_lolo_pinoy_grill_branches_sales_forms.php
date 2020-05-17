<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToLoloPinoyGrillBranchesSalesForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('lolo_pinoy_grill_branches_sales_forms', function(Blueprint $table){
            $table->string('invoice_number')->after('sf_id')->nullable();
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
        Schema::table('lolo_pinoy_grill_branches_sales_forms', function($table){
            //
        });
    }
}
