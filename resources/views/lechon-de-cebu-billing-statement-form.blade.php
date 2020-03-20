@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Billing Statement Form |')
@section('content')
<div id="wrapper">
	<!-- Sidebar -->
    @include('sidebar.sidebar')
    <div id="content-wrapper">
      <form action="{{ action('LoloPinoyLechonDeCebuController@storeBillingStatement') }}" method="post">
          {{csrf_field()}}
    	<div class="container-fluid">
    		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lechon de Cebu</a>
              </li>
              <li class="breadcrumb-item active">Billing Statement Form</li>
            </ol>
            <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
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
                                <input type="text" name="date" class="form-control" required="required" />
                                @if ($errors->has('date'))
                                    <span class="alert alert-danger">
                                      <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                                  @endif
                                <label>Reference #</label>
                                <input type="text" name="refNumber" class="form-control" disabled="disabled" />
                                <label>PO Number</label>
                                <select name="poNumber" class="form-control">
                                    @foreach($getPurchaseOrders as $getPurchaseOrder)
                                    <option value="{{ $getPurchaseOrder['p_o_number'] }}">{{ $getPurchaseOrder['p_o_number'] }}</option>
                                    @endforeach
                                </select>
                                
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
<script>
  //status data
  new Vue({
  el: '#app-status',
    data: {
      statuses:[
        { text:'Unpaid', value: 'Unpaid' },
        { text:'Paid', value: 'Paid'}
      ]
    }
  })  
  
</script>
@endsection