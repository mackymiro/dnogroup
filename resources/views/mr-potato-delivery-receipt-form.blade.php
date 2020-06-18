@extends('layouts.mr-potato-app')
@section('title', 'Delivery Receipt Form |')
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
    	@include('sidebar.sidebar-mr-potato')
    	<div id="content-wrapper">
    		<div class="container-fluid">
    			 <!-- Breadcrumbs-->
		            <ol class="breadcrumb">
		              <li class="breadcrumb-item">
		                <a href="#">Mr Potato</a>
		              </li>
		              <li class="breadcrumb-item active">Delivery Receipt Form</li>
		            </ol>
		             <div class="col-lg-12">
		            	 <img src="{{ asset('images/mr-potato.png')}}" width="390" height="250" class="img-responsive mx-auto d-block" alt="Mr Potato">
		            	 
		            	 <h4 class="text-center"><u>DELIVERY RECEIPT</u></h4>
		            </div>
           		<div class="row">
            	<div class="col-lg-12">
            		<div class="card mb-3">
            			<div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            Delivery Receipt</div>
                        <div class="card-body">
                        	<form action="{{ action('MrPotatoController@storeDeliveryReceipt') }}" method="post">
                        		{{ csrf_field() }}
                        	<div class="form-group">
                        		<div class="form-row">
                    				<div class="col-md-2">
                    					<label>Date</label>
                    					<input type="text" name="date" class="datepicker form-control" />
                    				</div>
                    				<div class="col-md-4">
                    					<label>Delivered To</label>
                    					<input type="text" name="deliveredTo" class="form-control" required="required" />
                    				</div>
                    				<div class="col-md-4">
                        				<label>Address</label>
                        				<input type="text" name="address" class="form-control" />
                        			</div>
                        		</div>
                        	</div>
                        	
                          
                        	<div class="form-group">
                    			<div class="form-row">
	                    				<div class="col-md-2">
                    						<label>Product Id</label>
                    						<input type="text" name="productId" class="form-control" required="required" />
	                      				</div>
	                      				@if ($errors->has('productId'))
		                                  <span class="alert alert-danger">
		                                    <strong>{{ $errors->first('productId') }}</strong>
		                                  </span>
		                                @endif
                        				<div class="col-md-1">
                    						<label>QTY</label>
                    						<input type="text" name="qty" class="form-control" required="required" />
                        				</div>
                        				@if ($errors->has('qty'))
		                                  <span class="alert alert-danger">
		                                    <strong>{{ $errors->first('qty') }}</strong>
		                                  </span>
		                                @endif
                        				<div class="col-md-1">
                    						<label>Unit</label>
                    						<input type="text" name="unit" class="form-control" required="required" />
                        				</div>
                        				@if ($errors->has('unit'))
		                                  <span class="alert alert-danger">
		                                    <strong>{{ $errors->first('unit') }}</strong>
		                                  </span>
		                                @endif
                        				<div class="col-md-4">
                        					<label>Item Description</label>
                        					<input type="text" name="itemDescription" class="form-control" required="required" />
                        				</div>
                        				@if ($errors->has('itemDescription'))
		                                  <span class="alert alert-danger">
		                                    <strong>{{ $errors->first('itemDescription') }}</strong>
		                                  </span>
		                                @endif
                        				<div class="col-md-2">
                        					<label>Unit Price</label>
                        					<input type="text" name="unitPrice" class="form-control" required="required" />
                        				</div>
                        				@if ($errors->has('unitPrice'))
		                                  <span class="alert alert-danger">
		                                    <strong>{{ $errors->first('unitPrice') }}</strong>
		                                  </span>
		                                @endif
                    			</div>
                        	</div>
                    		<div>
	  	 				      <input type="submit" class="btn btn-success float-right" value="Add Delivery Receipt" />
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