@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Delivery Receipt Form| ')
@section('content')
<div id="wrapper">
	<!-- Sidebar -->
     @include('sidebar.sidebar')
    <div id="content-wrapper">
    	<div class="container-fluid">
    		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lechon de Cebu</a>
              </li>
              <li class="breadcrumb-item active">Delivery Receipt Form</li>
            </ol>
            <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
            	 <h4 class="text-center"><u>DELIVERY RECEIPT</u></h4>
            </div>
            <div class="row">
            	<div class="col-lg-12">
            		<div class="card mb-3">
            			<div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            Delivery Receipt</div>
                        <div class="card-body">
                        	<form action="{{ action('LoloPinoyLechonDeCebuController@storeDeliveryReceipt')}}" method="post">
                        		{{ csrf_field() }}
                        	<div class="form-group">
                        		<div class="form-row">
                    				<div class="col-md-4">
                    					<label>Sold To</label>
                    					<input type="text" name="soldTo" class="form-control" required="required" />
                    					@if ($errors->has('soldTo'))
		                                  <span class="alert alert-danger">
		                                    <strong>{{ $errors->first('soldTo') }}</strong>
		                                  </span>
		                                @endif
                    				</div>
                    				<div class="col-md-2">
                						<label>Time</label>
                						<div id="app-time">
                                            <select name="time" class="form-control">
                                                <option value="0">--Please Select--</option>
                                                <option v-for="time in times" v-bind:value="time.value">
                                                    @{{ time.text }}
                                                </option>
                                            </select> 
                                        </div>
                    				</div>
                                    <div class="col-md-2">
                                        <label>Date To be Delivered</label>
                                        <input type="text" name="dateDelivered" class="form-control" />
                                    </div>
                    				<div class="col-md-4">
                    					<label>Delivered To</label>
                    					<input type="text" name="deliveredTo" class="form-control" />
                    				</div>
                        		</div>
                        	</div>
                        	<div class="form-group">
                        		<div class="form-row">
                        			<div class="col-md-4">
                        				<label>Contact Person</label>
                        				<input type="text" name="contactPerson" class="form-control" />
                        			</div>
                        			<div class="col-md-2">
                        				<label>Mobile #</label>
                        				<input type="" name="mobile" class="form-control" />
                        			</div>
                        			<div class="col-md-4">
                        				<label>Special Instruction/Request</label>
                        				<input type="text" name="specialInstruction" class="form-control" />
                        			</div>
                        		</div>
                        	</div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-4">  
                                        <label>Consignee Name</label>
                                        <input type="text" name="consigneeName" class="form-control" />
                                    </div>
                                    <div class="col-md-4">
                                        <label>Consignee Contact #</label>
                                        <input type="text" name="consigneeContact" class="form-control" />
                                    </div>
                                </div>
                            </div>
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
                    		<div>
	  	 				      <input type="submit" class="btn btn-success float-right" value="Add Delivery Receipt" />
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
@endsection