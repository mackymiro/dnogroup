<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToWimpysFoodExpressClientBookingForms extends Migration
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
            $table->string('item')->after('qty')->nullable();
            $table->decimal('less', 15,2)->after('item')->nullable();
            $table->decimal('downpayment', 15,2)->after('less')->nullable();
    
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
