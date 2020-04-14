@extends('layouts.ribos-bar-app')
@section('title', 'Payment Voucher Form |')
@section('content')

<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
      
  });
</script>
<div id="wrapper">
	<!-- Sidebar -->
    @include('sidebar.sidebar-ribos-bar')
    <div id="content-wrapper">
    	<div class="container-fluid">
    		 <!-- Breadcrumbs-->
	            <ol class="breadcrumb">
	              <li class="breadcrumb-item">
	                <a href="#">Ribo's Bar</a>
	              </li>
                <li class="breadcrumb-item active">Payables</li>
	              <li class="breadcrumb-item ">Payment Voucher Form</li>
	            </ol>
	            <div class="col-lg-12">
	            	  <img src="{{ asset('images/ribos.jpg')}}" width="390" height="250" class="img-responsive mx-auto d-block" alt="Rib's Bar">
	            	 
	            	 <h4 class="text-center"><u>PAYMENT VOUCHER</u></h4>
	            </div>
	            <div class="row">
	            	<div class="col-lg-12">
	            		<div class="card mb-3">
	            			<div class="card-header">
                              <i class="fas fa-file-invoice" aria-hidden="true"></i>
                          	  Payment Voucher</div>
                              <form action="{{ action('RibosBarController@paymentVoucherStore') }}" method="post">
                                {{ csrf_field() }}
                          	  <div class="card-body">
                                    @if(session('error'))
                                        <p class="alert alert-danger">{{ Session::get('error') }}</p>
                                    @endif
                          	  		<div class="form-group">
                      	  				<div class="form-row">
                      	  						<div class="col-lg-4">
                      	  							<label>Paid To</label>
                      	  							<input type="text" name="paidTo" class="form-control" required="required" />
                      	  						</div>
                                      @if ($errors->has('paidTo'))
                                        <span class="alert alert-danger">
                                          <strong>{{ $errors->first('paidTo') }}</strong>
                                        </span>
                                      @endif
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
                                     
                      	  				</div>
                          	  		</div>
                                  <div class="form-group">
                                      <div class="form-row">
                                          <div class="col-lg-4">
                                              <label>Particulars</label>
                                              <input type="text" name="particulars" class="form-control" required="required"/>
                                          </div>
                                          <div class="col-lg-2">
                                              <label>Amount</label>
                                              <input type="text" name="amount" class="form-control"  required="required"/>
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