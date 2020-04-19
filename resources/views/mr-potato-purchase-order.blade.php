@extends('layouts.mr-potato-app')
@section('title', 'Purchase Order Form |')
@section('content')
<div id="wrapper">
	<!-- Sidebar -->
    	@include('sidebar.sidebar-mr-potato')
    	<div id="content-wrapper">
    		<div class="container-fluid">
    			 <!-- Breadcrumbs-->
		            <ol class="breadcrumb">
		              <li class="breadcrumb-item">
		                <a href="#">Mr Potato</a>
		              </li>
		              <li class="breadcrumb-item active">Purchase Order Form</li>
		            </ol>
		             <div class="col-lg-12">
					 	<div style="float:left; margin-left:140px">
							<img src="{{ asset('images/ribos.jpg')}}" width="390" height="250" class="img-responsive mx-auto d-block" alt="Mr Potato">
						</div>
						<div style="flaot:left; margin-right:50px;">
							 <img src="{{ asset('images/mr-potato.png')}}" width="390" height="250" class="img-responsive mx-auto d-block" alt="Mr Potato">
						</div>
		            	 <h4 class="text-center"><u>PURCHASE ORDER</u></h4>
		            </div>
		            <div class="row">
	            		<div class="col-lg-12">
	            			<div class="card mb-3">
	            				 <div class="card-header">
		                              <i class="fab fa-first-order" aria-hidden="true"></i>
		                            Purchase Order</div>
	                            <div class="card-body">
	                            	<form action="{{ action('MrPotatoController@store') }}" method="post">
	                            		 {{csrf_field()}}
	                            	<div class="form-group">
	                            		<div class="form-row">
											@if ($errors->has('branchLocation'))
											<span class="alert alert-danger">
												<strong>{{ $errors->first('paidTo') }}</strong>
											</span>
											@endif
                            				<div class="col-lg-4">
                            					<label>Branch Location</label>
                            					<input type="text" name="branchLocation" class="form-control" required="required" />
                            					
                            				</div>
                            			
                            				<div class="col-lg-2">
                            					<label>Date</label>
                            					<input type="text" name="date" class="form-control" />
                            				</div>
											@if ($errors->has('orderedBy'))
												<span class="alert alert-danger">
													<strong>{{ $errors->first('orderedBy') }}</strong>
												</span>
											@endif
											<div class="col-lg-4">	
                        						<label>Oredered By</label>
                        						<input type="text" name="orderedBy" class="form-control" required="required" />
                        						
                            				</div>
	                            		</div>
	                            	</div>
	                            	<div class="form-group">
	                            		<div class="form-row">
	                            			<div class="col-lg-2">
	                            				<label>Particulars</label>
												<select class="form-control" name="particulars">
													<option value="0">--Please Select--</option>
													<optgroup label="Containers">
														<option value="Small (100’s per pack)" >Small (100’s per pack)</option>
														<option value="Medium (25’s per pack)">Medium (25’s per pack)</option>
														<option value="Large (25’s per pack)">Large (25’s per pack)</option>
														<option value="Jumbo (25’s per pack)" >Jumbo (25’s per pack)</option>
														<option value="Trio (Barkada) (50’s per pack)" >Trio (Barkada) (50’s per pack)</option>
													</optgroup>
													<optgroup label="Beverages">
														<option value="Bottled Water" >Bottled Water</option>
														
													</optgroup>
													<optgroup label="Fries">
														<option value="Aviko (2.5kls) Main Fries" >Aviko (2.5kls) Main Fries</option>
														<option value="Farm Frite Fries (2kls)" >Farm Frite Fries (2kls)</option>
													</optgroup>
													<optgroup label="Flavoring">
														<option value="Cheese" >Cheese</option>
														<option value="Barbecue" >Barbecue</option>
														<option value="Sour Cream" >Sour Cream</option>
														<option value="Sour Cheese" >Sour Cheese</option>
														<option value="Sweetcorn" >Sweetcorn</option>
														<option value="Chili Barbeque" >Chili Barbeque</option>
													</optgroup>
													<option value="Cooking Oil (20kl)">Cooking Oil (20kl)</option>
												</select>
	                            			</div>
											
	                            			<div class="col-lg-2">
	                            				<label>QTY</label>
	                            				<input type="text" name="qty" class="form-control" />
	                            			
	                            			</div>
											@if ($errors->has('unit'))
												<span class="alert alert-danger">
													<strong>{{ $errors->first('unit') }}</strong>
												</span>
												@endif
											<div class="col-lg-2">
	                            				<label>Unit</label>
												<div id="app-unit">
													<select class="form-control" name="unit">
														<option value="0">--Please Select--</option>
														<option v-for="unit in units" v-bind:value="unit.value">
															@{{ unit.text }}
														</option>
													</select>
												</div>
	                            			</div>
											@if ($errors->has('price'))
												<span class="alert alert-danger">
													<strong>{{ $errors->first('price') }}</strong>
												</span>
											@endif
	                            			<div class="col-lg-2">
	                            				<label>Price</label>
	                            				<input type="text" name="price" class="form-control" required="required" />
	                            				
	                            			</div>
										
											<div class="col-lg-2">
	                            				<label>Subtotal</label>
	                            				<input type="text" name="subtotal" class="form-control"  />
	                            				
	                            			</div>
	                            		</div>
	                            		
	                            	</div>
	                            	<br>
	                                <div>
	                                    <input type="submit" class="btn btn-success float-right" value="Add Purchase Order" />
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
	//unit
	new Vue({
	el: '#app-unit',
		data:{
			units:[
				{text:'PIECE', value:'PIECE'},
				{text:'Bottle', value:'Bottle'},
				{text:'PACK', value:'PACK'},
				{text:'KILO', value:'KILO'},
				{text:'BOX', value:'BOX'}
			]
		}
	});
</script>
@endsection