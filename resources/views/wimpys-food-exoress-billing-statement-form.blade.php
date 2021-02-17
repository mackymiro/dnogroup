@extends('layouts.wimpys-food-express-app')
@section('title', 'Billing Statement Form |')
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
    @include('sidebar.sidebar-wimpys-food-express')
    <div id="content-wrapper">
      <form action="{{ action('WimpysFoodExpressController@storeBillingStatement') }}" method="post">
          {{csrf_field()}}
    	<div class="container-fluid">
    		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Wimpy's Food Express</a>
              </li>
              <li class="breadcrumb-item active">Billing Statement Form</li>
            </ol>
            <div class="col-lg-12">
            <img src="{{ asset('images/digitized-logos/wimpys-logo1.jpg')}}" width="350" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
             
            	 <h4 class="text-center"><u>BILLING STATEMENT</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            Billing Statement</div>
                          <div class="card-body">
                          <div class="form-group">
                              <div class="form-row">
                                <div class="col-lg-2">
                                    <label>Bill To</label>
                                    <input type="text" name="billTo" class="form-control" required="required" />
                                    @if ($errors->has('billTo'))
                                        <span class="alert alert-danger">
                                          <strong>{{ $errors->first('billTo') }}</strong>
                                        </span>
                                    @endif
                                </div>	
                              <div class="col-lg-2">
                                <label>Date</label>
                                <input type="text" name="date" class="datepicker form-control" required="required" />
                                @if ($errors->has('date'))
                                  <span class="alert alert-danger">
                                    <strong>{{ $errors->first('date') }}</strong>
                                  </span>
                                  @endif
                              </div>
                              <div class="col-lg-4">
                                <label>Address</label>
                                <input type="text" name="address" class="form-control" required="required" />
                                @if ($errors->has('address'))
                                    <span class="alert alert-danger">
                                      <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                  @endif
                              </div>
                              <div class="col-lg-4">
                                <label>Period Covered</label>
                                <input type="text" name="periodCovered" class="form-control" required="required" />
                                 @if ($errors->has('periodCovered'))
                                    <span class="alert alert-danger">
                                      <strong>{{ $errors->first('periodCovered') }}</strong>
                                    </span>
                                  @endif
                              </div>
                            </div>
                    	 		</div>
                          <div class="form-group">
                            <div class="form-row">
                              <div class="col-lg-2">
                                  <label>Terms</label>
                                  <input type="text" name="terms" class="form-control" required="required" />
                                  @if ($errors->has('terms'))
                                  <span class="alert alert-danger">
                                      <strong>{{ $errors->first('terms') }}</strong>
                                  </span>
                                  @endif
                              </div>
                              </div>
                    	 		</div>
                        <div class="form-group">
                            <div class="form-row">
            	 						<div class="col-lg-2">
        	 								<label>Date</label>
        	 								<input type="text" name="transactionDate" class="datepicker form-control" required="required"  />
        	 								@if ($errors->has('transactionDate'))
                            <span class="alert alert-danger">
                              <strong>{{ $errors->first('transactionDate') }}</strong>
                            </span>
                          @endif
            	 						</div>
                                      
                        <div class="col-lg-2">
                          <label>Order </label>
                          <select name="choose" class="chooseOption form-control" >
                            <option value="Client Booking Form">Client Booking Form</option>
                            <option value="DR">DR</option> 
                            </select>
                        
                        </div>
                        <div id="cbf" class="col-lg-2">
                            <label>CBF #</label>
                            <select data-live-search="true" name="cbf" class="cbfSelect form-control selectpicker">
                              <option value="0">--Please Select--</option>
                              @foreach($getAllCbfs as $getAllCbf)
                                <option value="{{ $getAllCbf->wimpys_food_express_code}}">{{ $getAllCbf->wimpys_food_express_code}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div  id="dateOfEvent" class="col-lg-2">
        	 								<label>Date Of Event</label>
        	 								<input type="text" name="dateOfEvent" class="form-control" disabled/>
        	 							
                        </div>
                        <div  id="timeOfEvent" class="col-lg-2">
        	 								<label>Time Of Event</label>
        	 								<input type="text" name="timeOfEvent" class="form-control" disabled/>
        	 							
                        </div>
                        <div  id="noOfPax" class="col-lg-2">
        	 								<label>No Of People (Pax)</label>
        	 								<input type="text" name="noOfPax" class="form-control" disabled />
        	 							
                        </div>
                        <div  id="motiff" class="col-lg-2">
        	 								<label>Motiff</label>
        	 								<input type="text" name="motiff" class="form-control" disabled />
        	 							
                        </div>
                        <div  id="typeOfPackage" class="col-lg-4">
        	 								<label>Type Of Package</label>
        	 								<input type="text" name="typeOfPackage" class="form-control" disabled />
        	 							
                        </div>
                        <div  id="client" class="col-lg-4">
        	 								<label>Client</label>
        	 								<input type="text" name="client" class="form-control" disabled />
        	 							
                        </div>
                        <div  id="placeOfEvent" class="col-lg-4">
        	 								<label>Place Of Event</label>
        	 								<input type="text" name="placeOfEvent" class="form-control" disabled />
        	 							
                        </div>
                        <div  id="totalAmount" class="col-lg-2">
        	 								<label>Total Amount</label>
        	 								<input type="text" name="totalAmount" class="form-control" disabled />
        	 							
                        </div>
                        <div id="drNo" class="col-lg-2">
                            <label>DR #</label>
                            <select data-live-search="true" name="drNo" class="drSelect form-control selectpicker">
                              <option value="0">--Please Select--</option>
                              @foreach($drNos as $drNo)
                              <option value="{{ $drNo->wimpys_food_express_code}}">{{ $drNo->wimpys_food_express_code}}</option>
                              @endforeach
                            </select>	
                        </div>
                        <div id="drList" class="col-lg-2">
                            <label>DR Lists Id</label>
                            <select id="dataList" name="drList" class="chooseDr form-control "> 
                            </select>
                        </div>
										    <div id="qty" class="col-lg-4">
        	 								<label>Qty</label>
        	 								<input type="text" name="qty" class="form-control" disabled/>
        	 							
                        </div>
										      <div id="unit" class="col-lg-2">
            	 							<label>Unit</label>
            	 							<input type="text" name="unit" class="form-control" disabled/>
            	 							
            	 						</div>
                           <div id="description" class="col-lg-4">
            	 							<label>Description</label>
            	 							<input type="text" name="description" class="form-control" disabled/>
            	 							
            	 						</div>
            	 						<div id="price" class="col-lg-2">
            	 							<label>Price</label>
            	 							<input type="text" name="price" class="form-control" disabled/>
            	 							
            	 						</div>	
                	 				</div>
                	 				 <br>
                              <div>
                                <button type="submit" class="btn btn-success btn-lg float-right"><i class="fas fa-save"></i> Save Billing</button>
                              </div>
                    	 		</div>
                          </div>
                    </div>
                </div>
            </div>
            
           
    	</div>
     </form>  
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

  const ORDER_FORM = "Client Booking Form";
  const ORDER_FORM_DR = "DR"; 

  $("#drNo").hide();
  $("#drList").hide();
  $("#qty").hide();
  $("#unit").hide();
  $("#description").hide();
  $("#price").hide();

  $(".chooseOption").change(function(){
      const cat  = $(this.options[this.selectedIndex]).closest('option:selected').val();
      if(cat === ORDER_FORM){
          $("#cbf").show();
          $("#dateOfEvent").show();
          $("#timeOfEvent").show();
          $("#noOfPax").show();
          $("#motiff").show();
          $("#typeOfPackage").show();
          $("#client").show();
          $("#placeOfEvent").show();
          $("#totalAmount").show();

          $("#drNo").hide();
          $("#drList").hide();
          $("#qty").hide();
          $("#unit").hide();
          $("#description").hide();
          $("#price").hide();

      }else if(cat === ORDER_FORM_DR){
          $("#drNo").show();
          $("#drList").show();
          $("#qty").show();
          $("#unit").show();
          $("#description").show();
          $("#price").show();


          $("#cbf").hide();
          $("#dateOfEvent").hide();
          $("#timeOfEvent").hide();
          $("#noOfPax").hide();
          $("#motiff").hide();
          $("#typeOfPackage").hide();
          $("#client").hide();
          $("#placeOfEvent").hide();
          $("#totalAmount").hide();
      } 
  });

  $(".cbfSelect").change(function(){
      <?php
         $moduleName = "Client Booking";
         $clientBookings =  DB::table(
                          'wimpys_food_express_client_booking_forms')
                          ->select(
                              'wimpys_food_express_client_booking_forms.id',
                              'wimpys_food_express_client_booking_forms.user_id',
                              'wimpys_food_express_client_booking_forms.bf_id',
                              'wimpys_food_express_client_booking_forms.date_of_event',
                              'wimpys_food_express_client_booking_forms.time_of_event',
                              'wimpys_food_express_client_booking_forms.no_of_people',
                              'wimpys_food_express_client_booking_forms.motiff',
                              'wimpys_food_express_client_booking_forms.qty',
                              'wimpys_food_express_client_booking_forms.amount',
                              'wimpys_food_express_client_booking_forms.type_of_package',
                              'wimpys_food_express_client_booking_forms.total',
                              'wimpys_food_express_client_booking_forms.client',
                              'wimpys_food_express_client_booking_forms.place_of_event',
                              'wimpys_food_express_client_booking_forms.mobile_number',
                              'wimpys_food_express_client_booking_forms.email',
                              'wimpys_food_express_client_booking_forms.special_requests',
                              'wimpys_food_express_client_booking_forms.menu',
                              'wimpys_food_express_client_booking_forms.deleted_at',
                              'wimpys_food_express_codes.wimpys_food_express_code',
                              'wimpys_food_express_codes.module_id',
                              'wimpys_food_express_codes.module_code',
                              'wimpys_food_express_codes.module_name')
                          ->join('wimpys_food_express_codes', 'wimpys_food_express_client_booking_forms.id', '=', 'wimpys_food_express_codes.module_id')
                          ->where('wimpys_food_express_client_booking_forms.bf_id', NULL)
                          ->where('wimpys_food_express_client_booking_forms.deleted_at', NULL)
                          ->where('wimpys_food_express_codes.module_name', $moduleName)
                          ->get()->toArray();  
      ?>
       const cb = $(this).children("option:selected").val();
        <?php foreach($clientBookings as $clientBooking): ?>
            if(cb ==="<?= $clientBooking->wimpys_food_express_code?>" ){
                $("#dateOfEvent").html('<label>Date Of Event</label><input type="text"  name="dateOfEvent" value="<?= $clientBooking->date_of_event; ?>" class="form-control" readonly="readonly" />');
                $("#timeOfEvent").html('<label>Time Of Event</label><input type="text"  name="timeOFEvent" value="<?= $clientBooking->time_of_event; ?>" class="form-control" readonly="readonly" />');
                $("#noOfPax").html('<label>No Of People(Pax)</label><input type="text"  name="noOfPax" value="<?= $clientBooking->no_of_people; ?>" class="form-control" readonly="readonly" />');
                $("#motiff").html('<label>Motiff</label><input type="text"  name="motiff" value="<?= $clientBooking->motiff; ?>" class="form-control" readonly="readonly" />');
                $("#typeOfPackage").html('<label>Type Of Package</label><input type="text"  name="typeOfPackage" value="<?= $clientBooking->type_of_package; ?>" class="form-control" readonly="readonly" />');
                $("#client").html('<label>Client</label><input type="text"  name="client" value="<?= $clientBooking->client; ?>" class="form-control" readonly="readonly" />');
                $("#placeOfEvent").html('<label>Place Of Event</label><input type="text" name="placeOfEvent" value="<?= $clientBooking->place_of_event; ?>" class="form-control" readonly="readonly" />');
                $("#totalAmount").html('<label>Total Amount</label><input type="text" name="totalAmount" value="<?= $clientBooking->total; ?>" class="form-control" readonly="readonly" />');
               
            }
             
        <?php endforeach; ?>

        
  });


  $(".drSelect").change(function(){
      <?php
           $moduleName = "Delivery Receipt"; 
           $getDrNos = DB::table(
                      'wimpys_food_express_delivery_receipts')
                      ->select( 
                      'wimpys_food_express_delivery_receipts.id',
                      'wimpys_food_express_delivery_receipts.user_id',
                      'wimpys_food_express_delivery_receipts.dr_id',
                      'wimpys_food_express_delivery_receipts.sold_to',
                      'wimpys_food_express_delivery_receipts.dr_no',
                      'wimpys_food_express_delivery_receipts.delivered_to',
                      'wimpys_food_express_delivery_receipts.time',
                      'wimpys_food_express_delivery_receipts.date',
                      'wimpys_food_express_delivery_receipts.unit',
                      'wimpys_food_express_delivery_receipts.date_to_be_delivered',
                      'wimpys_food_express_delivery_receipts.contact_person',
                      'wimpys_food_express_delivery_receipts.mobile_num',
                      'wimpys_food_express_delivery_receipts.qty',
                      'wimpys_food_express_delivery_receipts.description',
                      'wimpys_food_express_delivery_receipts.price',
                      'wimpys_food_express_delivery_receipts.total',
                      'wimpys_food_express_delivery_receipts.special_instruction',
                      'wimpys_food_express_delivery_receipts.consignee_name',
                      'wimpys_food_express_delivery_receipts.consignee_contact_num',
                      'wimpys_food_express_delivery_receipts.status',
                      'wimpys_food_express_delivery_receipts.prepared_by',
                      'wimpys_food_express_delivery_receipts.checked_by',
                      'wimpys_food_express_delivery_receipts.received_by',
                      'wimpys_food_express_delivery_receipts.created_by',
                      'wimpys_food_express_delivery_receipts.deleted_at',
                      'wimpys_food_express_codes.wimpys_food_express_code',
                      'wimpys_food_express_codes.module_id',
                      'wimpys_food_express_codes.module_code',
                      'wimpys_food_express_codes.module_name')
                      ->join('wimpys_food_express_codes', 'wimpys_food_express_delivery_receipts.id', '=', 'wimpys_food_express_codes.module_id')
                      ->where('wimpys_food_express_delivery_receipts.dr_id', NULL)
                      ->where('wimpys_food_express_delivery_receipts.deleted_at', NULL)
                      ->where('wimpys_food_express_codes.module_name', $moduleName)
                  
                      ->get()->toArray();

      ?>
       const dr = $(this).children("option:selected").val();
       <?php foreach($getDrNos as $getDrNo ): ?>
             if(dr === "<?= $getDrNo->wimpys_food_express_code?>"){
                 <?php 
                    $getDrNosInsides = DB::table(
                                    'wimpys_food_express_delivery_receipts')
                                    ->where('dr_no', $getDrNo->dr_no)
                                    ->get(); ?>
                  <?php foreach($getDrNosInsides as $getDrNosInside):?>
                      $("#dataList").append(  
                            `<option value="<?php echo $getDrNosInside->id?>"><?= $getDrNosInside->id?></option>
                            `);
                      $(".chooseDr").change(function(){
                          const cat  = $(this.options[this.selectedIndex]).closest('option:selected').val();
                          <?php
                            $datas  = DB::table(
                                  'wimpys_food_express_delivery_receipts')
                                  ->where('id', $getDrNosInside->id)
                                  ->get(); ?>

                             <?php foreach($datas as $data): ?>
                                  if(cat === "<?= $data->id?>"){
                                      $("#qty").html('<label>Qty</label><input type="text" name="qty" value="<?= $data->qty; ?>" class="form-control" readonly="readonly" />');
                                      $("#unit").html('<label>Unit</label><input type="text" name="unit" value="<?= $data->unit; ?>" class="form-control" readonly="readonly" />');
                                      $("#description").html('<label>Description</label><input type="text" name="description" value="<?= $data->description; ?>" class="form-control" readonly="readonly" />');
                                      $("#price").html(`<label>Price</label><input type="text" name="price" value="<?= $data->price; ?>" class="form-control" readonly="readonly" />`);
                                         
                                  }

                             <?php endforeach; ?>
                        
                      });
                        
                  <?php endforeach; ?>
                  $("#qty").html('<label>Qty</label><input type="text" name="qty" value="<?= $data->qty; ?>" class="form-control" readonly="readonly" />');
                  $("#unit").html('<label>Unit</label><input type="text" name="unit" value="<?= $data->unit; ?>" class="form-control" readonly="readonly" />');
                  $("#description").html('<label>Description</label><input type="text" name="description" value="<?= $data->description; ?>" class="form-control" readonly="readonly" />');
                  $("#price").html(`<label>Price</label><input type="text" name="price" value="<?= $data->price; ?>" class="form-control" readonly="readonly" />`);
                                   

             }
       <?php endforeach;?>

  });
</script>
@endsection