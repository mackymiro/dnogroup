@extends('layouts.ribos-bar-app')
@section('title', 'Edit Billing Statement |')
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
     @include('sidebar.sidebar-ribos-bar')
     <div id="content-wrapper"> 
     	<div class="container-fluid">
     		<!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Ribo's Bar</a>
              </li>
              <li class="breadcrumb-item active">Update Billing Statement Form</li>
            </ol>
             <a href="{{ url('ribos-bar/billing-statement-lists') }}">Back to Lists</a>
             <div class="col-lg-12">
              <img src="{{ asset('images/digitized-logos/ribos-food-corp.png')}}" width="390" height="250" class="img-responsive mx-auto d-block" alt="Rib's Bar">
            
            	 <h4 class="text-center"><u>BILLING STATEMENT/COLLECTION STATEMENT</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                         <div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            Edit Billing Statement</div>
                          <div class="card-body">
                                 @if(session('SuccessE'))
                                     <p class="alert alert-success">{{ Session::get('SuccessE') }}</p>
                                    @endif 
                                  <form action="{{ action('RibosBarController@updateBillingInfo', $billingStatement['id']) }}" method="post">

                                   {{csrf_field()}}
                                   <input name="_method" type="hidden" value="PUT">
                                   <div class="form-group">
                                      <div class="form-row">
                                        <div class="col-lg-4">
                                          <label>Bill To</label>
                                          <input type="text" name="billTo" class="form-control" value="{{ $billingStatement['bill_to']}}" />
                                  
                                        </div>
                                        <div class="col-lg-2">
                                          <label>Date</label>
                                          <input type="text" name="date" class="datepicker form-control" value="{{ $billingStatement['date']}}" />
                                      
                                        </div>
                                        <div class="col-lg-4">
                                          <label>Address</label>
                                          <input type="text" name="address" class="form-control" value="{{ $billingStatement['address']}}" />
                                        
                                        </div>	
                                        <div class="col-lg-4">
                                          <label>Period Covered</label>
                                          <input type="text" name="periodCovered" class="form-control" value="{{ $billingStatement['period_cover']}}" />
                                        
                                        </div>
                                      <div class="col-lg-2">
                                        <label>Terms</label>
                                        <input type="text" name="terms" class="form-control" value="{{ $billingStatement['terms']}}" />
                                      </div>
                            			</div>
	                            	</div>
                                <div class="form-group">
	                            		<div class="form-row">	
                            				<div class="col-lg-2">
                                            <label>Date</label>
                                            <input type="text" name="transactionDate" class="datepicker form-control" value="{{ $billingStatement['date_of_transaction']}}" disabled />
                                            
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Order</label>
                                        <input type="text" name="order" class="form-control" value="{{ $billingStatement['order']}}" disabled/>
                                    </div>
                                    @if($billingStatement['order'] != "Delivery Receipt")
                                          <div class="col-lg-2">
                                          <label>Invoice #</label>
                                          <input type="text" name="invoiceNumber" class="form-control" value="{{ $billingStatement['invoice_number']}}" />
                                          </div>
                                      @endif
                                    <div class="col-lg-4">
                                    <label>Item Description</label>
                                    <input type="text" name="description" class="form-control" value="{{ $billingStatement['description']}}" disabled />
                                    
                                    </div>
                                @if($billingStatement['order'] == "Delivery Receipt")
                                  <div class="col-lg-2">
                                  <label>Product Id</label>
                                  <input type="text" name="productId" class="form-control" value="{{ $billingStatement['product_id']}}" disabled />
                                  </div>
                                  <div class="col-lg-1">
                                  <label>QTY</label>
                                  <input type="text" name="qty" class="form-control" value="{{ $billingStatement['qty']}}" disabled />
                                  </div>
                                  <div class="col-lg-1">
                                  <label>Unit Price</label>
                                  <input type="text" name="unitPrice" class="form-control" value="{{ $billingStatement['unit_price']}}" disabled />
                                  </div>
                                  <div class="col-lg-1">
                                  <label>Unit</label>
                                  <input type="text" name="unit" class="form-control" value="{{ $billingStatement['unit']}}" disabled />
                                  </div>
                                @endif
                                  <div class="col-lg-1">
                                  <label>Amount</label>
                                  <input type="text" name="amount" class="form-control" value="<?php echo number_format($billingStatement['amount'], 2); ?>" disabled="disabled" />
                                  
                                  </div>
											           <div class="col-lg-12 float-right">
                                    <br>
                                    <br>
                                    <input type="submit" class="btn btn-success float-right btn-lg"  value="Update Billing Statement" />
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
                              Add 
                          </div>
                          <div class="card-body">
                          <form action="{{ action('RibosBarController@addNewBillingData', $id) }}" method="post">
                            {{csrf_field()}}
                            @if(session('addBillingSuccess'))
                              <p class="alert alert-success">{{ Session::get('addBillingSuccess') }}</p>
                              @endif 
                          <div class="form-group">
                            <div class="form-row">	
                                <div class="col-lg-12">
                                  <label>Date</label>
                                  <input type="text" name="transactionDate" class="datepicker form-control" required />
                                  
                                </div>
                              <div class="col-lg-12">
                                <label>Order</label>
                                <select name="choose" class="chooseOption form-control" >
                                  <option value="Sales Invoice">Sales Invoice</option>
                                  <option value="Delivery Receipt">Delivery Receipt</option> 
                                </select>
                                
                              </div>
                              <div id="invoiceNo" class="col-lg-12">
                                <label>Invoice #</label>
                                <select data-live-search="true" name="invoiceNumber" class="invoiceSelect form-control selectpicker">
                                  <option value="0">--Please Select--</option>
                                  @foreach($getAllSalesInvoices as $getAllSalesInvoice)
                                  <option value="{{ $getAllSalesInvoice->ribos_bar_code}}">{{ $getAllSalesInvoice->ribos_bar_code}}</option>
                                  @endforeach
                                </select>
                              </div>
                              <div id="drNo" class="col-lg-12">
                                <label>DR #</label>
                                <select data-live-search="true" name="drNo" class="drSelect form-control selectpicker">
                                  <option value="0">--Please Select--</option>
                                  @foreach($drNos as $drNo)
                                  <option value="{{ $drNo->ribos_bar_code}}">{{ $drNo->ribos_bar_code}}</option>
                                  @endforeach
                                </select>	
                              </div>
                              <div id="drList" class="col-lg-12">
                                <label>DR Lists Id</label>
                                <select id="dataList" name="drList" class="chooseDr form-control "> 
                                </select>
                              </div>
                                <div id="invoiceList" class="col-lg-12">
                                  <label>Invoice List Id</label>
                                  <select id="dataInvoice" name="invoiceListId" class="chooseInvoice form-control "> 
                                  </select>
                                </div>
                                <div id="drProdId" class="col-lg-12">
                                    <label>Product Id</label>
                                    <input type="text" name="productId" class="form-control"  disabled />
                                      
                                  </div>
                                  <div id="qty" class="col-lg-12">
                                    <label>Qty</label>
                                    <input type="text" name="qty" class="form-control"  disabled />
                                    
                                  </div>
                                  <div id="totalKls" class="col-lg-12">
                                    <label>Total Kls</label>
                                    <input type="text" name="totalKls" class="form-control"  disabled />
                                    
                                  </div>
	            	 					
                                  <div id="description" class="col-lg-12">
                                  <label>Item Description</label>
                                  <input type="text" name="description" class="form-control" disabled/>
                                  
                                  </div>
                                  <div id="unitPrice" class="col-lg-12">
                                    <label>Unit Price</label>
                                    <input type="text" name="unitPrice" class="form-control"  disabled/>
                                    
                                  </div>
                                  <div  id="drUnit" class="col-lg-12">
                                    <label>Unit</label>
                                    <input type="text" name="unit" class="form-control"  disabled />
                                    
                                  </div>
                                    <div id="amount" class="col-lg-12">
                                    <label>Amount</label>
                                    <input type="text" name="amount" class="form-control" disabled />
                                    
                                    </div>
	            	 					
	                            		</div>                            		
	                            	</div>
                                <div>
                                    <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-plus"></i>Add</button>
                                </div>
                                </form>
                          </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-3">
                          <div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            Edit Billing Statement</div>
                          <div class="card-body">
                            
                                @foreach($bStatements as $bStatement)
                                    <div class="form-group">
                      
                                    <div id="deletedId{{ $bStatement['id'] }}" class="form-row">
                                       <div class="col-lg-2">
	                                            <label>Date</label>
	                                            <input type="text" name="transactionDate" class="form-control" value="{{ $bStatement['date_of_transaction']}}" disabled />
		                                    </div>
										                    	@if($bStatement['order'] === "Delivery Receipt")
                                        <div class="col-lg-2">
	                                            <label>Dr No</label>
	                                            <input type="text" name="transactionDate" class="form-control" value="{{ $bStatement['dr_no']}}" disabled />
		                                     </div>
                                        <div class="col-lg-2">
	                                            <label>Product Id</label>
	                                            <input type="text" name="productId" class="form-control" value="{{ $bStatement['product_id']}}" disabled />
		                                    </div>
                                        <div class="col-lg-2">
	                                            <label>QTY</label>
	                                            <input type="text" name="qty" class="form-control" value="{{ $bStatement['qty']}}" disabled />
		                                    </div>
										  	                <div class="col-lg-2">
	                                            <label>Unit Price</label>
	                                            <input type="text" name="unitPrice" class="form-control" value="{{ $bStatement['unit_price']}}" disabled />
		                                    </div>
                                        <div class="col-lg-2">
	                                            <label>Unit </label>
	                                            <input type="text" name="unit" class="form-control" value="{{ $bStatement['unit']}}" disabled />
		                                    </div>
											                  @endif
                                        @if($bStatement['order'] != "Delivery Receipt")
		                                    <div class="col-lg-2">
                                        <label>Invoice #</label>
                                        <input type="text" name="invoiceNumber" class="form-control" value="{{ $bStatement['invoice_number']}}" disabled/>
                                        </div>
                                        <div class="col-lg-2">
	                                            <label>QTY</label>
	                                            <input type="text" name="qty" class="form-control" value="{{ $bStatement['qty']}}" disabled />
		                                    </div>
											                  <div class="col-lg-2">
	                                            <label>Total Kls</label>
	                                            <input type="text" name="totalKls" class="form-control" value="{{ $bStatement['total_kls']}}" disabled />
		                                    </div>
                                        <div class="col-lg-2">
	                                            <label>Unit Price</label>
	                                            <input type="text" name="unitPrice" class="form-control" value="{{ $bStatement['unit_price']}}" disabled />
		                                    </div>
  										                  	@endif
                                      <div class="col-lg-4">
                                      <label>Description</label>
                                      <input type="text" name="description" class="form-control" value="{{ $bStatement['description']}}" disabled />
                                      
                                      </div>
                                      <div class="col-lg-2">
                                      <label>Amount</label>
                                      <input type="text" name="amount" class="form-control" value="<?php echo number_format($bStatement['amount'], 2); ?>" disabled="disabled" />
                                      
                                      </div>
                                        <div class="col-lg-4 ">
                                          <br>
                                       
                                          @if(Auth::user()['role_type'] == 1)
                                          <a id="delete" onClick="confirmDelete('{{ $bStatement['id'] }}')" href="javascript:void" class="btn btn-danger">Remove</a>
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

