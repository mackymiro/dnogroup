@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'Transaction Lists |')
@section('content')
<style >
	.anchor{
		color:white;
	}

	.anchor:hover{
		color:black;
	}
</style>
<div id="wrapper">
	 @include('sidebar.sidebar-lolo-pinoy-grill')
     <div id="content-wrapper">
		<div class="container-fluid">
			 <!-- Breadcrumbs-->
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">Lolo Pinoy Grill Commissary</a>
                </li>
                <li class="breadcrumb-item active">Payables</li>
                <li class="breadcrumb-item ">Transaction List</li>
              </ol>
               <div class="row">
               		<div class="col-lg-12">
               			<div class="card mb-3">
               				<div class="card-header">
	    					  <i class="fa fa-file-invoice" aria-hidden="true"></i>
	    					  Transaction List</div>
    					  	<div class="card-body">
    					  		<div class="table-responsive">
    					  			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				  						<thead>
					  						<tr>
											   <th>Action</th>
				  								<th>Invoice #</th>
				  								<th>Voucher Ref #</th>
												<th  class="bg-info" style="color:#fff;">Category</th>
				  								<th>Issued Date</th>
												<th>Paid To</th>
												<th>Account Name</th>
				  								<th  class="bg-danger" style="color:white;">Amount Due</th>
				  								<th>Delivered Date</th>
												<th style="width:230px;">Payment Method</th>
				  								<th class="bg-success" style="color:white;">Status</th>
												<th>Created By</th>
					  						</tr>
				  						</thead>
				  						<tfoot>
				  							<tr>
											  <th>Action</th>
				  								<th>Invoice #</th>
				  								<th>Voucher Ref #</th>
												<th  class="bg-info" style="color:#fff;">Category</th>
				  								<th>Issued Date</th>
												<th>Paid To</th>
												<th>Account Name</th>
				  								<th  class="bg-danger" style="color:white;">Amount Due</th>
				  								<th>Delivered Date</th>
												<th style="width:230px;">Payment Method</th>
				  								<th class="bg-success" style="color:white;">Status</th>
												<th>Created By</th>
					  						</tr>
				  						</tfoot>
				  						<tbody>
				  							@foreach($getTransactionLists as $getTransactionList)
											<?php $id = $getTransactionList['id']; ?>
											<?php
												$amount1 = DB::table('lolo_pinoy_grill_commissary_payment_vouchers')
															->select('*')
															->where('id', $id)
															->sum('amount');
												
												$amount2 = DB::table('lolo_pinoy_grill_commissary_payment_vouchers')
															->select('*')
															->where('pv_id', $id)
															->sum('amount');
												$compute = $amount1 + $amount2;
											?>
				  							<tr id="deletedId{{ $getTransactionList['id'] }}">
			  									<td width="2%">
			  										@if(Auth::user()['role_type'] == 1)
					  									<a id="delete" onClick="confirmDelete('{{ $getTransactionList['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
				              						@endif
			  									</td>
			  									<td>
			  										@if($getTransactionList['status'] != "FULLY PAID AND RELEASED")
													  <p style="width:250px;">
													  	<a href="{{ url('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-payables-detail/'.$getTransactionList['id']) }}" title="Edit">{{ $getTransactionList['invoice_number']}}</a>
			  										  </p>
													@else
													<p style="width:250px;">{{ $getTransactionList['invoice_number']}}</p>
			  										@endif
			  									</td>
			  									<td><p style="width:140px;">LPGC-{{ $getTransactionList['voucher_ref_number']}}</p></td>
			  									<td class="bg-info" style="color:#fff;"><p style="width:150px;">{{ $getTransactionList['category']}}</p></td>
												<td><p style="width:130px;">{{ $getTransactionList['issued_date']}}</p></td>
												<td><p style="width:200px;">{{ $getTransactionList['paid_to']}}</p></td>
												<td><p style="width:200px;">{{ $getTransactionList['account_name']}}</p></td>
			  									<td class="bg-danger" style="color:white;">
												  	<?php echo number_format($compute, 2); ?>
												</td>
												<td><p style="width:160px;">{{ $getTransactionList['delivered_date']}}</p></td>
			  									<td><p style="width:190px;">{{ $getTransactionList['method_of_payment'] }}</p></td>
			  									
			  									<td class="bg-success" style="color:white; "><p style="width:240px;"><a class="anchor" href="{{ url('lolo-pinoy-grill-commissary/view-payables-details/'.$getTransactionList['id']) }}">{{ $getTransactionList['status'] }}</a></p></td>
			  									<td><p style="width:190px;">{{ $getTransactionList['created_by']}}</p></td>
				  							</tr>
				  							@endforeach
				  						</tbody>
    					  			</table>
    					  		</div>	
    					  		<br>
    					  		<table class="table table-bordered">
								  <thead>
					  					<tr>
					  						<th width="30%" class="bg-info" style="color:white; font-size:28px;">TOTAL BALANCE DUE</th>
					  						<th class="bg-danger" style="color:white; font-size:28px;"><span id="totalDue">₱ <?php echo number_format($totalAmoutDue, 2);?></span></th>
					  					</tr>

					  				</thead>
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
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript">
	  function doRefresh(){
            $("#totalDue").fadeOut(500);
            $("#totalDue").fadeIn(500);     
            setTimeout(function() {
             doRefresh();
            }, 1000);
        }

        $(document).ready(function () {
          doRefresh(); 
        });
	 function confirmDelete(id){
        const x = confirm("Do you want to delete this?");
        if(x){
            $.ajax({
              type: "DELETE",
              url: '/lolo-pinoy-grill-commissary/delete-transaction-list/' + id,
              data:{
                _method: 'delete', 
                "_token": "{{ csrf_token() }}",
                "id": id
              },
              success: function(data){
                console.log(data);
                $("#deletedId"+id).fadeOut('slow');
               
              },
              error: function(data){
                console.log('Error:', data);
              }

            });

        }else{
            return false;
        }
    }
</script>
@endsection