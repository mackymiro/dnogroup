<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User; 
use App\LechonDeCebuSalesInvoice;

class LoloPinoyLechonDeCebuTest extends TestCase
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
    public function test_user_can_view_a_lechon_de_cebu(){
       
    }

     /* @test */
      public function test_user_can_view_a_delivery_receipt_form(){

        $user = factory(User::class)->make();
        $response  = $this->actingAs($user, 'web')->get('/lolo-pinoy-lechon-de-cebu/delivery-receipt-form');

        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('lechon-de-cebu-delivery-receipt-form');

     }

      /* @test */
      public function test_user_can_view_a_delivery_receipt_list(){
       

     }

      /* @test */
      public function test_user_can_view_a_purchase_order_form(){

        $user = factory(User::class)->make();
        $response  = $this->actingAs($user, 'web')->get('/lolo-pinoy-lechon-de-cebu/purchase-order');

        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('lechon-de-cebu-purchase-order');

     }

    /* @test */
     public function test_user_can_view_a_billing_statement_form(){
        $user = factory(User::class)->make();
        $response  = $this->actingAs($user, 'web')->get('/lolo-pinoy-lechon-de-cebu/billing-statement-form');

        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('lechon-de-cebu-billing-statement-form');
     }

     

      /* @test */
     public function test_user_can_view_a_payment_voucher_form(){
         $user = factory(User::class)->make();

         $response  = $this->actingAs($user, 'web')->get('/lolo-pinoy-lechon-de-cebu/payment-voucher-form');

         $response->assertStatus(200);
         $response->assertSuccessful();
         $response->assertViewIs('payment-voucher-form');

     }

      /* @test */
    public function test_user_can_view_a_raw_materials(){
        $user = factory(User::class)->make();

        $response  = $this->actingAs($user, 'web')->get('/lolo-pinoy-lechon-de-cebu/commissary/raw-materials');

        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('commissary-raw-materials');

    }

      /* @test */
    public function test_user_can_view_a_commissary_stock_inventory(){
        $user = factory(User::class)->make();

        $response  = $this->actingAs($user, 'web')->get('/lolo-pinoy-lechon-de-cebu/commissary/stocks-inventory');

        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('commissary-stocks-inventory');

    }

     /* @test */
     public function test_user_can_view_a_commissary_inventory_of_stocks(){
        $user = factory(User::class)->make();

        $response  = $this->actingAs($user, 'web')->get('/lolo-pinoy-lechon-de-cebu/commissary/inventory-of-stocks');

        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('commissary-inventory-of-stocks');

    }

     /* @test */
     public function test_user_can_view_a_sales_per_outlet(){
        $user = factory(User::class)->make();

        $response  = $this->actingAs($user, 'web')->get('/lolo-pinoy-lechon-de-cebu/sales-per-outlet');

        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('lechon-de-cebu-sales-invoice-sales-per-outlet');

    }

     /* @test */
     public function test_user_can_view_a_sales_private_orders(){
        $user = factory(User::class)->make();

        $response  = $this->actingAs($user, 'web')->get('/lolo-pinoy-lechon-de-cebu/sales-invoice/private-orders');

        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('lechon-de-cebu-sales-invoice-private-orders');

    }

     /* @test */
     public function test_a_sales_invoice_date_is_required(){
       /* $invoice = factory(LechonDeCebuSalesInvoice::class)->create();

        $response = $this->actingAs($invoice, 'web')->post('lolo-pinoy-lechon-de-cebu/store-sales-invoice',[
            'date' =>'2018-09-09'
        ]);

        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertSessionHasErrors('date');*/

    }

}
