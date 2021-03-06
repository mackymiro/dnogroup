<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWlgCorporationPettyCashesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wlg_corporation_petty_cashes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('pc_id')->nullable();
            $table->string('date')->nullable();
            $table->string('petty_cash_name')->nullable();
            $table->string('petty_cash_summary')->nullable();
            $table->decimal('amount', 15,2)->nullable();
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
        Schema::dropIfExists('wlg_corporation_petty_cashes');
    }
}
