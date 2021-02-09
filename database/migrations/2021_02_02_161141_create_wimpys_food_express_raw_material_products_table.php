<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWimpysFoodExpressRawMaterialProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wimpys_food_express_raw_material_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('raw_materials_id');
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
        Schema::dropIfExists('wimpys_food_express_raw_material_products');
    }
}
