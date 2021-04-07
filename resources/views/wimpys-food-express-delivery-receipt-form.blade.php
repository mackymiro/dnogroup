@extends('layouts.wimpys-food-express-app')
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
                    					<input type="text" name="date" class="datepicker  form-control" autocomplete="off" />
                    					
                    				</div>
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
                                        <input type="text" name="dateDelivered" class="datepicker form-control" />
                                    </div>
                    				<div class="col-md-4">
                    					<label>Delivered To</label>
                    					<input type="text" name="deliveredTo" class="form-control" />
                    				</div>
                                    <div class="col-md-4">
                        				<label>Contact Person</label>
                        				<input type="text" name="contactPerson" class="form-control" />
                        			</div>
                                    <div class="col-md-2">
                        				<label>Mobile #</label>
                        				<input type="" name="mobile" class="form-control" />
                        			</div>
                        		</div>
                        	</div>
                        	<div class="form-group">
                        		<div class="form-row">
                        			
                        			
                        			<div class="col-md-4">
                        				<label>Special Instruction/Request</label>
                        				<input type="text" name="specialInstruction" class="form-control" />
                        			</div>
                                    <div class="col-md-4">
                        				<label>Delivered For:</label>
                        				<input type="text" name="deliveredFor" class="form-control" />
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
                                    <div class="col-md-2">
                                    <label>Product Id</label>
                                    <select data-live-search="true" name="productId" class="selectpicker form-control">
                                        <option value="0">--Please Select--</option>
                                        @foreach($getRawMaterials as $getRawMaterial)
                                            <option value="{{ $getRawMaterial->id}}-{{ $getRawMaterial->product_id_no}}">{{ $getRawMaterial->product_id_no}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                    				<div  class="col-md-1">
                						<label>QTY</label>
                                        <div id="qtyclose">
                						<input type="text" name="qty" class="form-control" disabled 
                                         />
                                         </div>
                                         <div id="qty"></div>
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
                                    <div class="col-md-2">
                    					<label>Amount</label>
                                        <div id="amountClose">
                                            <input type="text" name="amount" class="form-control"  disabled />
                                        </div>
                                        <div id="amount"></div>
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
<script>
    const isNumber =(evt) => {
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	};


    checkQty = function(){
       const quantity = parseInt($("#qtyInput").val());
      
        if(quantity === 1){
            const unitPrice = parseInt($("#uPrice").val());
            const calc = parseInt(unitPrice) * parseInt(quantity);
            const tot = calc.toFixed();
           
            $("#amountClose").hide();
            $("#amount").html(`<input type="text" name="amount" id="amount" value="${tot}" class="form-control" readonly>`);
        }else{
            const unitPrice = parseInt($("#uPrice").val());
            const calc = parseInt(unitPrice) * parseInt(quantity);
            const tot = calc.toFixed();

            $("#amountClose").hide();
            $("#amount").html(`<input type="text" name="amount" id="amount" value="${tot}" class="form-control" readonly>`);
   
        }
       

    }

    $("select").change(function(){
        <?php
            $getRawMaterials = DB::table(
                                  'wimpys_food_express_raw_materials')
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
                                  'wimpys_food_express_raw_materials')
                                  ->where('id', $getRawMaterial->id)
                                  ->get();
                    ?>
                     $("#qtyclose").hide();
                     $("#qty").html(`
                        
                        <input type="text" id="qtyInput" name="qtyInput" class="form-control" onkeypress="return isNumber(event)"  autocomplete="off"
                        onchange="javascript:checkQty()" />
                     `)
                    
                     $("#available").html('<input type="text" name="available" value="<?= $getId[0]->remaining_stock?>" class="form-control" readonly="readonly" /> ');
                     $("#availableClose").hide();       
                     $("#unit").html('<input type="text" name="unit" value="<?= $getId[0]->unit?>" class="form-control" readonly="readonly" /> ');
                     $("#unitClose").hide();
                     $("#itemDesc").html('<input type="text" name="itemDescription" value="<?= $getId[0]->product_name; ?>" class="form-control" readonly="readonly">')
                     $("#itemDescClose").hide();
                     $("#unitPrice").html('<input type="text" id="uPrice" name="uPrice" value="<?= $getId[0]->unit_price; ?>" class="form-control" readonly="readonly" >');
                     $("#unitPriceClose").hide();       

                }

            <?php endforeach;?>
    });


</script>
@endsection