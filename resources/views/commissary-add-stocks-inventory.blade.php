@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
</script>
<div id="wrapper">
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
          @if($user->role_type == 1)
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/purchase-order') }}">P.O Form</a>
          @endif
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
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-receipt"></i>
          <span>Billing statement</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          @if($user->role_type == 1)
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/billing-statement-form') }}">Billing Statement Form</a>
          @endif
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
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/commissary/stocks-inventory') }}">Stocks inventory</a>     
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
                <li class="breadcrumb-item ">Commissary</li>
                <li class="breadcrumb-item active">Add Stocks Inventory</li>
              </ol>
              <div class="row">
          			<div class="col-lg-12">
      					<div class="card mb-3">
      						<div class="card-header">
          					  <i class="fa fa-plus" aria-hidden="true"></i>
          					  add Stocks Inventory</div>
      					  	 <div class="card-body">
      					  	 	<form action="{{ action('LoloPinoyLechonDeCebuController@addStockInventory') }}" method="post">
                        {{csrf_field()}}
                         @if(session('addStockInventory'))
                           <p class="alert alert-success">{{ Session::get('addStockInventory') }}</p>
                          @endif 
      					  	 	<div class="form-group">
  					  	 			<div class="form-row">
  					  	 				<div class="col-md-2">
  					  	 					<label>Branch </label>
  					  	 					<input type="text" name="branch" class="form-control"  />
  					  	 				</div>
  					  	 				
  					  	 				<div class="col-md-4">
					  	 					<label>Product Name</label>
					  	 					<input type="text" name="productName" class="form-control" required="required" />
                        @if ($errors->has('productName'))
                              <span class="alert alert-danger">
                                <strong>{{ $errors->first('productName') }}</strong>
                              </span>
                         @endif
  					  	 				</div>
  					  	 				<div class="col-md-1">
  					  	 					<label>Unit Price</label>
  					  	 					<input type="text" name="unitPrice" class="form-control" />
  					  	 				</div>
  					  	 				<div class="col-md-1">
  					  	 					<label>Unit</label>
  					  	 					<input type="text" name="unit" class="form-control" />
  					  	 				</div>
  					  	 				<div class="col-md-1">
  					  	 					<label>IN</label>
  					  	 					<input type="text" name="in" class="form-control" />
  					  	 				</div>
  					  	 				<div class="col-md-1">
  					  	 					<label>OUT</label>
  					  	 					<input type="text" name="out" class="form-control" />
  					  	 				</div>
                        <div class="col-md-2">
                          <label>Stock Out Amount</label>
                          <input type="text" name="stockAmount" class="form-control" />
                        </div>
  					  	 				
  					  	 			</div>
      					  	 	</div>
      					  	 	<div class="form-group">
      					  	 		<div class="form-row">
                          <div class="col-md-2">
                            <label>Remaining Stock</label>
                            <input type="text" name="remainingStock" class="form-control" />
                          </div>
      					  	 			<div class="col-md-2">
      					  	 				<label>Amount</label>
      					  	 				<input type="text" name="amount" class="form-control" />
      					  	 			</div>
      					  	 			<div class="col-md-2">
      					  	 				<label>Supplier</label>
      					  	 				<input type="text" name="supplier" class="form-control" />
      					  	 			</div>
      					  	 			
      					  	 		</div>
      					  	 	</div>
      					  	 	<div class="form-group">
      					  	 		<div class="form-row">
      					  	 			
      					  	 			<div class="float-right">
      					  	 				
      					  	 				<button type="submit" class="btn btn-success">
												      <i class="fa fa-plus" aria-hidden="true"></i>  Add Stocks
											       </button>
                             <br>
                             <br>
                             <a href="{{ url('lolo-pinoy-lechon-de-cebu/commissary/stocks-inventory') }}">Back</a>
      					  	 			</div>
      					  	 		</div>
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