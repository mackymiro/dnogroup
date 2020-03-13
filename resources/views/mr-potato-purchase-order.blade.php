@extends('layouts.mr-potato-app')
@section('title', 'Purchase Order Form |')
@section('content')
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
		              <li class="breadcrumb-item active">Purchase Order Form</li>
		            </ol>
		             <div class="col-lg-12">
		            	 <img src="{{ asset('images/mr-potato.png')}}" width="390" height="250" class="img-responsive mx-auto d-block" alt="Mr Potato">
		            	 
		            	 <h4 class="text-center"><u>PURCHASE ORDER</u></h4>
		            </div>
		            <div class="row">
	            		<div class="col-lg-12">
	            			<div class="card mb-3">
	            				 <div class="card-header">
		                              <i class="fab fa-first-order" aria-hidden="true"></i>
		                            Purchase Order</div>
	                            <div class="card-body">
	                            	<form action="{{ action('MrPotatoController@store') }}" method="post">
	                            		 {{csrf_field()}}
	                            	<div class="form-group">
	                            		<div class="form-row">
                            				<div class="col-lg-4">
                            					<label>Paid To</label>
                            					<input type="text" name="paidTo" class="form-control" required="required" />
                            					 @if ($errors->has('paidTo'))
			                                        <span class="alert alert-danger">
			                                          <strong>{{ $errors->first('paidTo') }}</strong>
			                                        </span>
			                                      @endif
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
                            					<input type="text" name="date" class="form-control" />
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