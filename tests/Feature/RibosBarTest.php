<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\RibosBarCashiersForm;
use App\User;

class RibosBarTest extends TestCase
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


    public function test_ribos_bar_cashiers_form(){
       
    }

      /* @test */ 
    public function test_user_can_view_petty_cash_list_ribos_bar(){
        $user = factory(User::class)->make();

        $response  = $this->actingAs($user, 'web')->get('/ribos-bar/petty-cash-list');
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('ribos-bar-petty-cash-list');
    }

     /* @test */ 
    public function test_user_can_view_utilities_ribos_bar(){
        $user = factory(User::class)->make();

        $response  = $this->actingAs($user, 'web')->get('/ribos-bar/utilities');
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('ribos-bar-utilities');

    }

     /* @test */ 
    public function test_user_can_view_utilities_bills_ribos_bar_veco(){
        $user = factory(User::class)->make();
        $id=1;
        $response  = $this->actingAs($user, 'web')->get('/ribos-bar/utilities/view-veco/'.$id);
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('ribos-bar-view-utility');

    }

     /* @test */ 
    public function test_user_can_view_utilities_bills_ribos_bar_mcwd(){
        $user = factory(User::class)->make();
        $id=1;
        $response  = $this->actingAs($user, 'web')->get('/ribos-bar/utilities/view-mcwd/'.$id);
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('ribos-bar-view-utility');

    }

     /* @test */ 
     public function test_user_can_view_utilities_bills_ribos_bar_internet(){
        $user = factory(User::class)->make();
        $id=1;
        $response  = $this->actingAs($user, 'web')->get('/ribos-bar/utilities/view-internet/'.$id);
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('ribos-bar-view-utility');

    }

      /* @test */ 
    public function test_user_can_view_petty_cash_ribos_bar(){
        $user = factory(User::class)->make();
        $id=1;
        $response  = $this->actingAs($user, 'web')->get('/ribos-bar/petty-cash/view/'.$id);
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('ribos-bar-view-petty-cash');
    }

     /* @test */ 
    public function test_user_can_view_store_stock_raw_materials_ribos_bar(){
        $user = factory(User::class)->make();
        $response  = $this->actingAs($user, 'web')->get('/ribos-bar/store-stock/raw-materials');
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('ribos-bar-raw-materials');
    }

    /* @test */ 
    public function test_user_can_view_raw_material_details_ribos_bar(){
        $user = factory(User::class)->make();
        $id = 1;
        $response  = $this->actingAs($user, 'web')->get('/ribos-bar/store-stock/view-raw-material-details/'.$id);
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('view-ribos-bar-raw-material-details');
    }

     /* @test */ 
    public function test_user_can_view_store_stock_stock_inventory(){
        $user = factory(User::class)->make();
        $response  = $this->actingAs($user, 'web')->get('/ribos-bar/store-stock/stocks-inventory');
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('ribos-bar-store-stock-inventory');
    }

     /* @test */ 
    public function test_user_can_view_store_stock_delivery_outlet(){
        $user = factory(User::class)->make();
        $response  = $this->actingAs($user, 'web')->get('/ribos-bar/store-stock/delivery-outlets');
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('ribos-bar-delivery-outlet');
    }

     /* @test */ 
    public function test_user_can_view_inventory(){
        $user = factory(User::class)->make();
        $id = 1;
        $response  = $this->actingAs($user, 'web')->get('/ribos-bar/store-stock/view-stock-inventory/'.$id);
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('ribos-bar-view-stock-inventory');

    }

      /* @test */ 
    public function test_user_can_view_inventory_of_stocks_store_stock(){
        $user = factory(User::class)->make();
        $response  = $this->actingAs($user, 'web')->get('/ribos-bar/store-stock/inventory-of-stocks');
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('ribos-bar-stocks-inventory');
    }

    /* @test */ 
    public function test_user_can_view_inventory_of_stocks_view(){
        $user = factory(User::class)->make();
        $id = 1;
        $response  = $this->actingAs($user, 'web')->get('/ribos-bar/store-stock/view-inventory-of-stocks/'.$id);
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('ribos-bar-view-inventory-stock');
    }

}

