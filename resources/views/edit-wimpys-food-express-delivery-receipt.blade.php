@extends('layouts.wimpys-food-express-app')
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

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css" >
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>


<div id="wrapper">
	 @include('sidebar.sidebar-wimpys-food-express')
	<div id="content-wrapper">
		<div class="container-fluid">
			<!-- Breadcrumbs-->
         <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#">Wimpy's Food Express</a>
            </li>
            <li class="breadcrumb-item active">Edit Delivery Receipt</li>
          </ol>
          <a href="{{ url('wimpys-food-express/delivery-receipt/lists') }}">Back to Lists</a>
          <div class="col-lg-12">
        	 <img src="{{ asset('images/digitized-logos/wimpys-logo1.jpg')}}" width="350" height="178" class="img-responsive mx-auto d-block" alt="Wimpy's Food Express">
             
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
                            <form action="{{ action('WimpysFoodExpressController@updateDeliveryReceipt', $getDeliveryReceipt['id']) }}" method="post">
                            	{{csrf_field()}}
                             <input name="_method" type="hidden" value="PUT">
                             <div class="card-body">
                             	<div class="form-group">
                             		<div class="form-row">
                                 <div class="col-md-2">
                                    <label>Date</label>
                                    <input type="text" name="date" class="datepicker form-control" value="{{ $getDeliveryReceipt['date']}}" />
                                    
                                </div>
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
                              <div class="col-md-4">
	                    					<label>Delivered For </label>
	                    					<input type="text" name="deliveredFor" class="form-control" value="{{ $getDeliveryReceipt['delivered_for']}}" />
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
                                  <input type="text" name="qty" class="qty form-control"  value="{{ $getDeliveryReceipt['qty']}}" 
                                    onkeypress="return isNumber(event)"
                                    onchange="javascript:checkQty()" autocomplete="off" />
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
                                  <input type="text" name="itemDescription" class="form-control"  value="{{ $getDeliveryReceipt['description']}}" readonly="readonly" />
                                </div>
                                <div id="itemDesc"></div>
                              </div>
                    					<div class="col-md-2">
                                <label>Unit Price</label>
                                <div id="unitPriceClose">
                                  <input type="text"  name="unitPrice" class="unitPrice form-control"  value="{{ $getDeliveryReceipt['unit_price']}}"   readonly="readonly"/>
                                </div>
                                <div id="unitPrice"></div>
                              </div>
                              <div class="col-md-2">
                                  <label>Amount</label>
                                  <div class="curAmount">
                                    <input type="text" name="amount" class="form-control"  disabled="disabled"
                                    value="<?= number_format($getDeliveryReceipt['price'], 2)?>" />
                                  </div>
                                  <div class="amountNew"></div>
                              </div>
                             		</div>
                             	</div>
                             	<div class="form-group">
              					  	 		<div class="form-row">
              					  	 			<div class="float-right">
              					  	 				
        					  	 					<button type="submit" class="btn btn-success btn-lg">
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
			  		<div class="col-lg-4">
			  			 <div class="card mb-3">
                    <div class="card-header">
                          <i class="fas fa-plus" aria-hidden="true"></i>
                        Add Delivery Receipt</div>
                        <div class="card-body">
                            @if(session('addDeliveryReceiptSuccess'))
                                <p class="alert alert-success">{{ Session::get('addDeliveryReceiptSuccess') }}</p>
                            @endif 
                            <form action="{{ action('WimpysFoodExpressController@addNewDeliveryReceiptData', $id) }}" method="post"> 
                            {{csrf_field()}}
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
                                        <input type="text" name="qtyAdd" class="qtyAdd form-control" required="required" 
                                        onkeypress="return isNumber(event)"
                                        onchange="javascript:checkQtyAdd()" autocomplete="off"/>
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
                                            <input type="text"  name="unitPrice" class="form-control" disabled />
                                        </div>
                                        <div id="unitPriceAdd"></div>
                                      </div>
                                      <div class="col-md-12">
                                        <label>Amount</label>
                                        <div class="curAmount">
                                            <input type="text" name="amount" class="form-control" disabled />
                                        </div>
                                        <div class="amountNew"></div>
                                      </div>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary btn-lg">Add New</button>
                               
                            </div>
                            </form>
                      </div>
			  			 </div>
			  		</div>
            <div class="col-lg-8">
                  <div class="card mb-3">
                     <div class="card-header">
                        <i class="fas fa-receipt" aria-hidden="true"></i>
                         Delivery Receipt
                      </div>
                      <div class="card-body">
                      @if(session('SuccessEdit'))
                                <p class="alert alert-success">{{ Session::get('SuccessEdit') }}</p>
                            @endif 
                            @foreach($dReceipts as $dReceipt)
                            <form action="{{ action('WimpysFoodExpressController@updateDr', $dReceipt['id'])}}" method="post">
                                {{csrf_field()}}
                            <input name="_method" type="hidden" value="PUT">
                            <div class="form-group">
                              <div id="deletedId{{ $dReceipt['id'] }}" class="form-row">
                                    <div class="col-md-2">
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
                                    <input type="text" name="unit" class="form-control" value="{{ $dReceipt['unit']}}" disabled />
                                  </div>
                                  <div class="col-md-4">
                                    <label>Description</label>
                                    <input type="text" name="description" class="form-control" value="{{ $dReceipt['description']}}" disabled />
                                  </div>
                                  <div class="col-md-2">
                                      <label>Unit Price</label>
                                      <div id="unitPrice2-{{ $dReceipt['id']}}">
                                        <input type="text"  name="unitPrice" class="form-control"  value="{{ $dReceipt['unit_price']}}" disabled/>
                                      </div>
                                      <div id="unitPrice2-{{ $dReceipt['id']}}"></div>
                                  </div>
                                  <div class="col-md-2">
                                      <label>Amount</label>
                                      <input type="text" name="unitPrice" class="form-control"  disabled="disabled"
                                      value="<?= number_format($dReceipt['price'], 2)?>" />
                                  </div>
                                  <div class="col-lg-4">
                                    <br>
                                    <input type="hidden" id="drId" name="drId" value="{{ $getDeliveryReceipt['id'] }}" />
                                    <!--<input type="submit" class="btn btn-success" value="Update" />-->
                                    @if(Auth::user()['role_type'] == 1)
                                    <a id="delete" onClick="confirmDelete('{{ $dReceipt['id'] }}')" href="javascript:void" class="btn btn-danger">Remove</a>
                                    @endif
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

