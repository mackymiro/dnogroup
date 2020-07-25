<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDnoResourcesDevelopmentCorpSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dno_resources_development_corp_suppliers', function (Blueprint $table) {
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
        Schema::dropIfExists('dno_resources_development_corp_suppliers');
    }
}
