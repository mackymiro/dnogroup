@extends('layouts.mr-potato-app')
@section('title', 'View Delivery Receipt |')
@section('content')
<div id="wrapper">
	<!-- Sidebar -->
   	@include('sidebar.sidebar-mr-potato')
   	<div id="content-wrapper">
   		<div class="container-fluid">
   			<!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Mr Potato</a>
              </li>
              <li class="breadcrumb-item active">View Delivery Receipt</li>
            </ol>           
            <a href="{{ url('mr-potato/delivery-receipt-lists') }}">Back to Lists</a>
             <div class="col-lg-12">
	        	 <img src="{{ asset('images/mr-potato.png')}}" width="390" height="250" class="img-responsive mx-auto d-block" alt="Mr Potato">
	        	 
	        	 <h4 class="text-center"><u>VIEW DELIVERY RECEIPT</u></h4>
			  </div>
			  <div class="row">
			  		<div class="col-lg-12">
			  			<div class="card mb-3">
			  				<div class="card-header">
		                        <i class="fas fa-receipt" aria-hidden="true"></i>
		                              View Delivery Receipt
		                         <div class="float-right">
                               
                                 	<a href="{{ action('MrPotatoController@printDelivery', $viewDeliveryReceipt['id'])}}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                               
                             	 </div>
		                    </div>
		                    <div class="card-body">
		                    	<div class="form-group">
	                    			<div class="form-row">
	                    				 <div class="col-lg-6">
	                    				 	<table class="table table-bordered">
	                    				 		<thead>
	                    				 			<tr>
		                    				 			<th width="30%">Delivered To</th>
		                    				 			<th>{{ $viewDeliveryReceipt['delivered_to']}}</th>
	                    				 			</tr>
	                    				 			<tr>
	                    				 				<th>Address</th>
	                    				 				<th>{{ $viewDeliveryReceipt['address']}}</th>
	                    				 			</tr>
	                    				 		</thead>	
	                    				 	</table>
	                    				 </div>
	                    				 <div class="col-lg-6">
                    				 		<table class="table table-bordered">
                    				 			<thead>
                    				 				<tr>
                    				 					<th width="30%">DR No</th>
                    				 					<th>{{ $viewDeliveryReceipt['dr_no']}}</th>
                    				 				</tr>
                    				 				<tr>
                    				 					<th>Date</th>
                    				 					<th>{{ $viewDeliveryReceipt['date']}}</th>
                    				 				</tr>
                    				 			</thead>
                    				 		</table>
	                    				 </div>
	                    			</div>
	                    		</div>
	                    		<table class="table table-striped">
	                    			<thead>
	                    				<tr>
	                    					<th  class="bg-info" style="color:white;">Product ID</th>
	                    					<th  class="bg-info" style="color:white;">Qty</th>
	                    					<th  class="bg-info" style="color:white;">Unit</th>
	                    					<th  class="bg-info" style="color:white;">Item Description</th>
	                    					<th  class="bg-info" style="color:white;">Unit Price</th>
	                    					<th  class="bg-info" style="color:white;">Amount</th>
	                    				</tr>
	                    			</thead>
	                    			<tbody>
	                    				<tr>
	                    					<td>{{ $viewDeliveryReceipt['product_id']}}</td>
	                    					<td>{{ $viewDeliveryReceipt['qty']}}</td>
	                    					<td>{{ $viewDeliveryReceipt['unit']}}</td>
	                    					<td>{{ $viewDeliveryReceipt['item_description']}}</td>
	                    					<td><?php echo number_format($viewDeliveryReceipt['unit_price'], 2)?></td>
	                    					<td><?php echo number_format($viewDeliveryReceipt['amount'], 2)?></td>
	                    				</tr>

	                    				@foreach($deliveryReceipts as $deliveryReceipt)
	                    				<tr>
	                    					<td>{{ $deliveryReceipt['product_id'] }}</td>
	                    					<td>{{ $deliveryReceipt['qty'] }}</td>
	                    					<td>{{ $deliveryReceipt['unit'] }}</td>
	                    					<td>{{ $deliveryReceipt['item_description'] }}</td>
	                    					<td><?php echo number_format($deliveryReceipt['unit_price'], 2)?></td>
	                    					<td><?php echo number_format($deliveryReceipt['amount'], 2)?></td>
	                    				</tr>
	                    				@endforeach
	                    				 <tr>
	                                        <td></td>
	                                        <td></td>
	                                        <td></td>
	                                        <td><strong>Total</strong></td>
	                                        <td>₱ <?php echo number_format($sum, 2)?></td>
	                                        <td>₱ <?php echo number_format($sum2, 2)?></td>
                                      	</tr>
	                    			</tbody>
	                    		</table>
	                    		 <br>
                       			 <br>
                       			 <table class="table table-bordered">
                       			 	<thead>
                       			 		<tr>
                       			 			<td width="30%">Prepared By/Checked By</td>
                       			 			<td>Approved By</td>
                       			 			<td>Received By & Date</td>
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
</div>
@endsection