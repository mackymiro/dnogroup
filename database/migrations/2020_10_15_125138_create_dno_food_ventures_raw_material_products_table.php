<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDnoFoodVenturesRawMaterialProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dno_food_ventures_raw_material_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('raw_materials_id')->nullable();
            $table->string('branch')->nullable();
            $table->string('product_id_no');
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
        Schema::dropIfExists('dno_food_ventures_raw_material_products');
    }
}
