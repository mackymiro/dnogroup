@extends('layouts.ribos-bar-app')
@section('title', 'Add New Purchase Order |')
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
		                <a href="#">Ribo's Bar</a>
		              </li>
		              <li class="breadcrumb-item active">Add New Purchase Order</li>
		            </ol>
		            <div class="row">
		            	<div class="col-lg-12">
		            		<div class="card mb-3">
		            			<div class="card-header">
        					  <i class="fa fa-plus" aria-hidden="true"></i>
        					  Add New</div>
        					   <div class="card-body">
        					   		<form action="{{ action('RibosBarController@addNewPurchaseOrder', $id) }}" method="post">
    					   				{{csrf_field()}}
    					   				 @if(session('purchaseOrderSuccess'))
						                   <p class="alert alert-success">{{ Session::get('purchaseOrderSuccess') }}</p>
						                  @endif 
	    					   		<div class="form-group">
	    					   			<div class="form-row">
    					   					<div class="col-lg-1">
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
						  					<div class="col-lg-4">
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
	    					   		<div class="form-group">
	    					   			<div class="form-row">
	    					   				<div class="col-lg-12 float-right">
					  							<input type="submit" class="btn btn-success" value="Add" />
					  							<br>
					  							<br>
					  							<br>
					  							<a href="{{ url('ribos-bar/edit-ribos-bar-purchase-order/'.$id) }}">Back</a>
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