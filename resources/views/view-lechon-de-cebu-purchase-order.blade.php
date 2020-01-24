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
          @if($user->role_type == 1)
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/purchase-order') }}">P.O Form</a>
          @endif
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/purchase-order-lists') }}">Lists</a>
         
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-receipt"></i>
          <span>Statement of account</span>
           <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/statement-of-account-form')}}">Statement of Account</a>
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/statement-of-account/lists') }}">Lists</a>
         
        </div>
        </a>
      </li>
       <li class="nav-item dropdown active">
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
    	<div class="container-fluid">
    		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lechon de Cebu</a>
              </li>
              <li class="breadcrumb-item active">View Purchase Order</li>
            </ol>
            <a href="{{ url('lolo-pinoy-lechon-de-cebu/purchase-order-lists') }}">Back to Lists</a>
             <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
            	 <h4 class="text-center"><u>VIEW PURCHASE ORDER</u></h4>
            </div>
             <div class="form-group">
             	<div class="form-row">
             		<div class="col-lg-6">
            			<label>Paid to</label>
            			<br>
      					 {{ $purchaseOrder['paid_to'] }}
      			 		<br>
      			 		<br>
      			 		<label>Address</label>
      			 		<br>
      			 		Labogon Mandaue City
      			 		
            		</div>
            		<div class="col-lg-6">
            			<label>P.O Number</label>
            			<br>
            			<a href="#">P.O-{{ $purchaseOrder['p_o_number'] }}</a>
            			<br>
            			<br>
            			<label>Date</label>
            			<br>
            			{{ $purchaseOrder['date'] }}
            		</div>
             	</div>
             </div>
             <table class="table table-striped">
             		<thead>
             			<tr>
             				<th>QUANTITY</th>
             				<th>DESCRIPTION</th>
             				<th>UNIT PRICE</th>
             				<th>AMOUNT</th>
             			</tr>
             		</thead>
               		<tbody>

           				<tr>
           					<td>{{ $purchaseOrder['quantity']}}</td>
           					<td>{{ $purchaseOrder['description']}}</td>
           					<td>{{ $purchaseOrder['unit_price']}}</td>
           					<td>{{ $purchaseOrder['amount']}}</td>
           				</tr>
           				@foreach($pOrders as $pOrder)
           				<tr>
           					<td>{{ $pOrder['quantity'] }}</td>
           					<td>{{ $pOrder['description'] }}</td>
           					<td>{{ $pOrder['unit_price'] }}</td>
           					<td><?php echo number_format($pOrder['amount'], 2) ?></td>
           				</tr>	
           				@endforeach
           				<tr>
           					<td></td>
           					<td></td>
           					<td><strong>Total</strong></td>
           					<td></td>
           				</tr>
               		</tbody>
             </table>
             <div class="form-group">
                <div class="form-row">
                    <div class="col-lg-6">
                      <label>Requested By</label>
                    </div>
                    <div class="col-lg-6">
                      <label>Prepared By</label>
                      <p>{{ $purchaseOrder['created_by'] }}</p>
                    </div>
                </div>
             </div>
             <div class="form-group">
                <div class="form-row">
                    <div class="col-lg-6">
                      <label>Checked By</label>
                    </div>
                   
                </div>
             </div>
    	</div>
    </div>	

</div>
@endsection