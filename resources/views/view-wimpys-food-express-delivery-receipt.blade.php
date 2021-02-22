@extends('layouts.wimpys-food-express-app')
@section('title', 'View Delivery Receipt |')
@section('content')

<div id="wrapper">
	<!-- Sidebar -->
   @include('sidebar.sidebar-wimpys-food-express')
     <div id="content-wrapper">
     	<div class="container-fluid">
     		<!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Wimpy's Food Express</a>
              </li>
              <li class="breadcrumb-item active">View Delivery Receipt</li>
            </ol>
             <a href="{{ url('wimpys-food-express/delivery-receipt/lists') }}">Back to Lists</a>
          	<div class="col-lg-12">
                 <img src="{{ asset('images/digitized-logos/wimpys-logo1.jpg')}}" width="350" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
             
            	 <h4 class="text-center"><u>VIEW DELIVERY RECEIPT</u></h4>
            </div>
            <div class="row">
            	 <div class="col-lg-12">
            	 	 <div class="card mb-3">
                  	 	 	<div class="card-header">
                            <i class="fas fa-receipt" aria-hidden="true"></i>
                                  View Delivery Receipt
                                  @if($viewDeliveryReceipt[0]->deleted_at == NULL)
                                  <div class="float-right">
                                  
                                    <a href="{{ action('WimpysFoodExpressController@printDelivery', $viewDeliveryReceipt[0]->id)}}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                                  
                                  </div>
                                  @endif
                        </div>
                        <div class="card-body">
                        @if($viewDeliveryReceipt[0]->deleted_at != NULL)
                          <h1 style="color:red; font-size:28px; font-weight:bold">This Item Has Been Deleted! (CLERICAL ERROR)</h1>
                          @endif
                          <div class="form-group">
                              <div class="form-row">
                                   <div class="col-lg-6">
                                    <table class="table table-bordered">
                                      <thead>
                                          <tr>
                                              <th width="30%">Sold To</th>
                                              <th>{{ $viewDeliveryReceipt[0]->sold_to }}</th>
                                          </tr>
                                          <tr>
                                              <th>Delivered To</th>
                                              <th>{{ $viewDeliveryReceipt[0]->delivered_to}}</th>
                                          </tr>
                                          <tr> 
                                              <th>Contact Person</th>
                                              <th>{{ $viewDeliveryReceipt[0]->contact_person }}</th>
                                          </tr>
                                          <tr>
                                              <th>Time</th>
                                              <th>{{ $viewDeliveryReceipt[0]->time }}</th>
                                          </tr>
                                         
                                         
                                      </thead>
                                      
                                  </table>   
                             </div>
                          <div class="col-lg-6">
                              <table class="table table-bordered">
                                  <thead>
                                      <tr>
                                          <th width="30%">Mobile #</th>
                                          <th>{{ $viewDeliveryReceipt[0]->mobile_num}}</th>
                                      </tr>
                                      <tr> 
                                          <th>DR No</th>
                                          <th>{{ $viewDeliveryReceipt[0]->module_code }}{{ $viewDeliveryReceipt[0]->wimpys_food_express_code }}</th>
                                      </tr> 
                                       <tr>
                                          <th>Date</th>
                                          <th>{{ $viewDeliveryReceipt[0]->date }}</th>
                                       </tr>
                                        <tr>
                                          <th>Date To Be Delivered</th>
                                          <th>{{ $viewDeliveryReceipt[0]->date_to_be_delivered }}</th>
                                       </tr>
                                       <tr>
                                          <th>Special Instructions</th>
                                          <th>{{ $viewDeliveryReceipt[0]->special_instruction }}</th>
                                       </tr>
                                  </thead>
                              </table>
                          </div>
                          </div>
                          </div>	
                        	 <table class="table table-striped">
                        	 	     <thead>
	                                  <tr>
                                       <th class="bg-info" style="color:white;">Product ID</th>
	                                    <th class="bg-info" style="color:white;">Qty</th>
                                      <th class="bg-info" style="color:white;">Unit</th>
	                                    <th class="bg-info" style="color:white;">Item Description</th>
                                      <th class="bg-info" style="color:white;">Unit Price</th>
	                                    <th class="bg-info" style="color:white;">Amount</th>
	                                  
	                                  </tr>
                                  </thead>
                                  <tbody>
                                      <tr>
                                        <td>{{ $viewDeliveryReceipt[0]->product_id}}</td>
                                        <td>{{ $viewDeliveryReceipt[0]->qty}}</td>
                                        <td>{{ $viewDeliveryReceipt[0]->unit}}</td>
                                        <td>{{ $viewDeliveryReceipt[0]->description}}</td>
                                        <td><?= number_format($viewDeliveryReceipt[0]->unit_price, 2)?></td>
                                        <td><?= number_format($viewDeliveryReceipt[0]->price, 2)?></td>
                                    </tr>

                                  	 @foreach($deliveryReceipts as $deliveryReceipt)
                                     <tr>
                                        <td>{{ $deliveryReceipt['product_id'] }}</td>
                                        <td>{{ $deliveryReceipt['qty'] }}</td>
                                        <td>{{ $deliveryReceipt['unit'] }}</td>
                                        <td>{{ $deliveryReceipt['description'] }}</td>
                                        <td><?= number_format($deliveryReceipt['unit_price'], 2)?></td>
                                        <td><?= number_format($deliveryReceipt['price'], 2)?></td>
                                      </tr>
                                  	
                                      
                                       @endforeach
                                       <tr>
	                                        <td></td>
	                                        <td></td>
	                                        <td></td>
	                                        <td><strong>Total</strong></td>
	                                        <td>₱ <?= number_format($sum, 2)?></td>
	                                        <td>₱ <?= number_format($sum2, 2)?></td>
                                      	</tr>
                                  </tbody>

                        	 </table>
                           <br>
                           <br>
                           <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Prepared By:</th>
                                        <th>Checked By:</th>
                                        <th>Received By:</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $viewDeliveryReceipt[0]->created_by}}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                           </table>
                        </div>
            	 	 </div>
            	 </div>
            </div>
     	</div>	
     </div>
      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Ribos Food Corporation 2019</span>
            <br>
            <br>
            <span>Made with ❤️ at <a href="https://cebucodesolutions.com" target="_blank">Cebu Code Solutions</a></span>
          </div>
        </div>
      </footer>
</div>
@endsection