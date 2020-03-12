@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'Cash Voucher Lists |')
@section('content')
<div id="wrapper">
	 @include('sidebar.sidebar-lolo-pinoy-grill')
	  <div id="content-wrapper">
	  		<div class="container-fluid">
	  			 <!-- Breadcrumbs-->
	              <ol class="breadcrumb">
	                <li class="breadcrumb-item">
	                  <a href="#">Lolo Pinoy Grill Commissary</a>
	                </li>
	                <li class="breadcrumb-item active">Cash Vouchers All Lists</li>
	              </ol>
	              <div class="row">
	              	<div class="col-lg-12">
	              		<div class="card mb-3">
	              			<div class="card-header">
	    					  <i class="fa fa-file-invoice" aria-hidden="true"></i>
	    					  All Lists</div>
	    					  <div class="card-body">
	    					  		<div class="table-responsive">
	    					  			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
	    					  				<thead>
						  						<th>Action</th>
						  						<th>Reference #</th>
							                    <th>Paid To</th>
						  						<th>Account No</th>
						  						<th>Date</th>
						  						<th>Method Of Payment</th>
						  						<th>Particulars</th>
						  						<th>Amount</th>
						  						<th>Created By</th>
					  						</thead>
					  						<tfoot>
					  							<th>Action</th>
						  						<th>Reference #</th>
							                    <th>Paid To</th>
						  						<th>Account No</th>
						  						<th>Date</th>
						  						<th>Method Of Payment</th>
						  						<th>Particulars</th>
						  						<th>Amount</th>
						  						<th>Created By</th>
					  						</tfoot>
					  						<tbody>
					  							@foreach($getAllCashVouchers as $getAllCashVoucher)
					  							<tr id="deletedId{{ $getAllCashVoucher['id']}}">
					  								<td>
					  									<a href="{{ url('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-payment-voucher/'.$getAllCashVoucher['id']) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
	      		  										<a id="delete" href="javascript:void" onClick="confirmDelete('{{ $getAllCashVoucher['id']}}')" title="Delete"><i class="fas fa-trash"></i></a>
	      		  										<a href="{{ url('lolo-pinoy-grill-commissary/view-lolo-pinoy-grill-payment-voucher/'.$getAllCashVoucher['id']) }}" title="View"><i class="fas fa-low-vision"></i></a>
					  								</td>
					  								<td>{{ $getAllCashVoucher['reference_number'] }}</td>
					  								<td>{{ $getAllCashVoucher['paid_to'] }}</td>
					  								<td>{{ $getAllCashVoucher['account_no']}}</td>
					  								<td>{{ $getAllCashVoucher['date'] }}</td>
					  								<td class="bg-success" style="color:white;">{{ $getAllCashVoucher['method_of_payment'] }}</td>
					  								<td>{{ $getAllCashVoucher['particulars']}}</td>
					  								<td><?php echo number_format($getAllCashVoucher['amount'], 2); ?></td>
					  								<td>{{ $getAllCashVoucher['created_by'] }}</td>
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
</div>
@endsection