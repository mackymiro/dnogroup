<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWimpysFoodExpressDeliveryReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wimpys_food_express_delivery_receipts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('dr_id')->nullable();
            $table->string('sold_to')->nullable();
            $table->string('delivered_to')->nullable();
            $table->string('time')->nullable();
            $table->string('dr_no')->nullable();
            $table->string('date')->nullable();
            $table->string('date_to_be_delivered')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('mobile_num')->nullable();
            $table->string('qty')->nullable();
            $table->string('unit')->nullable();
            $table->string('description')->nullable();
            $table->decimal('price', 15,2)->nullable();
            $table->decimal('total', 15,2)->nullable();
            $table->string('special_instruction')->nullable();
            $table->string('consignee_name')->nullable();
            $table->string('consignee_contact_num')->nullable();
            $table->string('status')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('checked_by')->nullable();
            $table->string('received_by')->nullable();
            $table->string('created_by');
            $table->timestamps();
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
        Schema::dropIfExists('wimpys_food_express_delivery_receipts');
    }
}
