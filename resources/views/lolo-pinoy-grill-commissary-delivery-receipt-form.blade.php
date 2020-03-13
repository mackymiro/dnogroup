@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'Delivery Receipt Form| ')
@section('content')
<div id="wrapper">
	<!-- Sidebar -->
     @include('sidebar.sidebar-lolo-pinoy-grill')
     <div id="content-wrapper">
     		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lolo Pinoy Grill Commissary</a>
              </li>
              <li class="breadcrumb-item active">Delivery Receipt Form</li>
            </ol>
            <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoy-grill.jpeg')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lolo Pinoy Grill ">
            	 
            	 <h4 class="text-center"><u>DELIVERY RECEIPT</u></h4>
            </div>
            <div class="row">
         		<div class="col-lg-12">
         			<div class="card mb-3">
         				<div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            Delivery Receipt</div>
                       	 <div class="card-body">
                       	 	<form action="{{ action('LoloPinoyGrillCommissaryController@storeDeliveryReceipt')}}" method="post">
                       	 		{{ csrf_field() }}
                    		<div class="form-group">
                        		<div class="form-row">
                    				<div class="col-md-4">
                    					<label>Delivered To</label>
                    					<input type="text" name="deliveredTo" class="form-control" required="required" />
                    					@if ($errors->has('deliveredTo'))
		                                  <span class="alert alert-danger">
		                                    <strong>{{ $errors->first('deliveredTo') }}</strong>
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
                    						<label>Product Id</label>
                    						<input type="text" name="productId" class="form-control" required="required" />
                      				</div>
                        				<div class="col-md-1">
                    						<label>QTY</label>
                    						<input type="text" name="qty" class="form-control" required="required" />
                        				</div>
                        				<div class="col-md-1">
                    						<label>Unit</label>
                    						<input type="text" name="unit" class="form-control" required="required" />
                        				</div>
                        				<div class="col-md-4">
                        					<label>Item Description</label>
                        					<input type="text" name="itemDescription" class="form-control" required="required" />
                        				</div>
                        				<div class="col-md-2">
                        					<label>Unit Price</label>
                        					<input type="text" name="unitPrice" class="form-control" required="required" />
                        				</div>
                    				
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