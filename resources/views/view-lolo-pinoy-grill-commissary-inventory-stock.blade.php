@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'View Inventory Of Stocks Item Details |')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
  $(function() {
    $( ".datepicker" ).datepicker();
  });
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div id="wrapper">
	<!-- Sidebar -->
   	@include('sidebar.sidebar-lolo-pinoy-grill')
   	<div id="content-wrapper">
   		<div class="container-fluid">
   			 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lolo Pinoy Grill Commissary</a>
              </li>
              <li class="breadcrumb-item ">Commissary</li>
              <li class="breadcrumb-item ">Inventory Of Stock</li>
              <li class="breadcrumb-item active">Item Details</li>
            </ol>
            <a href="{{ url('lolo-pinoy-grill-commissary/commissary/inventory-of-stocks') }}">Back to Lists</a>
             <div class="col-lg-12">
            	  <img src="{{ asset('images/lolo-pinoy-grill.jpeg')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lolo Pinoy Grill Commissary">
            	 
            	 <h4 class="text-center"><u>INVENTORY OF STOCK ITEM DETAILS </u></h4>


            </div>
            <div class="row">
            	<div class="col-lg-12">
            		<div class="card mb-3">
            			 <div class="card-header">
                              <i class="fas fa-apple-alt" aria-hidden="true"></i>
                           Inventory Stock View Item Details
                           	
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
		            	 				<th colspan="12" class="bg-info" style="color:white;">TRANSACTION</th>
		            	 			</tr>
		            	 		</thead>
		            	 		<tbody>
		            	 			<tr>
									 	<th>ACTION</th>
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
  										<td>
										  <!-- Button trigger modal -->
										  @if($getViewStockDetail['remarks'] === NULL)
										  <a data-toggle="modal" data-target="#getItem<?php echo $getViewStockDetail['id']?>" href="#" title="Edit"><i class="fa fa-comments" aria-hidden="true"></i></a>
										 
										  @else
										  <i class="fa fa-comments" aria-hidden="true"></i>
										  @endif
										</td>
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
                        	<br>
                        	
                        </div>
            		</div>
            	</div>
            </div>
   		</div>
   	</div>
	   <!-- Modal -->
	   @foreach($getViewStockDetails as $getViewStockDetail)
		<div class="modal fade" id="getItem<?php echo $getViewStockDetail['id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Add Remarks - {{ $getViewStockDetail['description']}}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
			<div id="succUp<?php echo $getViewStockDetail['id']?>"></div>
			<div class="form-group">
				<div class="form-row">
					<div class="col-lg-2">
						<label>Date</label>
						<input type="text" id="date<?php echo $getViewStockDetail['id'] ?>" name="date" disabled class="datepicker form-control" value="{{ $getViewStockDetail['date']}}" />
					</div>
					<div class="col-lg-2">
						<label>Reference #</label>
						<input type="text" name="referenceNumber" class="form-control" value="{{ $getViewStockDetail['reference_no'] }}"  disabled/>
					</div>
					<div class="col-lg-4">
						<label>Description</label>
						<input type="text" name="description" class="form-control" value="{{ $getViewStockDetail['description']}}" disabled/>
					</div>
					<div class="col-lg-2">
						<label>Item</label>
						<input type="text" name="item" class="form-control" value="{{ $getViewStockDetail['item']}}" disabled />
					</div>
					@if($getViewStockDetail['description'] != "DELIVERY IN")
					<div class="col-lg-1">
						<label>QTY</label>
						<input type="text" id="qty<?php echo $getViewStockDetail['id'] ?>" name="qty" class="form-control" disabled value="{{ $getViewStockDetail['qty']}}" />
					</div>
					@else
					<div class="col-lg-1">
						<label>QTY</label>
						<input type="text" id="qty<?php echo $getViewStockDetail['id'] ?>" name="qty" class="form-control"  value="{{ $getViewStockDetail['qty']}}" />
					</div>
					@endif
					@if($getViewStockDetail['description'] != "DELIVERY IN")
					<div class="col-lg-1">
						<label>Unit</label>
						<input type="text" id="unit<?php echo $getViewStockDetail['id'] ?>" name="unit" disabled class="form-control" value="{{ $getViewStockDetail['unit'] }}" />
					</div>
					@else
					<div class="col-lg-1">
						<label>Unit</label>
						<input type="text" id="unit<?php echo $getViewStockDetail['id'] ?>" name="unit"  class="form-control" value="{{ $getViewStockDetail['unit'] }}" />
					</div>

					@endif
					<div class="col-lg-4">
  						<label>Status</label>
						<select id="status<?php echo $getViewStockDetail['id']?>" name="status" class=" form-control"> 
  							<option value="0">--Select Status--</option>
							<option value="Paid" {{ ( "Paid" == $getViewStockDetail['status']) ? 'selected' : '' }}>Paid</option>
							<option value="Unpaid" {{ ( "Unpaid" == $getViewStockDetail['status']) ? 'selected' : '' }}>Unpaid</option>
						</select>
					</div>
					@if($getViewStockDetail['description'] != "DELIVERY IN")
					<div class="col-lg-4">
						<label>Requesting Branch</label>
						<input type="text" id="requestingBranch<?php echo $getViewStockDetail['id'] ?>" disabled name="requestingBranch" class="form-control" value="{{ $getViewStockDetail['requesting_branch']}}" />
					</div>
					@else
					<div class="col-lg-4">
						<label>Requesting Branch</label>
						<input type="text" id="requestingBranch<?php echo $getViewStockDetail['id'] ?>" name="requestingBranch" class="form-control" value="{{ $getViewStockDetail['requesting_branch']}}" />
					</div>
					@endif
					@if($getViewStockDetail['description'] != "DELIVERY IN")
					<div class="col-lg-4">
						<label>Cheque No Issued</label>
						<input type="text" id="chequeNoIssued<?php echo $getViewStockDetail['id'] ?>" disabled name="chequeNoIssued" class="form-control" value="{{ $getViewStockDetail['cheque_no_issued']}}" />
					</div>
					@else
					<div class="col-lg-4">
						<label>Cheque No Issued</label>
						<input type="text" id="chequeNoIssued<?php echo $getViewStockDetail['id'] ?>" name="chequeNoIssued" class="form-control" value="{{ $getViewStockDetail['cheque_no_issued']}}" />
					</div>
					@endif
				</div>
			</div>
			<div class="form-group">
				<div class="form-row">
					
				
					<div class="col-lg-4">
						<label>Remarks</label>
						<input type="text" id="remarks<?php echo $getViewStockDetail['id'] ?>" name="remarks" class="form-control" value="{{ $getViewStockDetail['remarks']}}" />
					</div>
					
				</div>
			</div>
			</div>
			<div class="modal-footer">
  				<input type="hidden" id="iSId" name="iSId" value="{{ $viewStockDetail['id']}}">
				<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
				<button type="button" onclick="addRemarks(<?php echo $getViewStockDetail['id']?>)" class="btn btn-success btn-lg">Add Remarks</button>
			</div>
			</div>
		</div>
		</div>
		@endforeach
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
<script type="text/javascript">
	
	const addRemarks = (id) =>{
		
		const date = $("#date"+id).val();
		const qty = $("#qty"+id).val();
		const unit = $("#unit"+id).val();
		const status = $("#status"+id).val();
		const requestingBranch = $("#requestingBranch"+id).val();
		const chequeNoIssued = $("#chequeNoIssued"+id).val();
		const remarks =  $("#remarks"+id).val();
		const mainId = $("#iSId").val();

		//make ajax call
		$.ajax({
                type:"PATCH",
                url:'/lolo-pinoy-grill-commissary/inventory-stock-update/' +id,
                data:{
                    _method:'patch',
                    "_token":"{{ csrf_token() }}",
                    "id":id,
					"date":date,
					"qty":qty,
					"unit":unit,
					"status":status,
					"requestingBranch":requestingBranch,
					"chequeNoIssued":chequeNoIssued,
					"remarks":remarks,
					"mainId":mainId,
                },
                success:function(data){
                    console.log(data);
					const getData = data;
                    const succData = getData.split(":");
                    const succDataArr = succData[0];

					if(succDataArr == "Success"){
						$("#succUp"+id).fadeIn().delay(3000).fadeOut();
						$("#succUp"+id).html(`<p class="alert alert-success">Succesfully added a remarks.</p>`);
						
						setTimeout(function(){
							document.location.reload();
						}, 3000);
					}
                    
                    
                },
                error:function(data){
                    console.log('Error:', data);
                }
           });


	}
</script>
@endsection