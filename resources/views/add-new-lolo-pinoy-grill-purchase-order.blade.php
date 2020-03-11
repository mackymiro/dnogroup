@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'Add New Purchase Order |')
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
		              <li class="breadcrumb-item active">Add New Purchase Order</li>
		            </ol>
		            <div class="row">
		            	<div class="col-lg-12">
		            		<div class="card mb-3">
		            			<div class="card-header">
        					  <i class="fa fa-tasks" aria-hidden="true"></i>
        					  Add New</div>
        					  <div class="card-body">
        					  	<form action="{{ action('LoloPinoyGrillCommissaryController@addNewPurchaseOrder', $id) }}" method="post">
        					  		{{csrf_field()}}
        					  		 @if(session('purchaseOrderSuccess'))
						                   <p class="alert alert-success">{{ Session::get('purchaseOrderSuccess') }}</p>
						                  @endif 
        					  	<div class="form-group">
        					  		<div class="form-row">
    					  				<div class="col-lg-1">
			                                    <label>Quantity</label>
			                                    <input type="text" name="quantity" class="form-control" required="required" />
			                                   
			                                 </div>
			                                 <div class="col-lg-4">
			                                    <label>Description</label>
			                                    <input type="text" name="description" class="form-control" required="required" />
			                                   
			                                  </div>
			                                  <div class="col-lg-4">
			                                    <label>Unit Price</label>
			                                    <input type="text" name="unitPrice" class="form-control" required="required" />
			                                   
			                                  </div>
		                                   	  <div class="col-lg-2">
			                                    <label>Amount</label>
			                                    <input type="text" name="amount" class="form-control" required="required" />
			                                    
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
				  							<a href="{{ url('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-purchase-order/'.$id) }}">Back</a>
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