<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoloPinoyGrillBranchesStoreStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lolo_pinoy_grill_branches_store_stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('di_id')->nullable();
            $table->string('dr_no')->nullable();
            $table->string('supplier')->nullable();
            $table->string('qty')->nullable();
            $table->string('unit')->nullable();
            $table->decimal('product_in', 15,2)->nullable();
            $table->decimal('product_out', 15,2)->nullable();
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
        Schema::dropIfExists('lolo_pinoy_grill_branches_store_stocks');
    }
}
