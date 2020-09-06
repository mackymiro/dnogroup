<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSeniordetailsToLoloPinoyGrillBranchesSalesForms extends Migration
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
            $table->string('senior_citizen_label')->after('total_discounts_seniors_pwds')->nullable();
            $table->string('senior_citizen_id')->after('senior_citizen_label')->nullable();
            $table->string('senior_citizen_name')->after('senior_citizen_id')->nullable();
            $table->decimal('senior_amount', 15, 2)->after('senior_citizen_name')->nullable();
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
