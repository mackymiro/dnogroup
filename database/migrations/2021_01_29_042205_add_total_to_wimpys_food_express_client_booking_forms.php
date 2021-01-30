<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalToWimpysFoodExpressClientBookingForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('wimpys_food_express_client_booking_forms', function(Blueprint $table){
            $table->string('qty')->after('motiff')->nullable();
            $table->decimal('amount', 15, 2)->after('qty')->nullable();
            $table->decimal('total', 15,2)->after('type_of_package')->nullable();
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
    }
}
