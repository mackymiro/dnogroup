@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Add New Delivery Receipt |')
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
              <li class="breadcrumb-item active">Add New Delivery Receipt</li>
            </ol>
            <div class="row">
            	<div class="col-lg-12">
            		<div class="card mb-3">
            			<div class="card-header">
      						  <i class="fa fa-receipt" aria-hidden="true"></i>
      						  Add New</div>

						   <div class="card-body">
						   	  @if(session('addDeliveryReceiptSuccess'))
                     <p class="alert alert-success">{{ Session::get('addDeliveryReceiptSuccess') }}</p>
                    @endif 
						   		<form action="{{ action('LoloPinoyLechonDeCebuController@addNewDeliveryReceiptData', $id) }}" method="post">
						   				{{csrf_field()}}
						   		<div class="form-group">
						   			<div class="form-row">
  			   				       <div class="col-md-1">
              						<label>QTY</label>
              						<input type="text" name="qty" class="form-control" required="required" />
                					</div>
                  				<div class="col-md-4">
                  					<label>Description</label>
                  					<input type="text" name="description" class="form-control" required="required" />
                  				</div>
                  				<div class="col-md-2">
                  					<label>Price</label>
                  					<input type="text" name="price" class="form-control" required="required" />
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
  			  							<a href="{{ url('lolo-pinoy-lechon-de-cebu/edit-delivery-receipt/'.$id) }}">Back</a>
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