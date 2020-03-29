<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoloPinoyGrillBranchesRequisitionSlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lolo_pinoy_grill_branches_requisition_slips', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('rs_id');
            $table->string('requesting_department');
            $table->string('request_date');
            $table->string('date_released');
            $table->string('quantity_requested');
            $table->string('unit');
            $table->string('item');
            $table->string('quantity_given');
            $table->string('released_by');
            $table->string('received_by')->nullable();
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
        Schema::dropIfExists('lolo_pinoy_grill_branches_requisition_slips');
    }
}
