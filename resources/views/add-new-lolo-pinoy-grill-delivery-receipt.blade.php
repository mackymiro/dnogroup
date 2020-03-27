@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'Add New Delivery Receipt |')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
</script>
<div id="wrapper">
	 @include('sidebar.sidebar-lolo-pinoy-grill')
	 <div id="content-wrapper">
	 	<div class="container-fluid">
	 		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lolo Pinoy Grill Commissary</a>
              </li>
              <li class="breadcrumb-item active">Add New Delivery Receipt</li>
            </ol>
             <div class="row">
             		<div class="col-lg-12">
             			<div class="card mb-3">
         					<div class="card-header">
      						  <i class="fa fa-receipt" aria-hidden="true"></i>
      						  Add New</div>
      						  <div class="card-body">
      						  	@if(session('addDeliveryReceiptSuccess'))
			                     <p class="alert alert-success">{{ Session::get('addDeliveryReceiptSuccess') }}</p>
			                    @endif 
      						  <form action="{{ action('LoloPinoyGrillCommissaryController@addNewDeliveryReceiptData', $id)}}" method="post">
      						  	{{csrf_field()}}
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
		                	<div class="form-group">
					   			<div class="form-row">
					   				<div class="col-lg-12 float-right">
			  							<input type="submit" class="btn btn-success" value="Add" />
			  							<br>
			  							<br>
			  							<br>
			  							<a href="{{ url('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-delivery-receipt/'.$id) }}">Back</a>
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