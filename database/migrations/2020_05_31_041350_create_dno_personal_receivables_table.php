<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDnoPersonalReceivablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dno_personal_receivables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('r_id')->nullable();
            $table->string('name_of_tenant')->nullable();
            $table->string('contract_date')->nullable();
            $table->string('unit_no')->nullable();
            $table->decimal('monthly_rent')->nullable();
            $table->string('advance_deposit')->nullable();
            $table->decimal('advance_deposit_amount', 15, 2)->nullable();
            $table->string('period')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->string('remarks')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('dno_personal_receivables');
    }
}
