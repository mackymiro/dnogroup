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
                                          <label>Branch Location</label>
                                          <input type="text" name="branchLocation" class="form-control" value="{{ $purchaseOrder['branch_location']}}" />
                                          
                                        </div>
                                              
                                      <div class="col-lg-2">
                                        <label>Date</label>
                                        <input type="text" name="date" class="form-control" value="{{ $purchaseOrder['date']}}" />
                                      </div>
                                 
                                     <div class="col-lg-4">	
                                        <label>Oredered By</label>
                                        <input type="text" name="orderedBy" class="form-control" value="{{ $purchaseOrder['ordered_by'] }}" />
                                        
                                      </div>
                                </div>
                              </div>
                          	  <div class="form-group">
	                            		<div class="form-row">
	                            			<div class="col-lg-4">
	                            				<label>Particulars</label>
                                        <select class="form-control" name="particulars">
                                          <option value="0">--Please Select--</option>
                                          <optgroup label="Containers">
                                            <option value="Small (100’s per pack)" <?php echo (("Small (100’s per pack)" == $purchaseOrder['particulars']) ? 'selected' : '')?>>Small (100’s per pack)</option>
                                            <option value="Medium (25’s per pack)" <?php echo (("Medium (25’s per pack)" == $purchaseOrder['particulars']) ? 'selected' : '')?>>Medium (25’s per pack)</option>
                                            <option value="Large (25’s per pack)" <?php echo (("Large (25’s per pack)" == $purchaseOrder['particulars']) ? 'selected' : '')?>>Large (25’s per pack)</option>
                                            <option value="Jumbo (25’s per pack)" <?php echo (("Jumbo (25’s per pack)" == $purchaseOrder['particulars']) ? 'selected' : '')?>>Jumbo (25’s per pack)</option>
                                            <option value="Trio (Barkada) (50’s per pack)" <?php echo (("Trio (Barkada) (50’s per pack)" == $purchaseOrder['particulars']) ? 'selected' : '')?>>Trio (Barkada) (50’s per pack)</option>
                                          </optgroup>
                                          <optgroup label="Beverages">
                                            <option value="Bottled Water" <?php echo (("Bottled Water" == $purchaseOrder['particulars']) ? 'selected' : '')?> >Bottled Water</option>
                                            
                                          </optgroup>
                                          <optgroup label="Fries">
                                            <option value="Aviko (2.5kls) Main Fries" <?php echo (("Aviko (2.5kls) Main Fries" == $purchaseOrder['particulars']) ? 'selected' : '')?>>Aviko (2.5kls) Main Fries</option>
                                            <option value="Farm Frite Fries (2kls)" <?php echo (("Farm Frite Fries (2kls)" == $purchaseOrder['particulars']) ? 'selected' : '')?>>Farm Frite Fries (2kls)</option>
                                          </optgroup>
                                          <optgroup label="Flavoring">
                                            <option value="Cheese" <?php echo (("Cheese" == $purchaseOrder['particulars']) ? 'selected' : '')?>>Cheese</option>
                                            <option value="Barbecue" <?php echo (("Barbecue" == $purchaseOrder['particulars']) ? 'selected' : '')?>>Barbecue</option>
                                            <option value="Sour Cream" <?php echo (("Sour Cream" == $purchaseOrder['particulars']) ? 'selected' : '')?>>Sour Cream</option>
                                            <option value="Sour Cheese" <?php echo (("Sour Cheese" == $purchaseOrder['particulars']) ? 'selected' : '')?>>Sour Cheese</option>
                                            <option value="Sweetcorn" <?php echo (("Sweetcorn" == $purchaseOrder['particulars']) ? 'selected' : '')?> >Sweetcorn</option>
                                            <option value="Chili Barbeque" <?php echo (("Chili Barbeque" == $purchaseOrder['particulars']) ? 'selected' : '')?>>Chili Barbeque</option>
                                          </optgroup>
                                          <option value="Cooking Oil (20kl)" <?php echo (("Cooking Oil (20kl)" == $purchaseOrder['particulars']) ? 'selected' : '')?>>Cooking Oil (20kl)</option>
                                        </select>
	                            			</div>
											
	                            			<div class="col-lg-2">
                                        <label>QTY</label>
                                        <input type="text" name="qty" class="form-control" value="{{ $purchaseOrder['qty'] }}" />
                                      
	                            			</div>
											
										              	<div class="col-lg-2">
	                            				<label>Unit</label>
                                      <div id="app-unit">
                                        <select class="form-control" name="unit">
                                          <option value="0">--Please Select--</option>
                                          <option v-for="unit in units" v-bind:value="unit.value"
                                            :selected="unit.value=={{ json_encode($purchaseOrder['unit'])}} ? true : false ">
                                              @{{ unit.text }}
                                          </option>
                                        </select>
                                      </div>
	                            			</div>

	                            			<div class="col-lg-2">
                                        <label>Price</label>
                                        <input type="text" name="price" class="form-control" value="{{ $purchaseOrder['price'] }}" />
	                            				
	                            			</div>
										
                                    <div class="col-lg-2">
                                      <label>Subtotal</label>
                                      <input type="text" name="subtotal" class="form-control"  value="{{ $purchaseOrder['subtotal']}}" />
                                      
                                    </div>
                                  </div>
	                            		
	                            	</div>
                                <br>
	                                <div>
	                                    <input type="submit" class="btn btn-success float-right" value="Update" />
	                                </div>
                      			</form>
                          </div>
            		</div>
            	</div>	
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-3">
                         <div class="card-header">
                             <i class="fa fa-plus" aria-hidden="true"></i>
                              Add 
                          </div>
                          <form action="{{ action('MrPotatoController@addNew', $purchaseOrder['id'] )}}" method="post">
                             {{csrf_field()}}
                          <div class="card-body">
                              @if(session('addNewSuccess'))
	                             	<p class="alert alert-success">{{ Session::get('addNewSuccess') }}</p>
	                            @endif
                              <div class="form-group">  
                                  <div class="form-row">
                                      <div class="col-lg-8">
                                          <label>Particulars</label>
                                          <select class="form-control" name="particulars">
                                          <option value="0">--Please Select--</option>
                                          <optgroup label="Containers">
                                            <option value="Small (100’s per pack)" >Small (100’s per pack)</option>
                                            <option value="Medium (25’s per pack)" >Medium (25’s per pack)</option>
                                            <option value="Large (25’s per pack)" >Large (25’s per pack)</option>
                                            <option value="Jumbo (25’s per pack)" >Jumbo (25’s per pack)</option>
                                            <option value="Trio (Barkada) (50’s per pack)" >Trio (Barkada) (50’s per pack)</option>
                                          </optgroup>
                                          <optgroup label="Beverages">
                                            <option value="Bottled Water" >Bottled Water</option>
                                            
                                          </optgroup>
                                          <optgroup label="Fries">
                                            <option value="Aviko (2.5kls) Main Fries">Aviko (2.5kls) Main Fries</option>
                                            <option value="Farm Frite Fries (2kls)" >Farm Frite Fries (2kls)</option>
                                          </optgroup>
                                          <optgroup label="Flavoring">
                                            <option value="Cheese" >Cheese</option>
                                            <option value="Barbecue" >Barbecue</option>
                                            <option value="Sour Cream" >Sour Cream</option>
                                            <option value="Sour Cheese" >Sour Cheese</option>
                                            <option value="Sweetcorn"  >Sweetcorn</option>
                                            <option value="Chili Barbeque" >Chili Barbeque</option>
                                          </optgroup>
                                          <option value="Cooking Oil (20kl)">Cooking Oil (20kl)</option>
                                        </select>
                                      </div>
                                      
                                  </div>
                                  <div class="form-group">
                                      <div class="form-row">
                                          <div class="col-lg-8">
                                              <label>QTY</label>
                                              <input type="text" name="qty" class="form-control"  />
                                            
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <div class="form-row">
                                        <div class="col-lg-8">
                                            <label>Unit</label>
                                            <div id="app-unit1">
                                              <select class="form-control" name="unit">
                                                <option value="0">--Please Select--</option>
                                                <option v-for="unit in units" v-bind:value="unit.value">
                                                    @{{ unit.text }}
                                                </option>
                                              </select>
                                            </div>
                                          </div>
                                      </div>
                                  </div>
                                  @if ($errors->has('price'))
                                    <span class="alert alert-danger">
                                      <strong>{{ $errors->first('price') }}</strong>
                                    </span>
											            @endif
                                  <div class="form-group">
                                      <div class="form-row">
                                          <div class="col-lg-8">
                                              <label>Price</label>
                                              <input type="text" name="price" class="form-control" required="required" />
                                            
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <div class="form-row">
                                          <div class="col-lg-8">
                                            <label>Subtotal</label>
                                            <input type="text" name="subtotal" class="form-control"  value="{{ $purchaseOrder['subtotal']}}" />
                                            
                                          </div>
                                      </div>
                                  </div>
                                  <div>
                                    @if($user->role_type == 1)
                                       <input type="submit" class="btn btn-primary" value="Add" />
                                    @endif
                                   </div>
                              </div>
                              </form>
                          </div>
                    </div>
                </div>
                <div class="col-lg-8">
                     <div class="card mb-3">
                       <div class="card-header">
                           <i class="fab fa-first-order" aria-hidden="true"></i>
                          Purchase Order</div>
                        <div class="card-body">
                               @if(session('SuccessEdit'))
                               <p class="alert alert-success">{{ Session::get('SuccessEdit') }}</p>
                            @endif
                            @foreach($pOrders as $pOrder)
                            <form action="{{ action('MrPotatoController@updatePo', $pOrder['id']) }}" method="post">
                               {{csrf_field()}}
                            <div id="deletedId{{ $pOrder['id']}}">
                            <input name="_method" type="hidden" value="PATCH">
                             <div class="form-group">
                                <div class="form-row">
                                <div  class="form-row">
                                    <div class="col-lg-4">
                                        <label>Particulars</label>
                                        <select class="form-control" name="particulars">
                                          <option value="0">--Please Select--</option>
                                          <optgroup label="Containers">
                                            <option value="Small (100’s per pack)" <?php echo (("Small (100’s per pack)" == $pOrder['particulars']) ? 'selected' : '')?>>Small (100’s per pack)</option>
                                            <option value="Medium (25’s per pack)" <?php echo (("Medium (25’s per pack)" == $pOrder['particulars']) ? 'selected' : '')?>>Medium (25’s per pack)</option>
                                            <option value="Large (25’s per pack)" <?php echo (("Large (25’s per pack)" == $pOrder['particulars']) ? 'selected' : '')?>>Large (25’s per pack)</option>
                                            <option value="Jumbo (25’s per pack)" <?php echo (("Jumbo (25’s per pack)" == $pOrder['particulars']) ? 'selected' : '')?>>Jumbo (25’s per pack)</option>
                                            <option value="Trio (Barkada) (50’s per pack)" <?php echo (("Trio (Barkada) (50’s per pack)" == $pOrder['particulars']) ? 'selected' : '')?>>Trio (Barkada) (50’s per pack)</option>
                                          </optgroup>
                                          <optgroup label="Beverages">
                                            <option value="Bottled Water" <?php echo (("Bottled Water" == $pOrder['particulars']) ? 'selected' : '')?> >Bottled Water</option>
                                            
                                          </optgroup>
                                          <optgroup label="Fries">
                                            <option value="Aviko (2.5kls) Main Fries" <?php echo (("Aviko (2.5kls) Main Fries" == $pOrder['particulars']) ? 'selected' : '')?>>Aviko (2.5kls) Main Fries</option>
                                            <option value="Farm Frite Fries (2kls)" <?php echo (("Farm Frite Fries (2kls)" == $pOrder['particulars']) ? 'selected' : '')?>>Farm Frite Fries (2kls)</option>
                                          </optgroup>
                                          <optgroup label="Flavoring">
                                            <option value="Cheese" <?php echo (("Cheese" == $pOrder['particulars']) ? 'selected' : '')?>>Cheese</option>
                                            <option value="Barbecue" <?php echo (("Barbecue" == $pOrder['particulars']) ? 'selected' : '')?>>Barbecue</option>
                                            <option value="Sour Cream" <?php echo (("Sour Cream" == $pOrder['particulars']) ? 'selected' : '')?>>Sour Cream</option>
                                            <option value="Sour Cheese" <?php echo (("Sour Cheese" == $pOrder['particulars']) ? 'selected' : '')?>>Sour Cheese</option>
                                            <option value="Sweetcorn" <?php echo (("Sweetcorn" == $pOrder['particulars']) ? 'selected' : '')?> >Sweetcorn</option>
                                            <option value="Chili Barbeque" <?php echo (("Chili Barbeque" == $pOrder['particulars']) ? 'selected' : '')?>>Chili Barbeque</option>
                                          </optgroup>
                                          <option value="Cooking Oil (20kl)" <?php echo (("Cooking Oil (20kl)" == $pOrder['particulars']) ? 'selected' : '')?>>Cooking Oil (20kl)</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                      <label>Qty</label>
                                      <input type="text" name="qty" class="form-control" value="{{ $pOrder['qty'] }}" />
                                    
                                    </div>
                                    <div class="col-lg-2">
                                      <label>Unit </label>
                                      <div id="app-unit2">
                                        <select class="form-control" name="unit">
                                          <option value="0">--Please Select--</option>
                                          <option v-for="unit in units" v-bind:value="unit.value"
                                            :selected="unit.value=={{ json_encode($pOrder['unit'])}} ? true : false ">
                                              @{{ unit.text }}
                                          </option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col-lg-2">
                                      <label>Price</label>
                                      <input type="text" name="price" class="form-control" value="{{ $pOrder['price']}}" />
                                     
                                    </div>
                                    <div class="col-lg-2">
                                      <label>Subtotal</label>
                                      <input type="text" name="subtotal" class="form-control" value="{{ $pOrder['subtotal']}}" />
                                     
                                    </div>
                                  
                                  </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-4">
                                            <br>

                                            <input type="hidden" name="poId" value="{{ $purchaseOrder['id'] }}" />
                                            <input type="submit" class="btn btn-success" value="Update" />
                                            @if($user->role_type == 1)
                                            <a id="delete" onClick="confirmDelete('{{ $pOrder['id'] }}')" href="javascript:void" class="btn btn-danger">Remove</a>
                                            @endif
                                        </div> 
                                    </div>
                                </div>
                              </div>
                              </form>
                              @endforeach
                           
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
   const confirmDelete = (id) => {
        const x = confirm("Do you want to delete this?");
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

  new Vue({
	el: '#app-unit1',
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

  new Vue({
	el: '#app-unit2',
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