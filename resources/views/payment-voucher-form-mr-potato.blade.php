@extends('layouts.mr-potato-app')
@section('title', 'Payment Voucher Form |')
@section('content')
<div id="wrapper">
	<!-- Sidebar -->
    @include('sidebar.sidebar-mr-potato')
    <div id="content-wrapper">
    	<div class="container-fluid">
    		 <!-- Breadcrumbs-->
	            <ol class="breadcrumb">
	              <li class="breadcrumb-item">
	                <a href="#">Mr Potato</a>
	              </li>
	              <li class="breadcrumb-item active">Payment Voucher Form</li>
	            </ol>
	            <div class="col-lg-12">
	            	 <img src="{{ asset('images/mr-potato.png')}}" width="390" height="250" class="img-responsive mx-auto d-block" alt="Mr Potato">
	            	 
	            	 <h4 class="text-center"><u>PAYMENT VOUCHER</u></h4>
	            </div>
	            <div class="row">
	            	<div class="col-lg-12">
	            		<div class="card mb-3">
	            			<div class="card-header">
                              <i class="fas fa-file-invoice" aria-hidden="true"></i>
                          	  Payment Voucher</div>
                          	  <div class="card-body">
                          	  		<div class="form-group">
                      	  				<div class="form-row">
                  	  						<div class="col-lg-4">
                  	  							<label>Paid To</label>
                  	  							<input type="text" name="paidTo" class="form-control" />
                  	  						</div>
                  	  						<div class="col-lg-4">
                  	  							<label>Account Number</label>
                  	  							<input type="text" name="accountNumber" class="form-control" />
                  	  						</div>
                  	  						<div class="col-lg-4">
                  	  							<label>Reference Number</label>
                  	  							<input type="text" name="referenceNumber" class="form-control" />
                  	  						</div>
                      	  				</div>
                          	  		</div>
                          	  		<div class="form-group">
                          	  			<div class="form-row">
                      	  					<div class="col-lg-2">
                      	  						<label>Date</label>
                      	  						<input type="text" name="date" class="form-control" />
                      	  					</div>
                      	  					<div class="col-lg-4">
                      	  						<label>Particulars</label>
                      	  						<input type="text" name="particulars" class="form-control" />
                      	  					</div>
                      	  					<div class="col-lg-2">
                      	  						<label>Method Of Payment</label>
                      	  						<input type="text" name="date" class="form-control" />
                      	  					</div>
                          	  			</div>
                          	  		</div>
                          	  </div>
	            		</div>
	            	</div>	
	            </div>	
    	</div>
    </div>
</div>
@endsection