<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMrPotatoPurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mr_potato_purchase_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('po_id')->nullable();
            $table->string('paid_to')->nullable();
            $table->string('address')->nullable();
            $table->string('p_o_number');
            $table->string('date')->nullable();
            $table->integer('quantity');
            $table->string('description');
            $table->decimal('unit_price', 15,2);
            $table->decimal('amount', 15,2);
            $table->decimal('total_price', 15,2);
            $table->string('requested_by')->nullabl();
            $table->string('prepared_by')->nullable();
            $table->string('checked_by')->nullable();
            $table->string('requesting_branch')->nullable();
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
        Schema::dropIfExists('mr_potato_purchase_orders');
    }
}
