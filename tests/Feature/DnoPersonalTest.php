<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\DnoPersonalCreditCard;
use App\DnoPersonalPaymentVoucher;
use App\DnoPersonalProperty;

class DnoPersonalTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @test
     */
    public function test_user_can_view_a_cebu_properties_page()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user, 'web')->get('/dno-peronal/cebu-properties');

        $response->assertSuccessful();
        $response->assertViewIs('dno-personal-properties');
    
    }
   
    /* @test */
    public function test_store_properties(){

    }   

     /* @test */

     public function test_user_can_view_a_vehicles_page(){

            $user = factory(User::class)->make();
            $response  = $this->actingAs($user, 'web')->get('/dno-personal/vehicles');

            $response->assertStatus(200);
            $response->assertSuccessful();
            $response->assertViewIs('dno-personal-vehicles');
     }      

    /* @test */
    public function test_user_can_view_a_personal_expenses(){
        $user = factory(User::class)->make();
        $response  = $this->actingAs($user, 'web')->get('/dno-personal');

        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('dno-personal');
    }
    

     /* @test */
     public function test_user_can_view_a_credit_card_accounts(){
        $user = factory(User::class)->make();
        $response  = $this->actingAs($user, 'web')->get('/dno-personal/credit-card/ald-accounts');

        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('dno-personal-credit-card');
    }


       /* @test */
    public function test_user_can_view_a_payment_voucher_form(){
        $user = factory(User::class)->make();
        $response  = $this->actingAs($user, 'web')->get('/dno-personal/payment-voucher-form');

        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('payment-voucher-form-dno-personal');
        
    }

     /* @test */
    public function test_user_can_view_a_payment_voucher_transaction_list(){
        $user = factory(User::class)->make();
        $pVoucher = factory(DnoPersonalPaymentVoucher::class)->make();
        $response  = $this->actingAs($user, $pVoucher,  'web')->get('/dno-personal/payables/transaction-list');

        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('dno-personal-transaction-list');
    }
    

}
