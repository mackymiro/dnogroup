<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDnoPersonalPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dno_personal_properties', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('pp_id');
            $table->string('property_name');
            $table->string('property_account_code');
            $table->string('property_account_name');
            $table->string('address');
            $table->string('unit');
            $table->string('status');
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
        Schema::dropIfExists('dno_personal_properties');
    }
}
