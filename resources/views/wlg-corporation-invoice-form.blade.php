@extends('layouts.wlg-corporation-app')
@section('title', 'Invoice Form|')
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
    @include('sidebar.sidebar-wlg-corporation')
    <div id="content-wrapper">
        <div class="container-fluid">
             <!-- Breadcrumbs-->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="#">WLG Corporation</a>
				</li>
				<li class="breadcrumb-item active">Invoice Form</li>
			
			</ol>
            <div class="col-lg-12">
            <img src="{{ asset('images/wlg-corporation.png')}}" width="235" height="114" class="img-responsive mx-auto d-block" alt="WLG Corporation"> 
            	 <h4 class="text-center"><u>INVOICE FORM</u></h4>
            </div>
            <div class="row">
                 <div class="col-lg-12">
                      <div class="card mb-3">
                         <div class="card-header">
							<i class="fa fa-file-invoice" aria-hidden="true"></i>
							Invoice Form                         
						 </div>
                         <div class="card-body">
                            <form action="{{ action('WlgCorporationController@addInvoice') }}" method="post">
                            {{ csrf_field() }}
                            @if(session('error'))
                                <p class="alert alert-danger">{{ Session::get('error') }}</p>
                            @endif 
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-2">
                                        <label>Date</label>
                                        <input type="text" name="date" class="datepicker form-control" required/>
                                        @if ($errors->has('date'))
                                            <span class="alert alert-danger">
                                                <strong>{{ $errors->first('date') }}</strong>
                                            </span>
	                                     @endif
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Delivery Terms</label>
                                        <input type="text" name="deliveryTerms" class=" form-control" required/>
                                        @if ($errors->has('deliveryTerms'))
                                            <span class="alert alert-danger">
                                                <strong>{{ $errors->first('deliveryTerms') }}</strong>
                                            </span>
	                                     @endif
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Tranport By</label>
                                        <input type="text" name="transportBy" class=" form-control" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Invoice Number</label>
                                        <input type="text" name="invoiceNumber" class=" form-control" />
                                    </div>
                                </div>
                              </div>
                              <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-4">
                                            <label>Shipper</label>
                                            <input type="text" name="shipper" class="form-control" required/>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Consignee</label>
                                            <input type="text" name="consignee" class=" form-control" />
                                        </div>
                                        <div class="col-lg-2 ">
                                            <label>Notify Party</label>
                                            <input type="text" name="notifyParty" class=" form-control" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Attention</label>
                                            <input type="text" name="attention" class=" form-control" />
                                        </div>
                                    </div>
                              </div>
                              <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-1">
                                            <label>No</label>
                                            <input type="text" name="no" class="form-control " />
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Description of Goods</label>
                                            <input type="text" name="descGoods" class="form-control " required />
                                            @if ($errors->has('descGoods'))
                                                <span class="alert alert-danger">
                                                    <strong>{{ $errors->first('descGoods') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Qty</label>
                                            <input type="text" name="qty" class="form-control " />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Unit Price (USD)</label>
                                            <input type="text" name="unitPrice" class="form-control " />
                                        </div>
                                         <div class="col-lg-2">
                                            <label>Total Amount </label>
                                            <input type="text" name="totalAmount" class="form-control " />
                                        </div>
                                    </div>
                              </div>
                              <div class="float-right">
		  	 				      <button type="submit" class="btn btn-success " ><i class="fas fa-plus"></i> Add Invoice</button>
                              </div>
                              </form>
                         </div><!-- end of card body -->
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