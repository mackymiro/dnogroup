@extends('layouts.mr-potato-app')
@section('title', 'Edit Delivery Receipt |')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
</script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css" >
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<div id="wrapper">
	@include('sidebar.sidebar-ribos-bar')
	<div id="content-wrapper">
		<div class="container-fluid">
			<!-- Breadcrumbs-->
	         <ol class="breadcrumb">
	            <li class="breadcrumb-item">
	              <a href="#">Ribo's Bar</a>
	            </li>
	            <li class="breadcrumb-item active">Edit Delivery Receipt</li>
	          </ol>
	           <a href="{{ url('ribos-bar/delivery-receipt-lists') }}">Back to Lists</a>
	           <div class="col-lg-12">
			   	<img src="{{ asset('images/digitized-logos/ribos-food-corp.png')}}" width="390" height="250" class="img-responsive mx-auto d-block" alt="Rib's Bar">

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
	                            <form action="{{ action('RibosBarController@updateDeliveryReceipt', $getDeliveryReceipt['id']) }}" method="post">
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
												<select  data-live-search="true" id="prod" name="productId" class="selectpicker form-control">
													<?php
														$prodArr = $getDeliveryReceipt['product_id'];
														$prodExp = explode("-", $prodArr);
													?>
													<option value="0">--Please Select--</option>
													@foreach($getRawMaterials as $getRawMaterial)
													<option value="{{ $getRawMaterial->id}}-{{ $getRawMaterial->product_id_no}}" <?= ($prodExp[1] == $getRawMaterial->product_id_no) ? 'selected="selected"' : '' ?>>{{ $getRawMaterial->product_id_no}}</option>
													@endforeach
												</select>
												</div>
			                      			
		                        				<div class="col-md-1">
		                    						<label>QTY</label>
		                    						<input type="text" name="qty" class="form-control" value="{{ $getDeliveryReceipt['qty']}}" />
		                        				</div>
		                        				
												<div class="col-md-2">
													<label>Unit</label>
													<div id="unitClose">
														<input type="text" name="unit" class="form-control"  value="{{ $getDeliveryReceipt['unit']}}" readonly="readonly" />
													</div>
													<div id="unit"></div>
												</div>
		                        				
												<div class="col-md-4">
													<label>Item Description</label>
													<div id="itemDescClose">
																<input type="text" name="itemDescription" class="form-control"  value="{{ $getDeliveryReceipt['item_description']}}" readonly="readonly" />
													</div>
													<div id="itemDesc"></div>
                    							</div>
		                        				
												<div class="col-md-2">
													<label>Unit Price</label>
													<div id="unitPriceClose">
														<input type="text" name="unitPrice" class="form-control"  value="{{ $getDeliveryReceipt['unit_price']}}"   readonly="readonly"/>
													</div>
													<div id="unitPrice"></div>
												</div>
		                        				<div class="col-md-2">
		                        					<label>Amount</label>
		                        					<input type="text" name="unitPrice" class="form-control" value="<?= number_format($getDeliveryReceipt['amount'], 2)?>" disabled="disabled" />
		                        				</div>
		                    					<div class="col-lg-12 float-right">
			                                  	    <br>
				                                    <br>
				                                    <input type="submit" class="btn btn-success btn-lg"  value="Update Purchase Order" />
				                                 </div> 
		                    			</div>
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
								<i class="fas fa-plus" aria-hidden="true"></i>
								Add Delivery Receipt</div>
							<div class="card-body">
							@if(session('addDeliveryReceiptSuccess'))
								<p class="alert alert-success">{{ Session::get('addDeliveryReceiptSuccess') }}</p>
							@endif 
							<form action="{{ action('RibosBarController@addNewDeliveryReceiptData', $id)}}  " method="post">
								{{ csrf_field() }}
								<div class="form-group">
									<div class="form-row">
										<div class="col-md-12">
											<label>Product Id</label>
											<select data-live-search="true" id="productIdAdd" name="productId" class="form-control selectpicker">
												<option value="0">--Please Select--</option>
												@foreach($getRawMaterials as $getRawMaterial)
												<option value="{{ $getRawMaterial->id}}-{{ $getRawMaterial->product_id_no}}">{{ $getRawMaterial->product_id_no}}</option>
												@endforeach
											</select>
										</div>
										<div class="col-md-12">
											<label>QTY</label>
											<input type="text" name="qty" class="form-control" required="required" />
										</div>
										<div class="col-md-12">
										<label>Remaining Stock</label>
										<div id="availableCloseAdd">
											<input type="text" name="available" class="form-control" disabled />
										</div>
										<div id="availableAdd"></div>
										</div>
										<div class="col-md-12">
											<label>Unit</label>
											<div id="unitCloseAdd">
												<input type="text" name="unit" class="form-control" disabled/>
											</div>
											<div id="unitAdd"></div>
										</div>
										<div class="col-md-12">
											<label>Item Description</label>
											<div id="itemDescCloseAdd">
												<input type="text" name="itemDescription" class="form-control" disabled />
											</div>
											<div id="itemDescAdd"></div>
										</div>
										<div class="col-md-12">
											<label>Unit Price</label>
											<div id="unitPriceCloseAdd">
												<input type="text" name="unitPrice" class="form-control" disabled />
											</div>
											<div id="unitPriceAdd"></div>
										</div>
										
									</div>
								</div>
								<div>
								@if(Auth::user()['role_type'] == 1)
								<button type="submit" class="btn btn-primary btn-lg">Add New</button>
								@endif
								</div>
								</form>
							</div>
						</div>
					</div>
	      			<div class="col-lg-8">
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
		                       		<form action="{{ action('RibosBarController@updateDr', $dReceipt['id']) }}" method="post">
	                       			 {{csrf_field()}}
                           			 <input name="_method" type="hidden" value="PATCH">
                           			<div id="deletedId{{ $dReceipt['id']}}">
		                       		<div class="form-group">
		                    			<div class="form-row">
		                					<div class="col-lg-2">
		                						<label>Product Id</label>
												<select data-live-search="true" name="productId" class="product-{{ $dReceipt['id']}} form-control selectpicker">
                                                    <?php
                                                        $prodArr = $dReceipt['product_id'];
                                                        $prodExp = explode("-", $prodArr);
                                                        
                                                    ?>
                                                    <option value="0">--Please Select--</option>
                                                   @foreach($getRawMaterials as $getRawMaterial)
                                                       <option value="{{ $getRawMaterial->id}}-{{ $getRawMaterial->product_id_no}}" <?= ($prodExp[1] == $getRawMaterial->product_id_no) ? 'selected="selected"' : '' ?>>{{ $getRawMaterial->product_id_no}}</option>
                                                    @endforeach
                                                </select>

											</div>
			                      			
		                    				<div class="col-md-1">
		                						<label>QTY</label>
		                						<input type="text" name="qty" class="form-control" value="{{ $dReceipt['qty']}}" />
		                    				</div>
		                    				
											<div class="col-md-2">
                                                <label>Unit</label>
                                                <div id="unitClose2-{{ $dReceipt['id']}}">
                                                <input type="text" name="unit" class="form-control"  value="{{ $dReceipt['unit']}}" disabled />
                                                </div>
                                                <div id="unit2-{{ $dReceipt['id']}}"></div>
                                            </div>
		                    				
											<div class="col-md-4">
                                                <label>Item Description</label>
                                                <div id="itemDescClose2-{{ $dReceipt['id']}}">
                                                  <input type="text" name="itemDescription" class="form-control"  value="{{ $dReceipt['item_description']}}" disabled/>
                                                </div>
                                                 <div id="itemDesc2-{{ $dReceipt['id']}}"></div>
                                            </div>
		                    				
											<div class="col-md-2">
                                                <label>Unit Price</label>
                                                <div id="unitPrice2-{{ $dReceipt['id']}}">
                                                 <input type="text" name="unitPrice" class="form-control"  value="{{ $dReceipt['unit_price']}}" disabled/>
                                                </div>
                                                <div id="unitPrice2-{{ $dReceipt['id']}}"></div>
                                            </div>
		                    				 <div class="col-md-2">
		                                        <label>Amount</label>
		                                        <input type="text" name="unitPrice" class="form-control"  disabled="disabled"
		                                        value="<?= number_format($dReceipt['amount'], 2)?>" />
		                                    </div>
		                    			</div>
		                			 </div>
		                			 <div  class="form-group">
		                                <div class="form-row">
		                                     <div class="col-lg-4">
		                                      <br>
		                                      <input type="hidden" name="drId" value="{{ $getDeliveryReceipt['id'] }}" />
		                                      <!--<input type="submit" class="btn btn-success" value="Update" />-->
		                                      @if(Auth::user()['role_type'] == 1)
		                                      <a id="delete" onClick="confirmDelete('{{ $dReceipt['id'] }}')" href="javascript:void" class="btn btn-danger">Remove</a>
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
	 $("#productIdAdd").change(function(){
		<?php
			$getRawMaterials = DB::table(
							'ribos_bar_raw_materials')
							->where('rm_id', NULL)
							->get(); ?>

		  <?php foreach($getRawMaterials as $key=>$getRawMaterial): ?>
				var prodId = $(this).children("option:selected").val();
                var prodIdSplit = prodId.split("-");
                var prodArr = prodIdSplit[0];
				if(prodArr  == "<?= $getRawMaterial->id;?>"){
					<?php 
                        $getId = DB::table(
                                  'ribos_bar_raw_materials')
                                  ->where('id', $getRawMaterial->id)
                                  ->get();
                    ?>
					 $("#availableAdd").html('<input type="text" name="available" value="<?= $getId[0]->remaining_stock?>" class="form-control" readonly="readonly" /> ');
                     $("#availableCloseAdd").hide(); 
                     $("#unitAdd").html('<input type="text" name="unit" value="<?= $getId[0]->unit?>" class="form-control" readonly="readonly" /> ');
                     $("#unitCloseAdd").hide();
                     $("#itemDescAdd").html('<input type="text" name="itemDescription" value="<?= $getId[0]->product_name; ?>" class="form-control" readonly="readonly">')
                     $("#itemDescCloseAdd").hide();
                     $("#unitPriceAdd").html('<input type="text" name="unitPrice" value="<?= $getId[0]->unit_price; ?>" class="form-control" readonly="readonly" >');
                     $("#unitPriceCloseAdd").hide();
				}


		  <?php endforeach; ?>
	 }); 

	 $(document).ready(function(){
		$("#prod").change(function(){
			<?php
                   $getRawMaterials = DB::table(
                                  'ribos_bar_raw_materials')
                                  ->where('rm_id', NULL)
                                  ->get(); ?>
			<?php foreach($getRawMaterials as $key=>$getRawMaterial): ?>
				  var prodId = $(this).children("option:selected").val();
                  var prodIdSplit = prodId.split("-");
                  var prodArr = prodIdSplit[0];
				  if(prodArr  == "<?= $getRawMaterial->id;?>"){
					<?php 
                        $getId = DB::table(
                                  'ribos_bar_raw_materials')
                                  ->where('id', $getRawMaterial->id)
                                  ->get();
                    ?>
					$("#unit").html('<input type="text" name="unit" value="<?= $getId[0]->unit?>" class="form-control" readonly="readonly" /> ');
                     $("#unitClose").hide();
                     $("#itemDesc").html('<input type="text" name="itemDescription" value="<?= $getId[0]->product_name; ?>" class="form-control" readonly="readonly">')
                     $("#itemDescClose").hide();
                     $("#unitPrice").html('<input type="text" name="unitPrice" value="<?= $getId[0]->unit_price; ?>" class="form-control" readonly="readonly" >');
                     $("#unitPriceClose").hide();
                                
                 
				  }
			<?php endforeach; ?>
		});
	});	

	 const confirmDelete = (id) =>{
        var x = confirm("Do you want to delete this?");
        if(x){
            $.ajax({
              type: "DELETE",
              url: '/ribos-bar/delete-delivery-receipt/' + id,
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