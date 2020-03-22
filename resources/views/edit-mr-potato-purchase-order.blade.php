@extends('layouts.mr-potato-app')
@section('title', 'Edit Purchase Order |')
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
              <li class="breadcrumb-item active">Update Purchase Order Form</li>
            </ol>
            <a href="{{ url('mr-potato/purchase-order-lists') }}">Back to Lists</a>
             <div class="col-lg-12">
            	 <img src="{{ asset('images/mr-potato.png')}}" width="390" height="250" class="img-responsive mx-auto d-block" alt="Mr Potato">
            	 
            	 <h4 class="text-center"><u>PURCHASE ORDER</u></h4>
            </div>
            <div class="row">
            	<div class="col-lg-12">
            		<div class="card mb-3">
            			<div class="card-header">
	                       <i class="fab fa-first-order" aria-hidden="true"></i>
	                         Edit Purchase Order</div>
                          <div class="card-body">
                          		 @if(session('SuccessE'))
	                             	<p class="alert alert-success">{{ Session::get('SuccessE') }}</p>
	                            @endif
	                            <form action="{{ action('MrPotatoController@update', $purchaseOrder['id']) }}" method="post"> 
	                            	{{csrf_field()}}
                     			 <input name="_method" type="hidden" value="PATCH">
                          		<div class="form-group">
                          			<div class="form-row">
                      					<div class="col-lg-4">
		                					<label>Paid To</label>
		                					<input type="text" name="paidTo" class="form-control" value="{{ $purchaseOrder['paid_to']}}" />
		                					 
		                				</div>
		                				<div class="col-lg-4">	
		            						<label>Address</label>
		            						<input type="text" name="address" class="form-control" value="{{ $purchaseOrder['address']}}" />
		            						 
		                				</div>
		                				<div class="col-lg-2">
                        					<label>Date</label>
                        					<input type="text" name="date" class="form-control" value="{{ $purchaseOrder['date']}}" />
                        				</div>
                          			</div>
                          		</div>
                          		<div class="form-group">
                          			<div class="form-row">
                      					<div class="col-lg-2">
                            				<label>Quantity</label>
                            				<input type="text" name="quantity" class="form-control" value="{{ $purchaseOrder['quantity']}}" />
                            				
                            			</div>
                            			<div class="col-lg-4">
                            				<label>Description</label>
                            				<input type="text" name="description" class="form-control" value="{{ $purchaseOrder['description']}}" />
                        					
                            			</div>
                            			<div class="col-lg-2">
                            				<label>Unit Price</label>
                            				<input type="text" name="unitPrice" class="form-control" value="{{ $purchaseOrder['unit_price'] }}" />
                            				
                            			</div>
                            			<div class="col-lg-2">
                            				<label>Amount</label>
                            				<input type="text" name="amount" class="form-control" value="{{ $purchaseOrder['amount']}}" />
                            				
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
                           <i class="fab fa-first-order" aria-hidden="true"></i>
                           Edit Purchase Order</div>
                        <div class="card-body">
                               @if(session('SuccessEdit'))
                               <p class="alert alert-success">{{ Session::get('SuccessEdit') }}</p>
                            @endif
                            @foreach($pOrders as $pOrder)
                            <form action="{{ action('MrPotatoController@updatePo', $pOrder['id']) }}" method="post">
                               {{csrf_field()}}
                            <input name="_method" type="hidden" value="PATCH">
                             <div class="form-group">
                               
                                <div id="deletedId{{ $pOrder['id']}}" class="form-row">
                                    <div class="col-lg-1">
                                      <label>Quantity</label>
                                      <input type="text" name="quantity" class="form-control" value="{{ $pOrder['quantity']}}" />
                                    
                                    </div>
                                    <div class="col-lg-4">
                                      <label>Description</label>
                                      <input type="text" name="description" class="form-control" value="{{ $pOrder['description']}}" />
                                    
                                    </div>
                                    <div class="col-lg-2">
                                      <label>Unit Price</label>
                                      <input type="text" name="unitPrice" class="form-control" value="{{ $pOrder['unit_price']}}" />
                                    
                                    </div>
                                    <div class="col-lg-2">
                                      <label>Amount</label>
                                      <input type="text" name="amount" class="form-control" value="{{ $pOrder['amount']}}" />
                                     
                                    </div>
                                    <div class="col-lg-2">
                                        <br>
                                        <input type="hidden" name="poId" value="{{ $purchaseOrder['id'] }}" />
                                        <input type="submit" class="btn btn-success" value="Update" />
                                        @if($user->role_type == 1)
                                        <a id="delete" onClick="confirmDelete('{{ $pOrder['id'] }}')" href="javascript:void" class="btn btn-danger">Remove</a>
                                        @endif
                                      </div> 
                                </div>
                              </form>
                              @endforeach
                             </div>
                             <div>
                                @if($user->role_type == 1)
                                  <a href="{{ url('mr-potato/add-new/'.$purchaseOrder['id']) }}" class="btn btn-primary">Add New</a>
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
              url: '/mr-potato/delete/' + id,
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