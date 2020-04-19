@extends('layouts.dno-personal-app')
@section('title', 'Payment Voucher Form |')
@section('content')
<style>
.selcls { 
    padding: 9px; 
    border: solid 1px #517B97; 
    min-height: 40px;
    outline: 0; 
    background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #CAD9E3), to(#FFFFFF)); 
    background: -moz-linear-gradient(top, #FFFFFF, #CAD9E3 1px, #FFFFFF 25px); 
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px; 
    -moz-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px; 
    -webkit-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px; 
	} 
</style>
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
      
  });
</script>
<div id="wrapper">
	<!-- Sidebar -->
    @include('sidebar.sidebar-dno-personal')
    <div id="content-wrapper">
    	<div class="container-fluid">
    		 <!-- Breadcrumbs-->
	            <ol class="breadcrumb">
	              <li class="breadcrumb-item">
	                <a href="#">DNO Personal</a>
	              </li>
                <li class="breadcrumb-item active">Payables</li>
	              <li class="breadcrumb-item ">Payment Voucher Form</li>
	            </ol>
	            <div class="col-lg-12">
	            	  <img src="{{ asset('images/DIC-LOGO.png')}}" width="255" height="172" class="img-responsive mx-auto d-block" alt="DNO Personal">
	            	 
	            	 <h4 class="text-center"><u>PAYMENT VOUCHER</u></h4>
	            </div>
	            <div class="row">
	            	<div class="col-lg-12">
	            		<div class="card mb-3">
	            			<div class="card-header">
                              <i class="fas fa-file-invoice" aria-hidden="true"></i>
                          	  Payment Voucher</div>
                              <form action="{{ action('DnoPersonalController@paymentVoucherStore') }}" method="post">
                                {{ csrf_field() }}
                          	  <div class="card-body">
                                  
                                    @if(session('error'))
                                        <p class="alert alert-danger">{{ Session::get('error') }}</p>
                                    @endif
                          	  		<div class="form-group">
                      	  				<div class="form-row">
                      	  						<div class="col-lg-4">
                      	  							<label>Paid To</label>
                      	  						  <select name="paidTo" class="selcls form-control">
                                            <option value="0">--Please Select--</option>
                                            @foreach($getCreditCards as $getCreditCard)
                                            <option value="">{{ $getCreditCard['bank_name'] }}</option>
                                            @endforeach
                                        </select>
                      	  						</div>
                                    
                    	  						  <div class="col-md-2">
                                         <label>Account #</label>
                                          <input type="text" name="accountNo" class="selcls form-control"  required="required" value="{{ old('invoiceNumber') }}" />
                                      </div>
                      	  						<div class="col-md-2">
                                          <label>Issued Date </label>
                                          <input type="text" name="issuedDate" class="selcls form-control" value="{{ old('issuedDate') }}" />
                                      </div>
                                       <div class="col-md-2">
                                          <label>Delivered Date </label>
                                          <input type="text" name="deliveredDate" class="selcls form-control" value="{{ old('deliveredDate') }}" />
                                      </div>
                                     
                      	  				</div>
                          	  		</div>
                                  <div class="form-group">
                                      <div class="form-row">
                                          <div class="col-lg-4">
                                              <label>Particulars</label>
                                              <input type="text" name="particulars" class="selcls form-control" required="required"/>
                                          </div>
                                          <div class="col-lg-2">
                                              <label>Amount</label>
                                              <input type="text" name="amount" class="selcls form-control"  required="required"/>
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