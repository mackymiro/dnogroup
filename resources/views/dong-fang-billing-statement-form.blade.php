@extends('layouts.dong-fang-corporation-app')
@section('title', 'Billing Statement Form |')
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
    @include('sidebar.sidebar-dong-fang-corporation')
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                <a href="#">Dong Fang Corporation</a>
                </li>
                <li class="breadcrumb-item active">Billing Statement Form</li>
               
            </ol>  
            <div class="col-lg-12">
                 <img src="{{ asset('images/dong-fang-corporation.png')}}" width="277" height="139" class="img-responsive mx-auto d-block" alt="DNO Personal">
	            	 
                <h4 class="text-center"><u>BILLING STATEMENT</u></h4>
            </div> 
            <div class="row">
                 <div class="col-lg-12">
                     <div class="card mb-3">
                         <div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                          	  Billing Statement
                        </div>
                        <div class="card-body">
                            <form action="{{ action('DongFangCorporationController@storeBillingStamtement') }}" method="post">
                            {{ csrf_field() }}
                            @if(session('error'))
                                <p class="alert alert-danger">{{ Session::get('error') }}</p>
                            @endif
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-2">
                                        <label>Date</label>
                                        <input type="text" name="date" class="datepicker form-control" />
                                    </div>
                                    @if ($errors->has('accountNo'))
                                            <span class="alert alert-danger">
                                            <strong>{{ $errors->first('accountNo') }}</strong>
                                            </span>
                                     @endif
                                    <div class="col-lg-2">
                                        <label>Account No</label>
                                        <input type="text" name="accountNo" class="form-control" required />
                                    </div>
                                    @if ($errors->has('companyName'))
                                            <span class="alert alert-danger">
                                            <strong>{{ $errors->first('companyName') }}</strong>
                                            </span>
                                     @endif
                                    <div class="col-lg-4">
                                        <label>Company Name</label>
                                        <input type="text" name="companyName" class="form-control" required />
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Address</label>
                                        <input type="text" name="address" class="form-control" />
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                     <div class="col-lg-2">
                                        <label>Billing Statement No</label>
                                        <input type="text" name="billingStatementNo" class="form-control" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Attention</label>
                                        <input type="text" name="attention" class="form-control" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Ref #</label>
                                        <input type="text" name="refNumber" class="form-control" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>PO #</label>
                                        <input type="text" name="poNumber" class="form-control" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Terms</label>
                                        <input type="text" name="terms" class="form-control" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Due Date</label>
                                        <input type="text" name="dueDate" class="datepicker form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-2">
                                        <label>Date</label> 
                                        <input type="text" name="dateDetails" class="datepicker form-control" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>No of Pax</label> 
                                        <input type="text" name="noPax" class="form-control" />
                                    </div>
                                    @if ($errors->has('particular'))
                                            <span class="alert alert-danger">
                                            <strong>{{ $errors->first('particular') }}</strong>
                                            </span>
                                     @endif
                                    <div class="col-lg-4">
                                        <label>Particular</label> 
                                        <input type="text" name="particular" class="form-control" required />
                                    </div>
                                     <div class="col-lg-2">
                                        <label>Price Per Pax</label> 
                                        <input type="text" name="pricePerPax" class="form-control" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Amount</label> 
                                        <input type="text" name="amount" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-success float-right"><i class="fa fa-plus" aria-hidden="true"></i> Add Billing Statement</button>
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
</div>
@endsection