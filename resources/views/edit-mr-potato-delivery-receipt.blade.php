@extends('layouts.mr-potato-app')
@section('title', 'Edit Delivery Receipt |')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
</script>
<div id="wrapper">
	@include('sidebar.sidebar-mr-potato')
	<div id="content-wrapper">
		<div class="container-fluid">
			<!-- Breadcrumbs-->
	         <ol class="breadcrumb">
	            <li class="breadcrumb-item">
	              <a href="#">Mr Potato</a>
	            </li>
	            <li class="breadcrumb-item active">Edit Delivery Receipt</li>
	          </ol>
	          <a href="{{ url('mr-potato/delivery-receipt-lists') }}">Back to Lists</a>
	           <div class="col-lg-12">
  	        	  <img src="{{ asset('images/mr-potato.png')}}" width="390" height="250" class="img-responsive mx-auto d-block" alt="Mr Potato">
  	        	 
  	        	 <h4 class="text-center"><u>DELIVERY RECEIPT</u></h4>
		      </div>
		     <div class="row">
     			<div class="col-lg-12">
     				<div class="card mb-3">
     					<div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            Edit Delivery Receipt
                        </div>
                        <div class="card-body">
                        	 @if(session('updateSuccessfull'))
                             	<p class="alert alert-success">{{ Session::get('updateSuccessfull') }}</p>
                             @endif 
                        	<form action="{{ action('MrPotatoController@updateDeliveryReceipt', $getDeliveryReceipt['id']) }}" method="post">
                        	{{csrf_field()}}
                     		<input name="_method" type="hidden" value="PATCH">
                    		<div class="form-group">
                        		<div class="form-row">
                    				
                    				<div class="col-md-4">
                    					<label>Delivered To</label>
                    					<input type="text" name="deliveredTo" class="form-control" value="{{ $getDeliveryReceipt['delivered_to']}}" />
                    				</div>
                    				<div class="col-md-4">
                        				<label>Address</label>
                        				<input type="text" name="address" class="form-control" value="{{ $getDeliveryReceipt['address']}}" />
                        			</div>
                        		</div>
                        	</div>
                        	<div class="form-group">
                    			<div class="form-row">
	                    				<div class="col-md-2">
                    						<label>Product Id</label>
                    						<input type="text" name="productId" class="form-control" value="{{ $getDeliveryReceipt['product_id']}}"  />
	                      				</div>
	                      			
                        				<div class="col-md-1">
                    						<label>QTY</label>
                    						<input type="text" name="qty" class="form-control" value="{{ $getDeliveryReceipt['qty']}}" />
                        				</div>
                        				
                        				<div class="col-md-1">
                    						<label>Unit</label>
                    						<input type="text" name="unit" class="form-control" value="{{ $getDeliveryReceipt['unit']}}" />
                        				</div>
                        				
                        				<div class="col-md-4">
                        					<label>Item Description</label>
                        					<input type="text" name="itemDescription" class="form-control" value="{{ $getDeliveryReceipt['item_description']}}" />
                        				</div>
                        				
                        				<div class="col-md-2">
                        					<label>Unit Price</label>
                        					<input type="text" name="unitPrice" class="form-control" value="{{ $getDeliveryReceipt['unit_price']}}" />
                        				</div>
                        				<div class="col-md-2">
                        					<label>Amount</label>
                        					<input type="text" name="unitPrice" class="form-control" value="<?php echo number_format($getDeliveryReceipt['amount'], 2)?>" disabled="disabled" />
                        				</div>
                    					<div class="col-lg-12 float-right">
	                                  	    <br>
		                                    <br>
		                                    <input type="submit" class="btn btn-success"  value="Update Purchase Order" />
		                                 </div> 
                    			</div>
                        	</div>
                        	</form>
                        </div>

     				</div>
     			</div>
		     </div>
		     <div class="row">
		     	<div class="col-lg-12">
		     		<div class="card mb-3">
		     			<div class="card-header">
                    	  <i class="fas fa-receipt" aria-hidden="true"></i>
                        	Edit Delivery Receipt
                        </div>
                        <div class="card-body">
                        	 @if(session('SuccessEdit'))
                                     <p class="alert alert-success">{{ Session::get('SuccessEdit') }}</p>
                                  @endif 
                    		 @foreach($dReceipts as $dReceipt)
                    		 <form action="{{ action('MrPotatoController@updateDr', $dReceipt['id']) }}" method="post">
                		 		 {{csrf_field()}}
                           	 <input name="_method" type="hidden" value="PATCH">
                           	 <div id="deletedId{{ $dReceipt['id']}}">
                    		<div class="form-group">
                    			<div class="form-row">
                					<div class="col-lg-1">
                						<label>Product Id</label>
                						<input type="text" name="productId" class="form-control" value="{{ $dReceipt['product_id']}}"  />
                      				</div>
	                      			
                    				<div class="col-md-1">
                						<label>QTY</label>
                						<input type="text" name="qty" class="form-control" value="{{ $dReceipt['qty']}}" />
                    				</div>
                    				
                    				<div class="col-md-1">
                						<label>Unit</label>
                						<input type="text" name="unit" class="form-control" value="{{ $dReceipt['unit']}}" />
                    				</div>
                    				
                    				<div class="col-md-4">
                    					<label>Item Description</label>
                    					<input type="text" name="itemDescription" class="form-control" value="{{ $dReceipt['item_description']}}" />
                    				</div>
                    				
                    				<div class="col-md-2">
                    					<label>Unit Price</label>
                    					<input type="text" name="unitPrice" class="form-control" value="{{ $dReceipt['unit_price']}}" />
                    				</div>
                    				 <div class="col-md-1">
                                        <label>Amount</label>
                                        <input type="text" name="unitPrice" class="form-control"  disabled="disabled"
                                        value="<?php echo number_format($dReceipt['amount'], 2)?>" />
                                    </div>
                    			</div>
                			</div>
                			 <div  class="form-group">
                                <div class="form-row">
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
                        	</div>
                        	</form>
                			@endforeach
                    		 <div>
                                  @if($user->role_type == 1)
                                  <a href="{{ url('mr-potato/add-new-delivery-receipt/'.$getDeliveryReceipt['id'] ) }}" class="btn btn-primary">Add New</a>
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
              url: '/mr-potato/delete-delivery-receipt/' + id,
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