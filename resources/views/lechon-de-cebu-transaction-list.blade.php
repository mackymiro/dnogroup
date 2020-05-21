@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
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
	 @include('sidebar.sidebar')
     <div id="content-wrapper">
		<div class="container-fluid">
			 <!-- Breadcrumbs-->
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">Lechon de Cebu</a>
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
										  	<?php $sum = 0; ?>
				  							@foreach($getTransactionLists as $getTransactionList)
											<?php $id = $getTransactionList['id']; ?>
											<?php
												$amount1 = DB::table('lechon_de_cebu_payment_vouchers')
															->select('*')
															->where('id', $id)
															->sum('amount');
												
												$amount2 = DB::table('lechon_de_cebu_payment_vouchers')
															->select('*')
															->where('pv_id', $id)
															->sum('amount');
												$compute = $amount1 + $amount2;
											?>
									
											
				  							<tr id="deletedId{{ $getTransactionList['id'] }}">
			  									<td width="2%">
			  										@if($user->role_type == 1)
					  									<a id="delete" onClick="confirmDelete('{{ $getTransactionList['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
				              						@endif
			  									</td>
			  									<td>
			  										
			  										<a href="{{ url('lolo-pinoy-lechon-de-cebu/edit-payables-detail/'.$getTransactionList['id']) }}" title="Edit">{{ $getTransactionList['invoice_number']}}</a>
			  									
			  									</td>
			  									<td>LPLDC-{{ $getTransactionList['voucher_ref_number']}}</td>
			  									<td>{{ $getTransactionList['issued_date']}}</td>
			  									<td class="bg-danger" style="color:white;">												  
												  <?php echo number_format($compute, 2); ?></td>
			  									<td>{{ $getTransactionList['delivered_date']}}</td>
			  									
			  									<td class="bg-success" style="color:white; "><a class="anchor" href="{{ url('lolo-pinoy-lechon-de-cebu/view-payables-details/'.$getTransactionList['id']) }}">{{ $getTransactionList['status'] }}</a></td>
			  								
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
	 function confirmDelete(id){
        var x = confirm("Do you want to delete this?");
        if(x){
            $.ajax({
              type: "DELETE",
              url: '/lolo-pinoy-lechon-de-cebu/delete-transaction-list/' + id,
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