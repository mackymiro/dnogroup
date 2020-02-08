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
      <li class="nav-item dropdown active">
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
              <li class="breadcrumb-item active">View Payment Voucher</li>
            </ol>
            
            <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
            	 <h4 class="text-center"><u>VIEW PAYMENT VOUCHER</u></h4>
            </div>
             <div class="row">
             	<div class="col-lg-12">
             		<div class="card mb-3">
         				 <div class="card-header">
                              <i class="fas fa-file-invoice" aria-hidden="true"></i>
                            View Payment Voucher </div>
                         <div class="card-body">
                         	<div class="form-group">
                         		<div class="form-row">
                         			<div class="col-lg-6">
                         				<label>Reference Number</label>
                         				<br>
                         				{{ $paymentVoucher['reference_number']}}
                         				<br>
                         				<br>
                         				<label>Paid To</label>
                         				<br>
                         				{{ $paymentVoucher['paid_to']}}
                         				<br>
                         				<br>
                         				<label>Account Number</label>
                         				<br>
                         				{{ $paymentVoucher['account_no']}}
                         				<br>
                         			</div>
                         			<div class="col-lg-6">
                         				<label>Date</label>
                         				<br>
                         				{{ $paymentVoucher['date']}}
                         				<br>
                         				<br>
                         				<label>Method Of Payment</label>
                         				<br>
                         				{{ $paymentVoucher['method_of_payment']}}
                         			</div>
                         		</div>
                         	</div>
                         	<div class="table-responsive">
                         		<table class="table table-striped">
                         			<thead>
                         				<tr>
                         					<th>Particulars</th>
                         					<th>Amount</th>
                         				</tr>
                         			</thead>
                         			<tbody>
                         				<tr>
                         				
                         					<td>{{ $paymentVoucher['particulars']}}</td>
                         					<td><?php echo number_format($paymentVoucher['amount'], 2);?></td>
                         				</tr>
                         				@foreach($pVouchers as $pVoucher)
                         				<tr>
                         					
                         					<td>{{ $pVoucher['particulars']}}</td>
                         					<td><?php echo number_format($pVoucher['amount'], 2);  ?></td>
                         				</tr>
                         				@endforeach
                         				<tr>
	                                      
	                                      <td><strong>Total</strong></td>
	                                      <td></td>
	                                    </tr>
                         			</tbody>
                         		</table>
                         		
                         	</div>
                         	<div class="form-group">
                     				<div class="form-row">
                     					<div class="col-lg-6">
                                        <label>Prepared/Checked By</label>
                                        <br>
                                        {{ $paymentVoucher['prepared_by']}}
                                        <br>
                                        <br>
                                        <label>Date</label>
                                        {{ $paymentVoucher['date_approved']}}
                                      </div>
                                      <div class="col-lg-6">
                                        <label>Approved By</label>
                                        {{ $paymentVoucher['approved_by'] }}
                                        <br>
                                        <br>
                                        <label>Received By </label>
                                        {{ $paymentVoucher['received_by_date']}}
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