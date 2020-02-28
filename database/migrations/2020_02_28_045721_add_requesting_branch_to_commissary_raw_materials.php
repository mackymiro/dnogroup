<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRequestingBranchToCommissaryRawMaterials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table('commissary_raw_materials', function(Blueprint $table) {
            $table->string('requesting_branch')->after('qty');
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
         Schema::table('commissary_raw_materials', function($table) {
            $table->dropColumn('requesting_branch');
        });
    }
}