<script>
   const isNumber =(evt) => {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
      }
      return true;
    };

    checkQtyAdd = function(){
      const quantity = parseInt($(".qtyAdd").val());
      if(quantity === 1){
          const unitPrice = parseInt($(".unitPrice").val());
          
          const calc = parseInt(unitPrice) * parseInt(quantity);
          const tot = calc.toFixed();

          $(".curAmount").hide();
          $(".amountNew").html(`<input type="text" name="amount" id="amount" value="${tot}" class="form-control" readonly>`);
     
         
      }else{
          const unitPrice = parseInt($(".unitPrice").val());
          const calc = parseInt(unitPrice) * parseInt(quantity);
          const tot = calc.toFixed();
         
          $(".curAmount").hide();
          $(".amountNew").html(`<input type="text" name="amount" id="amount" value="${tot}" class="form-control" readonly>`);
     
      }
    }


    checkQty = function(){
      const quantity = parseInt($(".qty").val());
     
      if(quantity === 1){
          const unitPrice = parseInt($(".unitPrice").val());
          const calc = parseInt(unitPrice) * parseInt(quantity);
          const tot = calc.toFixed();

          $(".curAmount").hide();
          $(".amountNew").html(`<input type="text" name="amount" id="amount" value="${tot}" class="form-control" readonly>`);
     
         
      }else{
          const unitPrice = parseInt($(".unitPrice").val());
         
          const calc = parseInt(unitPrice) * parseInt(quantity);
          const tot = calc.toFixed();
          
          $(".curAmount").hide();
          $(".amountNew").html(`<input type="text" name="amount" id="amount" value="${tot}" class="form-control" readonly>`);
     
      }
    }

    const confirmDelete = (id) => {
        const x = confirm("Do you want to delete this?");
        const drId = $('#drId').val();
       
          if(x){
              $.ajax({
                type: "DELETE",
                url: '/wimpys-food-express/delete-delivery-receipt/' + id,
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

    $("#productIdAdd").change(function(){
      <?php
        $getRawMaterials = DB::table(
                      'wimpys_food_express_raw_materials')
                      ->where('rm_id', NULL)
                      ->get(); ?>
        <?php foreach($getRawMaterials as $key=>$getRawMaterial): ?>
                var prodId = $(this).children("option:selected").val();
                var prodIdSplit = prodId.split("-");
                var prodArr = prodIdSplit[0];

                if(prodArr  == "<?= $getRawMaterial->id;?>"){
                    <?php 
                        $getId = DB::table(
                                  'wimpys_food_express_raw_materials')
                                  ->where('id', $getRawMaterial->id)
                                  ->get();
                    ?>

                     $("#availableAdd").html('<input type="text" name="available" value="<?= $getId[0]->remaining_stock?>" class="form-control" readonly="readonly" /> ');
                     $("#availableCloseAdd").hide(); 
                     $("#unitAdd").html('<input type="text" name="unit" value="<?= $getId[0]->unit?>" class="form-control" readonly="readonly" /> ');
                     $("#unitCloseAdd").hide();
                     $("#itemDescAdd").html('<input type="text" name="itemDescription" value="<?= $getId[0]->product_name; ?>" class="form-control" readonly="readonly">')
                     $("#itemDescCloseAdd").hide();
                     $("#unitPriceAdd").html('<input type="text"  name="unitPrice" value="<?= $getId[0]->unit_price; ?>" class="unitPrice form-control" readonly="readonly" >');
                     $("#unitPriceCloseAdd").hide();
                }

        <?php endforeach; ?>

    }); 
  
</script>

@endsection