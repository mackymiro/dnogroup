@extends('layouts.dno-resources-development-corp-app')
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
    @include('sidebar.sidebar-dno-resources-development-corp')
    <div id="content-wrapper">
         <div class="container-fluid">
             <!-- Breadcrumbs-->
             <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">DNO Resources and Development Corp</a>
              </li>
              <li class="breadcrumb-item active">Purchase Order Form</li>
            </ol>
            <div class="col-lg-12">
                <img src="{{ asset('images/dno-resources.jpg')}}" width="420" height="250" class="img-responsive mx-auto d-block" alt="DNO Resources and Development Corp">
	            	 
	             
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
                                <form action="{{ action('DnoResourcesDevelopmentController@store') }}" method="post">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <div class="form-row">
                                        @if ($errors->has('paidTo'))
                                        <span class="alert alert-danger">
                                          <strong>{{ $errors->first('paidTo') }}</strong>
                                        </span>
                                        @endif
                                        <div class="col-lg-4">
                                            <label>Paid To</label>
                                            <input type="text" name="paidTo" class="form-control" required="required" />
                                            
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Address</label>
                                            <input type="text" name="address" class="form-control" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Date</label> 
                                            <input type="text" name="date" class="datepicker form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">  
                                        <div class="col-lg-2">
                                            <label>Quantity</label>
                                            <input type="text" name="quantity" class="form-control" />
                                        </div>
                                        @if ($errors->has('description'))
                                        <span class="alert alert-danger">
                                          <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                        @endif
                                        <div class="col-lg-4">
                                            <label>Description</label>
                                            <input type="text" name="description" class="form-control"  required="required"/>
                                        
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Unit </label>
                                            <input type="text" name="unit" class="form-control" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Unit Price</label>
                                            <input type="text" name="unitPrice" class="form-control" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Amount</label>
                                            <input type="text" name="amount" class="form-control"  />
                                            
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div>
                                    <input type="submit" class="btn btn-success float-right" value="Add Purchase Order" />
                                </div>
                                </form>
                            </div>
                     </div>
                </div>
            </div>  
         </div>
    </div>
</div>
@endsection