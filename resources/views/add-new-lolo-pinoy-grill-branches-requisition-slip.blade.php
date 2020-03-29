@extends('layouts.lolo-pinoy-grill-branches-app')
@section('title', 'Add New Requisiton Form |')
@section('content')
<script>
  $(document).ready(function(){
	$('.alert-success').fadeIn().delay(3000).fadeOut(); 
   });
</script>
<div id="wrapper">
	 @include('sidebar.sidebar-lolo-pinoy-grill-branches')

	    <div id="content-wrapper"> 
	    	<div class="container-fluid">
	    		 <!-- Breadcrumbs-->
		            <ol class="breadcrumb">
		              <li class="breadcrumb-item">
		                <a href="#">Lolo Pinoy Grill Branches</a>
		              </li>
		              <li class="breadcrumb-item active">Add New Requisition Form</li>
		            </ol>
		            <div class="row">
		            	<div class="col-lg-12">
		            		<div class="card mb-3">
		            			<div class="card-header">
        					  <i class="fa fa-plus" aria-hidden="true"></i>
        					  Add New</div>
        					   <div class="card-body">
        					   		<form action="{{ action('LoloPinoyGrillBranchesController@addNewRequisitionSlip', $id) }}" method="post">
    					   				{{csrf_field()}}
    					   				 @if(session('purchaseOrderSuccess'))
						                   <p class="alert alert-success">{{ Session::get('purchaseOrderSuccess') }}</p>
						                  @endif 
	    					   		<div class="form-group">
	    					   			<div class="form-row">
    					   					<div class="col-lg-2">
                                        <label>Quantity Requested</label>
                                        <input type="text" name="quantityRequested" class="form-control" value="" />
                                      
                                      </div>
                                      <div class="col-lg-2">
                                        <label>Unit</label>
                                        <input type="text" name="unit" class="form-control" required="required" />
                                      
                                      </div>
                                     
                                      <div class="col-lg-2">
                                        <label>Item</label>
                                        <input type="text" name="item" class="form-control" required="required" />
                                      
                                      </div>
                                      <div class="col-lg-2">
                                        <label>Quantity Given</label>
                                        <input type="text" name="quantityGiven" class="form-control" required="required" />
                                        
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
					  							<a href="{{ url('lolo-pinoy-grill-branches/edit/'.$id) }}">Back</a>
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