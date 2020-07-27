<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWlgCorporationSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wlg_corporation_suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('s_id')->nullable();
            $table->string('date');
            $table->string('supplier_name');
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
        Schema::dropIfExists('wlg_corporation_suppliers');
    }
}
