@extends('layouts.dno-food-ventures-app')
@section('title', 'Delivery Receipt Form| ')
@section('content')
<script>
 
  $(function() {
    $( ".datepicker" ).datepicker();
  });
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css" >
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>



<div id="wrapper">
	<!-- Sidebar -->
     @include('sidebar.sidebar-dno-food-ventures')
     <div id="content-wrapper">
     		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">DNO Food Ventures</a>
              </li>
              <li class="breadcrumb-item active">Delivery Receipt Form</li>
            </ol>
            <div class="col-lg-12">
            <img src="{{ asset('images/digitized-logos/dno-food-venture.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="DNO Food Ventures">
            	 
            	 <h4 class="text-center"><u>DELIVERY RECEIPT</u></h4>
            </div>
            <div class="row">
         		<div class="col-lg-12">
         			<div class="card mb-3">
         				<div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            Delivery Receipt</div>
                       	 <div class="card-body">
                       	 	<form action="{{ action('DnoFoodVenturesController@storeDeliveryReceipt')}}" method="post">
                       	 		{{ csrf_field() }}
                    		<div class="form-group">
                        		<div class="form-row">
                            <div class="col-md-2">
                                <label>Date</label>
                                <input type="text" name="date" class="datepicker form-control" required="required" />
                              
                              </div>
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
                              <div class="col-md-4">
                                <label>Charge to</label>
                                <input type="text" name="chargeTo" class="form-control" />
                              </div>
                              <div class="col-lg-4">
                                      <label>Address To</label>
                                      <input type="text" name="addressTo" class="form-control" />
                                  </div>
                              </div>
                        	</div>
                        
                          
                        	<div class="form-group">
                            <div class="form-row">
                                <div class="col-md-2">
                                  <label>Product Id</label>
                                  <select data-live-search="true" name="productId" class="selectpicker form-control">
                                      <option value="0">--Please Select--</option>
                                      @foreach($getRawMaterials as $getRawMaterial)
                                        <option value="{{ $getRawMaterial->id}}-{{ $getRawMaterial->raw_material_product->product_id_no}}">{{ $getRawMaterial->raw_material_product->product_id_no}}</option>
                                      @endforeach
                                  </select>
                                </div>
                                 
                                  <div class="col-md-1">
                                    <label>QTY</label>
                                    <input type="text" name="qty" class="form-control"  onkeypress="return isNumber(event)"/>
                                    
                                  </div>
                                  <div class="col-md-4">
                                     <label>Remaining Stock</label>
                                    <div id="availableClose">
                                      <input type="text" name="available" class="form-control" disabled />
                                    </div>
                                    <div id="available"></div>
                                  </div>
                                  <div class="col-md-1">
                                    <label>Unit</label>
                                    <div id="unitClose">
                                        <input type="text" name="unit" class="form-control" disabled/>
                                    </div>
                                    <div id="unit"></div>
                                  </div>
                                  <div class="col-md-4">
                                    <label>Item Description</label>
                                    <div id="itemDescClose">
                                      <input type="text" name="itemDescription" class="form-control" disabled />
                                    </div>
                                    <div id="itemDesc"></div>
                                  </div>
                                  <div class="col-md-2">
                                    <label>Unit Price</label>
                                    <div id="unitPriceClose">
                                      <input type="text" name="unitPrice" class="form-control"  disabled />
                                    </div>
                                    <div id="unitPrice"></div>
                                  </div>
                              
                            </div>
                        	</div>
                        	<div>
                          <button type="submit" class="btn btn-success btn-lg float-right"><i class="fas fa-save"></i> Save Delivery Receipt</button>
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
<script> 
  const isNumber =(evt) => {
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}

  $(document).ready(function(){
      $("select").change(function(){
          <?php
            $getRawMaterials = DB::table(
                                  'dno_food_ventures_raw_materials')
                                  ->where('rm_id', NULL)
                                  ->get(); ?>
          <?php foreach($getRawMaterials as $key=>$getRawMaterial): ?>
              
              var prodId = $(this).children("option:selected").val();
              var prodIdSplit = prodId.split("-");
              var prodArr = prodIdSplit[0];
  
              if(prodArr  === "<?= $getRawMaterial->id;?>"){
                    console.log(prodArr);
                    <?php 
                        $getId = DB::table(
                                  'dno_food_ventures_raw_materials')
                                  ->where('id', $getRawMaterial->id)
                                  ->get();
                    ?>
                     $("#available").html('<input type="text" name="available" value="<?= $getId[0]->remaining_stock?>" class="form-control" readonly="readonly" /> ');
                     $("#availableClose").hide(); 
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
</script>
@endsection