<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class WlgCorporationTest extends TestCase
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
    public function test_user_can_view_wlg_corp_page(){
        $user = factory(User::class)->make();

        $response  = $this->actingAs($user, 'web')->get('/wlg-corporation');
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('wlg-corporation');
    }

    /* @test */ 
    public function test_user_can_view_payment_voucher_form_wlg(){
        $user = factory(User::class)->make();

        $response  = $this->actingAs($user, 'web')->get('/wlg-corporation/payment-voucher-form');
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('payment-voucher-form-wlg-corp');
    }

    
    /* @test */ 
    public function test_user_can_view_po_form_wlg(){
        $user = factory(User::class)->make();

        $response  = $this->actingAs($user, 'web')->get('/wlg-corporation/purchase-order');
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('wlg-corporation-purchase-order');
    }
}

