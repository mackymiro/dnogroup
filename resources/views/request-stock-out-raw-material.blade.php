@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Request Stock Out |')
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
              <li class="breadcrumb-item">Commissary</li>
              <li class="breadcrumb-item active">Request Stock Out</li>
            </ol>
            <div class="row">
            	<div class="col-lg-12">
            		<div class="card mb-3">
            			<div class="card-header">
						  <i class="fa fa-apple-alt" aria-hidden="true"></i>
						  Request Stock Out</div>
					  	<div class="card-body">
					  		  @if(session('requestStockOut'))
		                       <p class="alert alert-success">{{ Session::get('requestStockOut') }}</p>
		                      @endif 
					  		<form action="{{ action('LoloPinoyLechonDeCebuController@requestStockOut', $getRequestStock['id'])}}" method="post">
					  			{{csrf_field()}}
					  		<div class="form-group">
					  			<div class="form-row">
				  					<div class="col-lg-2">
				   						<label>Product ID</label>
				   						<input type="text" name="productId" class="form-control" value="{{ $getRequestStock['product_id_no'] }}" readonly="readonly" />	
				   					</div>
				  					<div class="col-lg-4">
					   					<label>Description</label>
					   					<input type="text" name="description" class="form-control" value="DELIVERY OUT" readonly="readonly" />
					   				</div>
					   				<div class="col-lg-4">
					   					<label>Reference Number</label>
					   					<input type="text" name="referenceNum" class="form-control" />
					   				</div>
					   				<div class="col-lg-2">
					   					<label>QTY</label>
					   					<input type="text" name="qty" class="form-control" required="required" />
					   				</div>
					   				<div class="col-lg-4">
					   					<label>Requesting Branch</label>
					   					<input type="text" name="requestingBranch" class="form-control"/>
					   				</div>
					  			</div>
					  		</div>
					  		<div class="form-group">
					   			<div class="form-row">
					   				<div class="col-lg-2">
					   					<label>Status</label>
					   					<div id="app-status">
				   							<select name="status" class="form-control">
				   								<option value="0">--Please Select--</option>
				   								<option v-for="status in statuses" v-bind:value="status.value">
				   									@{{ status.text }}
				   								</option>
				   							</select>
					   					</div>
					   				</div>
					   				
					   				<div class="col-lg-2">
					   					<label>Cheque No Issued</label>
					   					<input type="text" name="chequeNo" class="form-control" />
					   				</div>
					   			</div> 
					   		</div>
					   		<div class="form-group">
					   			<div class="form-row">
					   				<div class="col-lg-12">
				   						<input type="submit" class="btn btn-success" value="Request Stock Out" />
				   						<br>
				   						<br>
				   						<a href="{{ url('lolo-pinoy-lechon-de-cebu/view-raw-material-details/'.$id) }}">Go Back</a>
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
<script>
	new Vue({
	el: '#app-status',
		data: {
			statuses:[
				{ text:'Paid', value: 'Paid' },
				{ text:'Unpaid', value: 'Unpaid'}
			]
		}
	})	
</script>
@endsection