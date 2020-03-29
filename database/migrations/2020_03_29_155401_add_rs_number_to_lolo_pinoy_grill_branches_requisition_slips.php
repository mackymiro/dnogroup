<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRsNumberToLoloPinoyGrillBranchesRequisitionSlips extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('lolo_pinoy_grill_branches_requisition_slips', function(Blueprint $table) {
            $table->string('rs_number')->after('rs_id');
           
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
          Schema::table('lolo_pinoy_grill_branches_requisition_slips', function($table) {
            $table->dropColumn('rs_nummber');
        });
    }
}
