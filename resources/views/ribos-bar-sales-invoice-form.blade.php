@extends('layouts.ribos-bar-app')
@section('title', 'Sales Invoice Form| ')
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
     @include('sidebar.sidebar-ribos-bar')
     <div id="content-wrapper">
 		<div class="container-fluid">
 			 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Ribo's Bar</a>
              </li>
              <li class="breadcrumb-item active">Sales Invoice Form</li>
            </ol>
             <div class="col-lg-12">
            	 <img src="{{ asset('images/digitized-logos/ribos-food-corp.png')}}" width="390" height="250" class="img-responsive mx-auto d-block" alt="Rib's Bar">
            	 
            	 <h4 class="text-center"><u>SALES INVOICE FORM</u></h4>
            </div>
            <div class="row">
            	<div class="col-lg-12">
            		<div class="card mb-3">
            			<div class="card-header">
                              <i class="fas fa-cash-register" aria-hidden="true"></i>
                            Sales Invoice Form</div>
                        <div class="card-body">
                        	<form action="{{ action('RibosBarController@storeSalesInvoice') }}" method="post">
                        		{{ csrf_field() }}
                        	<div class="form-group">
                    			<div class="form-row">
									<div class="col-md-2">
                     					<label>Date</label>
                     					<input type="text" name="date" class="datepicker form-control" required="required" />

                         			</div>
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
							<button type="submit" class="btn btn-success btn-lg float-right"><i class="fas fa-save"></i> Save Sales Invoice</button>
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