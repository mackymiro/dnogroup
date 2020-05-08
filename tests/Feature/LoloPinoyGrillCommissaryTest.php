<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User; 


class LoloPinoyGrillCommissaryTest extends TestCase
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
    public function test_user_can_view_petty_cash_list_lp_grill(){
        $user = factory(User::class)->make();
        $response  = $this->actingAs($user, 'web')->get('/lolo-pinoy-grill-commissary/petty-cash-list');

        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('lolo-pinoy-grill-commissary-petty-cash-list');
    }

     /* @test */
    public function test_user_can_view_payment_voucher_form_lp_grill(){
        
        $user = factory(User::class)->make();
        $response  = $this->actingAs($user, 'web')->get('/lolo-pinoy-grill-commissary/payment-voucher-form');

        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('payment-voucher-form-lolo-pinoy-grill');

    }

       /* @test */
    public function test_user_can_view_utilities_lp_grill(){
        $user = factory(User::class)->make();
        $response  = $this->actingAs($user, 'web')->get('/lolo-pinoy-grill-commissary/utilities');

        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('lolo-pinoy-grill-commissary-utilities');
    }

      /* @test */   
    public function test_user_can_view_utility_bill(){
        $user = factory(User::class)->make();
        $id = 1;
        $response  = $this->actingAs($user, 'web')->get('/lolo-pinoy-grill-commissary/utilities/view-veco/'.$id);

        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('lolo-pinoy-grill-commissary-view-utility');

    }

     /* @test */   
     public function test_user_can_view_petty_cash(){
        $user = factory(User::class)->make();
        $id=1;
        $response  = $this->actingAs($user, 'web')->get('lolo-pinoy-grill-commissary/petty-cash/view/'.$id);

        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('lolo-pinoy-grill-commissary-view-petty-cash');
     }
}
