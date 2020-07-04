<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChequetotalamountToLoloPinoyGrillCommissaryPaymentVouchers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table('lolo_pinoy_grill_commissary_payment_vouchers', function(Blueprint $table){
            $table->decimal('cheque_total_amount', 15, 2)->after('cheque_amount')->nullable();
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
    }
}
