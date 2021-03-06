@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Purchase Order Form |')
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

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css" >
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<div id="wrapper">
	<!-- Sidebar -->
    @include('sidebar.sidebar')
     <div id="content-wrapper">
        <div class="container-fluid">
             <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lechon de Cebu</a>
              </li>
              <li class="breadcrumb-item active">Purchase Order Form</li>
            </ol>

            <div class="col-lg-12">
             <img src="{{ asset('images/digitized-logos/lolo-pinoy-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            		 
            	 <h4 class="text-center"><u>PURCHASE ORDER</u></h4>
            </div>
            <div class="row">
                 <div class="col-lg-12">
                      <div class="card mb-3">
                             <div class="card-header">
                              <i class="fab fa-first-order" aria-hidden="true"></i>
                            Purchase Order</div>
                          <div class="card-body">
                                <form action="{{ action('LoloPinoyLechonDeCebuController@store') }}" method="post">
                                {{csrf_field()}}
                              <div class="form-group">
                                  <div class="form-row">
                                    <div class="col-lg-6">
                                        @if(session('purchaseOrderSuccess'))
                                         <p class="alert alert-success">{{ Session::get('purchaseOrderSuccess') }}</p>
                                        @endif  
                                      <label>Paid to</label>
                                      <input type="text" name="paidTo" class="form-control" required="required" />
                                      @if ($errors->has('paidTo'))
                                        <span class="alert alert-danger">
                                          <strong>{{ $errors->first('paidTo') }}</strong>
                                        </span>
                                      @endif
                                      <label>Address</label>
                                      <input type="text" name="address" class="form-control" required="required" />
                                      @if ($errors->has('address'))
                                        <span class="alert alert-danger">
                                          <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                      @endif
                                     
                                    </div>
                                    <div class="col-lg-6">
                                     
                                      <label>Date</label>
                                      <input type="text" name="date"  class="datepicker form-control" required="required" autocomplete="off"/>
                                      @if ($errors->has('date'))
                                        <span class="alert alert-danger">
                                          <strong>{{ $errors->first('date') }}</strong>
                                        </span>
                                      @endif
                                      <label>Recieved By</label>
                                      <select data-live-search="true" name="recievedBy" class="form-control selectpicker">
                                          @foreach($getSuppliers as $getSupplier)
                                          <option value="{{ $getSupplier['supplier_name']}}">{{ $getSupplier['supplier_name']}}</option>
                                          @endforeach
                                      </select>
                                    </div>
                                  </div>
                              </div>
                              <div class="form-group">
                                <div class="form-row">
                                  <div class="col-lg-1">
                                    <label>Quantity</label>
                                    <input type="text" name="quantity" class="form-control" required="required" />
                                    @if ($errors->has('quantity'))
                                        <span class="alert alert-danger">
                                          <strong>{{ $errors->first('quantity') }}</strong>
                                        </span>
                                    @endif
                                  </div>
                                  <div class="col-lg-4">
                                    <label>Description</label>
                                    <input type="text" name="description" class="form-control" required="required" />
                                    @if ($errors->has('description'))
                                        <span class="alert alert-danger">
                                          <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                  </div>
                                 
                                  <div class="col-lg-2">
                                    <label>Unit Price</label>
                                    <input type="text" name="unitPrice" class="form-control" required="required" />
                                    @if ($errors->has('unitPrice'))
                                        <span class="alert alert-danger">
                                          <strong>{{ $errors->first('unitPrice') }}</strong>
                                        </span>
                                    @endif
                                  </div>
                                  <div class="col-lg-2">
                                    <label>Amount</label>
                                    <input type="text" name="amount" class="form-control" required="required" />
                                     @if ($errors->has('amount'))
                                        <span class="alert alert-danger">
                                          <strong>{{ $errors->first('amount') }}</strong>
                                        </span>
                                    @endif
                                  </div>            
                                </div>
                                <br>
                                <div>
                                <button type="submit" class="btn btn-success btn-lg float-right"><i class="fas fa-save"></i> Save Purchase Order</button>
                              <br>
                                </div>
                              </div>
                              </form>
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
    <!-- /.content-wrapper -->
</div>

@endsection