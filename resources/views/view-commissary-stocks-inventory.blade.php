@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
</script>
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
            <a class="dropdown-item" href="">Payment Voucher Form</a>
            <a class="dropdown-item" href="login.html">Cash Vouchers</a>
            <a class="dropdown-item" href="login.html">Cheque Vouchers</a> 
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
              <li class="breadcrumb-item active">View Commissary Stocks Inventory Details</li>
            </ol>
             <a href="{{ url('lolo-pinoy-lechon-de-cebu/commissary/stocks-inventory') }}">Back to Lists</a>
            <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
            	 <h4 class="text-center"><u>VIEW COMMISSARY STOCKS INVENTORY</u></h4>
            </div>
             <div class="row">
             	<div class="col-lg-12">
             		<div class="card mb-3">
             			 <div class="card-header">
                              <i class="fas fa-apple-alt" aria-hidden="true"></i>
                            View Commissary Stocks Inventory </div>
                         <div class="card-body">
                         	<div class="table-responsive">
                         		<table class="table table-striped">
                         			<thead>	
                         				<tr>
                         					<th>Branch</th>
                     						<th>Product Id No</th>
                     						<th>Product Name</th>
                     						<th>Unit Price</th>
                     						<th>Unit</th>
                     						<th class="alert alert-danger">IN</th>
                     						<th>OUT</th>
                     						<th>Remaining Stock</th>
                     						<th>Amount</th>
                     						<th>Supplier</th>
                         				</tr>
                         			</thead>
                         			<tbody>
                         				<tr>
                         					<td>{{ $getStocksInventory['branch'] }}</td>
                         					<td>{{ $getStocksInventory['product_id_no'] }}</td>
                         					<td>{{ $getStocksInventory['product_name'] }}</td>
                         					<td>{{ $getStocksInventory['unit_price'] }}</td>
                         					<td>{{ $getStocksInventory['unit'] }}</td>
                         					<td class="alert alert-danger">{{ $getStocksInventory['in'] }}</td>
                         					<td>{{ $getStocksInventory['out'] }}</td>
                         					<td>{{ $getStocksInventory['remaining_stock'] }}</td>
                         					<td>{{ $getStocksInventory['amount'] }}</td>
                         					<td>{{ $getStocksInventory['supplier'] }}</td>
                         				</tr>
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