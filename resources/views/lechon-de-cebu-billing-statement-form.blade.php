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
           <i class="fab fa-first-order"></i>
          <span>Purchase order</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/purchase-order') }}">P.O Form</a>
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/purchase-order-lists') }}">Lists</a>
         
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-receipt"></i>
          <span>Statement of account</span>
        </a>
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
      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-file-invoice"></i>
          <span>Cash vouchers</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-book"></i>
          <span>Check vouchers</span>
        </a>
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
      <form action="{{ action('LoloPinoyLechonDeCebuController@storeBillingStatement') }}" method="post">
          {{csrf_field()}}
    	<div class="container-fluid">
    		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lechon de Cebu</a>
              </li>
              <li class="breadcrumb-item active">Billing Statement Form</li>
            </ol>
            <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
            	 <h4 class="text-center"><u>BILLING STATEMENT</u></h4>
            </div>
            <div class="form-group">
            	<div class="form-row">
            		<div class="col-lg-6">
            			<label>Bill to</label>
            			<input type="text" name="billTo" class="form-control" required="required" />
            			@if ($errors->has('billTo'))
		                  <span class="alert alert-danger">
		                    <strong>{{ $errors->first('billTo') }}</strong>
		                  </span>
		                @endif
            			<label>Address</label>
            			<input type="text" name="address" class="form-control" required="required" />
            			@if ($errors->has('address'))
		                  <span class="alert alert-danger">
		                    <strong>{{ $errors->first('address') }}</strong>
		                  </span>
		                @endif
            			<label>Period Covered</label>
            			<input type="text" name="periodCovered" class="form-control" required="required" />
            			@if ($errors->has('periodCovered'))
		                  <span class="alert alert-danger">
		                    <strong>{{ $errors->first('periodCovered') }}</strong>
		                  </span>
		                @endif
            		</div>
            		<div class="col-lg-6">
            			<label>Date</label>
            			<input type="text" name="date" class="form-control" required="required" />
            			@if ($errors->has('date'))
		                  <span class="alert alert-danger">
		                    <strong>{{ $errors->first('date') }}</strong>
		                  </span>
		                @endif
            			<label>Reference #</label>
            			<input type="text" name="refNumber" class="form-control" disabled="disabled" />
            			<label>PO Number</label>
            			<input type="text" name="poNumber" class="form-control" disabled="disabled" />
            			
            			<label>Terms</label>
            			<input type="text" name="terms" class="form-control" required="required" />
            			@if ($errors->has('terms'))
		                  <span class="alert alert-danger">
		                    <strong>{{ $errors->first('terms') }}</strong>
		                  </span>
		                @endif
            		</div>
            	</div>
            </div>
            <div class="form-group">
            	<div class="form-row">
              			<div class="col-lg-1">
            					<label>Date</label>
            					<input type="text" name="transactionDate" class="form-control" required="required" />
            					@if ($errors->has('transactionDate'))
        		                  <span class="alert alert-danger">
        		                    <strong>{{ $errors->first('transactionDate') }}</strong>
        		                  </span>
        		                @endif
              			</div>
              			<div class="col-lg-1">
              					<label>Invoice #</label>
              					<input type="text" name="invoiceNumber" class="form-control" disabled="disabled" />
              			</div>
            			<div class="col-lg-4">
            				<label>Whole Lechon 500/KL</label>
            				<input type="text" name="wholeLechon" class="form-control"  required="required" />
            				@if ($errors->has('wholeLechon'))
    		                  <span class="alert alert-danger">
    		                    <strong>{{ $errors->first('wholeLechon') }}</strong>
    		                  </span>
    		                @endif
            			</div>
            			<div class="col-lg-4">
            				<label>Description</label>
            				<input type="text" name="description" class="form-control"  required="required" />
            				@if ($errors->has('description'))
    		                  <span class="alert alert-danger">
    		                    <strong>{{ $errors->first('description') }}</strong>
    		                  </span>
    		                @endif
            			</div>
            			<div class="col-lg-1">
            				<label>Amount</label>
            				<input type="text" name="amount" class="form-control" disabled="disabled" />
            			</div>
            	</div>
            	<br>
		          <div>
		              <input type="submit" class="btn btn-success float-right" value="Add Billing" />
		          </div>
            </div>
           
    	</div>
     </form>  
    </div>
</div>

@endsection