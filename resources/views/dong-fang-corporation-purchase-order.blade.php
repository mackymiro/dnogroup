@extends('layouts.dong-fang-corporation-app')
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
        @include('sidebar.sidebar-dong-fang-corporation')
        <div id="content-wrapper">
            <div class="container-fluid">
                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Dong Fang Corporation</a>
                    </li>
                    <li class="breadcrumb-item active">Purchase Order Form</li>
                </ol>
                <div class="col-lg-12">
                    <img src="{{ asset('images/dong-fang-corporation.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
                        
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
                                    <form action="{{ action('DongFangCorporationController@store') }}" method="post">
                                      {{csrf_field()}}
                                     <div class="form-group">
                                         <div class="form-row">
                                            <div class="col-lg-4">
                                                @if(session('purchaseOrderSuccess'))
                                                <p class="alert alert-success">{{ Session::get('purchaseOrderSuccess') }}</p>
                                                @endif  
                                                @if ($errors->has('paidTo'))
                                                    <span class="alert alert-danger">
                                                    <strong>{{ $errors->first('paidTo') }}</strong>
                                                    </span>
                                                @endif
                                                <label>Paid to</label>
                                                <input type="text" name="paidTo" class="form-control" required="required" />
                                            </div>
                                            <div class="col-lg-4">
                                                <label>Address</label>
                                                <input type="text" name="address" class="form-control" required="required" />
                                                @if ($errors->has('address'))
                                                    <span class="alert alert-danger">
                                                    <strong>{{ $errors->first('address') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-lg-2">
                                                 <label>Date</label>
                                                <input type="text" name="date"  class="datepicker form-control" required="required" autocomplete="off"/>
                                                @if ($errors->has('date'))
                                                    <span class="alert alert-danger">
                                                    <strong>{{ $errors->first('date') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                         </div>     
                                     </div>
                                     <div class="form-group">
                                        <div class="form-row">
                                            <div class="col-lg-2">
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
                                     </div>
                                     <br>
                                    <div>
                                        <button type="submit" class="btn btn-success btn-lg float-right"><i class="fas fa-save"></i> Save Purchase Order</button>
                                        <br>
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