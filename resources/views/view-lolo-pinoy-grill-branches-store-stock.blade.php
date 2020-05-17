@extends('layouts.lolo-pinoy-grill-branches-app')
@section('title', 'View Stock Inventory Details |')
@section('content')
<div id="wrapper">
    <!-- Sidebar -->
    @include('sidebar.sidebar-lolo-pinoy-grill-branches')
    <div id="content-wrapper">
        <div class="container-fluid">
             <!-- Breadcrumbs-->
             <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lolo Pinoy Grill Branches</a>
              </li>
              <li class="breadcrumb-item ">Store Stock</li>
              <li class="breadcrumb-item ">Stock Inventory</li>
              <li class="breadcrumb-item active">Item Details</li>
            </ol>
            <a href="{{ url('lolo-pinoy-grill-branches/store-stock/view-stock-inventory') }}">Back to Lists</a>
            <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoy-grill.jpeg')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lolo Pinoy Grill">
            	 
            	 <h4 class="text-center"><u>STOCK INVENTORY ITEM DETAILS </u></h4>
            </div>
            <div class="row">
                 <div class="col-lg-12">
                     <div class="card mb-3">
                         <div class="card-header">
                              <i class="fas fa-store" aria-hidden="true"></i>
                            View Stock Inventory Item Details
                           
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
		            	 				<td>{{ $viewStockInventory['product_name'] }}</td>
		            	 				<td>{{ $viewStockInventory['unit_price']}}</td>
		            	 				<td>{{ $viewStockInventory['supplier']}}</td>
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
		            	 				<th>{{ $viewStockInventory['in']}} {{ $viewStockInventory['unit']}}</th>
		            	 				<td></td>
		            	 			</tr>
		            	 			<tr>
		            	 				<th>TOTAL OUT</th>
		            	 				<th>{{ $viewStockInventory['out']}} {{ $viewStockInventory['unit']}}</th>
		            	 				<th></th>
		            	 			</tr>
		            	 			<tr>
		            	 				<th class="bg-info" style="color:white;">REMANING STOCK</th>
		            	 				<th class="bg-info" style="color:white;">
		            	 					<?php
		            	 						$in = $viewStockInventory['in'];
		            	 						$out = $viewStockInventory['out'];
		            	 						$minus = $in - $out;
		            	 					?>
		            	 					{{ $minus }} {{ $viewStockInventory['unit']}}
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
                                     @foreach($getStoreStockDetails as $getStoreStockDetail)
		            	 			<tr>

		            	 				<td>{{ $getStoreStockDetail['date']}}</td>
		            	 				<td>{{ $getStoreStockDetail['reference_no']}}</td>
		            	 				@if($getStoreStockDetail['description'] == "DELIVERY IN")
		            	 					<td class="bg-success" style="color:white;">{{ $getStoreStockDetail['description']}}</td>
	            	 					@else
	            	 						<td class="bg-danger" style="color:white;">{{ $getStoreStockDetail['description']}}</td>
	            	 					@endif
		            	 				<td>{{ $getStoreStockDetail['item']}}</td>
		            	 				<td>{{ $getStoreStockDetail['qty']}}</td>
		            	 				<td>{{ $getStoreStockDetail['unit']}}</td>
		            	 				<td><?php echo number_format($getStoreStockDetail['amount'], 2)?></td>
		            	 				@if($getStoreStockDetail['status'] == "Paid")
		            	 					<td class="bg-success" style="color:white;">{{ $getStoreStockDetail['status']}}</td>
	            	 					@else
	            	 						<td class="bg-danger" style="color:white;">{{ $getStoreStockDetail['status']}}</td>
	            	 					@endif
		            	 				<td>{{ $getStoreStockDetail['requesting_branch']}}</td>
		            	 				<td>{{ $getStoreStockDetail['cheque_no_issued']}}</td>
		            	 				<th>{{ $getStoreStockDetail['remarks']}}</th>
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
</div>
@endsection