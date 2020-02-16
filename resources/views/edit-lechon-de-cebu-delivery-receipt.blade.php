@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Edit Delivery Receipt |')
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
                <li class="breadcrumb-item active">Edit Delivery Receipt</li>
              </ol>
              <a href="{{ url('lolo-pinoy-lechon-de-cebu/delivery-receipt/lists') }}">Back to Lists</a>
              <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
            	 <h4 class="text-center"><u>UPDATE DELIVERY RECEIPT</u></h4>
			  </div>
			  <div class="row">
			  		<div class="col-lg-12">
			  			<div class="card mb-3">
			  				<div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            Edit Delivery Receipt</div>
                             @if(session('updateSuccessfull'))
                             	<p class="alert alert-success">{{ Session::get('updateSuccessfull') }}</p>
                             @endif 
                            <form action="{{ action('LoloPinoyLechonDeCebuController@updateDeliveryReceipt', $getDeliveryReceipt['id']) }}" method="post">
                            	{{csrf_field()}}
                             <input name="_method" type="hidden" value="PATCH">
                             <div class="card-body">
                             	<div class="form-group">
                             		<div class="form-row">
                     				  	<div class="col-md-4">
	                    					<label>Sold To</label>
	                    					<input type="text" name="soldTo" class="form-control" value="{{ $getDeliveryReceipt['sold_to']}}" />
	                    					
                    					</div>
                    					<div class="col-md-2">
	                						<label>Time</label>
	                						<input type="text" name="time" class="form-control" value="{{ $getDeliveryReceipt['time']}}" />
	                    				</div>
	                    				<div class="col-md-4">
	                    					<label>Delivered To</label>
	                    					<input type="text" name="deliveredTo" class="form-control" value="{{ $getDeliveryReceipt['delivered_to']}}" />
	                    				</div>
                             		</div>
                             	</div>
                             	<div class="form-group">
                         			<div class="form-row">
                     					<div class="col-md-4">
	                        				<label>Contact Person</label>
	                        				<input type="text" name="contactPerson" class="form-control" value="{{ $getDeliveryReceipt['contact_person']}}" />
	                        			</div>
	                        			<div class="col-md-2">
	                        				<label>Mobile #</label>
	                        				<input type="" name="mobile" class="form-control" value="{{ $getDeliveryReceipt['mobile_num']}}" />
	                        			</div>
	                        			<div class="col-md-4">
	                        				<label>Special Instruction/Request</label>
	                        				<input type="text" name="specialInstruction" class="form-control" value="{{ $getDeliveryReceipt['special_instruction']}}" />
	                        			</div>
                         			</div>
                             	</div>
                             	<div class="form-group">
                             		<div class="form-row">
                     					<div class="col-md-1">
	                						<label>QTY</label>
	                						<input type="text" name="qty" class="form-control" value="{{ $getDeliveryReceipt['qty']}}" />
	                    				</div>
	                    				<div class="col-md-4">
	                    					<label>Description</label>
	                    					<input type="text" name="description" class="form-control" value="{{ $getDeliveryReceipt['description'] }}" />
	                    				</div>
                    					<div class="col-md-2">
	                    					<label>Price</label>
	                    					<input type="text" name="price" class="form-control" value="<?php echo number_format($getDeliveryReceipt['price'], 2)?>" />
	                    				</div>
                             		</div>
                             	</div>
                             	<div class="form-group">
      					  	 		<div class="form-row">
      					  	 			<div class="float-right">
      					  	 				
					  	 					<button type="submit" class="btn btn-success">
										      <i class="fa fa-refresh" aria-hidden="true"></i> Update Delivery Receipt
									      	 </button>
			                            
      					  	 			</div>
      					  	 		</div>
      					  	 	</div>
                             </div>
                         	</form>
			  			</div>
			  		</div>
			  </div>
			  <div class="row">
			  		<div class="col-lg-12">
			  			 <div class="card mb-3">
			  			 	 <div class="card-header">
	                              <i class="fas fa-receipt" aria-hidden="true"></i>
	                            Edit Delivery Receipt</div>
	                            <div class="card-body">
                                  @if(session('SuccessEdit'))
                                     <p class="alert alert-success">{{ Session::get('SuccessEdit') }}</p>
                                  @endif 
                                  @foreach($dReceipts as $dReceipt)
                                  <form action="{{ action('LoloPinoyLechonDeCebuController@updateDr', $dReceipt['id'])}}" method="post">
                                     {{csrf_field()}}
                                 <input name="_method" type="hidden" value="PATCH">
	                            	  <div class="form-group">
                                    <div id="deletedId{{ $dReceipt['id'] }}" class="form-row">
                                         <div class="col-md-1">
                                          <label>QTY</label>
                                          <input type="text" name="qty" class="form-control" value="{{ $dReceipt['qty']}}" />
                                        </div>
                                        <div class="col-md-4">
                                          <label>Description</label>
                                          <input type="text" name="description" class="form-control" value="{{ $dReceipt['description']}}" />
                                        </div>
                                        <div class="col-md-2">
                                          <label>Price</label>
                                          <input type="text" name="price" class="form-control" value="<?php echo number_format($dReceipt['price'], 2); ?>" />
                                        </div>
                                        <div class="col-lg-2">
                                          <br>
                                          <input type="hidden" name="drId" value="{{ $getDeliveryReceipt['id'] }}" />
                                          <input type="submit" class="btn btn-success" value="Update" />
                                          @if($user->role_type == 1)
                                          <a id="delete" onClick="confirmDelete('{{ $dReceipt['id'] }}')" href="javascript:void" class="btn btn-danger">Remove</a>
                                          @endif
                                        </div>
                                    </div>
                                    
                                  </div>
                                  </form>
                                  @endforeach
	                            	  <div>
		                                  @if($user->role_type == 1)
		                                  <a href="{{ url('lolo-pinoy-lechon-de-cebu/add-new-delivery-receipt/'.$getDeliveryReceipt['id'] ) }}" class="btn btn-primary">Add New</a>
		                                  @endif
		                                </div>
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
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript">
   function confirmDelete(id){
      var x = confirm("Do you want to delete this?");
        if(x){
            $.ajax({
              type: "DELETE",
              url: '/lolo-pinoy-lechon-de-cebu/delete-delivery-receipt/' + id,
              data:{
                _method: 'delete', 
                "_token": "{{ csrf_token() }}",
                "id": id
              },
              success: function(data){
                console.log(data);
                $("#deletedId"+id).fadeOut('slow');
               
              },
              error: function(data){
                console.log('Error:', data);
              }

            });

        }else{
            return false;
        }
   }
</script>
@endsection