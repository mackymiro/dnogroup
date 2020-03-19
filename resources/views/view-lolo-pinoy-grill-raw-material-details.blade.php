@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'View RAW Material Details |')
@section('content')
<div id="wrapper">
	<!-- Sidebar -->
   	@include('sidebar.sidebar')
   	<div id="content-wrapper">
   		<div class="container-fluid">
   			 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lolo Pinoy Grill Commissary</a>
              </li>
              <li class="breadcrumb-item ">Commissary</li>
              <li class="breadcrumb-item ">RAW Materials</li>
              <li class="breadcrumb-item active">Item Details</li>
            </ol>
            <a href="{{ url('lolo-pinoy-lechon-de-cebu/commissary/raw-materials') }}">Back to Lists</a>
            <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoy-grill.jpeg')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lolo Pinoy Grill">
            	 
            	 <h4 class="text-center"><u>ITEM DETAILS </u></h4>
            </div>
            <div class="row">
            	 <div class="col-lg-12">
	            	 <div class="card mb-3">
	            	 	 <div class="card-header">
                              <i class="fas fa-apple-alt" aria-hidden="true"></i>
                            View Item Details
                           
                        </div>
	            	 	 <div class="card-body">
		            	 	<div class="form-group">
		            	 		<div class="form-row">
		            	 			<div class="col-lg-12">
		            	 				<a href="{{ url('lolo-pinoy-grill-commissary/raw-material/add-delivery-in/'.$viewRawDetail['id']) }}" class="btn btn-success">ADD DELIVERY IN</a>
			            	 			<br>
			            	 			<br>
		            	 				<a href="{{ url('lolo-pinoy-grill-commissary/raw-material/request-stock-out/'.$viewRawDetail['id'])}}" class="btn btn-primary">REQUEST STOCK OUT</a>
		            	 			</div>
		            	 		
		            	 		</div>
		            	 	</div>
		            	 	<table class="table table-bordered">
		            	 		<thead>
		            	 			<tr>
		            	 				<th colspan="3">Date</th>

		            	 			</tr>
		            	 			<tr>

		            	 				<th>PRODUCT NAME</th>
		            	 				<th>UNIT PRICE</th>
		            	 				<th>SUPPLIER</th>
		            	 			</tr>
		            	 		</thead>
		            	 		<tbody>
		            	 			<tr>
		            	 				<td>{{ $viewRawDetail['product_name'] }}</td>
		            	 				<td>{{ $viewRawDetail['unit_price']}}</td>
		            	 				<td>{{ $viewRawDetail['supplier']}}</td>
		            	 			</tr>
		            	 		</tbody>
		            	 		
		            	 	</table>
		            	 	<table class="table table-bordered">
		            	 		<thead>
		            	 			<tr>
		            	 				<th colspan="2" class="bg-danger" style="color:white;">SUMMARY REPORT</th>
		            	 				<th class="bg-danger" style="color:white;">TOTAL VALUE</th>
		            	 			</tr>
		            	 		</thead>
		            	 		
		            	 		<tbody>
		            	 			<tr>
		            	 				<th>TOTAL IN</th>
		            	 				<th>{{ $viewRawDetail['in']}} {{ $viewRawDetail['unit']}}</th>
		            	 				<td></td>
		            	 			</tr>
		            	 			<tr>
		            	 				<th>TOTAL OUT</th>
		            	 				<th>{{ $viewRawDetail['out']}} {{ $viewRawDetail['unit']}}</th>
		            	 				<th></th>
		            	 			</tr>
		            	 			<tr>
		            	 				<th class="bg-info" style="color:white;">REMANING STOCK</th>
		            	 				<th class="bg-info" style="color:white;">
		            	 					<?php
		            	 						$in = $viewRawDetail['in'];
		            	 						$out = $viewRawDetail['out'];
		            	 						$minus = $in - $out;
		            	 					?>
		            	 					{{ $minus }} {{ $viewRawDetail['unit']}}
		            	 				</th>
		            	 				<th></th>
		            	 			</tr>

		            	 			<tr>
		            	 				<th colspan="2" class="bg-danger" style="color:white;">TOTAL STOCK VALUE</th>
		            	 				<th>
		            	 				
		            	 				</th>
		            	 				
		            	 			</tr>


		            	 		</tbody>
		            	 		
		            	 	</table>
		            	 	<table class="table table-bordered">
		            	 		<thead>
		            	 			<tr>
		            	 				<th colspan="10" class="bg-info" style="color:white;">TRANSACTION</th>
		            	 			</tr>
		            	 		</thead>
		            	 		<tbody>
		            	 			<tr>
		            	 				<th>DATE</th>
		            	 				<th>REFERENCE #</th>
		            	 				<th>DESCRPTION</th>
		            	 				<th>ITEM</th>
		            	 				<th>QTY</th>
		            	 				<th>UNIT</th>
		            	 				<th>AMOUNT</th>
		            	 				<th>STATUS</th>
		            	 				<th>REQUESTING BRANCH</th>
		            	 				<th>CHEQUE NO. ISSUED</th>
		            	 			</tr>

		            	 			@foreach($getViewRawDetails as $getViewRawDetail)
		            	 			<tr>

		            	 				<td>{{ $getViewRawDetail['date']}}</td>
		            	 				<td>{{ $getViewRawDetail['reference_no']}}</td>
		            	 				@if($getViewRawDetail['description'] == "DELIVERY IN")
		            	 					<td class="bg-success" style="color:white;">{{ $getViewRawDetail['description']}}</td>
	            	 					@else
	            	 						<td class="bg-danger" style="color:white;">{{ $getViewRawDetail['description']}}</td>
	            	 					@endif
		            	 				<td>{{ $getViewRawDetail['item']}}</td>
		            	 				<td>{{ $getViewRawDetail['qty']}}</td>
		            	 				<td>{{ $getViewRawDetail['unit']}}</td>
		            	 				<td><?php echo number_format($getViewRawDetail['amount'], 2)?></td>
		            	 				@if($getViewRawDetail['status'] == "Paid")
		            	 					<td class="bg-success" style="color:white;">{{ $getViewRawDetail['status']}}</td>
	            	 					@else
	            	 						<td class="bg-danger" style="color:white;">{{ $getViewRawDetail['status']}}</td>
	            	 					@endif
		            	 				<td>{{ $getViewRawDetail['requesting_branch']}}</td>
		            	 				<td>{{ $getViewRawDetail['cheque_no_issued']}}</td>
		            	 			</tr>
		            	 			@endforeach
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