@extends('layouts.ribos-bar-app')
@section('title', 'View RAW Material Details |')
@section('content')
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
              <li class="breadcrumb-item ">RAW Materials</li>
              <li class="breadcrumb-item active">Item Details</li>
            </ol>
            <a href="{{ url('ribos-bar/store-stock/raw-materials') }}">Back to Lists</a>
            <div class="col-lg-12">
            	 <img src="{{ asset('images/ribos.jpg')}}" width="390" height="250" class="img-responsive mx-auto d-block" alt="Lolo Pinoy Grill">
            	 
            	 <h4 class="text-center"><u>ITEM DETAILS </u></h4>
            </div>
            <div class="row">
                 <div class="col-lg-12">
                     <div class="card mb-3">
                        <div class="card-header">
                             <i class="fas fa-store"></i>
                            View Item Details
                           
                        </div>
                        <div class="card-body">
                            <div class="form-group">
		            	 		<div class="form-row">
		            	 			<div class="col-lg-12">
                                        <!-- Button trigger modal -->
                                          
                                        <a class="btn btn-primary" href="#" data-toggle="modal" data-target=".addDeliveryIn" >ADD DELIVERY IN </a>
                                    	<br>
			            	 			<br>
                                        <a class="btn btn-primary" href="#" data-toggle="modal" data-target=".requestStockOut" >REQUEST STOCK OUT</a>
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
    <!--Modal-->
    <div class="modal fade requestStockOut" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Request Stock Out</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-row">
                            <div id="validateStatusRSO" class="col-lg-12">
                                <p  class="alert alert-danger">Please Select Status</p>
                            </div>
                            <div id="succAddDRequest" class="col-lg-12"></div>
                            <div id="existsRSO" class="col-lg-12"></div>
                            <div class="col-md-2">
                                <label>Product Id</label>
                                <input type="text" id="productIdRSO" name="productIdRSO" class="form-control" value="{{ $viewRawDetail['product_id_no']}}" readonly="readonly" />
                            </div>
                            <div class="col-md-4">
                                <label>Description</label>
                                <input type="text" id="descriptionRSO" name="descriptionRSO" class="form-control" value="DELIVERY OUT" disabled="disabled" readonly="readonly" />
                               
                            </div>
                            <div class="col-md-4">
                                <label>Reference NUmber</label>
                                <input type="text" id="refNoRSO" name="refNoRSO" class="form-control" />
                            </div>
                            <div class="col-md-2">
                                <label>Qty</label>
                                <input type="text" id="qtyRSO" name="qtyRSO" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-4">
                                <label>Requesting Branch</label>
                                <input type="text" id="requestingBranch" name="requestingBranch" class="form-control" />
                            </div>
                            <div class="col-md-4">
                                <label>Status</label>
                                <div id="app-status-stock">
                                    <select id="statusRSO" name="statusRSO" class="form-control">
                                        <option value="0">--Please Select--</option>
                                        <option v-for="statusStock in statusStocks" v-bind:value="statusStock.value">
                                            @{{ statusStock.text }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Cheque No Issued</label>
                                <input type="hidden" id="rStockOut" value="REQUEST STOCK OUT" />
                                <input type="text" id="chequeNoIssuedRSO" name="chequeNoIssuedRSO" class="form-control" />
                            </div>
                          
                        </div>
                    </div>
                  
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeRSO()" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" onclick="requestStockOut(<?php echo $viewRawDetail['id']?>)" class="btn btn-success">Request Stock Out</button>
                </div>
            </div>
        </div>
    </div><!-- end of Modal -->
    <!--Modal-->
    <div class="modal fade addDeliveryIn" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add RAW Material</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-row">
                            <div id="validateStatus" class="col-lg-12">
                                <p  class="alert alert-danger">Please Select Status</p>
                            </div>
                             <div id="existsDeliveryIn" class="col-lg-12"></div>
                            <div id="succAddDeliveryIn" class="col-lg-12"></div>
                            <div class="col-md-2">
                                <label>Product Id</label>
                                <input type="text" id="productId" name="productId" class="form-control" value="{{ $viewRawDetail['product_id_no']}}" readonly="readonly" />
                            </div>
                            <div class="col-md-4">
                                <label>Description</label>
                                <input type="text" id="description" name="description" class="form-control" value="DELIVERY IN" disabled="disabled" readonly="readonly" />
                               
                            </div>
                            <div class="col-md-4">
                                <label>Reference NUmber</label>
                                <input type="text" id="refNo" name="refNo" class="form-control" />
                            </div>
                            <div class="col-md-2">
                                <label>Qty</label>
                                <input type="text" id="qty" name="qty" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-4">
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
                            <div class="col-md-4">
                                <label>Cheque No Issued</label>
                                <input type="text" id="chequeNoIssued" name="chequeNoIssued" class="form-control" />
                            </div>
                          
                        </div>
                    </div>
                  
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeDeliveryIn()" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" onclick="addDeliveryIn(<?php echo $viewRawDetail['id']?>)" class="btn btn-success">Add Delivery In</button>
                </div>
            </div>
        </div>
    </div><!-- end of Modal -->
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
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript">
    $("#validateStatus").hide();
    $("#validateStatusRSO").hide();

    const closeRSO = () =>{
        $("#refNoRSO").val('');
        $("#qtyRSO").val('');
        $("#requestingBranch").val('');
        $("#statusRSO").val('');
        $('#chequeNoIssuedRSO').val('');
    }

    const closeDeliveryIn = () =>{
        $("#refNo").val('');
        $("#qty").val('');
        $("#chequeNoIssued").val('');
        $("#status").val('');
    }

    const requestStockOut = (id) => {
        const productId = $("#productIdRSO").val();
        const description = $("#descriptionRSO").val();
        const refNo = $("#refNoRSO").val();
        const qty = $("#qtyRSO").val();
        const requestingBranch = $("#requestingBranch").val();
        const statusRSO = $("#statusRSO").val();
        const chequeNoIssued = $('#chequeNoIssuedRSO').val();
        const rStockOut = $("#rStockOut").val();
        if(statusRSO == 0){
            $("#validateStatusRSO").fadeIn().delay(3000).fadeOut();
        }else{
               //make ajax call
               $.ajax({
                type:'POST',
                url:'/ribos-bar/store-stock/request-stock-out',
                data:{
                    _method:'post',
                    "_token": "{{ csrf_token() }}",
                    "id":id,
                    "productId":productId,
                    "description":description,
                    "refNo":refNo,
                    "qty":qty,
                    "status":status,
                    "requestingBranch":requestingBranch,
                    "chequeNoIssued":chequeNoIssued,
                    "rStockOut":rStockOut,
                },
                success:function(data){
                    console.log(data);
                    const getData = data;
                    const succData = getData.split(":");
                    const succDataArr = succData[0];
                    if(succDataArr == "Success"){
                       $("#succAddDRequest").fadeIn().delay(3000).fadeOut();
                       $("#succAddDRequest").html(`<p class="alert alert-success"> ${data}</p>`);
                      
                        setTimeout(function(){
                            document.location.reload();
                        }, 3000);
                    }else{
                        $("#existsRSO").fadeIn().delay(3000).fadeOut();
                        $("#existsRSO").html(`<p class="alert alert-danger">${data}</p>`);
                    }
                },
                error:function(data){
                    console.log('Error:', data);
                }

            }); 
        }

    }

    const addDeliveryIn = (id) =>{
        const productId = $("#productId").val();
        const description = $("#description").val();
        const refNo = $("#refNo").val();
        const qty  = $("#qty").val();
        const chequeNoIssued = $("#chequeNoIssued").val();
        const status = $("#status").val();

        if(status == 0){
            $("#validateStatus").fadeIn().delay(3000).fadeOut();
        }else{
            //make ajax call
            $.ajax({
                type:'POST',
                url:'/ribos-bar/store-stock/add-delivery-in',
                data:{
                    _method:'post',
                    "_token": "{{ csrf_token() }}",
                    "id":id,
                    "productId":productId,
                    "description":description,
                    "refNo":refNo,
                    "qty":qty,
                    "status":status,
                    "chequeNoIssued":chequeNoIssued,
                },
                success:function(data){
                    console.log(data);
                    const getData = data;
                    const succData = getData.split(":");
                    const succDataArr = succData[0];
                    if(succDataArr == "Success"){
                       $("#succAddDeliveryIn").fadeIn().delay(3000).fadeOut();
                       $("#succAddDeliveryIn").html(`<p class="alert alert-success"> ${data}</p>`);
                      
                        setTimeout(function(){
                            document.location.reload();
                        }, 3000);
                    }else{
                        $("#existsDeliveryIn").fadeIn().delay(3000).fadeOut();
                        $("#existsDeliveryIn").html(`<p class="alert alert-danger">${data}</p>`);
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
	el: '#app-status-stock',
		data: {
			statusStocks:[
				{ text:'Paid', value: 'Paid' },
				{ text:'Unpaid', value: 'Unpaid'}
			]
		}
	})	

	new Vue({
	el: '#app-status',
		data: {
			statuses:[
				{ text:'Paid', value: 'Paid' },
				{ text:'Unpaid', value: 'Unpaid'}
			]
		}
	})	
</script>
@endsection