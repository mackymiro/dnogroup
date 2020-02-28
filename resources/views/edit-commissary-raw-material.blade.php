@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Edit Stocks Inventory |')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
</script>
<div id="wrapper">
	@include('sidebar.sidebar')
	<div id="content-wrapper">
		<div class="container-fluid">
				<!-- Breadcrumbs-->
             <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">Lechon de Cebu</a>
                </li>
                <li class="breadcrumb-item ">Commissary</li>
                <li class="breadcrumb-item active">Edit RAW Materials</li>
              </ol>
               <a href="{{ url('lolo-pinoy-lechon-de-cebu/commissary/raw-materials') }}">Back to Lists</a>
              <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
            	 <h4 class="text-center"><u>COMMISSARY RAW MATERIALS</u></h4>
        	  </div>
        	  <div class="row">
        	  		<div class="col-lg-12">
        	  			<div class="card mb-3">
        	  				 <div class="card-header">
                              <i class="fas fa-apple-alt" aria-hidden="true"></i>
                            	Edit Commissary RAW Materials</div>
                        	<div class="card-body">
	                    			@if(session('successRawMaterial'))
	                                 <p class="alert alert-success">{{ Session::get('successRawMaterial') }}</p>
	                                @endif 
                					<form action="{{ action('LoloPinoyLechonDeCebuController@updateRawMaterial', $getRawMaterial['id']) }}" method="post">
	                        	 		 {{csrf_field()}}
	                               <input name="_method" type="hidden" value="PATCH">
                        			<div class="form-group">
            	 					<div class="form-row">
        	 							<div class="col-md-2">
  					  	 					<label>Branch </label>
  					  	 					<input type="text" name="branch" class="form-control" value="{{ $getRawMaterial['branch'] }}" />
  					  	 				</div>
				  	 					<div class="col-md-4">
					  	 					<label>Product Name</label>
					  	 					<input type="text" name="productName" class="form-control" value="{{ $getRawMaterial['product_name'] }}" />
                      
  					  	 				</div>
				  	 					<div class="col-md-1">
					  	 					<label>Unit Price</label>
					  	 					<input type="text" name="unitPrice" class="form-control" value="{{ $getRawMaterial['unit_price'] }}" />
					  	 				</div>
					  	 				<div class="col-md-1">
					  	 					<label>Unit</label>
					  	 					<input type="text" name="unit" class="form-control" value="{{ $getRawMaterial['unit'] }}" />
					  	 				</div>
					  	 				<div class="col-md-1">
					  	 					<label>IN</label>
					  	 					<input type="text" name="in" class="form-control" value="{{ $getRawMaterial['in'] }}" />
					  	 				</div>
					  	 				<div class="col-md-1">
					  	 					<label>OUT</label>
					  	 					<input type="text" name="out" class="form-control" value="{{ $getRawMaterial['out'] }}" />
					  	 				</div>
					                      <div class="col-md-2">
					                        <label>Stock Out Amount</label>
					                        <input type="text" name="stockAmount" class="form-control" value="<?php echo number_format($getRawMaterial['stock_amount'], 2)?>" />
					                      </div>
					  	 				
            	 					</div>
            	 				</div>
            	 				<div class="form-group">
      					  	 		<div class="form-row">
				                          <div class="col-md-2">
				                            <label>Remaining Stock</label>
				                            <input type="text" name="remainingStock" class="form-control" value="{{ $getRawMaterial['remaining_stock'] }}" />
				                          </div>
      					  	 			<div class="col-md-2">
      					  	 				<label>Amount</label>
      					  	 				<input type="text" name="amount" class="form-control" value="<?php echo number_format($getRawMaterial['amount'], 2)?>" />
      					  	 			</div>
      					  	 			<div class="col-md-2">
      					  	 				<label>Supplier</label>
      					  	 				<input type="text" name="supplier" class="form-control" value="{{ $getRawMaterial['supplier'] }}" />
      					  	 			</div>
      					  	 			
      					  	 		</div>
      					  	 	</div>
  					  	 		<div class="form-group">
      					  	 		<div class="form-row">
      					  	 			<div class="float-right">
      					  	 				
					  	 					<button type="submit" class="btn btn-success">
										      <i class="fa fa-plus" aria-hidden="true"></i> Update RAW Materials
									      	 </button>
			                            
      					  	 			</div>
      					  	 		</div>
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