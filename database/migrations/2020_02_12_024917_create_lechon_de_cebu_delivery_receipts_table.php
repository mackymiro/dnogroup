<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLechonDeCebuDeliveryReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lechon_de_cebu_delivery_receipts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('dr_id');
            $table->string('delivered_to');
            $table->string('time');
            $table->string('dr_no');
            $table->string('date');
            $table->string('contact_person');
            $table->string('mobile_num');
            $table->string('qty');
            $table->string('description');
            $table->decimal('price', 15, 2);
            $table->decimal('total', 15, 2);
            $table->string('special_instruction');
            $table->string('prepared_by');
            $table->string('checked_by');
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
        Schema::dropIfExists('lechon_de_cebu_delivery_receipts');
    }
}
