<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWimpysFoodExpressOrderFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wimpys_food_express_order_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('order_id')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('no_of_people')->nullable();
            $table->string('items')->nullable();
            $table->string('qty')->nullable();
            $table->string('unit')->nullable();
            $table->decimal('price', 15,2)->nullable();
            $table->decimal('total', 15,2)->nullable();
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
        Schema::dropIfExists('wimpys_food_express_order_forms');
    }
}
