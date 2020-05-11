<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class DnoResourcesDevelopmentTest extends TestCase
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
    public function test_user_can_view_purchase_order_form_dno_resources(){
        $user = factory(User::class)->make();
        
        $response  = $this->actingAs($user, 'web')->get('/dno-resources-development/purchase-order');
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('dno-resources-purchase-order');
    }

    
}
