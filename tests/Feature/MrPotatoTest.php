<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class MrPotatoTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

     /* @test */ 
    public function test_user_can_view_petty_cash_list_mr_potato(){
        $user = factory(User::class)->make();

        $response  = $this->actingAs($user, 'web')->get('/mr-potato/petty-cash-list');
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('mr-potato-petty-cash-list');
    }

     /* @test */ 
    public function test_user_can_view_payment_voucher_form_mr_potato(){
        $user = factory(User::class)->make();

        $response  = $this->actingAs($user, 'web')->get('/mr-potato/payment-voucher-form');
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('payment-voucher-form-mr-potato');

    } 

     /* @test */ 
    public function test_user_can_view_utilitites_mr_potato(){
        $user = factory(User::class)->make();

        $response  = $this->actingAs($user, 'web')->get('/mr-potato/utilities');
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('mr-potato-utilities');
    }

      /* @test */ 
    public function test_user_can_view_bills_mr_potato(){
        $user = factory(User::class)->make();
        $id = 1;
        $response  = $this->actingAs($user, 'web')->get('/mr-potato/utilities/view-veco/'.$id);
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('mr-potato-view-utility');

    }

}
