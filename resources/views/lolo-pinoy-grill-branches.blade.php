@extends('layouts.lolo-pinoy-grill-branches-app')
@section('title', 'Transaction Lists (TODAY) | DNO HOldings Co')
@section('content')
<script>
  $(document).ready(function(){
	$('table.display').DataTable( {} );
  });
</script>
<div id="wrapper">
	 @include('sidebar.sidebar-lolo-pinoy-grill-branches')
	 <div id="content-wrapper">
		<div class="container-fluid">
			<!-- Breadcrumbs-->
			<ol class="breadcrumb">
	              <li class="breadcrumb-item">
	                <a href="#">Lolo Pinoy Grill Branches</a>
	              </li>
  				 @if(!empty($data))
				  <li class="breadcrumb-item active">
  					{{ $data }}
				  </li>
				 @endif
				  <li class="breadcrumb-item active">Transaction Lists</li>
			  
			</ol>
			<div class="row">
				<div class="col-lg-12">
					<div class="card mb-3">
						<div class="card-header">
							<i class="fa fa-file-invoice" aria-hidden="true"></i>
							Transaction List (TODAY)
                         
						</div>
						<div class="card-body">
							@if($data)
							<div class="table-responsive">
								<table class="table table-bordered display" width="100%" cellspacing="0">
									 <thead>
										<tr>
											<th>Date</th>
											<th>Transaction ID</th>
											<th>Branch</th>
											<th class="bg-danger" style="color:#fff;">Total Amount Of Sales</th>
											<th >Total Discounts (Seniors/PWD's)</th>
											<th >Gift Cert</th>
										
											<th>Cashier</th>
										</tr>
									</thead>
									<tfoot>	
										<tr>
											<th>Date</th>
											<th>Transaction ID</th>
											<th>Branch</th>
											<th class="bg-danger" style="color:#fff;">Total Amount Of Sales</th>
											<th >Total Discounts (Seniors/PWD's)</th>
											<th >Gift Cert</th>
										
											<th>Cashier</th>
										</tr>
									</tfoot>
									<tbody>	
										@foreach($getTransactionBranches as $getTransactionBranch)
										<tr>
											<td>{{ $getTransactionBranch['date']}}</td>
											<td>
											<a href="{{ url('lolo-pinoy-grill-branches/transaction-list-details/'.$getTransactionBranch['id']) }}">
												{{ $getTransactionBranch['id']}}
											</a></td>
											<td>{{ $getTransactionBranch['branch']}}</td>
										
											<td class="bg-danger" style="color:#fff;"><?= number_format($getTransactionBranch['total_amount_of_sales'], 2); ?></td>
											<td><?= number_format($getTransactionBranch['total_discounts_seniors_pwds']); ?></td>
											<td><?= number_format($getTransactionBranch['gift_cert'], 2)?></td>
											<td>{{ $getTransactionBranch['created_by']}}</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div><!-- end of table responsive  -->
							<table class="table table-bordered">
  								<thead>	
									<tr>
										<th width="20%" class="bg-info" style="color:white;">TOTAL SALES </th>
										<th class="bg-danger" style="color:white; font-size:30px;">₱ <?= number_format($sum, 2)?></th>
									</tr>
								
								</thead>
							</table>
							@else
  								<h1> Login To Branch To View Transactions </h1>
							@endif
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