<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWimpysFoodExpressClientBookingFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wimpys_food_express_client_booking_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('bf_id')->nullable();
            $table->string('date_of_event');
            $table->string('time_of_event');
            $table->string('no_of_people');
            $table->string('motiff');
            $table->string('type_of_package');
            $table->string('client');
            $table->string('place_of_event');
            $table->string('mobile_number');
            $table->string('email');
            $table->string('special_requests');
            $table->string('menu')->nullable();
            $table->string('menu_cat')->nullable();
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
        Schema::dropIfExists('wimpys_food_express_client_booking_forms');
    }
}
