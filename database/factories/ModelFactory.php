<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'first_name' => $faker->name,
        'last_name'=>$faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'role_type'=>rand(0,100),
        'remember_token' => str_random(10),
    ];
});



$factory->define(App\RibosBarCashiersForm::class, function (Faker\Generator $faker) {

    return [
        'user_id' => rand(0,100),
        'cf_id'=>rand(0,100),
        'date'=>str_random(10),
        'cashier_name'=>$faker->name,
        'bar_tender_name'=>$faker->name,
        'shifting_schedule'=>$faker->name,
        'starting_os'=>str_random(10),
        'cash_sales'=>rand(0,100),
        'credit_card_sales'=>rand(0,100),
        'signing_privilage_sales'=>str_random(10),
        'total_reading'=>str_random(10),
        'closing_os'=>str_random(10),
        'items'=>str_random(10),
        'opening_inventory'=>str_random(10),
        'sold'=>str_random(10),
        'closing'=>str_random(10),
        'total'=>rand(0,100),
        'created_by'=>str_random(10),
       
    ];
});
