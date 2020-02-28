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
                                     <i class="fa fa-print fa-2x" aria-hidden="true"></i>
                              
                                </div>
                        </div>
                        <div class="card-body">
                        	 <div class="form-group">
                        	 	<div class="form-row">
                    	 			<div class="col-lg-6">
                    	 				<label>Sold To</label>
                    	 				<br>
                    	 				{{ $viewDeliveryReceipt['sold_to'] }}
                    	 				<br>
                    	 				<br>
                    	 				<label>Delivered To</label>
                    	 				<br>
                    	 				{{ $viewDeliveryReceipt['delivered_to']}}
                    	 				<br>
                    	 				<br>
                    	 				<label>Contact Person</label>
                    	 				<br>
                    	 				{{ $viewDeliveryReceipt['contact_person'] }}
                    	 				<label>Time</label>
                    	 				<br>
                    	 				{{ $viewDeliveryReceipt['time'] }}
                    	 				
                    	 			</div>
                    	 			<div class="col-lg-6">
                    	 				
                    	 				<label>Mobile #</label>
                    	 				<br>
                    	 				{{ $viewDeliveryReceipt['mobile_num']}}
                    	 				<br>
                    	 				<br>
                    	 				<label>DR No</label>
                    	 				<br>
                    	 				{{ $viewDeliveryReceipt['dr_no'] }}
                    	 				<br>
                    	 				<br>
                    	 				<label>Date</label><br>
                    	 				{{ $viewDeliveryReceipt['date'] }}
                    	 			</div>
                        	 	</div>
                        	 </div>
                        	 <table class="table table-striped">
                        	 	 <thead>
	                                  <tr>
	                                    <th>QTY</th>
	                                    <th>DESCRIPTION</th>
	                                    <th>PRICE</th>
	                                  
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