@extends('layouts.dno-resources-development-corp-app')
@section('title', 'Delivery Transaction Form| ')
@section('content')
<style>
.selcls { 
    padding: 9px; 
    border: solid 1px #517B97; 
    outline: 0; 
    background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #CAD9E3), to(#FFFFFF)); 
    background: -moz-linear-gradient(top, #FFFFFF, #CAD9E3 1px, #FFFFFF 25px); 
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px; 
    -moz-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px; 
    -webkit-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px; 
	} 
</style>
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
     @include('sidebar.sidebar-dno-resources-development-corp')
     <div id="content-wrapper">
        <div class="container-fluid">
             <!-- Breadcrumbs-->
             <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">DNO Resources and Development Corp</a>
              </li>
              <li class="breadcrumb-item active">Delivery Transaction Form</li>
            </ol>
            <div class="col-lg-12">
            	  <img src="{{ asset('images/dno-resources.jpg')}}" width="420" height="250" class="img-responsive mx-auto d-block" alt="DNO Resources and Development Corp">
	         	   
            	 <h4 class="text-center"><u>DELIVERY TRANSACTION FORM</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            Delivery Transaction
                        </div>
                        <div class="card-body">
                            <form action="{{ action('DnoResourcesDevelopmentController@addDeliveryTransaction')}}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="form-row">
                                    @if ($errors->has('supplierName'))
                                        <span class="alert alert-danger">
                                        <strong>{{ $errors->first('supplierName') }}</strong>
                                        </span>
                                    @endif
                                    <div class="col-lg-4">
                                        <label>Supplier Name</label>
                                        <input type="text" name="supplierName" class="form-control" required/>
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Delivery Date</label>
                                        <input type="text" name="deliveryDate" class="datepicker form-control" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Delivery To</label>
                                        <input type="text" name="deliveredTo" class="form-control" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>DR No</label>
                                        <input type="text" name="drNo" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                     @if ($errors->has('deliveryDescription'))
                                        <span class="alert alert-danger">
                                        <strong>{{ $errors->first('deliveryDescription') }}</strong>
                                        </span>
                                    @endif
                                    <div class="col-lg-4">
                                        <label>Delivery Description</label>
                                        <input type="text" name="deliveryDescription" class="form-control" required/>
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Qty</label>
                                        <input type="text" name="qty" class="form-control" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Total</label>
                                        <input type="text" name="total" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div>
	  	 				      <input type="submit" class="btn btn-success float-right" value="Add Delivery Transaction Form" />
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