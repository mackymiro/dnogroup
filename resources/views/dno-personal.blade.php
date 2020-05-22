@extends('layouts.dno-personal-app')
@section('title', 'Personal Expenses|')
@section('content')

<div id="wrapper">
	@include('sidebar.sidebar-dno-personal')
	<div id="content-wrapper">
		<div class="container-fluid">
			<!-- Breadcrumbs-->
			<ol class="breadcrumb">
	              <li class="breadcrumb-item">
	                <a href="#">DNO Personal</a>
	              </li>
				  <li class="breadcrumb-item active">Personal Expenses</li>
				  @if(\Request::is('dno-personal')) 
					<li class="breadcrumb-item ">ALD Accounts</li>
				  @elseif(\Request::is('dno-personal/personal-expenses/mod-accounts'))
					<li class="breadcrumb-item ">MOD Accounts</li>
				  @endif
	              
			</ol>
			<div class="row">
				<div class="col-lg-12">
					<div class="card mb-3">
						<div class="card-header">
							<i class="fa fa-file-invoice" aria-hidden="true"></i>
							Transaction List
                         
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
									 <thead>
										<tr>
											<th>Invoice #</th>
											<th>Paid To</th>
											<th>Account Name</th>
											<th >Issued Date</th>
											<th >Delivered Date</th>
											<th class="bg-danger" style="color:white;">Amount Due</th>
											<th >Status</th>
											<th>Created By</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Invoice #</th>
											<th>Paid To</th>
											<th>Account Name</th>
											<th >Issued Date</th>
											<th >Delivered Date</th>
											<th class="bg-danger" style="color:white;">Amount Due</th>
											<th >Status</th>
											<th>Created By</th>
										</tr>
									</tfoot>
									<tbody>
										@if(\Request::is('dno-personal')) 
										@foreach($getTransactions as $getTransaction)
										<?php $id = $getTransaction['id']; ?>
                                        <?php
												$amount1 = DB::table('dno_personal_payment_vouchers')
															->select('*')
															->where('id', $id)
															->sum('amount');
												
												$amount2 = DB::table('dno_personal_payment_vouchers')
															->select('*')
															->where('pv_id', $id)
															->sum('amount');
												$compute = $amount1 + $amount2;
											?>
										<tr>
											<td><a href="{{ url('dno-personal/personal-expenses/ald-accounts/transactions/'
											.$getTransaction['id']) }}">{{ $getTransaction['invoice_number']}}</a></td>
											<td>{{ $getTransaction['paid_to']}}</td>
											<td>{{ $getTransaction['account_name']}}</td>
											<td>{{ $getTransaction['issued_date'] }}</td>
											<td>{{ $getTransaction['delivered_date'] }}</td>
											<td class="bg-danger" style="color:white;"> <?php echo number_format($compute, 2);?></td>
                                          
											 <?php if($getTransaction['status'] === "FOR APPROVAL"): ?>
												<td class="bg-danger" style="color:white;">UNPAID</td>
											<?php elseif($getTransaction['status'] === "FOR CONFIRMATION"): ?>
												<td class="bg-danger" style="color:white;">UNPAID</td>
											<?php elseif($getTransaction['status'] === "FULLY PAID AND RELEASED"): ?>
												<td class="bg-success" style="color:white;">PAID</td>
											<?php else: ?>
												<td class="bg-danger " style="color:white;">UNPAID</td>
											<?php endif; ?>
											
											<td>{{ $getTransaction['created_by'] }}</td>
										</tr>
										@endforeach
										@elseif(\Request::is('dno-personal/personal-expenses/mod-accounts'))
										@foreach($getModTransactions as $getModTransaction)
										<?php $id = $getModTransaction['id']; ?>
                                        <?php
												$amount1 = DB::table('dno_personal_payment_vouchers')
															->select('*')
															->where('id', $id)
															->sum('amount');
												
												$amount2 = DB::table('dno_personal_payment_vouchers')
															->select('*')
															->where('pv_id', $id)
															->sum('amount');
												$compute = $amount1 + $amount2;
											?>
										<tr>
											<td><a href="{{ url('dno-personal/personal-expenses/mod-accounts/transactions/'
											.$getModTransaction['id']) }}">{{ $getModTransaction['invoice_number']}}</a></td>
											<td>{{ $getModTransaction['paid_to']}}</td>
											<td>{{ $getModTransaction['account_name']}}</td>
											<td>{{ $getModTransaction['issued_date'] }}</td>
											<td>{{ $getModTransaction['delivered_date'] }}</td>
											<td class="bg-danger" style="color:white;"> <?php echo number_format($compute, 2);?></td>
                                          
											 <?php if(isset($getModTransaction['status']) == "FOR APPROVAL"): ?>
												<td class="bg-danger" style="color:white;">UNPAID</td>
											<?php elseif(isset($getModTransaction['status']) == "FOR CONFIRMATION"): ?>
												<td class="bg-danger" style="color:white;">UNPAID</td>
											<?php elseif(isset($getModTransaction['status']) == "FULLY PAID AND RELEASED"): ?>
												<td class="bg-success" style="color:white;">PAID</td>
											<?php else: ?>
												<td class="bg-danger " style="color:white;">UNPAID</td>
											<?php endif; ?>
											
											<td>{{ $getModTransaction['created_by'] }}</td>
										</tr>
										@endforeach

										@endif
									</tbody>
								</table>
							</div>
							<br>
							<table class="table table-bordered">
								<thead>
									@if(\Request::is('dno-personal'))
									<tr>
										<th width="20%" class="bg-info" style="color:white;">TOTAL BALANCE DUE</th>
										<th class="bg-danger" style="color:white; font-size:30px;"><?php echo number_format($totalAmountDue, 2);?></th>
									</tr>
									@elseif(\Request::is('dno-personal/personal-expenses/mod-accounts'))
									<tr>
										<th width="20%" class="bg-info" style="color:white;">TOTAL BALANCE DUE</th>
										<th class="bg-danger" style="color:white; font-size:30px;"><?php echo number_format($totalAmountDueMod, 2);?></th>
									</tr>
									@endif
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
@endsection