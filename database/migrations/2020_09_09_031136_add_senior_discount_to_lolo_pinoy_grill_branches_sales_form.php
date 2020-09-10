<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSeniorDiscountToLoloPinoyGrillBranchesSalesForm extends Migration
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
            $table->decimal('senior_discount', 15,2)->after('senior_amount')->nullable();
            $table->decimal('total', 15,2)->after('total_amount_of_sales')->nullable();
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
