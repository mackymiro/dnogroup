@extends('layouts.mr-potato-app')
@section('title', 'Sales Invoice Form| ')
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
              <li class="breadcrumb-item active">Sales Invoice Form</li>
            </ol>
             <div class="col-lg-12">
            	  <img src="{{ asset('images/mr-potato.png')}}" width="390" height="250" class="img-responsive mx-auto d-block" alt="Mr Potato">
            	 
            	 <h4 class="text-center"><u>SALES INVOICE FORM</u></h4>
            </div>
            <div class="row">
            	<div class="col-lg-12">
            		<div class="card mb-3">
            			<div class="card-header">
                              <i class="fas fa-cash-register" aria-hidden="true"></i>
                            Sales Invoice Form</div>
                        <div class="card-body">
                        	<form action="{{ action('MrPotatoController@storeSalesInvoice') }}" method="post">
                        		{{ csrf_field() }}
                        	<div class="form-group">
                    			<div class="form-row">
                    				<div class="col-md-2">
                     					<label>Invoice #</label>
                     					<input type="text" name="invoiceNum" class="form-control" required="required" />
                     					@if($errors->has('invoiceNum'))
		                                  <span class="alert alert-danger">
		                                    <strong>{{ $errors->first('invoiceNum') }}</strong>
		                                  </span>
		                                @endif

                         			</div>
                         			<div class="col-md-4">
                         				<label>Ordered By</label>
                         				<input type="text" name="orderedBy" class="form-control" required="required" />
                         				@if($errors->has('orderedBy'))
		                                  <span class="alert alert-danger">
		                                    <strong>{{ $errors->first('orderedBy') }}</strong>
		                                  </span>
		                                @endif
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
                     					<label>Qty</label>
                     					<input type="text" name="qty" class="form-control" />
                         			</div>
                         			<div class="col-md-2">
                         				<label>Total KlS</label>
                         				<input type="text" name="totalKls" class="form-control" />
                         			</div>
                         			<div class="col-md-4">
                         				<label>Item Description</label>
                         				<input type="text" name="itemDescription" class="form-control" />
                         			</div>
                         			<div class="col-md-1">
                         				<label>Unit Price</label>
                         				<input type="text" name="unitPrice" class="form-control" disabled="disabled" value="500.00" />
                         			</div>
                    			</div>
                        	</div>
                        	<div>
	  	 				      <input type="submit" class="btn btn-success float-right" value="Add Sales Invoice" />
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