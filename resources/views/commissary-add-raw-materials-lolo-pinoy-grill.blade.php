@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'Add RAW Materials |')
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
                <li class="breadcrumb-item ">Commissary</li>
                <li class="breadcrumb-item active">Add RAW Materials</li>
              </ol>

              <div class="row">
              		<div class="col-lg-12">
              			<div class="card mb-3">
              				<div class="card-header">
          					  <i class="fa fa-plus" aria-hidden="true"></i>
          					  add RAW Materials</div>
      					  	<div class="card-body">
      					  			<form action="{{ action('LoloPinoyGrillCommissaryController@addRawMaterial') }}" method="post">
			                        {{csrf_field()}}
			                         @if(session('addRawMaterial'))
			                           <p class="alert alert-success">{{ Session::get('addRawMaterial') }}</p>
			                          @endif 
  					  				<div class="form-group">
  					  	 			<div class="form-row">
  					  	 				<div class="col-md-2">
  					  	 					<label>Branch </label>
  					  	 					<input type="text" name="branch" class="form-control"  />
  					  	 				</div>
  					  	 				
  					  	 				<div class="col-md-4">
					  	 					<label>Product Name</label>
					  	 					<input type="text" name="productName" class="form-control" required="required" />
					                        @if ($errors->has('productName'))
					                              <span class="alert alert-danger">
					                                <strong>{{ $errors->first('productName') }}</strong>
					                              </span>
					                         @endif
  					  	 				</div>
  					  	 				<div class="col-md-1">
  					  	 					<label>Unit Price</label>
  					  	 					<input type="text" name="unitPrice" class="form-control" />
  					  	 				</div>
  					  	 				<div class="col-md-1">
  					  	 					<label>Unit</label>
  					  	 					<input type="text" name="unit" class="form-control" />
  					  	 				</div>
  					  	 				<div class="col-md-1">
  					  	 					<label>IN</label>
  					  	 					<input type="text" name="in" class="form-control" />
  					  	 				</div>
  					  	 				<div class="col-md-1">
  					  	 					<label>OUT</label>
  					  	 					<input type="text" name="out" class="form-control" />
  					  	 				</div>
				                        <div class="col-md-2">
				                          <label>Stock Out Amount</label>
				                          <input type="text" name="stockAmount" class="form-control" />
				                        </div>
  					  	 				
  					  	 			</div>
      					  	 	</div>
      					  	 	<div class="form-group">
      					  	 		<div class="form-row">
				                          <div class="col-md-2">
				                            <label>Remaining Stock</label>
				                            <input type="text" name="remainingStock" class="form-control" />
				                          </div>
      					  	 			<div class="col-md-2">
      					  	 				<label>Amount</label>
      					  	 				<input type="text" name="amount" class="form-control" />
      					  	 			</div>
      					  	 			<div class="col-md-2">
      					  	 				<label>Supplier</label>
      					  	 				<input type="text" name="supplier" class="form-control" />
      					  	 			</div>
      					  	 			
      					  	 		</div>
      					  	 	</div>
      					  	 		<div class="form-group">
      					  	 		<div class="form-row">
      					  	 			
      					  	 			<div class="float-right">
      					  	 				
      					  	 				<button type="submit" class="btn btn-success">
												      <i class="fa fa-plus" aria-hidden="true"></i>  Add RAW Materials
											       </button>
				                             <br>
				                             <br>
				                             <a href="{{ url('lolo-pinoy-grill-commissary/commissary/raw-materials') }}">Back</a>
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