<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftdeleteToLoloPinoyGrillBranchesRequisitionSlips extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('lolo_pinoy_grill_branches_requisition_slips', function(Blueprint $table){
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
        //
        Schema::table('lolo_pinoy_grill_branches_requisition_slips', function(Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
