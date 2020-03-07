<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoloPinoyGrillCommissaryDeliveryReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lolo_pinoy_grill_commissary_delivery_receipts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('dr_id');
            $table->string('delivered_to');
            $table->string('address');
            $table->string('dr_no');
            $table->string('date');
            $table->string('product_id');
            $table->string('qty');
            $table->string('item_description');
            $table->decimal('unit_price', 15, 2);
            $table->decimal('amount', 15, 2);
            $table->string('approved_by');
            $table->string('prepared_by');
            $table->string('checked_by');
            $table->string('received_by');
            $table->string('created_by');
            $table->string('duplicate_status');
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
        Schema::dropIfExists('lolo_pinoy_grill_commissary_delivery_receipts');
    }
}
