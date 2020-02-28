<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToCommissaryRawMaterials extends Migration
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
            $table->string('status')->nullable()->after('cheque_no_issued');
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
            $table->dropColumn('status');
        });
    }
}
