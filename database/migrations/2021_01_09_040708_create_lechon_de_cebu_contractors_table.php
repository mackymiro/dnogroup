<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLechonDeCebuContractorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lechon_de_cebu_contractors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('c_id')->nullable();
            $table->string('date');
            $table->string('contractor_name');
            $table->decimal('amount', 15,2);
            $table->string('contract_date');
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
        Schema::dropIfExists('lechon_de_cebu_contractors');
    }
}
