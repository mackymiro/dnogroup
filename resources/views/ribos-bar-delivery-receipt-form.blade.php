@extends('layouts.ribos-bar-app')
@section('title', 'Delivery Receipt Form |')
@section('content')
<div id="wrapper">
	<!-- Sidebar -->
    	@include('sidebar.sidebar-ribos-bar')
    	<div id="content-wrapper">
    		<div class="container-fluid">
    			<!-- Breadcrumbs-->
		            <ol class="breadcrumb">
		              <li class="breadcrumb-item">
		                <a href="#">Ribo's Bar</a>
		              </li>
		              <li class="breadcrumb-item active">Delivery Receipt Form</li>
		            </ol>
		            <div class="col-lg-12">
		            	 <img src="{{ asset('images/ribos.jpg')}}" width="390" height="250" class="img-responsive mx-auto d-block" alt="Rib's Bar">
		            	 
		            	 <h4 class="text-center"><u>DELIVERY RECEIPT</u></h4>
		            </div>
		            <div class="row">
		            	<div class="col-lg-12">
		            		<div class="card mb-3">
		            			<div class="card-header">
		                              <i class="fas fa-receipt" aria-hidden="true"></i>
		                            Delivery Receipt</div>
	                            <div class="card-body">
	                            	<form action="{{ action('RibosBarController@storeDeliveryReceipt') }}" method="post">
	                            		{{ csrf_field() }}
                            		<div class="form-group">
                            			<div class="form-row">
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
</div>
@endsection