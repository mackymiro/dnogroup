<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDinoIndustrialCorporationCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dino_industrial_corporation_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('dic_code');
            $table->integer('module_id');
            $table->string('module_code');
            $table->string('module_name');
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
        Schema::dropIfExists('dino_industrial_corporation_codes');
    }
}
