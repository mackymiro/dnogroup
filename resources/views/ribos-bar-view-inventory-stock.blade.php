@extends('layouts.ribos-bar-app')
@section('title', 'View Inventory Of Stocks Item Details |')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
</script>
<div id="wrapper">
    <!-- Sidebar -->
   	@include('sidebar.sidebar-ribos-bar')
       <div id="content-wrapper">
            <div class="container-fluid">
                 <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Ribo's Bar</a>
                </li>
                <li class="breadcrumb-item ">Store Stock</li>
                <li class="breadcrumb-item ">Inventory Of Stock</li>
                <li class="breadcrumb-item active">Item Details</li>
                </ol>
                <a href="{{ url('ribos-bar/store-stock/inventory-of-stocks') }}">Back to Lists</a>
                <div class="col-lg-12">
            	     <img src="{{ asset('images/ribos.jpg')}}"width="390" height="250" class="img-responsive mx-auto d-block" alt="Ribo's Bar">
            	    <h4 class="text-center"><u>INVENTORY OF STOCK ITEM DETAILS </u></h4>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <i class="fas fa-store" aria-hidden="true"></i>
                                 Inventory Stock View Item Details
                               
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
                            @if(session('viewInventoryOfStocks'))
                                <p class="alert alert-success">{{ Session::get('viewInventoryOfStocks') }}</p>
                            @endif 
                            @foreach($getViewStockDetails as $getViewStockDetail)
                                <form action="{{ action('RibosBarController@inventoryStockUpdate', $getViewStockDetail['id']) }}" method="post">
                                {{csrf_field()}}
                                <input name="_method" type="hidden" value="PATCH">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-2">
                                            <label>Date</label>
                                            <input type="text" name="date" class="form-control" value="{{ $getViewStockDetail['date']}}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Reference #</label>
                                            <input type="text" name="referenceNumber" class="form-control" value="{{ $getViewStockDetail['reference_no'] }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Description</label>
                                            <input type="text" name="description" class="form-control" value="{{ $getViewStockDetail['description']}}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Item</label>
                                            <input type="text" name="item" class="form-control" value="{{ $getViewStockDetail['item']}}" />
                                        </div>
                                        <div class="col-lg-1">
                                            <label>QTY</label>
                                            <input type="text" name="qty" class="form-control" value="{{ $getViewStockDetail['qty']}}" />
                                        </div>
                                        <div class="col-lg-1">
                                            <label>Unit</label>
                                            <input type="text" name="unit" class="form-control" value="{{ $getViewStockDetail['unit'] }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>amount</label>
                                            <input type="text" name="amount" class="form-control" value="{{ $getViewStockDetail['amount']}}" />
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-1">
                                            <label>Status</label>
                                            <input type="text" name="status" class="form-control" value="{{ $getViewStockDetail['status'] }}" />
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Requesting Branch</label>
                                            <input type="text" name="requestingBranch" class="form-control" value="{{ $getViewStockDetail['requesting_branch']}}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Cheque No Issued</label>
                                            <input type="text" name="chequeNoIssued" class="form-control" value="{{ $getViewStockDetail['cheque_no_issued']}}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Remarks</label>
                                            <input type="text" name="remarks" class="form-control" value="{{ $getViewStockDetail['remarks']}}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <br>
                                            <input type="hidden" name="iSId" value="{{ $viewStockDetail['id']}}">
                                            <input type="submit" class="btn btn-success" value="Add Remarks" />
                                        </div>
                                    </div>
                                </div>
                                </form>
                            @endforeach	
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