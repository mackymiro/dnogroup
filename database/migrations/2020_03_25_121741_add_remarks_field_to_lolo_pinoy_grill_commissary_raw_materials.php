<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRemarksFieldToLoloPinoyGrillCommissaryRawMaterials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table('lolo_pinoy_grill_commissary_raw_materials', function(Blueprint $table) {
            $table->string('remarks')->nullable()->after('status');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
         Schema::table('lolo_pinoy_grill_commissary_raw_materials', function($table) {
            $table->dropColumn('remarks');
        });
    }
}
