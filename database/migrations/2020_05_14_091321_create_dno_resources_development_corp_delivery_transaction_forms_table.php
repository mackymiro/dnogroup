<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDnoResourcesDevelopmentCorpDeliveryTransactionFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dno_resources_development_corp_delivery_transaction_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('dt_id');
            $table->string('supplier_name')->nullable();
            $table->string('delivery_date')->nullable();
            $table->string('delivered_to')->nullable();
            $table->string('dr_no')->nullable();
            $table->string('delivery_description')->nullable();
            $table->string('qty')->nullable();
            $table->decimal('total', 15, 2)->nullable();
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
        Schema::dropIfExists('dno_resources_development_corp_delivery_transaction_forms');
    }
}
