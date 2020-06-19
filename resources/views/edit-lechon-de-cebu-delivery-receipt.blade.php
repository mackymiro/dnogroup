@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Edit Delivery Receipt |')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
  $(function() {
        $( ".datepicker" ).datepicker();
    });
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

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
        	 
        	 <h4 class="text-center"><u>DELIVERY RECEIPT</u></h4>
			  </div>
			  <div class="row">
			  		<div class="col-lg-12">
			  			<div class="card mb-3">
			  				<div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            Edit Delivery Receipt</div>
                            <br>
                            <br>
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
                                <div id="app-time">
                                    <select name="time" class="form-control">
                                        <option value="0">--Please Select--</option>
                                       <option v-for="time in times" v-bind:value="time.value"
                                          :selected="time.value=={{json_encode($getDeliveryReceipt['time'])}}?true : false">
                                             @{{ time.text }}
                                        </option>
                                    </select> 
                                </div>              
                              </div>
                              <div class="col-md-2">
                                    <label>Date To be Delivered</label>
                                    <input type="text" name="dateDelivered" class="datepicker form-control" value="{{ $getDeliveryReceipt['date_to_be_delivered']}}" />
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
                                    <div class="col-md-4">  
                                        <label>Consignee Name</label>
                                        <input type="text" name="consigneeName" class="form-control" value="{{ $getDeliveryReceipt['consignee_name'] }}" />
                                    </div>
                                    <div class="col-md-4">
                                        <label>Consignee Contact #</label>
                                        <input type="text" name="consigneeContact" class="form-control" value="{{ $getDeliveryReceipt['consignee_contact_num']}}" />
                                    </div>
                                </div>
                            </div>
                             	<div class="form-group">
                             		<div class="form-row">
                     					<div class="col-md-1">
	                						<label>QTY</label>
	                						<input type="text" name="qty" class="form-control" value="{{ $getDeliveryReceipt['qty']}}" />
	                    				</div>
                              <div class="col-md-1">
	                						<label>Unit</label>
	                						<input type="text" name="unit" class="form-control" value="{{ $getDeliveryReceipt['unit']}}" />
	                    				</div>
	                    				<div class="col-md-4">
	                    					<label>Description</label>
	                    					<input type="text" name="description" class="form-control" value="{{ $getDeliveryReceipt['description'] }}" />
	                    				</div>
                    					<div class="col-md-2">
	                    					<label>Price</label>
	                    					<input type="text" name="price" class="form-control" value="{{ $getDeliveryReceipt['price']}}" />
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
                                        <div class="col-md-1">
                                          <label>Unit</label>
                                          <input type="text" name="unit" class="form-control" value="{{ $dReceipt['unit']}}" />
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
                                          <input type="hidden" id="drId" name="drId" value="{{ $getDeliveryReceipt['id'] }}" />
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
<script>
     //branch data
    new Vue({
    el: '#app-time',
        data: {
            times:[
                { text:'12:00 AM', value: '12:00 AM' },
                { text:'1:00 AM', value: '1:00 AM' },
                { text:'2:00 AM', value: '2:00 AM' },
                { text:'3:00 AM', value: '3:00 AM' },
                { text:'4:00 AM', value: '4:00 AM' },
                { text:'5:00 AM', value: '5:00 AM' },
                { text:'6:00 AM', value: '6:00 AM' },
                { text:'7:00 AM', value: '7:00 AM' },
                { text:'8:00 AM', value: '8:00 AM' },
                { text:'9:00 AM', value: '9:00 AM' },
                { text:'10:00 AM', value: '10:00 AM' },
                { text:'11:00 AM', value: '11:00 AM' },
                { text:'12:00 PM', value: '12:00 PM' },
                { text:'1:00 PM', value: '1:00 PM' },
                { text:'2:00 PM', value: '2:00 PM' },
                { text:'3:00 PM', value: '3:00 PM' },
                { text:'4:00 PM', value: '4:00 PM' },
                { text:'5:00 PM', value: '5:00 PM' },
                { text:'6:00 PM', value: '6:00 PM' },
                { text:'7:00 PM', value: '7:00 PM' },
                { text:'8:00 PM', value: '8:00 PM' },
                { text:'9:00 PM', value: '9:00 PM' },
                { text:'10:00 PM', value: '10:00 PM' },
                { text:'11:00 PM', value: '11:00 PM' }
            ]
        }
    })  
</script>

<script type="text/javascript">
    const confirmDelete = (id) => {
        const x = confirm("Do you want to delete this?");
        const drId = $('#drId').val();
       
          if(x){
              $.ajax({
                type: "DELETE",
                url: '/lolo-pinoy-lechon-de-cebu/delete-delivery-receipt/' + id,
                data:{
                  _method: 'delete', 
                  "_token": "{{ csrf_token() }}",
                  "id": id,
                  "drId":drId,
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