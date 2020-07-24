<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLechonDeCebuSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lechon_de_cebu_suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('s_id')->nullable();
            $table->string('date');
            $table->string('supplier_name');
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
        Schema::dropIfExists('lechon_de_cebu_suppliers');
    }
}
