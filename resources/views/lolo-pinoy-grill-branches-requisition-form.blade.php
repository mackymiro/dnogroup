@extends('layouts.lolo-pinoy-grill-branches-app')
@section('title', 'Purchase Order Form |')
@section('content')

<div id="wrapper">
	<!-- Sidebar -->
    @include('sidebar.sidebar-lolo-pinoy-grill-branches')
     <div id="content-wrapper">
        <div class="container-fluid">
             <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lolo Pinoy Grill Branches</a>
              </li>
              <li class="breadcrumb-item active">Requisition Form</li>
            </ol>

            <div class="col-lg-12">
            	   <img src="{{ asset('images/lolo-pinoy-grill.jpeg')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lolo Pinoy Grill ">
            	 
            	 <h4 class="text-center"><u>REQUISITION FORM</u></h4>
            </div>
            <div class="row">
                 <div class="col-lg-12">
                      <div class="card mb-3">
                             <div class="card-header">
                              <i class="fab fa-first-order" aria-hidden="true"></i>
                            Purchase Order</div>
                          <div class="card-body">
                                <form action="{{ action('LoloPinoyGrillBranchesController@store') }}" method="post">
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
                                      <label>P.O Number</label>
                                      <input type="text" name="poNum" class="form-control" disabled="disabled" />
                                      <label>Date</label>
                                      <input type="text" name="date" id="datepicker" class="form-control" required="required" />
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
                                    <input type="submit" class="btn btn-success float-right" value="Add Purchase Order" />
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