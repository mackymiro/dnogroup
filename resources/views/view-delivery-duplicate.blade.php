@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'View Delivery Duplicate |')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
</script>
<script>
    function myFunction() {
      window.print();
    }
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
              <li class="breadcrumb-item active">View Duplicate Delivery Receipt</li>
            </ol>
             <a href="{{ url('lolo-pinoy-lechon-de-cebu/delivery-receipt/lists') }}">Back to Lists</a>
          	<div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
            	 <h4 class="text-center"><u>VIEW DUPLICATE DELIVERY RECEIPT</u></h4>
            </div>
            <div class="row">
            	 <div class="col-lg-12">
            	 	 <div class="card mb-3">
              	 	 	   <div class="card-header">
                                <i class="fas fa-receipt" aria-hidden="true"></i>
                              View Duplicate Delivery Receipt
                               <div class="float-right">
                                 <button class="btn btn-success" onclick="myFunction()"><i class="fa fa-print fa-2x" aria-hidden="true"></i></button>
                              
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
                                              <th>{{ $viewDeliveryReceiptDuplicate['sold_to'] }}</th>
                                          </tr>
                                          <tr>
                                              <th>Delivered To</th>
                                              <th>{{ $viewDeliveryReceiptDuplicate['delivered_to']}}</th>
                                          </tr>
                                          <tr> 
                                              <th>Contact Person</th>
                                              <th>{{ $viewDeliveryReceiptDuplicate['contact_person'] }}</th>
                                          </tr>
                                          <tr>
                                              <th>Time</th>
                                              <th>{{ $viewDeliveryReceiptDuplicate['time'] }}</th>
                                          </tr>
                                         
                                      </thead>
                                      
                                  </table>   
                             </div>
                    	 			  <div class="col-lg-6">
                              <table class="table table-bordered">
                                  <thead>
                                      <tr>
                                          <th width="20%">Mobile #</th>
                                          <th>{{ $viewDeliveryReceiptDuplicate['mobile_num']}}</th>
                                      </tr>
                                      <tr> 
                                          <th>DR No</th>
                                          <th>{{ $viewDeliveryReceiptDuplicate['dr_no'] }}</th>
                                      </tr> 
                                       <tr>
                                          <th>Date</th>
                                          <th>{{ $viewDeliveryReceiptDuplicate['date'] }}</th>
                                       </tr>
                                  </thead>
                              </table>
                             </div>
                        	 	</div>
                        	 </div>
                        	 <table class="table table-striped">
                        	 	 <thead>
	                                  <tr>
	                                    <th  class="bg-info" style="color:white;">QTY</th>
	                                    <th  class="bg-info" style="color:white;">DESCRIPTION</th>
	                                    <th  class="bg-info" style="color:white;">PRICE</th>
	                                  
	                                  </tr>
                                  </thead>
                                  <tbody>
                                  	 <tr>
                                  	 	<td>{{ $viewDeliveryReceiptDuplicate['qty']}}</td>
                                  	 	<td>{{ $viewDeliveryReceiptDuplicate['description']}}</td>
                                  	 	<td><?php echo number_format($viewDeliveryReceiptDuplicate['price'], 2); ?></td>
                                  	 </tr>

                                  	 @foreach($deliveryReceiptDuplicates as $deliveryReceiptDuplicate)
                                     <tr>
                                        <td>{{ $deliveryReceiptDuplicate['qty']}}</td>
                                        <td>{{ $deliveryReceiptDuplicate['description']}}</td>
                                        <td><?php echo number_format($deliveryReceiptDuplicate['price'], 2)?></td>
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