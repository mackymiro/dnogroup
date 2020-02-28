<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChequeNoIssuedToCommissaryRawMaterials extends Migration
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
            $table->string('cheque_no_issued')->nullable()->after('requesting_branch');
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
            $table->dropColumn('cheque_no_issued');
        });
    }
}
