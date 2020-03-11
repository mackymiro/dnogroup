@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'Edit Payment Voucher |')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
</script>
<div id="wrapper">
	@include('sidebar.sidebar-lolo-pinoy-grill')
	 <div id="content-wrapper"> 
	 	<div class="container-fluid">
	 		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lolo Pinoy Grill Commissary</a>
              </li>
              <li class="breadcrumb-item active">Update Payment Voucher</li>
            </ol>
             <a href="{{ url('lolo-pinoy-grill-commissary/payment-voucher-form') }}">Back to Form</a>
              <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoy-grill.jpeg')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lolo Pinoy Grill">
            	 
            	 <h4 class="text-center"><u>PAYMENT VOUCHER</u></h4>
            </div>
             <div class="row">
             	<div class="col-lg-12">
             		<div class="card mb-3">
             			<div class="card-header">
                              <i class="fas fa-file-invoice" aria-hidden="true"></i>
                          	  Payment Voucher</div>

                      	 <form action="{{ action('LoloPinoyGrillCommissaryController@updatePaymentVoucher', $getPaymentVoucher['id']) }}" method="post">
                      	  {{ csrf_field() }}
                     	 <input name="_method" type="hidden" value="PATCH">
                  	  	 <div class="card-body">
                  	  	 	 @if(session('updateSuccessfull'))
                                 <p class="alert alert-success">{{ Session::get('updateSuccessfull') }}</p>
                                @endif 
                  	  	 	<div class="form-group">
                  	  	 		<div class="form-row">
                  	  	 			<div class="col-lg-4">
              	   						<label>Paid To</label>
              	   						<input type="text" name="paidTo" class="form-control" value="{{ $getPaymentVoucher['paid_to'] }}" />
          	   							
                  	   				</div>
                  	   				<div class="col-lg-4">
              	   						<label>Account No</label>
              	   						<input type="text" name="accountNum" class="form-control" value="{{ $getPaymentVoucher['account_no']}}" />
                  	   				</div>
                  	   				<div class="col-md-2">
			  	 						<label>Date </label>
			  	 						<input type="text" name="date" class="form-control" value="{{ $getPaymentVoucher['date']}}" />
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
				  	 					<input type="text" name="amount" class="form-control"  value="{{ $getPaymentVoucher['amount']}}" />
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


                  			<div>
		                        @if($user->role_type == 1)
		                        	<a href="{{ url('lolo-pinoy-grill-commissary/add-new-lolo-pinoy-grill-payment-voucher/'.$getPaymentVoucher['id']) }}" class="btn btn-primary">Add New </a>
		                        @endif
		                      </div>
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