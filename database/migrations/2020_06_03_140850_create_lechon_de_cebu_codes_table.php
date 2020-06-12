<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLechonDeCebuCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lechon_de_cebu_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('lechon_de_cebu_code');
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
        Schema::dropIfExists('lechon_de_cebu_codes');
    }
}
