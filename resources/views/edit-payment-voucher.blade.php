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
              <li class="breadcrumb-item active">Update Payment Voucher</li>
            </ol>
             <a href="{{ url('lolo-pinoy-lechon-de-cebu/payment-voucher-form') }}">Back to Form</a>
             <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
            	 <h4 class="text-center"><u>UPDATED PAYMENT VOUCHER</u></h4>
            </div>
            <div class="row">
            	 <div class="col-lg-12">
					<div class="card mb-3">
						 <div class="card-header">
                       <i class="fa fa-file-invoice" aria-hidden="true"></i>
                         Edit Payment Voucher</div>
                         <form action="{{ action('LoloPinoyLechonDeCebuController@updatePaymentVoucher', $getPaymentVoucher['id']) }}" method="post">
                         	{{ csrf_field() }}
                         	 <input name="_method" type="hidden" value="PATCH">
                         <div class="card-body">
                         	 @if(session('updateSuccessfull'))
                                 <p class="alert alert-success">{{ Session::get('updateSuccessfull') }}</p>
                                @endif 
                     		<div class="form-group">
                 				 <div class="form-row">
         				 			<div class="col-md-4">
				  	 					<label>Paid To </label>
				  	 					<input type="text" name="paidTo" class="form-control" value="{{ $getPaymentVoucher['paid_to']}}" />                           
				  	 				</div>
				  	 				<div class="col-md-4">
				  	 					<label>Account No</label>
				  	 					<input type="text" name="accountNo" class="form-control"  value="{{ $getPaymentVoucher['account_no']}}" />
					  	 			</div>
					  	 			<div class="col-md-2">
				  	 					<label>Date </label>
				  	 					<input type="text" name="date" class="form-control" value="{{ $getPaymentVoucher['date']}}"  />
					  	 			</div>
                 				 </div>
                     		</div>
                     		<div class="form-group">
                 				<div class="form-row">
             						<div class="col-md-4">
				  	 					<label>Particulars</label>
				  	 					<input type="text" name="particulars" class="form-control" value="{{ $getPaymentVoucher['particulars']}}" />
				  	 			    </div>
				  	 			   	<div class="col-md-2">
				  	 					<label>Amount</label>
				  	 					<input type="text" name="amount" class="form-control" value="<?php echo number_format($getPaymentVoucher['amount'], 2); ?>" />
					  	 			</div>
					  	 			<div class="col-md-2">
			  	 						<label>Method Of Payment</label>
				  	 					<select name="methodOfPayment" class="form-control">
				  	 						<option value="Cheque"  {{ ( $getPaymentVoucher['method_of_payment'] == "Cheque") ? 'selected' : '' }}>Cheque</option>
				  	 						<option value="Cash"  {{ ( $getPaymentVoucher['method_of_payment'] == "Cash") ? 'selected' : '' }}>Cash</option>
				  	 					</select>
			  	 			        </div>
                     			</div>
                     		</div>
                     		<div>
		  	 				    <input type="submit" class="btn btn-success float-right" value="Update Payment Voucher" />
			  	 			 </div>
			  	 			 <br>
                         </div>
                     	</form>
					</div>
            	 </div>
            </div>	
            <div class="row">
        		 <div class="col-lg-12">
        		 	<div class="card mb-3">
        		 		<div class="card-header">
                       <i class="fa fa-file-invoice" aria-hidden="true"></i>
                          Edit Payment Voucher</div>
                      	<div class="card-body">
                      		 @if(session('SuccessEdit'))
                               <p class="alert alert-success">{{ Session::get('SuccessEdit') }}</p>
                              @endif 
                      		@foreach($pVouchers as $pVoucher)
                      		<form action="{{ action('LoloPinoyLechonDeCebuController@updatePV', $pVoucher['id']) }}" method="post">
                      		 <div class="form-group">
                      		 	 {{csrf_field()}}
                                 <input name="_method" type="hidden" value="PATCH">
                      		 	<div id="deletedId{{ $pVoucher['id']}}" class="form-row">
                      		 		<div class="col-md-4">
			  	 					<label>Particulars</label>
			  	 					<input type="text" name="particulars" class="form-control" value="{{ $pVoucher['particulars']}}" />
				  	 			    </div>
			  	 			    	<div class="col-md-2">
				  	 					<label>Amount</label>
				  	 					<input type="text" name="amount" class="form-control"  value="<?php echo number_format($pVoucher['amount'], 2); ?>" />
					  	 			</div>
					  	 			<div class="col-lg-2">
                                      <br>
                                      <input type="hidden" name="pvId" value="{{ $pVoucher['id'] }}" />
                                      <input type="submit" class="btn btn-success" value="Update" />
                                      @if($user->role_type == 1)
                                      <a id="delete" onClick="confirmDelete('{{ $pVoucher['id']}}')" href="javascript:void" class="btn btn-danger">Remove</a>
                                      @endif
                                    </div>
                      		 	</div>
                      		 	
                      		 </div>
                      		</form>
                      		 @endforeach
                      		<div>
                              @if($user->role_type == 1)
                              <a href="{{ url('lolo-pinoy-lechon-de-cebu/add-new-payment-voucher/'.$getPaymentVoucher['id']) }}" class="btn btn-primary">Add New </a>
                              @endif
                            </div>
                      	</div>
        		 	</div>
        		 </div>
            </div>	
    	</div>	
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript">
	 function confirmDelete(id){
      var x = confirm("Do you want to delete this?");
        if(x){
            $.ajax({
              type: "DELETE",
              url: '/lolo-pinoy-lechon-de-cebu/delete-payment-voucher/' + id,
              data:{
                _method: 'delete', 
                "_token": "{{ csrf_token() }}",
                "id": id
              },
              success: function(data){
                console.log(data);
                $("#deletedId"+id).fadeOut('slow');
              },
              error: function(data){
                console.log('Error:', data);
              }

            });

        }else{
            return false;
        }
   }
</script>
@endsection