<script >
  $("#drNo").hide();
	$("#drList").hide();
	$("#drProdId").hide();
	$("#drUnit").hide();

  $(".chooseOption").change(function(){
      const cat  = $(this.options[this.selectedIndex]).closest('option:selected').val();
      if(cat === "Sales Invoice"){
        $("#invoiceNo").show();
        $("#invoiceList").show();
        $("#totalKls").show();

        $("#drProdId").hide();
        $("#drNo").hide();
        $("#drList").hide();
        $("#drUnit").hide();
      }else{
        $("#drProdId").show();
        $("#drNo").show();
        $("#drList").show();
        $("#drUnit").show();

        $("#invoiceNo").hide();
        $("#invoiceList").hide();
        $("#totalKls").hide();
      }
	});

  $(".invoiceSelect").change(function(){
      <?php
        $moduleName = "Sales Invoice";
        $salesInvoices = DB::table(
                    'ribos_bar_sales_invoices')
                    ->select(
                        'ribos_bar_sales_invoices.id',
                        'ribos_bar_sales_invoices.user_id',
                        'ribos_bar_sales_invoices.si_id',
                        'ribos_bar_sales_invoices.invoice_number',
                        'ribos_bar_sales_invoices.sales_invoice_number',
                        'ribos_bar_sales_invoices.date',
                        'ribos_bar_sales_invoices.ordered_by',
                        'ribos_bar_sales_invoices.address',
                        'ribos_bar_sales_invoices.qty',
                        'ribos_bar_sales_invoices.total_kls',
                        'ribos_bar_sales_invoices.item_description',
                        'ribos_bar_sales_invoices.unit_price',
                        'ribos_bar_sales_invoices.amount',
                        'ribos_bar_sales_invoices.total_amount', 
                        'ribos_bar_sales_invoices.created_by',
                        'ribos_bar_sales_invoices.deleted_at',                     
                        'ribos_bar_codes.ribos_bar_code',
                        'ribos_bar_codes.module_id',
                        'ribos_bar_codes.module_code',
                        'ribos_bar_codes.module_name')
                    ->leftJoin('ribos_bar_codes', 'ribos_bar_sales_invoices.id', '=', 'ribos_bar_codes.module_id')
                    ->where('ribos_bar_sales_invoices.si_id', NULL)
                    ->where('ribos_bar_codes.module_name', $moduleName)
                    ->where('ribos_bar_sales_invoices.deleted_at', NULL)
                    ->get()->toArray();

      ?>
      const invoice = $(this).children("option:selected").val();
      <?php foreach($salesInvoices as $salesInvoice): ?>
        if(invoice === "<?= $salesInvoice->ribos_bar_code?>"){
              <?php 
                  $getSIInsides = DB::table(
                                    'ribos_bar_sales_invoices')
                                    ->where('sales_invoice_number', $salesInvoice->sales_invoice_number)
                                    ->get(); ?>

               <?php foreach($getSIInsides as $getSIInside): ?>
                    $("#dataInvoice").append(  
                          `<option value="<?= $getSIInside->id?>"><?= $getSIInside->id?></option>
                          `);
                      $(".chooseInvoice").change(function(){
                          const cat  = $(this.options[this.selectedIndex]).closest('option:selected').val();
                          <?php 
                                            $datas  = DB::table(
                                                    'lolo_pinoy_grill_commissary_sales_invoices')
                                                    ->where('id', $getSIInside->id)
                                                    ->get(); ?>
                          <?php foreach($datas as $data): ?>
                            if(cat === "<?=  $data->id ?>"){
                              $("#qty").html('<label>Qty</label><input type="text" name="qty" value="<?= $data->qty; ?>" class="form-control" readonly="readonly" />');
                              $("#totalKls").html('<label>Total Kls</label><input type="text" name="totalKls" value="<?= $data->total_kls; ?>" class="form-control" readonly="readonly" />');
                              $("#description").html('<label>Item Description</label><input type="text" name="description" value="<?= $data->item_description; ?>" class="form-control" readonly="readonly" />');
                              $("#unitPrice").html('<label>Unit Price</label><input type="text" name="unitPrice" value="<?= $data->unit_price; ?>" class="form-control" readonly="readonly" />');
                              $("#amount").html('<label>Amount</label><input type="text" name="amount" value="<?= $data->amount; ?>" class="form-control" readonly="readonly" />');
                          
                            }

                          <?php endforeach; ?>
                        });
               <?php endforeach; ?>
                $("#qty").html('<label>Qty</label><input type="text" name="qty" value="<?= $salesInvoice->qty; ?>" class="form-control" readonly="readonly" />');
                $("#totalKls").html('<label>Total Kls</label><input type="text" name="totalKls" value="<?= $salesInvoice->total_kls; ?>" class="form-control" readonly="readonly" />');
                $("#description").html('<label>Item Description</label><input type="text" name="description" value="<?= $salesInvoice->item_description; ?>" class="form-control" readonly="readonly" />');
                $("#unitPrice").html('<label>Unit Price</label><input type="text" name="unitPrice" value="<?= $salesInvoice->unit_price; ?>" class="form-control" readonly="readonly" />');
                $("#amount").html('<label>Amount</label><input type="text" name="amount" value="<?= $salesInvoice->amount; ?>" class="form-control" readonly="readonly" />');
            
        }
      <?php endforeach; ?>

  });   

  $(".drSelect").change(function(){
      <?php
            $moduleName = "Delivery Receipt"; 
            $getDrNos = DB::table(
                    'ribos_bar_delivery_receipts')
                    ->select( 
                    'ribos_bar_delivery_receipts.id',
                    'ribos_bar_delivery_receipts.user_id',
                    'ribos_bar_delivery_receipts.dr_id',
                    'ribos_bar_delivery_receipts.delivered_to',
                    'ribos_bar_delivery_receipts.address',
                    'ribos_bar_delivery_receipts.dr_no',
                    'ribos_bar_delivery_receipts.date',
                    'ribos_bar_delivery_receipts.product_id',
                    'ribos_bar_delivery_receipts.qty',
                    'ribos_bar_delivery_receipts.unit',
                    'ribos_bar_delivery_receipts.item_description',
                    'ribos_bar_delivery_receipts.unit_price',
                    'ribos_bar_delivery_receipts.amount',
                    'ribos_bar_delivery_receipts.prepared_by',
                    'ribos_bar_delivery_receipts.approved_by',
                    'ribos_bar_delivery_receipts.checked_by',
                    'ribos_bar_delivery_receipts.received_by',
                    'ribos_bar_delivery_receipts.created_by',      
                    'ribos_bar_codes.ribos_bar_code',
                    'ribos_bar_codes.module_id',
                    'ribos_bar_codes.module_code',
                    'ribos_bar_codes.module_name')
                    ->leftJoin('ribos_bar_codes', 'ribos_bar_delivery_receipts.id', '=', 'ribos_bar_codes.module_id')
                    ->where('ribos_bar_delivery_receipts.dr_id', NULL)
                    ->where('ribos_bar_codes.module_name', $moduleName)
                    ->get()->toArray();
         ?>
         	const dr = $(this).children("option:selected").val();
          <?php foreach($getDrNos as $getDrNo ): ?>
              if(dr === "<?= $getDrNo->ribos_bar_code?>"){
                <?php 
                    $getDrNosInsides = DB::table(
                                    'ribos_bar_delivery_receipts')
                                    ->where('dr_no', $getDrNo->dr_no)
                                    ->get(); ?>
                 <?php foreach($getDrNosInsides as $getDrNosInside):?>
                      $("#dataList").append(  
                          `<option value="<?= $getDrNosInside->id?>"><?=  $getDrNosInside->id?></option>
                          `);

                          $(".chooseDr").change(function(){
                          const cat  = $(this.options[this.selectedIndex]).closest('option:selected').val();
                          <?php 
                                $datas  = DB::table(
                                        'lolo_pinoy_grill_commissary_delivery_receipts')
                                        ->where('id', $getDrNosInside->id)
                                        ->get(); ?>
                          <?php foreach($datas as $data): ?>
                            <?php
                                $prodExp = explode("-", $data->product_id);
                              ?>
                              if(cat === "<?= $data->id?>"){
                                $("#drProdId").html('<label>Product Id</label><input type="text" name="productId" value="<?= $prodExp[1]; ?>" class="form-control" readonly="readonly" />');
                                $("#qty").html('<label>Qty</label><input type="text" name="qty" value="<?= $data->qty; ?>" class="form-control" readonly="readonly" />');
                                $("#description").html('<label>Item Description</label><input type="text" name="description" value="<?= $data->item_description; ?>" class="form-control" readonly="readonly" />');
                                $("#unitPrice").html('<label>Unit Price</label><input type="text" name="unitPrice" value="<?= $data->unit_price; ?>" class="form-control" readonly="readonly" />');
                                $("#drUnit").html('<label>Unit</label><input type="text" name="unit" value="<?= $data->unit; ?>" class="form-control" readonly="readonly" />');
                                $("#amount").html('<label>Amount</label><input type="text" name="amount" value="<?= $data->amount; ?>" class="form-control" readonly="readonly" />');
                          
                              }

                          <?php endforeach;?>
						
				            	});
					

                 <?php endforeach; ?>
                 <?php
                      $prodExp = explode("-", $getDrNo->product_id);

                    ?>
                    $("#drProdId").html('<label>Product Id</label><input type="text" name="productId" value="<?= $prodExp[1]; ?>" class="form-control" readonly="readonly" />');				
                    $("#qty").html('<label>Qty</label><input type="text" name="qty" value="<?= $getDrNo->qty; ?>" class="form-control" readonly="readonly" />');
                    $("#description").html('<label>Item Description</label><input type="text" name="description" value="<?= $getDrNo->item_description; ?>" class="form-control" readonly="readonly" />');
                    $("#unitPrice").html('<label>Unit Price</label><input type="text" name="unitPrice" value="<?= $getDrNo->unit_price; ?>" class="form-control" readonly="readonly" />');
                    $("#drUnit").html('<label>Unit</label><input type="text" name="unit" value="<?= $getDrNo->unit; ?>" class="form-control" readonly="readonly" />');
                    $("#amount").html('<label>Amount</label><input type="text" name="amount" value="<?= $getDrNo->amount; ?>" class="form-control" readonly="readonly" />');
                        
          }
          <?php endforeach; ?>
  });

   function confirmDelete(id){
      const x = confirm("Do you want to delete this?");
        if(x){
            $.ajax({
              type: "DELETE",
              url: '/ribos-bar/delete-billing-statement/' + id,
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