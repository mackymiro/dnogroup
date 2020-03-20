@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Add New Sales Invoice |')
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
              <li class="breadcrumb-item active">Add New Sales Invoice</li>
            </ol>
            <div class="row">
            	<div class="col-lg-12">
            		<div class="card mb-3">
            			<div class="card-header">
						  <i class="fa fa-plus" aria-hidden="true"></i>
						  Add New</div>
					  	<div class="card-body">
				  			 @if(session('addSalesInvoiceSuccess'))
		                       <p class="alert alert-success">{{ Session::get('addSalesInvoiceSuccess') }}</p>
		                      @endif 
					  		<form action="{{ action('LoloPinoyLechonDeCebuController@addNewSalesInvoiceData', $id)}}" method="post">
					  			{{csrf_field()}}
					  		<div class="form-group">
				  				<div class="form-row">
				  					<div class="col-md-2">
                     					<label>Qty</label>
                     					<input type="text" name="qty" class="form-control" required="required"  />
	                         		</div>
	                         		 <div class="col-md-2">
                                        <label>Body 400/KLS</label>
                                        <input type="text" name="body" class="form-control" />
                                    </div>
                                    <div class="col-md-2">
                                        <label>Head & Feet 200/KLS</label>
                                        <input type="text" name="headFeet" class="form-control" />
                                    </div>
                         			<div class="col-md-4">
                         				<label>Item Description</label>
                         				<input type="text" name="itemDescription" class="form-control"/>
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
			  							<a href="{{ url('lolo-pinoy-lechon-de-cebu/edit-sales-invoice/'.$id) }}">Back</a>
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