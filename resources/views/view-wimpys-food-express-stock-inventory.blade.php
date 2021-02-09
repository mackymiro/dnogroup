@extends('layouts.wimpys-food-express-app')
@section('title', 'View Stock Inventory Item Details |')
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
              <li class="breadcrumb-item ">Stock Inventory</li>
              <li class="breadcrumb-item active">Item Details</li>
            </ol>
            <a href="{{ url('wimpys-food-express/stock-inventory') }}">Back to Lists</a>
             <div class="col-lg-12">
            	 <img src="{{ asset('images/digitized-logos/wimpys-logo1.jpg')}}" width="350" height="178" class="img-responsive mx-auto d-block" alt="Wimpys Food Express">             
            	 <h4 class="text-center"><u>STOCK INVENTORY ITEM DETAILS </u></h4>
            </div>
            <div class="row">
            	<div class="col-lg-12">
            		<div class="card mb-3">
            			 <div class="card-header">
                              <i class="fas fa-apple-alt" aria-hidden="true"></i>
                           Stock Inventory View Item Details
                           	 <div class="float-right">
			                   <button class="btn btn-success" onclick="myFunction()"> <i class="fa fa-print fa-2x" aria-hidden="true"></i></button>
			                  
			               	</div>
                        </div>
                        <div class="card-body">
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
		            	 				<td>{{ $viewStockDetail['product_name'] }}</td>
		            	 				<td>{{ $viewStockDetail['unit_price']}}</td>
		            	 				<td>{{ $viewStockDetail['supplier']}}</td>
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
		            	 				<th>{{ $viewStockDetail['in']}} {{ $viewStockDetail['unit']}}</th>
		            	 				<td></td>
		            	 			</tr>
		            	 			<tr>
		            	 				<th>TOTAL OUT</th>
		            	 				<th>{{ $viewStockDetail['out']}} {{ $viewStockDetail['unit']}}</th>
		            	 				<th></th>
		            	 			</tr>
		            	 			<tr>
		            	 				<th class="bg-info" style="color:white;">REMANING STOCK</th>
		            	 				<th class="bg-info" style="color:white;">
		            	 					<?php
		            	 						$in = $viewStockDetail['in'];
		            	 						$out = $viewStockDetail['out'];
		            	 						$minus = $in - $out;
		            	 					?>
		            	 					{{ $minus }} {{ $viewStockDetail['unit']}}
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
		            	 				<th colspan="11" class="bg-info" style="color:white;">TRANSACTION</th>
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
		            	 				<th>REMARKS</th>
		            	 			</tr>

		            	 			@foreach($getViewStockDetails as $getViewStockDetail)
		            	 			<tr>

		            	 				<td>{{ $getViewStockDetail['date']}}</td>
		            	 				<td>{{ $getViewStockDetail['reference_no']}}</td>
		            	 				@if($getViewStockDetail['description'] == "DELIVERY IN")
		            	 					<td class="bg-success" style="color:white;">{{ $getViewStockDetail['description']}}</td>
	            	 					@else
	            	 						<td class="bg-danger" style="color:white;">{{ $getViewStockDetail['description']}}</td>
	            	 					@endif
		            	 				<td>{{ $getViewStockDetail['item']}}</td>
		            	 				<td>{{ $getViewStockDetail['qty']}}</td>
		            	 				<td>{{ $getViewStockDetail['unit']}}</td>
		            	 				<td><?php echo number_format($getViewStockDetail['amount'], 2)?></td>
		            	 				@if($getViewStockDetail['status'] == "Paid")
		            	 					<td class="bg-success" style="color:white;">{{ $getViewStockDetail['status']}}</td>
	            	 					@else
	            	 						<td class="bg-danger" style="color:white;">{{ $getViewStockDetail['status']}}</td>
	            	 					@endif
		            	 				<td>{{ $getViewStockDetail['requesting_branch']}}</td>
		            	 				<td>{{ $getViewStockDetail['cheque_no_issued']}}</td>
		            	 				<td>{{ $getViewStockDetail['remarks']}}</td>
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