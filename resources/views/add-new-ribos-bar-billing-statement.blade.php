@extends('layouts.ribos-bar-app')
@section('title', 'Add New Billing|')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
</script>
<div id="wrapper">
		 @include('sidebar.sidebar-ribos-bar')
    <div id="content-wrapper"> 
    	<div class="container-fluid">
    		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Ribo's Bar</a>
              </li>
              <li class="breadcrumb-item active">Add New Billing</li>
            </ol>
            <div class="row">
	        	<div class="col-lg-12">
	        		<div class="card mb-3">
	    				<div class="card-header">
						  <i class="fa fa-plus" aria-hidden="true"></i>
						  Add New</div>
						   <div class="card-body">
						   		<form action="{{ action('RibosBarController@addNewBillingData', $id) }}" method="post">
						   			{{csrf_field()}}
                     @if(session('addBillingSuccess'))
                       <p class="alert alert-success">{{ Session::get('addBillingSuccess') }}</p>
                      @endif 
						   		<div class="form-group">
						   			<div class="form-row">
						   				<div class="col-lg-1">
						   					<label>Date</label>
	        								<input type="text" name="transactionDate" class="form-control" required="required" />
						   				</div>
						   				 <div class="col-lg-1">
	              					<label>Invoice #</label>
	              					<input type="text" name="invoiceNumber" class="form-control" required="required" />
		              			</div>
		              			<div class="col-lg-4">
		              				<label>Whole Lechon 500/KL</label>
        							   	<input type="text" name="wholeLechon" class="form-control"  required="required" />
		              			</div>
		              			<div class="col-lg-4">
		              				<label>Description</label>
        								  <input type="text" name="description" class="form-control"  required="required" />
		              			</div>
		              			<div class="col-lg-1">
            				        <label>Amount</label>
		            				    <input type="text" name="amount" class="form-control" disabled="disabled" />
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
				  							<a href="{{ url('ribos-bar/edit-ribos-bar-billing-statement/'.$id) }}">Back</a>
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