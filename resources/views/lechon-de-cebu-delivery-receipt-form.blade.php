@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('content')
<div id="wrapper">
	<!-- Sidebar -->
    <ul class="sidebar navbar-nav">
       <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-cash-register"></i>
          <span>Sales Invoice</span>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-receipt"></i>
          <span>Delivery Receipt</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/delivery-receipt-form')}}">Delivery Receipt Form</a>
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/delivery-receipt/lists') }}">Lists</a>
         
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fab fa-first-order"></i>
          <span>Purchase order</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/purchase-order') }}">P.O Form</a>
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/purchase-order-lists') }}">Lists</a>
         
        </div>
      </li>
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-receipt"></i>
          <span>Statement of account</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/statement-of-account-form')}}">Statement of Account</a>
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/statement-of-account/lists') }}">Lists</a>
         
        </div>
      </li>
       <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-receipt"></i>
          <span>Billing statement</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/billing-statement-form') }}">Billing Statement Form</a>
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/billing-statement-lists') }}">Lists</a>
         
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-file-invoice"></i>
          <span>Payment vouchers</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/payment-voucher-form') }}">Payment Voucher Form</a>
            <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/cash-vouchers') }}">Cash Vouchers</a>
            <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/cheque-vouchers') }}">Cheque Vouchers</a>  
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-apple-alt"></i>
          <span>Commissary</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          
          <a class="dropdown-item" href="login.html">RAW materials</a>
          <a class="dropdown-item" href="register.html">Production</a>
          <a class="dropdown-item" href="forgot-password.html">Stocks inventory</a>     
          <a class="dropdown-item" href="forgot-password.html">Delivery Outlets</a>

          <a class="dropdown-item" href="forgot-password.html">Sales of outlets</a>

          <a class="dropdown-item" href="forgot-password.html">Inventory of stocks</a>
         
        </div>
      </li>   
    </ul>
    <div id="content-wrapper">
    	<div class="container-fluid">
    		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lechon de Cebu</a>
              </li>
              <li class="breadcrumb-item active">Delivery Receipt Form</li>
            </ol>
            <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
            	 <h4 class="text-center"><u>DELIVERY RECEIPT</u></h4>
            </div>
            <div class="row">
            	<div class="col-lg-12">
            		<div class="card mb-3">
            			<div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            Delivery Receipt</div>
                        <div class="card-body">
                        	<form action="{{ action('LoloPinoyLechonDeCebuController@storeDeliveryReceipt')}}" method="post">
                        		{{ csrf_field() }}
                        	<div class="form-group">
                        		<div class="form-row">
                    				<div class="col-md-4">
                    					<label>Sold To</label>
                    					<input type="text" name="soldTo" class="form-control" required="required" />
                    					@if ($errors->has('soldTo'))
		                                  <span class="alert alert-danger">
		                                    <strong>{{ $errors->first('soldTo') }}</strong>
		                                  </span>
		                                @endif
                    				</div>
                    				<div class="col-md-2">
                						<label>Time</label>
                						<input type="text" name="time" class="form-control" />
                    				</div>
                    				<div class="col-md-4">
                    					<label>Delivered To</label>
                    					<input type="text" name="deliveredTo" class="form-control" />
                    				</div>
                        		</div>
                        	</div>
                        	<div class="form-group">
                        		<div class="form-row">
                        			<div class="col-md-4">
                        				<label>Contact Person</label>
                        				<input type="text" name="contactPerson" class="form-control" />
                        			</div>
                        			<div class="col-md-2">
                        				<label>Mobile #</label>
                        				<input type="" name="mobile" class="form-control" />
                        			</div>
                        			<div class="col-md-4">
                        				<label>Special Instruction/Request</label>
                        				<input type="text" name="specialInstruction" class="form-control" />
                        			</div>
                        		</div>
                        	</div>
                        	<div class="form-group">
                    			<div class="form-row">
                    				<div class="col-md-1">
                						<label>QTY</label>
                						<input type="text" name="qty" class="form-control" required="required" />
                    				</div>
                    				<div class="col-md-4">
                    					<label>Description</label>
                    					<input type="text" name="description" class="form-control" required="required" />
                    				</div>
                    				<div class="col-md-2">
                    					<label>Price</label>
                    					<input type="text" name="price" class="form-control" required="required" />
                    				</div>
                    			</div>
                        	</div>
                    		<div>
	  	 				      <input type="submit" class="btn btn-success float-right" value="Add Delivery Receipt" />
		  	 			    </div>
		  	 				</form>
                        </div>
            		</div>
            	</div>
            </div>
    	</div>
    </div>
</div>
@endsection