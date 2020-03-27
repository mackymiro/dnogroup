@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'Delivery Receipt Form| ')
@section('content')

<div id="wrapper">
	<!-- Sidebar -->
     @include('sidebar.sidebar-lolo-pinoy-grill')
     <div id="content-wrapper">
     		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lolo Pinoy Grill Commissary</a>
              </li>
              <li class="breadcrumb-item active">Delivery Receipt Form</li>
            </ol>
            <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoy-grill.jpeg')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lolo Pinoy Grill ">
            	 
            	 <h4 class="text-center"><u>DELIVERY RECEIPT</u></h4>
            </div>
            <div class="row">
         		<div class="col-lg-12">
         			<div class="card mb-3">
         				<div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            Delivery Receipt</div>
                       	 <div class="card-body">
                       	 	<form action="{{ action('LoloPinoyGrillCommissaryController@storeDeliveryReceipt')}}" method="post">
                       	 		{{ csrf_field() }}
                    		<div class="form-group">
                        		<div class="form-row">
                    				<div class="col-md-4">
                    					<label>Delivered To</label>
                    					<input type="text" name="deliveredTo" class="form-control" required="required" />
                    					@if ($errors->has('deliveredTo'))
		                                  <span class="alert alert-danger">
		                                    <strong>{{ $errors->first('deliveredTo') }}</strong>
		                                  </span>
		                                @endif
                    				</div>
                    				<div class="col-md-4">
                    					<label>Address</label>
                    					<input type="text" name="address" class="form-control" />
                    				</div>
                    			
                        			
                        		</div>
                        	</div>
                        	<div class="form-group">
                    			<div class="form-row">
                      				<div class="col-md-2">
                    						<label>Product Id</label>
                    						<select name="productId" class="form-control">
                                    <option value="0">--Please Select--</option>
                                    @foreach($getRawMaterials as $getRawMaterial)
                                    <option value="{{ $getRawMaterial['id']}}-{{ $getRawMaterial['product_id_no']}}">{{ $getRawMaterial['product_id_no']}}</option>
                                    @endforeach
                                </select>
                      				</div>
                        				<div class="col-md-1">
                    						<label>QTY</label>
                    						<input type="text" name="qty" class="form-control" required="required" />
                                
                        				</div>
                        				<div class="col-md-1">
                    						<label>Unit</label>
                                <div id="unitClose">
                    						    <input type="text" name="unit" class="form-control"/>
                                </div>
                                <div id="unit"></div>
                        				</div>
                        				<div class="col-md-4">
                        					<label>Item Description</label>
                                  <div id="itemDescClose">
                        					   <input type="text" name="itemDescription" class="form-control" />
                                  </div>
                                  <div id="itemDesc"></div>
                        				</div>
                        				<div class="col-md-2">
                        					<label>Unit Price</label>
                                  <div id="unitPriceClose">
                        					   <input type="text" name="unitPrice" class="form-control"  />
                                  </div>
                                  <div id="unitPrice"></div>
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
	
<script type="text/javascript">
  $(document).ready(function(){
      $("select").change(function(){
          <?php
            $getRawMaterials = DB::table(
                                  'lolo_pinoy_grill_commissary_raw_materials')
                                  ->where('rm_id', NULL)
                                  ->get(); ?>
          <?php foreach($getRawMaterials as $key=>$getRawMaterial): ?>
              
              var prodId = $(this).children("option:selected").val();
              var prodIdSplit = prodId.split("-");
              var prodArr = prodIdSplit[0];
  
              if(prodArr  == "<?php echo $getRawMaterial->id;?>"){
                    <?php 
                        $getId = DB::table(
                                  'lolo_pinoy_grill_commissary_raw_materials')
                                  ->where('id', $getRawMaterial->id)
                                  ->get();
                    ?>
                     $("#unit").html('<input type="text" name="unit" value="<?php echo $getId[0]->unit?>" class="form-control" readonly="readonly" /> ');
                     $("#unitClose").hide();
                     $("#itemDesc").html('<input type="text" name="itemDescription" value="<?php echo $getId[0]->product_name; ?>" class="form-control" readonly="readonly">')
                     $("#itemDescClose").hide();
                     $("#unitPrice").html('<input type="text" name="unitPrice" value="<?php echo $getId[0]->unit_price; ?>" class="form-control" readonly="readonly" >');
                     $("#unitPriceClose").hide();
                    
                  
              }
          <?php endforeach; ?>           
        
      });
  });
</script>
@endsection