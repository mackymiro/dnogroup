<?php

use Illuminate\Database\Seeder;

class RibosBarCashierFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\RibosBarCashiersForm::class, 10)->create();
    }
}
