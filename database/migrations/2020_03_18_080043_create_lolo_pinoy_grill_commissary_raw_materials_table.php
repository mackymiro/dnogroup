<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoloPinoyGrillCommissaryRawMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lolo_pinoy_grill_commissary_raw_materials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('rm_id')->nullable();
            $table->string('branch')->nullable();
            $table->string('product_id_no');
            $table->string('product_name')->nullable();
            $table->decimal('unit_price', 15,2)->nullable();
            $table->string('unit')->nullable();
            $table->string('in')->nullable();
            $table->string('out')->nullable();
            $table->decimal('stock_amount', 15,2)->nullable();
            $table->string('remaining_stock')->nullable();
            $table->decimal('amount', 15,2)->nullable();
            $table->string('supplier')->nullable();
            $table->string('date')->nullable();
            $table->string('item')->nullable();
            $table->string('description')->nullable();
            $table->string('reference_no')->nullable();
            $table->string('qty');
            $table->string('requesting_branch')->nullable();
            $table->string('cheque_no_issued')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('lolo_pinoy_grill_commissary_raw_materials');
    }
}
