@extends('layouts.mr-potato-app')
@section('title', 'Billing Statement Form |')
@section('content')
<script>
     $(function() {
        $(".datepicker").datepicker();
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
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css" >
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>


<div id="wrapper">
      <!-- Sidebar -->
        @include('sidebar.sidebar-mr-potato')
        <div id="content-wrapper">
            <div class="container-fluid">
                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Mr Potato</a>
                    </li>
                    <li class="breadcrumb-item active">Billing Statement Form</li>
                </ol>
                <div class="col-lg-12">
                     <img src="{{ asset('images/mr-potato.png')}}" width="390" height="250" class="img-responsive mx-auto d-block" alt="Mr Potato">
		              <h4 class="text-center"><u>BILLING STATEMENT</u></h4>
                </div>
                <div class="row">
                     <div class="col-lg-12">
                          <div class="card mb-3">
                                <div class="card-header">
                                    <i class="fas fa-receipt" aria-hidden="true"></i>
                                    Billing Statement
                                </div>
                                <form action="{{ action('MrPotatoController@storeBillingStatement') }}" method="post">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="form-row">
                                             <div class="col-lg-2">
                                                <label>Date</label>
                                                <input type="text" name="date" class="datepicker form-control" />
                                             </div>
                                             <div class="col-lg-4">
                                                <label>Bill To</label>
                                                <input type="text" name="billTo" class="form-control" required="required" />
                                                @if ($errors->has('billTo'))
                                                    <span class="alert alert-danger">
                                                    <strong>{{ $errors->first('billTo') }}</strong>
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
                                             <div class="col-lg-2">
                                                <label>Period Covered</label>
                                                <input type="text" name="periodCovered" class="form-control" required="required" />
                                              
                                             </div>
                                        </div>      
                                    </div>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="col-lg-2">
                                                <label>Terms</label>
                                                <input type="text" name="terms" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="col-lg-2">
                                                <label>Date</label>
                                                <input type="text" name="dateTransaction" class="datepicker form-control" />
                                            </div>
                                            <div class="col-lg-2">
                                                <label>Order</label>
                                                    <select name="choose" class="chooseOption form-control" >
                                                    <option value="Sales Invoice">Sales Invoice</option>
                                                    <option value="Delivery Receipt">Delivery Receipt</option> 
                                                    </select>
                                                
                                            </div>
                                            <div id="invoiceNo" class="col-lg-2">
                                                <label>Invoice #</label>
                                                <select data-live-search="true" name="invoiceNumber" class="invoiceSelect form-control selectpicker">
                                                    <option value="0">--Please Select--</option>
                                                    @foreach($getAllSalesInvoices as $getAllSalesInvoice)
                                                    <option value="{{ $getAllSalesInvoice->mr_potato_code}}">{{ $getAllSalesInvoice->mr_potato_code}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div id="drNo" class="col-lg-2">
                                                <label>DR #</label>
                                                <select data-live-search="true" name="drNo" class="drSelect form-control selectpicker">
                                                    <option value="0">--Please Select--</option>
                                                    @foreach($drNos as $drNo)
                                                    <option value="{{ $drNo->mr_potato_code}}">{{ $drNo->mr_potato_code}}</option>
                                                    @endforeach
                                                </select>	
                                            </div>
                                            <div id="drList" class="col-lg-2">
                                                <label>DR Lists Id</label>
                                                <select id="dataList" name="drList" class="chooseDr form-control "> 
                                                </select>
                                            </div>
                                            <div id="invoiceList" class="col-lg-2">
                                                <label>Invoice List Id</label>
                                                <select id="dataInvoice" name="invoiceListId" class="chooseInvoice form-control "> 
                                                </select>
                                            </div>
                                          
                                            <div id="qty" class="col-lg-1">
                                                <label>Qty</label>
                                                <input type="text" name="qty" class="form-control"  disabled />
                                            
                                            </div>
                                            <div id="unit" class="col-lg-1">
                                                <label>Unit</label>
                                                <input type="text" name="unit" class="form-control"  disabled />
                                            
                                            </div>
                                            <div id="totalKls" class="col-lg-1">
                                                <label>Total Kls</label>
                                                <input type="text" name="totalKls" class="form-control"  disabled />
                                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div id="description" class="col-lg-4">
                                                <label>Item Description</label>
                                                <input type="text" name="itemDescription" class="form-control" disabled/>
                                            </div>
                                            <div id="descriptionDrNo" class="col-lg-4">
                                                <label>Item Description</label>
                                                <input type="text" name="descriptionDrNo" class="form-control"  disabled />
                                            
                                            </div>
                                            <div id="unitPrice" class="col-lg-2">
                                                <label>Unit Price</label>
                                                <input type="text" name="unitPrice" class="form-control" disabled/>
                                            </div>
                                            <div id="amount" class="col-lg-2">
                                                <label>Amount</label>
                                                <input type="text" name="amount" class="form-control" disabled/>
                                            </div>
                                            
                                            
                                        </div>
                                    </div>
                                    <br>
                                    <div>
                                        <button type="submit" class="btn btn-success btn-lg float-right"><i class="fas fa-save"></i> Save Billing</button>
                                        <br>
                                        <br>
                                    </div>
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
     $("#drNo").hide();
     $("#drList").hide();
     $("#unit").hide();
     $("#descriptionDrNo").hide();
    
     $(".chooseOption").change(function(){
        const cat  = $(this.options[this.selectedIndex]).closest('option:selected').val();
        if(cat === "Sales Invoice"){
            $("#totalKls").show();
            $("#invoiceNo").show();
            $("#invoiceList").show();
            $("#description").show();


            $("#unit").hide();
            $("#drNo").hide();
            $("#drList").hide();
            $("#descriptionDrNo").hide();
           
        }else if(cat === "Delivery Receipt"){
            $("#unit").show();
            $("#drNo").show();
            $("#drList").show();
            $("#descriptionDrNo").show();

            $("#totalKls").hide();
            $("#invoiceNo").hide();
            $("#invoiceList").hide();
            $("#description").hide();

        }
     });

     $(".invoiceSelect").change(function(){
        <?php
          $moduleName = "Sales Invoice";
          $salesInvoices = DB::table(
                                  'mr_potato_sales_invoices')
                                  ->select(
                                      'mr_potato_sales_invoices.id',
                                      'mr_potato_sales_invoices.user_id',
                                      'mr_potato_sales_invoices.si_id',
                                      'mr_potato_sales_invoices.invoice_number',
                                      'mr_potato_sales_invoices.sales_invoice_number',
                                      'mr_potato_sales_invoices.date',
                                      'mr_potato_sales_invoices.ordered_by',
                                      'mr_potato_sales_invoices.address',
                                      'mr_potato_sales_invoices.qty',
                                      'mr_potato_sales_invoices.total_kls',
                                      'mr_potato_sales_invoices.item_description',
                                      'mr_potato_sales_invoices.unit_price',
                                      'mr_potato_sales_invoices.amount',
                                      'mr_potato_sales_invoices.created_by',
                                      'mr_potato_codes.mr_potato_code',
                                      'mr_potato_codes.module_id',
                                      'mr_potato_codes.module_code',
                                      'mr_potato_codes.module_name')
                                  ->join('mr_potato_codes', 'mr_potato_sales_invoices.id', '=', 'mr_potato_codes.module_id')
                                  ->where('mr_potato_sales_invoices.si_id', NULL)
                                  ->orderBy('mr_potato_sales_invoices.id', 'desc')
                                  ->where('mr_potato_codes.module_name', $moduleName)
                                  ->get()->toArray();
        
        ?>
        const invoice = $(this).children("option:selected").val();
        <?php foreach($salesInvoices as $salesInvoice): ?>
          if(invoice === "<?php echo $salesInvoice->mr_potato_code?>"){
               <?php 
                  $getSIInsides = DB::table(
                                    'mr_potato_sales_invoices')
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
                                      'mr_potato_sales_invoices')
                                      ->where('id', $getSIInside->id)
                                      ->get(); ?>

                      <?php foreach($datas as $data): ?>
                            if(cat === "<?= $data->id?>"){
                              $("#qty").html('<label>Qty</label><input type="text" name="qty" value="<?= $data->qty; ?>" class="form-control" readonly="readonly" />');
                              $("#totalKls").html('<label>Total Kls</label><input type="text" name="totalKls" value="<?= $data->total_kls; ?>" class="form-control" readonly="readonly" />');
                              $("#unitPrice").html('<label>Unit Price</label><input type="text" name="unitPrice" value="<?= $data->unit_price; ?>" class="form-control" readonly="readonly" />');
                            
                              $("#description").html('<label>Description</label><input type="text" name="itemDescription" value="<?= $data->item_description; ?>" class="form-control" readonly="readonly" />');
                              $("#amount").html('<label>Amount</label><input type="text" name="amount" value="<?= $data->amount; ?>" class="form-control" readonly="readonly" />');
         
                            }
                      <?php endforeach;?>
                  });
              <?php endforeach; ?>

            $("#qty").html('<label>Qty</label><input type="text" name="qty" value="<?= $salesInvoice->qty; ?>" class="form-control" readonly="readonly" />');
            $("#totalKls").html('<label>Total Kls</label><input type="text" name="totalKls" value="<?= $salesInvoice->total_kls; ?>" class="form-control" readonly="readonly" />');
            $("#unitPrice").html('<label>Unit Price</label><input type="text" name="unitPrice" value="<?= $salesInvoice->unit_price; ?>" class="form-control" readonly="readonly" />');
        
            $("#description").html('<label>Description</label><input type="text" name="itemDescription" value="<?= $salesInvoice->item_description; ?>" class="form-control" readonly="readonly" />');
            $("#amount").html('<label>Amount</label><input type="text" name="amount" value="<?= $salesInvoice->amount; ?>" class="form-control" readonly="readonly" />');
         
          }
        <?php endforeach; ?>
        
    });

    $(".drSelect").change(function(){
        <?php
             $moduleName = "Delivery Receipt"; 
             $getDrNos = DB::table(
                             'mr_potato_delivery_receipts')
                             ->select( 
                             'mr_potato_delivery_receipts.id',
                             'mr_potato_delivery_receipts.user_id',
                             'mr_potato_delivery_receipts.dr_id',
                             'mr_potato_delivery_receipts.dr_no',
                             'mr_potato_delivery_receipts.delivered_to',
                             'mr_potato_delivery_receipts.date',
                             'mr_potato_delivery_receipts.qty',
                             'mr_potato_delivery_receipts.unit',
                             'mr_potato_delivery_receipts.item_description',
                             'mr_potato_delivery_receipts.prepared_by',
                             'mr_potato_delivery_receipts.checked_by',
                             'mr_potato_delivery_receipts.received_by',
                             'mr_potato_delivery_receipts.created_by',
                             'mr_potato_codes.mr_potato_code',
                             'mr_potato_codes.module_id',
                             'mr_potato_codes.module_code',
                             'mr_potato_codes.module_name')
                             ->join('mr_potato_codes', 'mr_potato_delivery_receipts.id', '=', 'mr_potato_codes.module_id')
                             ->where('mr_potato_delivery_receipts.dr_id', NULL)
                             ->where('mr_potato_codes.module_name', $moduleName)
                             ->get();
     
          ?>
        const dr = $(this).children("option:selected").val();
        <?php foreach($getDrNos as $getDrNo ): ?>
             if(dr === "<?= $getDrNo->mr_potato_code?>"){
                <?php 
                    $getDrNosInsides = DB::table(
                                    'mr_potato_delivery_receipts')
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
                                      'mr_potato_delivery_receipts')
                                      ->where('id', $getDrNosInside->id)
                                      ->get(); ?>

                               <?php foreach($datas as $data): ?>
                                     if(cat === "<?= $data->id?>"){
                                          $("#qty").html('<label>Qty</label><input type="text" name="qty" value="<?= $data->qty; ?>" class="form-control" readonly="readonly" />');
                                          $("#unit").html('<label>Unit</label><input type="text" name="unit" value="<?= $data->unit; ?>" class="form-control" readonly="readonly" />');
                                          $("#unitPrice").html('<label>Unit Price</label><input type="text" name="unitPrice" value="<?= $data->unit_price; ?>" class="form-control" readonly="readonly" />');
                            
                                          $("#descriptionDrNo").html('<label> Item Description</label><input type="text" name="descriptionDrNo" value="<?= $data->item_description; ?>" class="form-control" readonly="readonly" />');
                                          $("#amount").html('<label>Amount</label><input type="text" name="amount" value="<?= $data->amount; ?>" class="form-control" readonly="readonly" />');
         
                                     }
                               <?php endforeach;?>
                        });       

                    <?php endforeach; ?>    
                $("#qty").html('<label>Qty</label><input type="text" name="qty" value="<?= $getDrNo->qty; ?>" class="form-control" readonly="readonly" />');
                $("#unit").html('<label>Unit</label><input type="text" name="unit" value="<?= $getDrNo->unit; ?>" class="form-control" readonly="readonly" />');
                $("#unitPrice").html('<label>Unit Price</label><input type="text" name="unitPrice" value="<?= $data->unit_price; ?>" class="form-control" readonly="readonly" />');
                            
                $("#descriptionDrNo").html('<label>Item Description</label><input type="text" name="descriptionDrNo" value="<?= $getDrNo->item_description; ?>" class="form-control" readonly="readonly" />');
                $("#amount").html('<label>Amount</label><input type="text" name="amount" value="<?= $data->amount; ?>" class="form-control" readonly="readonly" />');
         
             }
           
        <?php endforeach; ?>
        
    
    
    });
</script>
@endsection