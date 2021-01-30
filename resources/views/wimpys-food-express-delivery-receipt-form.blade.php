@extends('layouts.wimpys-food-express-app')
@section('title', 'Delivery Receipt Form| ')
@section('content')
<style>
.selcls { 
    padding: 9px; 
    border: solid 1px #517B97; 
    outline: 0; 
    background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #CAD9E3), to(#FFFFFF)); 
    background: -moz-linear-gradient(top, #FFFFFF, #CAD9E3 1px, #FFFFFF 25px); 
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px; 
    -moz-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px; 
    -webkit-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px; 
	} 
</style>
<script>
    $(function() {
        $( ".datepicker" ).datepicker();
    });
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div id="wrapper">
	<!-- Sidebar -->
     @include('sidebar.sidebar-wimpys-food-express')
    <div id="content-wrapper">
    	<div class="container-fluid">
    		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Wimpy's Food Express</a>
              </li>
              <li class="breadcrumb-item active">Delivery Receipt Form</li>
            </ol>
            <div class="col-lg-12">
                <img src="{{ asset('images/digitized-logos/wimpys-logo1.jpg')}}" width="350" height="178" class="img-responsive mx-auto d-block" alt="Wimpy's Food Express">
            
            	 <h4 class="text-center"><u>DELIVERY RECEIPT</u></h4>
            </div>
            <div class="row">
            	<div class="col-lg-12">
            		<div class="card mb-3">
            			<div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            Delivery Receipt</div>
                        <div class="card-body">
                        	<form action="{{ action('WimpysFoodExpressController@storeDeliveryReceipt')}}" method="post">
                        		{{ csrf_field() }}
                        	<div class="form-group">
                        		<div class="form-row">
                                    <div class="col-md-2">
                    					<label>Date</label>
                    					<input type="text" name="date" class="datepicker selcls form-control" autocomplete="off" />
                    					
                    				</div>
                    				<div class="col-md-4">
                    					<label>Sold To</label>
                    					<input type="text" name="soldTo" class="selcls form-control" required="required" />
                    					@if ($errors->has('soldTo'))
		                                  <span class="alert alert-danger">
		                                    <strong>{{ $errors->first('soldTo') }}</strong>
		                                  </span>
		                                @endif
                    				</div>
                    				<div class="col-md-2">
                						<label>Time</label>
                						<div id="app-time">
                                            <select name="time" class="selcls form-control">
                                                <option value="0">--Please Select--</option>
                                                <option v-for="time in times" v-bind:value="time.value">
                                                    @{{ time.text }}
                                                </option>
                                            </select> 
                                        </div>
                    				</div>
                                    <div class="col-md-2">
                                        <label>Date To be Delivered</label>
                                        <input type="text" name="dateDelivered" class="datepicker selcls form-control" />
                                    </div>
                    				<div class="col-md-4">
                    					<label>Delivered To</label>
                    					<input type="text" name="deliveredTo" class="selcls form-control" />
                    				</div>
                                    <div class="col-md-4">
                        				<label>Contact Person</label>
                        				<input type="text" name="contactPerson" class="selcls form-control" />
                        			</div>
                                    <div class="col-md-2">
                        				<label>Mobile #</label>
                        				<input type="" name="mobile" class="selcls form-control" />
                        			</div>
                        		</div>
                        	</div>
                        	<div class="form-group">
                        		<div class="form-row">
                        			
                        			
                        			<div class="col-md-4">
                        				<label>Special Instruction/Request</label>
                        				<input type="text" name="specialInstruction" class="selcls form-control" />
                        			</div>
                                    <div class="col-md-4">
                        				<label>Delivered For:</label>
                        				<input type="text" name="deliveredFor" class="selcls form-control" />
                        			</div>
                        		</div>
                        	</div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-4">  
                                        <label>Consignee Name</label>
                                        <input type="text" name="consigneeName" class="selcls form-control" />
                                    </div>
                                    <div class="col-md-4">
                                        <label>Consignee Contact #</label>
                                        <input type="text" name="consigneeContact" class="selcls form-control" />
                                    </div>
                                </div>
                            </div>
                        	<div class="form-group">
                    			<div class="form-row">
                    				<div class="col-md-1">
                						<label>QTY</label>
                						<input type="text" name="qty" class="selcls form-control" required="required" />
                    				</div>
                                    <div class="col-md-1">
                						<label>Unit</label>
                						<input type="text" name="unit" class="selcls form-control" required="required" />
                    				</div>
                    				<div class="col-md-4">
                    					<label>Description</label>
                    					<input type="text" name="description" class="selcls form-control" required="required" />
                    				</div>
                    				<div class="col-md-2">
                    					<label>Price</label>
                    					<input type="text" name="price" class="selcls form-control" required="required" />
                    				</div>
                    			</div>
                        	</div>
                    		<div>
                                <button type="submit" class="btn btn-success btn-lg float-right"><i class="fas fa-save"></i> Save Delivery Receipt</button>
                              <br>
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