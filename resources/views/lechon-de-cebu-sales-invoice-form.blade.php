@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Sales Invoice Form| ')
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
<div id="wrapper">
	<!-- Sidebar -->
     @include('sidebar.sidebar')
     <div id="content-wrapper">
     	<div class="container-fluid">
     		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lechon de Cebu</a>
              </li>
              <li class="breadcrumb-item active">Sales Invoice Form</li>
            </ol>
            <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
            	 <h4 class="text-center"><u>SALES INVOICE FORM</u></h4>
            </div>
            <div class="row">
            	<div class="col-lg-12">
            		<div class="card mb-3">
            			<div class="card-header">
                              <i class="fas fa-cash-register" aria-hidden="true"></i>
                            Sales Invoice Form</div>
                         <div class="card-body">
                         	<form action="{{ action('LoloPinoyLechonDeCebuController@storeSalesInvoice') }}" method="post">
                         		{{ csrf_field() }}
                         	<div class="form-group">
                         		<div class="form-row">
                                    <div class="col-md-2">
                                        
                                        <label>Date</label>
                                        <input type="text" name="date" class="selcls form-control" required="required" />
										@if($errors->has('date'))
		                                  <span class="alert alert-danger">
		                                    <strong>{{ $errors->first('date') }}</strong>
		                                  </span>
		                                @endif

                                    </div>
                         			<div class="col-md-2">

                     					<label>Invoice #</label>
                     					<input type="text" name="invoiceNum" class="selcls form-control" required="required" />
                     					@if($errors->has('invoiceNum'))
		                                  <span class="alert alert-danger">
		                                    <strong>{{ $errors->first('invoiceNum') }}</strong>
		                                  </span>
		                                @endif

                         			</div>
                         			<div class="col-md-4">
                         				<label>Ordered By</label>
                         				<input type="text" name="orderedBy" class="selcls form-control" required="required" />
                         				@if($errors->has('orderedBy'))
		                                  <span class="alert alert-danger">
		                                    <strong>{{ $errors->first('orderedBy') }}</strong>
		                                  </span>
		                                @endif
                         			</div>
                         			<div class="col-md-4">
                         				<label>Address</label>
                         				<input type="text" name="address" class="selcls form-control" /> 
                         			</div>
                         		</div>
                         	</div>
                         	<div class="form-group">
                         		<div class="form-row">
                         			<div class="col-lg-1">
                     					<label>Qty</label>
                     					<input type="text" name="qty" class="selcls form-control" />
                         			</div>
                         			
                                    <div class="col-md-2">
                                        <label>Body 400/KLS</label>
                                        <input type="text" name="body" class="selcls form-control" />
                                    </div>
                                    <div class="col-md-2">
                                        <label>Head & Feet 200/KLS</label>
                                        <input type="text" name="headFeet" class="selcls form-control" />
                                    </div>
                         			<div class="col-md-4">
                         				<label>Item Description</label>
                         				<input type="text" name="itemDescription" class="selcls form-control" />
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