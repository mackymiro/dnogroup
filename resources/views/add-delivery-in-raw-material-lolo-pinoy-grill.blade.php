@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'Add Delivery In |')
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
                <a href="#">Lolo Pinoy Grill Commissary</a>
              </li>
              <li class="breadcrumb-item">Commissary</li>
              <li class="breadcrumb-item active">Add Delivery In </li>
            </ol>
             <div class="row">
             	<div class="col-lg-12">
         			<div class="card mb-3">
     					<div class="card-header">
						  <i class="fa fa-apple-alt" aria-hidden="true"></i>
						  Delivery In</div>
					   <div class="card-body">
					   		  @if(session('addDeliveryIn'))
		                       <p class="alert alert-success">{{ Session::get('addDeliveryIn') }}</p>
		                      @endif 
					   		<form action="
					   		{{ action('LoloPinoyGrillCommissaryController@addDeliveryInRawMaterial', $id) }}" method="post">
					   			{{csrf_field()}}
					   		<div class="form-group">
					   			<div class="form-row">
					   				<div class="col-lg-2">
					   					<label>Product ID</label>
					   					<input type="text" name="productId" class="form-control" value="{{ $getRawMaterial['product_id_no'] }}" readonly="readonly" />	
					   				</div>
					   				<div class="col-lg-4">
					   					<label>Description</label>
					   					<input type="text" name="description" class="form-control" value="DELIVERY IN" readonly="readonly" />
					   				</div>
					   				<div class="col-lg-4">
					   					<label>Reference Number</label>
					   					<input type="text" name="referenceNum" class="form-control" required="required" />
					   				</div>
					   				<div class="col-lg-2">
					   					<label>QTY</label>
					   					<input type="text" name="qty" class="form-control" required="required" />
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
				   						<input type="submit" class="btn btn-success" value="Add Delivery In" />
				   						<br>
				   						<br>
				   						<a href="{{ url('lolo-pinoy-grill-commissary/view-raw-material-details/'.$id) }}">Go Back</a>
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