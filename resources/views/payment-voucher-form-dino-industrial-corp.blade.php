@extends('layouts.dino-industrial-corporation-app')
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

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css" >
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<div id="wrapper">
    <!-- Sidebar -->
    @include('sidebar.sidebar-dino-industrial-corporation')
    <div id="content-wrapper">
         <div class="container-fluid">
              <!-- Breadcrumbs-->
              <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                  <a href="#">DINO Industrial Corporation</a>
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
                          Payment Voucher
                        </div>
                        <div class="card-body">
                            <form action="{{ action('DinoIndustrialCorporationController@paymentVoucherStore') }}" method="post">
                            {{ csrf_field() }}
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
                                          @if ($errors->has('paidTo'))
                                            <span class="alert alert-danger">
                                                <strong>{{ $errors->first('paidTo') }}</strong>
                                            </span>
                                            @endif
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
                                            <option value="Petty Cash">Petty Cash</option>
                                            <option value="Utility">Utility</option>
                                            <option value="Payroll">Payroll</option>
                                            <option value="Supplier">Supplier</option>
                                        </select>
                                    </div>  
                                    <div id="supplierList" class="col-lg-2">
                                        <label>Supplier Name</label>
                                        <select data-live-search="true" id="supplierName" name="supplierName" class="form-control selectpicker">
                                            @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier['id']}}-{{ $supplier['supplier_name']}}">{{ $supplier['supplier_name']}}</option>
                                            @endforeach
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
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </di>
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

  new Vue({
    el: '#app-bill',
		data: {
			bills:[
				{ text:'Veco', value: 'Veco' },
				{ text:'Internet', value: 'Internet'}
			]
		}
  })
</script>
<script type="text/javascript">
      $("#pettyCashNo").hide();
      $("#supplierList").hide();
      $(".category").change(function(){
            const cat = $(this.options[this.selectedIndex]).closest('option:selected').val();
            if(cat === "None"){
                $("#pettyCashNo").hide();
                $("#supplierList").hide();
            }else if(cat === "Petty Cash"){
                $("#pettyCashNo").show();
                $("#supplierList").hide();
            }else if(cat === "Payroll"){
                $("#pettyCashNo").hide();
                $("#supplierList").hide();
            }else if(cat === "Supplier"){
                $("#supplierList").show();
            }
      });
</script>
@endsection