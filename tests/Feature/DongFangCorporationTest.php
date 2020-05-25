<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class DongFangCorporationTest extends TestCase
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
    public function test_user_can_view_dong_fang_corp_page(){
        $user = factory(User::class)->make();

        $response  = $this->actingAs($user, 'web')->get('/dong-fang-corporation');
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('dong-fang-corporation');
    }
    
    /* @test */ 
     public function test_user_can_view_payment_voucher_form_dong_fang_corp(){
        $user = factory(User::class)->make();

        $response  = $this->actingAs($user, 'web')->get('/dong-fang-corporation/payment-voucher-form');
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('payment-voucher-form-dong-fang-corp');
    }
    
}


