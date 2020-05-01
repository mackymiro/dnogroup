<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToDnoPersonalProperties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('dno_personal_properties', function(Blueprint $table){
            $table->string('account_name')->after('flag')->nullable();
            $table->string('account_id')->after('account_name')->nullable();
            $table->string('meter_no')->after('account_id')->nullable();
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
        Schema::table('dno_personal_properties', function($table){
            //
        }); 
    }
}
