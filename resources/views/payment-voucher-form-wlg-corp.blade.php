@extends('layouts.dong-fang-corporation-app')
@section('title', 'Payment Voucher Form |')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
      
  });
  $(function() {
    $( ".datepicker" ).datepicker();
  });
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div id="wrapper">
   <!-- Sidebar -->
    @include('sidebar.sidebar-wlg-corporation')
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                <a href="#">WLG Corporation</a>
                </li>
                <li class="breadcrumb-item active">Payables</li>
                <li class="breadcrumb-item ">Payment Voucher Form</li>
            </ol>
            <div class="col-lg-12">
                 <img src="{{ asset('images/wlg-corporation.png')}}" width="235" height="114" class="img-responsive mx-auto d-block" alt="WLG Corporation">
	            	 
                <h4 class="text-center"><u>PAYMENT VOUCHER</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                     <div class="card mb-3">
                        <div class="card-header">
                              <i class="fas fa-file-invoice" aria-hidden="true"></i>
                          	  Payment Voucher
                        </div>
                        <form action="{{ action('WlgCorporationController@paymentVoucherStore') }}" method="post">
                        {{ csrf_field() }}
                        <div class="card-body">
                              @if(session('error'))
                                <p class="alert alert-danger">{{ Session::get('error') }}</p>
                            @endif
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-2">
                                        <label>Payment Method</label>
                                        <div id="app-payment-method">
                                            <select name="paymentMethod" class="payment form-control">
                                                <option value="0">--Please Select--</option>
                                                <option v-for="payment in payments" v-bind:value="payment.value">
                                                    @{{ payment.text }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                         <label>Invoice #</label>
                                        <input type="text" name="invoiceNumber" class="form-control"  required="required" value="{{ old('invoiceNumber') }}" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Paid To</label>
                                        <input type="text" name="paidTo" class="form-control" required="required" />
                                    </div>
                                    <div class="col-md-4">
                                        <label>Account Name </label>
                                        <input type="text" name="accountName" class="form-control"  />
                                    </div>
                                    <div class="col-md-2">
                                        <label>Issued Date </label>
                                        <input type="text" name="issuedDate" class="datepicker form-control" value="{{ old('issuedDate') }}" />
                                    </div>
                                </div>
                            </div>
                             <div class="form-group">
                                <div class="form-row">
                                    <div  class="col-md-2">
                                        <label>Category</label>
                                        <select  name="category" class="category selcls form-control" > 
                                            <option value="None">None</option>
                                        
                                            <option value="Payroll">Payroll</option>
                                        </select>
                                    </div> 
                                
                                </div>
                            </div>
                            <div  class="form-group">
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
                            <button type="submit" class="btn btn-success btn-lg float-right"><i class="fas fa-save"></i> Save Payment Voucher</button>
                              <br>
                              <br>
                            </div>
                        </div>
                        </form>
                     </div>
                </div>
            </div><!-- end of row -->
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
	new Vue({
	el: '#app-payment-method',
		data: {
			payments:[
				{ text:'CASH', value: 'CASH' },
				{ text:'CHECK', value: 'CHECK'}
			]
		}
	})	

</script>
@endsection