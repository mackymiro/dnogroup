<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoloPinoyGrillCommissaryCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lolo_pinoy_grill_commissary_codes', function (Blueprint $table) {
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
        Schema::dropIfExists('lolo_pinoy_grill_commissary_codes');
    }
}
