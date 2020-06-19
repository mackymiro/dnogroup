@extends('layouts.ribos-bar-app')
@section('title', 'Billing Statement Form |')
@section('content')
<script>
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
    @include('sidebar.sidebar-ribos-bar')
    <div id="content-wrapper">
      <form action="{{ action('RibosBarController@storeBillingStatement') }}" method="post">
          {{csrf_field()}}
    	<div class="container-fluid">
    		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Ribo's Bar</a>
              </li>
              <li class="breadcrumb-item active">Billing Statement Form</li>
            </ol>
            <div class="col-lg-12">
            	 	<img src="{{ asset('images/digitized-logos/ribos-food-corp.png')}}" width="390" height="250" class="img-responsive mx-auto d-block" alt="Rib's Bar">
            
            	 <h4 class="text-center"><u>BILLING STATEMENT</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            Billing Statement</div>
                          <div class="card-body">
                            <div class="form-group">
                            <div class="form-row">
                              <div class="col-lg-6">
                                <label>Bill To</label>
                                <input type="text" name="billTo" class="form-control" required="required" />
                                @if ($errors->has('billTo'))
                                    <span class="alert alert-danger">
                                      <strong>{{ $errors->first('billTo') }}</strong>
                                    </span>
                                @endif
                                <label>Address</label>
                                <input type="text" name="address" class="form-control" required="required" />
                                @if ($errors->has('address'))
                                    <span class="alert alert-danger">
                                      <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                  @endif
                                <label>Period Covered</label>
                                <input type="text" name="periodCovered" class="form-control" required="required" />
                                @if ($errors->has('periodCovered'))
                                    <span class="alert alert-danger">
                                      <strong>{{ $errors->first('periodCovered') }}</strong>
                                    </span>
                                  @endif
                              </div>
                              <div class="col-lg-6">
                                <label>Date</label>
                                <input type="text" name="date" class="datepicker form-control" required="required" />
                                @if ($errors->has('date'))
                                    <span class="alert alert-danger">
                                      <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                                  @endif
                              
  
                                
                                <label>Terms</label>
                                <input type="text" name="terms" class="form-control" required="required" />
                                @if ($errors->has('terms'))
                                    <span class="alert alert-danger">
                                      <strong>{{ $errors->first('terms') }}</strong>
                                    </span>
                                  @endif
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="form-row">
                                  <div class="col-lg-1">
                                    <label>Date</label>
                                    <input type="text" name="transactionDate" class="form-control" required="required" />
                                    @if ($errors->has('transactionDate'))
                                            <span class="alert alert-danger">
                                              <strong>{{ $errors->first('transactionDate') }}</strong>
                                            </span>
                                          @endif
                                  </div>
                                  <div class="col-lg-1">
                                      <label>Invoice #</label>
                                      <input type="text" name="invoiceNumber" class="form-control" required="required" />
                                  </div>
                                <div class="col-lg-4">
                                  <label>Whole Lechon 500/KL</label>
                                  <input type="text" name="wholeLechon" class="form-control"  required="required" />
                                  @if ($errors->has('wholeLechon'))
                                        <span class="alert alert-danger">
                                          <strong>{{ $errors->first('wholeLechon') }}</strong>
                                        </span>
                                      @endif
                                </div>
                                <div class="col-lg-4">
                                  <label>Description</label>
                                  <input type="text" name="description" class="form-control"  required="required" />
                                  @if ($errors->has('description'))
                                        <span class="alert alert-danger">
                                          <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                      @endif
                                </div>
                                <div class="col-lg-1">
                                  <label>Amount</label>
                                  <input type="text" name="amount" class="form-control" disabled="disabled" />
                                </div>
                            </div>
                            <br>
                            <div>
                                <input type="submit" class="btn btn-success float-right" value="Add Billing" />
                            </div>
                          </div>
                          </div>
                    </div>
                </div>
            </div>
            
           
    	</div>
     </form>  
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