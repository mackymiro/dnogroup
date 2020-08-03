<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLechonDeCebuRawMaterialProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lechon_de_cebu_raw_material_products', function (Blueprint $table) {
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
        Schema::dropIfExists('lechon_de_cebu_raw_material_products');
    }
}
