@extends('layouts.lolo-pinoy-grill-branches-app')
@section('title', 'Requisition Slip |')
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
    @include('sidebar.sidebar-lolo-pinoy-grill-branches')
     <div id="content-wrapper">
        <div class="container-fluid">
             <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lolo Pinoy Grill Branches</a>
              </li>
              <li class="breadcrumb-item active">Requisition Slip</li>
            </ol>

            <div class="col-lg-12">
            	   <img src="{{ asset('images/lolo-pinoy-grill.jpeg')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lolo Pinoy Grill ">
            	 
            	 <h4 class="text-center"><u>REQUISITION SLIP</u></h4>
            </div>
            <div class="row">
                 <div class="col-lg-12">
                      <div class="card mb-3">
                             <div class="card-header">
                              <i class="fab fa-first-order" aria-hidden="true"></i>
                            Requisition Slip</div>
                          <div class="card-body">
                                <form action="{{ action('LoloPinoyGrillBranchesController@store') }}" method="post">
                                {{csrf_field()}}
                              <div class="form-group">
                                  <div class="form-row">
                                      <div class="col-lg-4">
                                          <label>Requesting Department</label>
                                          <input type="text" name="requestingDept" class="form-control" required="required" />
                                      </div>
                                      <div class="col-lg-2">
                                          <label>Request Date</label>
                                          <input type="text" name="requestDate" class="datepicker form-control" />
                                      </div>
                                      <div class="col-lg-2">
                                          <label>Date Released</label>
                                          <input type="text" name="dateReleased" class="datepicker form-control" />
                                      </div>
                                  </div>
                              </div>
                              <div class="form-group">
                                <div class="form-row">
                                  <div class="col-lg-2">
                                    <label>Quantity Requested</label>
                                    <input type="text" name="quantityRequested" class="form-control" required="required" />
                                    @if ($errors->has('quantityRequested'))
                                        <span class="alert alert-danger">
                                          <strong>{{ $errors->first('quantityRequested') }}</strong>
                                        </span>
                                    @endif
                                  </div>
                                  <div class="col-lg-2">
                                    <label>Unit</label>
                                    <input type="text" name="unit" class="form-control" required="required" />
                                    @if ($errors->has('unit'))
                                        <span class="alert alert-danger">
                                          <strong>{{ $errors->first('unit') }}</strong>
                                        </span>
                                    @endif
                                  </div>
                                 
                                  <div class="col-lg-2">
                                    <label>Item</label>
                                    <input type="text" name="item" class="form-control" required="required" />
                                    @if ($errors->has('item'))
                                        <span class="alert alert-danger">
                                          <strong>{{ $errors->first('item') }}</strong>
                                        </span>
                                    @endif
                                  </div>
                                  <div class="col-lg-2">
                                    <label>Quantity Given</label>
                                    <input type="text" name="quantityGiven" class="form-control" required="required" />
                                     @if ($errors->has('quantityGiven'))
                                        <span class="alert alert-danger">
                                          <strong>{{ $errors->first('quantityGiven') }}</strong>
                                        </span>
                                    @endif
                                  </div>            
                                </div>
                                <br>
                                <div>
                                    <input type="submit" class="btn btn-success float-right" value="Add Requisition Slip" />
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