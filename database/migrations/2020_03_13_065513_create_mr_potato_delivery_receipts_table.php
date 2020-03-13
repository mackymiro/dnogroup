<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMrPotatoDeliveryReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mr_potato_delivery_receipts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('dr_id')->nullable();
            $table->string('delivered_to')->nullable();
            $table->string('address')->nullable();
            $table->string('dr_no');
            $table->string('date')->nullable();
            $table->string('product_id');
            $table->string('qty');
            $table->string('item_description');
            $table->decimal('unit_price', 15, 2);
            $table->decimal('amount', 15, 2)->nullable();
            $table->string('approved_by')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('checked_by')->nullable();
            $table->string('received_by');
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
        Schema::dropIfExists('mr_potato_delivery_receipts');
    }
}
