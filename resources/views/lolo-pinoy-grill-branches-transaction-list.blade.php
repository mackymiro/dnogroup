@extends('layouts.lolo-pinoy-grill-branches-app')
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
	 @include('sidebar.sidebar-lolo-pinoy-grill-branches')
     <div id="content-wrapper">
		<div class="container-fluid">
			 <!-- Breadcrumbs-->
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">Lolo Pinoy Grill Branches</a>
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
				  								<th>Issued Date</th>
				  								<th  class="bg-danger" style="color:white;">Amount Due</th>
				  								<th>Delivered Date</th>
				  								<th class="bg-success" style="color:white;">Status</th>
					  						</tr>
				  						</thead>
				  						<tfoot>
				  							<tr>
				  								<th>Action</th>
				  								<th>Invoice #</th>
				  								<th>Voucher Ref #</th>
				  								<th>Issued Date</th>
				  								<th  class="bg-danger" style="color:white;">Amount Due</th>
				  								<th>Delivered Date</th>
				  								<th class="bg-success" style="color:white;">Status</th>
					  						</tr>
				  						</tfoot>
				  						<tbody>
				  							@foreach($getTransactionLists as $getTransactionList)
											<?php $id = $getTransactionList['id']; ?>
											<?php
												$amount1 = DB::table('lolo_pinoy_grill_branches_payment_vouchers')
															->select('*')
															->where('id', $id)
															->sum('amount');
												
												$amount2 = DB::table('lolo_pinoy_grill_branches_payment_vouchers')
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
			  										<a href="{{ url('lolo-pinoy-grill-branches/edit-lolo-pinoy-grill-branches-payables-detail/'.$getTransactionList['id']) }}" title="Edit">{{ $getTransactionList['invoice_number']}}</a>
			  										@else
			  											{{ $getTransactionList['invoice_number']}}
			  										@endif
			  									</td>
			  									<td>LPGB-{{ $getTransactionList['voucher_ref_number']}}</td>
			  									<td>{{ $getTransactionList['issued_date']}}</td>
			  									<td class="bg-danger" style="color:white;">
												  	<?php echo number_format($compute, 2); ?>
												</td>
			  									<td>{{ $getTransactionList['delivered_date']}}</td>
			  									@if($getTransactionList['status'] == "FULLY PAID AND RELEASED")
			  									<td class="bg-success" style="color:white; "><a class="anchor" href="{{ url('lolo-pinoy-grill-branches/view-lolo-pinoy-grill-branches-payables-details/'.$getTransactionList['id']) }}">{{ $getTransactionList['status'] }}</a></td>
			  									@else
			  									<td class="bg-success" style="color:white; ">{{ $getTransactionList['status'] }}</td>
			  									@endif
				  							</tr>
				  							@endforeach
				  						</tbody>
    					  			</table>
    					  		</div>	
    					  		<br>
    					  		<table class="table table-bordered">
					  				<thead>
					  					<tr>
					  						<th width="20%" class="bg-info" style="color:white;">TOTAL BALANCE DUE</th>
					  						<th class="bg-danger" style="color:white;"><?php echo number_format($totalAmoutDue, 2);?></th>
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
	const confirmDelete = (id) =>{
		const x = confirm("Do you want to delete this?");
        if(x){
            $.ajax({
              type: "DELETE",
              url: '/lolo-pinoy-grill-branches/delete-transaction-list/' + id,
              data:{
                _method: 'delete', 
                "_token": "{{ csrf_token() }}",
                "id": id
              },
              success: function(data){
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