@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'Add New Billing Statement |')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
</script>
<div id="wrapper">
	 @include('sidebar.sidebar-lolo-pinoy-grill')
	 <div id="content-wrapper">
	 		<div class="container-fluid">
	 			 <!-- Breadcrumbs-->
	            <ol class="breadcrumb">
	              <li class="breadcrumb-item">
	                <a href="#">Lolo Pinoy Grill Commissary</a>
	              </li>
	              <li class="breadcrumb-item active">Add New Billing Statement</li>
	            </ol>
	            <div class="row">
	            	<div class="col-lg-12">
	            		<div class="card mb-3">
	            			<div class="card-header">
      						  <i class="fa fa-receipt" aria-hidden="true"></i>
      						  Add New</div>
      						  <div class="card-body">
      						  		@if(session('addBillingSuccess'))
				                     	<p class="alert alert-success">{{ Session::get('addBillingSuccess') }}</p>
				                    @endif 
				                    <form action="{{ action('LoloPinoyGrillCommissaryController@addNewBillingData', $id) }}" method="post">
				                    	{{csrf_field()}}
      						  		<div class="form-group">
  						  				<div class="form-row">
					  						<div class="col-lg-1">
	                                            <label>Date</label>
	                                            <input type="text" name="transactionDate" class="form-control" value=""  required="required" />
		                                    </div>
		                                     <div class="col-lg-1">
	        	 								<label>Invoice #</label>
	        	 								<input type="text" name="invoiceNumber" class="form-control" value="" required="required" />
	            	 						</div>
	            	 						<div class="col-lg-4">
	            	 							<label>Whole Lechon 500/KL</label>
	            	 							<input type="text" name="wholeLechon" class="form-control" value="" required="required" />
	            	 							
	            	 						</div>
	            	 						<div class="col-lg-4">
	        	 								<label>Description</label>
	        	 								<input type="text" name="description" class="form-control" value="" required="required" />
	        	 								
	            	 						</div>
	            	 						<div class="col-lg-1">
	        	 								<label>Amount</label>
	        	 								<input type="text" name="amount" class="form-control" value="" disabled="disabled" required="required" />
	        	 								
	            	 						</div>
  						  				</div>
      						  		</div>
      						  		<div class="form-group">
							   			<div class="form-row">
							   				<div class="col-lg-12 float-right">
					  							<input type="submit" class="btn btn-success" value="Add" />
					  							<br>
					  							<br>
					  							<br>
					  							<a href="{{ url('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-billing-statement/'.$id) }}">Back</a>
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
</div>
@endsection