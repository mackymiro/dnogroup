@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'Add New Sales Invoice |')
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
              <li class="breadcrumb-item active">Add New Sales Invoice</li>
            </ol>
            <div class="row">
            	<div class="col-lg-12">
            		<div class="card mb-3">
            			<div class="card-header">
						  <i class="fa fa-cash-register" aria-hidden="true"></i>
						  Add New</div>
					  	<div class="card-body">
					  		 @if(session('addSalesInvoiceSuccess'))
		                       <p class="alert alert-success">{{ Session::get('addSalesInvoiceSuccess') }}</p>
		                      @endif 
					  		<form action="{{ action('LoloPinoyGrillCommissaryController@addNewSalesInvoiceData', $id) }}" method="post">
					  			{{csrf_field()}}
					  		<div class="form-group">
				  				<div class="form-row">
			  						<div class="col-md-2">
                     					<label>Qty</label>
                     					<input type="text" name="qty" class="form-control" />
                         			</div>
                         			<div class="col-md-2">
                         				<label>Total KlS</label>
                         				<input type="text" name="totalKls" class="form-control" />
                         			</div>
                         			<div class="col-md-4">
                         				<label>Item Description</label>
                         				<input type="text" name="itemDescription" class="form-control" />
                         			</div>
                         			<div class="col-md-1">
                         				<label>Unit Price</label>
                         				<input type="text" name="unitPrice" class="form-control" disabled="disabled" value="500.00" />
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
			  							<a href="{{ url('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-sales-invoice/'.$id) }}">Back</a>
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