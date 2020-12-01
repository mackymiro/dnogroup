@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'View RAW Material Details |')
@section('content')
<script>
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
              <li class="breadcrumb-item ">RAW Materials</li>
              <li class="breadcrumb-item active">Item Details</li>
            </ol>
            <a href="{{ url('lolo-pinoy-grill-commissary/commissary/raw-materials') }}">Back to Lists</a>
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
										<!-- Button trigger modal -->
										<button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#addDeliveryIn">
											ADD DELIVERY IN
										</button>
											
		            	 				<br>
			            	 			<br>
										 <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#requestStockOut">
  											REQUEST STOCK OUT
										</button>
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
		            	 				<td>{{ $viewRawDetail[0]->product_name }}</td>
		            	 				<td>{{ $viewRawDetail[0]->unit_price}}</td>
		            	 				<td>{{ $viewRawDetail[0]->supplier}}</td>
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
		            	 				<th>{{ $viewRawDetail[0]->in}} {{ $viewRawDetail[0]->unit}}</th>
		            	 				<td></td>
		            	 			</tr>
		            	 			<tr>
		            	 				<th>TOTAL OUT</th>
		            	 				<th>{{ $viewRawDetail[0]->out}} {{ $viewRawDetail[0]->unit}}</th>
		            	 				<th></th>
		            	 			</tr>
		            	 			<tr>
		            	 				<th class="bg-info" style="color:white;">REMANING STOCK</th>
		            	 				<th class="bg-info" style="color:white;">
		            	 					<?php
		            	 						$in = $viewRawDetail[0]->in;
		            	 						$out = $viewRawDetail[0]->out;
		            	 						$minus = $in - $out;
		            	 					?>
		            	 					{{ $minus }} {{ $viewRawDetail[0]->unit}}
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
		            	 	<table class="table table-bordered" id="dataTable" >
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
		            	 				<th>{{ $getViewRawDetail['remarks']}}</th>
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
	<!-- Modal -->
	<div class="modal fade" id="requestStockOut" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle"><i class="fa fa-apple-alt" aria-hidden="true"></i>  Request Stock Out</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
  				<div class="succAdd"></div>
  				<div class="col-lg-12 validate">
					<p class="alert alert-danger">Please Fill Up field</p>
				</div>
				<div class="form-group">
					<div class="form-row">
						<div class="col-lg-2">
							<label>Date</label>
							<input type="text" id="date1" name="date" class="datepicker form-control"  />	
						</div>
						<div class="col-lg-2">
							<label>Product ID</label>
							<input type="text" name="productId" class="form-control" value="{{ $viewRawDetail[0]->product_id_no}}" readonly="readonly" />	
						</div>
						<div class="col-lg-4">
							<label>Description</label>
							<input type="text" id="description1" name="description" class="form-control" value="DELIVERY OUT" readonly="readonly" />
						</div>
						<div class="col-lg-4">
							<label>Reference Number</label>
							<input type="text" id="referenceNum1" name="referenceNum" class="form-control" />
						</div>
						<div class="col-lg-2">
							<label>QTY</label>
							<input type="text" id="qty1" name="qty" class="form-control" required="required" />
						</div>
						<div class="col-lg-4">
							<label>Requesting Branch</label>
							<input type="text" id="requestingBranch1" name="requestingBranch" class="form-control"/>
						</div>
						<div class="col-lg-4">
							<label>Status</label>
							<div id="app-status1">
								<select id="status1" name="status" class="form-control">
									<option value="0">--Please Select--</option>
									<option v-for="status in statuses" v-bind:value="status.value">
										@{{ status.text }}
									</option>
								</select>
							</div>
						</div>
						
						<div class="col-lg-4">
							<label>Cheque No Issued</label>
							<input type="text" id="chequeNo1" name="chequeNo" class="form-control" />
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
				<button type="button" onclick="saveRequest(<?= $viewRawDetail[0]->id ?>)" class="btn btn-success btn-lg">Save Request Stock Out</button>
			</div>
			</div>
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="addDeliveryIn" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle"><i class="fa fa-apple-alt" aria-hidden="true"></i> Delivery In</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
  				<div class="succAdd"></div>
				<div class="col-lg-12 validate">
					<p class="alert alert-danger">Please Fill Up field</p>
				</div>
				<div class="form-group">
					<div class="form-row">
						<div class="col-lg-2">
							<label>Date</label>
							<input type="text" id="date" name="date" class="datepicker form-control"  />	
						</div>
						<div class="col-lg-2">
							<label>Product ID</label>
							<input type="text" name="productId" class="form-control" value="{{ $viewRawDetail[0]->product_id_no}}" readonly="readonly" />	
						</div>
						<div class="col-lg-4">
							<label>Description</label>
							<input type="text" id="description" name="description" class="form-control" value="DELIVERY IN" readonly="readonly" />
						</div>
						<div class="col-lg-4">
							<label>Reference Number</label>
							<input type="text" id="referenceNum" name="referenceNum" class="form-control" required="required" />
						</div>
						<div class="col-lg-2">
							<label>QTY</label>
							<input type="text" id="qty" name="qty" class="form-control" required="required" />
						</div>
						<div class="col-lg-4">
							<label>Status</label>
							<div id="app-status">
								<select id="status" name="status" class="form-control">
									<option value="0">--Please Select--</option>
									<option v-for="status in statuses" v-bind:value="status.value">
										@{{ status.text }}
									</option>
								</select>
							</div>
						</div>
						<div class="col-lg-4">
							<label>Cheque No Issued</label>
							<input type="text" id="chequeNo" name="chequeNo" class="form-control" />
						</div>

					</div>

				</div>
			
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
				<button type="button" onclick="saveDelivery(<?= $viewRawDetail[0]->id ?>)" class="btn btn-success btn-lg">Save Delivery</button>
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
<script type="text/javascript">
	$('.validate').hide();

	const saveRequest = (id) =>{
		const date = $("#date1").val();
		const description = $("#description1").val();
		const referenceNum = $("#referenceNum1").val();
		const qty = $("#qty1").val();
		const requestingBranch = $('#requestingBranch1').val();
		const status = $("#status1").val();
		const chequeNo = $('#chequeNo1').val();

		if(referenceNum1.length === 0 || qty1 === 0){
			$(".validate").fadeIn().delay(3000).fadeOut();
		}else{
			//make ajax call
			$.ajax({
                type:"POST",
                url:'/lolo-pinoy-grill-commissary/add-delivery-in-raw-material/' +id,
                data:{
                    _method:'post',
                    "_token":"{{ csrf_token() }}",
					"id":id,
					"date":date,
					"description":description,
					"referenceNum":referenceNum,
					"qty":qty,
					"status":status,
					"chequeNo":chequeNo,
					"requestingBranch":requestingBranch,
                    
                },
                success:function(data){
                    console.log(data);
					const getData = data;
                    const succData = getData.split(":");
                    const succDataArr = succData[0];

					if(succDataArr == "Success"){
						$(".succAdd").fadeIn().delay(3000).fadeOut();
						$(".succAdd").html(`<p class="alert alert-success">Request Stock Out Successfully Added.</p>`);
						
						setTimeout(function(){
							location.reload('/lolo-pinoy-grill-commissary/view-raw-material-details/'+id);
						}, 3000);
					}
                    
                    
                },
                error:function(data){
                    console.log('Error:', data);
                }
           });
		}
	}

	const saveDelivery = (id) =>{
		const date = $("#date").val();
		const description = $("#description").val();
		const referenceNum = $("#referenceNum").val();
		const qty = $("#qty").val();
		const status = $("#status").val();
		const chequeNo = $('#chequeNo').val();
		const requestingBranch = 0;

		if(referenceNum.length === 0 || qty.length === 0){
			$(".validate").fadeIn().delay(3000).fadeOut();
		}else{
			//make ajax call
			$.ajax({
                type:"POST",
                url:'/lolo-pinoy-grill-commissary/add-delivery-in-raw-material/' +id,
                data:{
                    _method:'post',
                    "_token":"{{ csrf_token() }}",
					"id":id,
					"date":date,
					"description":description,
					"referenceNum":referenceNum,
					"qty":qty,
					"status":status,
					"chequeNo":chequeNo,
                    "requestingBranch":requestingBranch,
                },
                success:function(data){
                    console.log(data);
					const getData = data;
                    const succData = getData.split(":");
                    const succDataArr = succData[0];

					if(succDataArr == "Success"){
						$(".succAdd").fadeIn().delay(3000).fadeOut();
						$(".succAdd").html(`<p class="alert alert-success">Delivery In Successfully Added.</p>`);
						
						setTimeout(function(){
							location.reload('/lolo-pinoy-grill-commissary/view-raw-material-details/'+id);
						}, 3000);
					}
                    
                    
                },
                error:function(data){
                    console.log('Error:', data);
                }
           });
		}
	}
</script>

<script>
	new Vue({
	el: '#app-status',
		data: {
			statuses:[
				{ text:'Paid', value: 'Paid' },
				{ text:'Unpaid', value: 'Unpaid'}
			]
		}
	})	
	new Vue({
	el: '#app-status1',
		data: {
			statuses:[
				{ text:'Paid', value: 'Paid' },
				{ text:'Unpaid', value: 'Unpaid'}
			]
		}
	})	
</script>
@endsection