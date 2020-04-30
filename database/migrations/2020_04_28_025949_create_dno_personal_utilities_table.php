<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDnoPersonalUtilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dno_personal_utilities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('vehicle_unit');
            $table->string('series');
            $table->string('denomination');
            $table->string('body_type');
            $table->string('year_model');
            $table->string('mv_file_no');
            $table->string('plate_no');
            $table->string('engine_no');
            $table->string('cr_no');
            $table->string('location');
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
        Schema::dropIfExists('dno_personal_utilities');
    }
}
