<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class LoloPinoyGrillBranchesTest extends TestCase
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
    public function test_user_can_view_petty_cash_list_lp_branches(){
        $user = factory(User::class)->make();
        $response  = $this->actingAs($user, 'web')->get('/lolo-pinoy-grill-branches/petty-cash-list');

        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('lolo-pinoy-grill-branches-petty-cash-list');
    }

     /* @test */  
    public function test_user_can_view_petty_cash_view_lp_branches(){

        $user = factory(User::class)->make();
        $id = 1;
        $response  = $this->actingAs($user, 'web')->get('/lolo-pinoy-grill-branches/petty-cash/view/'.$id);
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('lolo-pinoy-grill-branches-view-petty-cash');      
    }

     /* @test */  
    public function test_user_can_view_utility_lp_branches(){
        $user = factory(User::class)->make();

        $response  = $this->actingAs($user, 'web')->get('/lolo-pinoy-grill-branches/utilities');
        $response->assertStatus(200);
        $response->assertSuccessful('lolo-pinoy-grill-branches-utilities');
    }     
    
     /* @test */ 
    public function test_user_can_view_bills_lp_branches(){
        $user = factory(User::class)->make();
        $id = 1;
        $response  = $this->actingAs($user, 'web')->get('/lolo-pinoy-grill-branches/utilities/view-veco/'.$id);
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('lolo-pinoy-grill-branches-view-utility');  

    }

}
