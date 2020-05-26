@extends('layouts.wlg-corporation-app')
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
                <li class="breadcrumb-item active">Purchase Order Form</li>
            </ol>
            <div class="col-lg-12">
                 <img src="{{ asset('images/wlg-corporation.png')}}" width="235" height="114" class="img-responsive mx-auto d-block" alt="WLG Corporation">                
                <h4 class="text-center"><u>PURCHASE ORDER</u></h4>
            </div>
            <div class="row">
                 <div class="col-lg-12">
                    <div class="card mb-3">
                         <div class="card-header">
                                <i class="fab fa-first-order" aria-hidden="true"></i>
                            Purchase Order
                         </div>
                         <div class="card-body">
                            <form action="{{ action('WlgCorporationController@store') }}" method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-4">
                                        <label>Paid To</label>
                                        <input type="text" name="paidTo" class="form-control" required/>
                                        @if ($errors->has('paidTo'))
                                        <span class="alert alert-danger">
                                            <strong>{{ $errors->first('paidTo') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Address</label>
                                        <input type="text" name="address" class="form-control" required/>
                                         @if ($errors->has('address'))
                                            <span class="alert alert-danger">
                                                <strong>{{ $errors->first('address') }}</strong>
                                             </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Date</label>
                                        <input type="text" name="date" class="datepicker form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-2">
                                        <label>Model</label>
                                        <input type="text" name="model" class="form-control" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Particulars</label>
                                        <input type="text" name="particulars" class="form-control" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Quantity</label>
                                        <input type="text" name="quantity" class="form-control" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Unit Price</label>
                                        <input type="text" name="unitPrice" class="form-control" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Amount</label>
                                        <input type="text" name="amount" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div>
                                <button type="submit" class="btn btn-success float-right"><i class="fa fa-plus" aria-hidden="true"></i>  Add Purchase Order</button>
                            </div>
                            </form>
                         </div>
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

@endsection