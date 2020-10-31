@extends('layouts.dno-holdings-co-app')
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

<div id="wrapper">
	<!-- Sidebar -->
    @include('sidebar.sidebar-dno-holdings-co')
    <div id="content-wrapper">
      <form action="{{ action('DnoHoldingsCoController@storeBillingStatement') }}" method="post">
          {{csrf_field()}}
    	<div class="container-fluid">
    		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">DNO Holdings & Co</a>
              </li>
              <li class="breadcrumb-item active">Billing Statement Form</li>
            </ol>
            <div class="col-lg-12">
            	 	<img src="{{ asset('images/digitized-logos/dno-holdings-co.jpg')}}" width="390" height="250" class="img-responsive mx-auto d-block" alt="DNO Holdings & Co">
            	 
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
                          <label>DR #</label>
                          <input type="text" name="drNo" class="form-control" />
                        
                        </div>
										    <div  class="col-lg-4">
        	 								<label>Item Description</label>
        	 								<input type="text" name="description" class="form-control"/>
        	 							
            	 						</div>
										      <div  class="col-lg-2">
            	 							<label>Unit Price</label>
            	 							<input type="text" name="unitPrice" class="form-control"/>
            	 							
            	 						</div>
            	 						<div  class="col-lg-2">
            	 							<label>Amount</label>
            	 							<input type="text" name="amount" class="form-control"/>
            	 							
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
                  ->orderBy('ribos_bar_sales_invoices.id', 'desc')
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
                                  'ribos_bar_sales_invoices')
                                  ->where('id', $getSIInside->id)
                                  ->get(); ?>

                        <?php foreach($datas as $data): ?>
                          if(cat === "<?php echo $data->id ?>"){
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
              if(dr === "<?php echo $getDrNo->ribos_bar_code?>"){
                <?php 
                    $getDrNosInsides = DB::table(
                                    'ribos_bar_delivery_receipts')
                                    ->where('dr_no', $getDrNo->dr_no)
                                    ->get(); ?>

                     <?php foreach($getDrNosInsides as $getDrNosInside):?>
                          $("#dataList").append(  
                             `<option value="<?= $getDrNosInside->id?>"><?= $getDrNosInside->id?></option>
                          `);
                          $(".chooseDr").change(function(){
                            const cat  = $(this.options[this.selectedIndex]).closest('option:selected').val();
                            <?php 
                                            $datas  = DB::table(
                                                    'ribos_bar_delivery_receipts')
                                                    ->where('id', $getDrNosInside->id)
                                                    ->get(); ?>

                            <?php foreach($datas as $data): ?>
                              <?php
                                $prodExp = explode("-", $data->product_id);
                              ?>
                              if(cat === "<?= $data->id ?>"){
                                $("#drProdId").html('<label>Product Id</label><input type="text" name="productId" value="<?= $prodExp[1]; ?>" class="form-control" readonly="readonly" />');
                                $("#qty").html('<label>Qty</label><input type="text" name="qty" value="<?=  $data->qty; ?>" class="form-control" readonly="readonly" />');
                                $("#description").html('<label>Item Description</label><input type="text" name="description" value="<?= $data->item_description; ?>" class="form-control" readonly="readonly" />');
                                $("#unitPrice").html('<label>Unit Price</label><input type="text" name="unitPrice" value="<?= $data->unit_price; ?>" class="form-control" readonly="readonly" />');
                                $("#drUnit").html('<label>Unit</label><input type="text" name="unit" value="<?= $data->unit; ?>" class="form-control" readonly="readonly" />');
                                $("#amount").html('<label>Amount</label><input type="text" name="amount" value="<?= $data->amount; ?>" class="form-control" readonly="readonly" />');
                          
                              }

							              <?php endforeach; ?>
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
</script>
@endsection