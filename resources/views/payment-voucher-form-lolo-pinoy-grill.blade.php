@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'Payment Voucher Form |')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
      
  });
</script>
<div id="wrapper">
	<!-- Sidebar -->
    @include('sidebar.sidebar-lolo-pinoy-grill')
   <div id="content-wrapper">
 		<div class="container-fluid">
 			 <!-- Breadcrumbs-->
	            <ol class="breadcrumb">
	              <li class="breadcrumb-item">
	                <a href="#">Lolo Pinoy Grill Commissary</a>
	              </li>
                 <li class="breadcrumb-item active">Payables</li>
	              <li class="breadcrumb-item ">Payment Voucher Form</li>
	            </ol>
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
                          	  <form action="{{ action('LoloPinoyGrillCommissaryController@paymentVoucherStore') }}" method="post">
                          	  		{{ csrf_field() }}
                          	   <div class="card-body">
                                    @if(session('addSuccess'))
                                        <p class="alert alert-success">{{ Session::get('addSuccess') }}</p>
                                    @endif 
                                    @if(session('error'))
                                        <p class="alert alert-danger">{{ Session::get('error') }}</p>
                                    @endif 
                          	   		<div class="form-group">
                          	   			<div class="form-row">
                          	   				<div class="col-lg-4">
                      	   						<label>Paid To</label>
                      	   						<input type="text" name="paidTo" class="form-control" required="required" />
                  	   							@if ($errors->has('paidTo'))
				                                  <span class="alert alert-danger">
				                                    <strong>{{ $errors->first('paidTo') }}</strong>
				                                  </span>
				                                @endif
                          	   				</div>
                        	   			     <div class="col-md-2">
                                           <label>Invoice #</label>
                                            <input type="text" name="invoiceNumber" class="form-control"  required="required" value="{{ old('invoiceNumber') }}" />
                                        </div>
                          	   			 <div class="col-md-2">
                                          <label>Issued Date </label>
                                          <input type="text" name="issuedDate" class="form-control" value="{{ old('issuedDate') }}" />
                                      </div>
                                       <div class="col-md-2">
                                          <label>Delivered Date </label>
                                          <input type="text" name="deliveredDate" class="form-control" value="{{ old('deliveredDate') }}" />
                                      </div>
                                       <div class="col-md-2">
                                          <label>Amount Due</label>
                                          <input type="text" name="amountDue" class="form-control" value="{{ old('amountDue') }}" />
                                      </div>
                          	   			</div>
                          	   		</div>
                          	   	
                      	   			<div>
            			  	 				      <input type="submit" class="btn btn-success float-right" value="Add Payment Voucher" />
            				  	 			    </div>
                          	   		<br>
                          	   </div>
                          	</form>
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
<script>
	//branch data
	new Vue({
	el: '#app-payment-method',
		data: {
			payments:[
				{ text:'Cash', value: 'Cash' },
				{ text:'Cheque', value: 'Cheque'}
			]
		}
	})	
</script>
@endsection