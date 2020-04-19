<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDnoPersonalCreditCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dno_personal_credit_cards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('bank_name');
            $table->string('account_no');
            $table->string('account_name');
            $table->string('type_of_card');
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
        Schema::dropIfExists('dno_personal_credit_cards');
    }
}
