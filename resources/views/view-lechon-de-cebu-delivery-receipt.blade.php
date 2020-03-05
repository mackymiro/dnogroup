@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'View Delivery Receipt |')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
</script>

<div id="wrapper">
	<!-- Sidebar -->
   @include('sidebar.sidebar')
     <div id="content-wrapper">
     	<div class="container-fluid">
     		<!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lechon de Cebu</a>
              </li>
              <li class="breadcrumb-item active">View Delivery Receipt</li>
            </ol>
             <a href="{{ url('lolo-pinoy-lechon-de-cebu/delivery-receipt/lists') }}">Back to Lists</a>
          	<div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
            	 <h4 class="text-center"><u>VIEW DELIVERY RECEIPT</u></h4>
            </div>
            <div class="row">
            	 <div class="col-lg-12">
            	 	 <div class="card mb-3">
                  	 	 	<div class="card-header">
                            <i class="fas fa-receipt" aria-hidden="true"></i>
                                  View Delivery Receipt
                             <div class="float-right">
                               
                                 <a href="{{ action('LoloPinoyLechonDeCebuController@printDelivery', $viewDeliveryReceipt['id'])}}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                               
                              </div>
                        </div>
                        <div class="card-body">
                          <div class="form-group">
                              <div class="form-row">
                                   <div class="col-lg-6">
                                    <table class="table table-bordered">
                                      <thead>
                                          <tr>
                                              <th width="30%">Sold To</th>
                                              <th>{{ $viewDeliveryReceipt['sold_to'] }}</th>
                                          </tr>
                                          <tr>
                                              <th>Delivered To</th>
                                              <th>{{ $viewDeliveryReceipt['delivered_to']}}</th>
                                          </tr>
                                          <tr> 
                                              <th>Contact Person</th>
                                              <th>{{ $viewDeliveryReceipt['contact_person'] }}</th>
                                          </tr>
                                          <tr>
                                              <th>Time</th>
                                              <th>{{ $viewDeliveryReceipt['time'] }}</th>
                                          </tr>
                                         
                                      </thead>
                                      
                                  </table>   
                             </div>
                          <div class="col-lg-6">
                              <table class="table table-bordered">
                                  <thead>
                                      <tr>
                                          <th width="20%">Mobile #</th>
                                          <th>{{ $viewDeliveryReceipt['mobile_num']}}</th>
                                      </tr>
                                      <tr> 
                                          <th>DR No</th>
                                          <th>{{ $viewDeliveryReceipt['dr_no'] }}</th>
                                      </tr> 
                                       <tr>
                                          <th>Date</th>
                                          <th>{{ $viewDeliveryReceipt['date'] }}</th>
                                       </tr>
                                  </thead>
                              </table>
                          </div>
                          </div>
                          </div>
                         
                         
                        	
                        	 <table class="table table-striped">
                        	 	     <thead>
	                                  <tr>
	                                    <th class="bg-info" style="color:white;">QTY</th>
	                                    <th class="bg-info" style="color:white;">DESCRIPTION</th>
	                                    <th class="bg-info" style="color:white;">PRICE</th>
	                                  
	                                  </tr>
                                  </thead>
                                  <tbody>
                                  	 <tr>
                                  	 	<td>{{ $viewDeliveryReceipt['qty']}}</td>
                                  	 	<td>{{ $viewDeliveryReceipt['description']}}</td>
                                  	 	<td><?php echo number_format($viewDeliveryReceipt['price'], 2); ?></td>
                                  	 </tr>

                                  	 @foreach($deliveryReceipts as $deliveryReceipt)
                                     <tr>
                                        <td>{{ $deliveryReceipt['qty']}}</td>
                                        <td>{{ $deliveryReceipt['description']}}</td>
                                        <td><?php echo number_format($deliveryReceipt['price'], 2)?></td>
                                     </tr>
                                  	
                                      
                                       @endforeach
                                       <tr>
                                        <td></td>
                                       
                                        <td><strong>Total</strong></td>
                                        <td>₱ <?php echo number_format($sum, 2)?></td>
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
                                        <td>{{ $viewDeliveryReceipt['created_by']}}</td>
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