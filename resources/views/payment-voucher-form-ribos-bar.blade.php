@extends('layouts.ribos-bar-app')
@section('title', 'Payment Voucher Form |')
@section('content')
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
	              <li class="breadcrumb-item active">Payment Voucher Form</li>
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
                  	  						<div class="col-lg-4">
                  	  							<label>Account Number</label>
                  	  							<input type="text" name="accountNumber" class="form-control" required="required" />
                  	  						</div>
                  	  						<div class="col-lg-2">
                                      <label>Date</label>
                                      <input type="text" name="date" class="form-control" />
                                    </div>
                      	  				</div>
                          	  		</div>
                          	  		<div class="form-group">
                          	  			<div class="form-row">
                      	  					
                      	  					<div class="col-lg-4">
                      	  						<label>Particulars</label>
                      	  						<input type="text" name="particulars" class="form-control" />
                      	  					</div>
                                    <div class="col-lg-2">
                                      <label>Amount</label>
                                      <input type="text" name="amount" class="form-control" />
                                    </div>
                      	  					<div class="col-lg-2">
                      	  						<label>Method Of Payment</label>
                      	  						 <div id="app-payment-method">
                                          <select name="paymentMethod" class="form-control">
                                              <option value="0">--Please Select--</option>
                                              <option v-for="payment in payments" v-bind:value="payment.value">
                                              @{{ payment.text }}
                                            </option>
                                            </select>
                                        </div>
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