@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
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

<div id="wrapper">
	<!-- Sidebar -->
    @include('sidebar.sidebar')
    <div id="content-wrapper">
      <form action="{{ action('LoloPinoyLechonDeCebuController@storeBillingStatement') }}" method="post">
          {{csrf_field()}}
    	<div class="container-fluid">
    		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lechon de Cebu</a>
              </li>
              <li class="breadcrumb-item active">Billing Statement Form</li>
            </ol>
            <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
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
                              <div class="col-lg-6">
                               
                                <label>Bill To</label>
                                <input type="text" name="billTo" class="form-control" required="required" />
                                @if ($errors->has('billTo'))
                                    <span class="alert alert-danger">
                                      <strong>{{ $errors->first('billTo') }}</strong>
                                    </span>
                                @endif
                                <label>Address</label>
                                <input type="text" name="address" class="form-control" required="required" />
                                @if ($errors->has('address'))
                                    <span class="alert alert-danger">
                                      <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                  @endif
                                <label>Period Covered</label>
                                <input type="text" name="periodCovered" class="form-control" required="required" />
                                @if ($errors->has('periodCovered'))
                                    <span class="alert alert-danger">
                                      <strong>{{ $errors->first('periodCovered') }}</strong>
                                    </span>
                                  @endif
                                
                              </div>
                              <div class="col-lg-6">
                                <label>Date</label>
                                <input type="text" name="date" class="datepicker form-control" required="required" autocomplete="off" />
                                @if ($errors->has('date'))
                                    <span class="alert alert-danger">
                                      <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                                  @endif
                            
                               
                                <label>Branch</label>
                                <div id="app-branch">
                                  <select name="branch" class="form-control">
                                      <option value="0">--Please Select--</option>
                                      <option v-for="branch in branches" v-bind:value="branch.value">
                                          @{{ branch.text }}
                                      </option>
                                  </select>
                                </div>
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
                                    <input type="text" name="transactionDate" class="datepicker form-control" required="required" />
                                    @if ($errors->has('transactionDate'))
                                      <span class="alert alert-danger">
                                        <strong>{{ $errors->first('transactionDate') }}</strong>
                                      </span>
                                    @endif
                                  </div>
                                  <div class="col-lg-2">
                                      <label>Order</label>
                                        <select name="choose" class="chooseOption form-control" >
                                        <option value="Ssp">Ssp</option>
                                        <option value="Private Order">Private Order</option> 
                                        </select>
                                      
                                  </div>
                                  <div id="invoiceNo" class="col-lg-2">
                                      <label>Invoice #</label>
                                      <select data-live-search="true" name="invoiceNumber" class="invoiceSelect form-control selectpicker">
                                        <option value="0">--Please Select--</option>
                                        @foreach($getAllSalesInvoices as $getAllSalesInvoice)
                                        <option value="{{ $getAllSalesInvoice->lechon_de_cebu_code}}">{{ $getAllSalesInvoice->lechon_de_cebu_code}}</option>
                                        @endforeach
                                      </select>
                                  </div>
                                  <div id="drNo" class="col-lg-2">
                                      <label>DR #</label>
                                      <select data-live-search="true" name="drNo" class="drSelect form-control selectpicker">
                                        <option value="0">--Please Select--</option>
                                        @foreach($drNos as $drNo)
                                        <option value="{{ $drNo->lechon_de_cebu_code}}">{{ $drNo->lechon_de_cebu_code}}</option>
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
                                    <select id="dataInvoice" name="drList" class="chooseInvoice form-control "> 
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
                                <div id="body" class="col-lg-1">
                                  <label>Body 400/kls</label>
                                  <input type="text" name="body" class="form-control"  disabled />
                                 
                                </div>
                                <div id="headFeet" class="col-lg-2">
                                  <label>Head & Feet 200/KLS</label>
                                  <input type="text" name="headFeet" class="form-control"  disabled />
                                 
                                </div>
                                <div id="wholeLechon6000" class="col-lg-4">
                                  <label>Whole Lechon </label>
                                  <input type="text" name="wholeLechon6000" class="form-control"  disabled />
                                 
                                </div>
                                <div id="description" class="col-lg-4">
                                  <label>Description</label>
                                  <input type="text" name="description" class="form-control" />
                                
                                </div>
                                <div id="descriptionDrNo" class="col-lg-4">
                                  <label>Description</label>
                                  <input type="text" name="descriptionDrNo" class="form-control"  disabled />
                                  
                                </div>
                                <div id="amount" class="col-lg-1">
                                  <label>Amount</label>
                                  <input type="text" name="amount" class="form-control"  disabled />
                                 
                                </div>
                               
                            </div>
                            <br>
                            <div>
                            <button type="submit" class="btn btn-success btn-lg float-right"><i class="fas fa-save"></i> Save Billing</button>
										        <br>
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
<script type="text/javascript">
    $("#drNo").hide();
    $("#wholeLechon6000").hide();
    $("#descriptionDrNo").hide();
    $("#drList").hide();
    $("#unit").hide();
    $("#wholeLechon").hide();
    $(".chooseOption").change(function(){
         const cat  = $(this.options[this.selectedIndex]).closest('option:selected').val();
         if(cat === "Ssp"){
             $("#invoiceNo").show();
             $("#wholeLechon").show();
             $("#description").show();
             $("#body").show();
             $("#headFeet").show();
             $("#qty").show();
             $("#invoiceList").show();
             $("#amount").show();
             
             $("#drNo").hide();
             $("#wholeLechon6000").hide();
             $("#wholeLechon").hide();
             $("#descriptionDrNo").hide();
             $("#drList").hide();
             $("#unit").hide();
         }else if(cat === "Private Order"){
             $("#drNo").show();
             $("#wholeLechon6000").show();
             $("#descriptionDrNo").show();
             $("#drList").show();
             $("#qty").show();
             $("#unit").show();

             $("#invoiceNo").hide();
             $("#body").hide();
             $("#headFeet").hide();
             $("#amount").hide();
             $("#wholeLechon").hide();
             $("#description").hide();
             $("#invoiceList").hide();
         }  
    });

    $(".invoiceSelect").change(function(){
        <?php
          $moduleName = "Sales Invoice";
          $salesInvoices = DB::table(
                                  'lechon_de_cebu_sales_invoices')
                                  ->select(
                                      'lechon_de_cebu_sales_invoices.id',
                                      'lechon_de_cebu_sales_invoices.user_id',
                                      'lechon_de_cebu_sales_invoices.si_id',
                                      'lechon_de_cebu_sales_invoices.invoice_number',
                                      'lechon_de_cebu_sales_invoices.sales_invoice_number',
                                      'lechon_de_cebu_sales_invoices.date',
                                      'lechon_de_cebu_sales_invoices.ordered_by',
                                      'lechon_de_cebu_sales_invoices.address',
                                      'lechon_de_cebu_sales_invoices.qty',
                                      'lechon_de_cebu_sales_invoices.total_kls',
                                      'lechon_de_cebu_sales_invoices.body',
                                      'lechon_de_cebu_sales_invoices.head_and_feet',
                                      'lechon_de_cebu_sales_invoices.item_description',
                                      'lechon_de_cebu_sales_invoices.unit_price',
                                      'lechon_de_cebu_sales_invoices.amount',
                                      'lechon_de_cebu_sales_invoices.created_by',
                                      'lechon_de_cebu_codes.lechon_de_cebu_code',
                                      'lechon_de_cebu_codes.module_id',
                                      'lechon_de_cebu_codes.module_code',
                                      'lechon_de_cebu_codes.module_name')
                                  ->join('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                                  ->where('lechon_de_cebu_sales_invoices.si_id', NULL)
                                  ->orderBy('lechon_de_cebu_sales_invoices.id', 'desc')
                                  ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                  ->get()->toArray();
        
        ?>
        const invoice = $(this).children("option:selected").val();
        <?php foreach($salesInvoices as $salesInvoice): ?>
          if(invoice === "<?php echo $salesInvoice->lechon_de_cebu_code?>"){
               <?php 
                  $getSIInsides = DB::table(
                                    'lechon_de_cebu_sales_invoices')
                                    ->where('sales_invoice_number', $salesInvoice->sales_invoice_number)
                                    ->get(); ?>
              <?php foreach($getSIInsides as $getSIInside): ?>
                 $("#dataInvoice").append(  
                          `<option value="<?php echo $getSIInside->id?>"><?php echo $getSIInside->id?></option>
                          `);
                  $(".chooseInvoice").change(function(){
                      const cat  = $(this.options[this.selectedIndex]).closest('option:selected').val();
                      <?php 
                              $datas  = DB::table(
                                      'lechon_de_cebu_sales_invoices')
                                      ->where('id', $getSIInside->id)
                                      ->get(); ?>

                      <?php foreach($datas as $data): ?>
                            if(cat === "<?php echo $data->id?>"){
                              $("#qty").html('<label>Qty</label><input type="text" name="qty" value="<?php echo $data->qty; ?>" class="form-control" readonly="readonly" />');
                              $("#body").html('<label> Body 400/kls</label><input type="text" name="body" value="<?php echo $data->body; ?>" class="form-control" readonly="readonly" />');
                              $("#headFeet").html('<label> Head & Feet 200/KLS</label><input type="text" name="headFeet" value="<?php echo $data->head_and_feet; ?>" class="form-control" readonly="readonly" />');
                              
                              $("#description").html('<label>Description</label><input type="text" name="description" value="<?php echo $data->item_description; ?>" class="form-control" readonly="readonly" />');
                              $("#amount").html('<label>Amount</label><input type="text" name="amount" value="<?php echo $data->amount; ?>" class="form-control" readonly="readonly" />');
         
                            }
                      <?php endforeach;?>
                  });
              <?php endforeach; ?>

            $("#qty").html('<label>Qty</label><input type="text" name="qty" value="<?php echo $salesInvoice->qty; ?>" class="form-control" readonly="readonly" />');
            $("#body").html('<label> Body 400/kls</label><input type="text" name="body" value="<?php echo $salesInvoice->body; ?>" class="form-control" readonly="readonly" />');
            $("#headFeet").html('<label> Head & Feet 200/KLS</label><input type="text" name="headFeet" value="<?php echo $salesInvoice->head_and_feet; ?>" class="form-control" readonly="readonly" />');
            
            $("#description").html('<label>Description</label><input type="text" name="description" value="<?php echo $salesInvoice->item_description; ?>" class="form-control" readonly="readonly" />');
            $("#amount").html('<label>Amount</label><input type="text" name="amount" value="<?php echo $salesInvoice->amount; ?>" class="form-control" readonly="readonly" />');
         
          }
        <?php endforeach; ?>
        
    });

    $(".drSelect").change(function(){
        <?php
             $moduleName = "Delivery Receipt"; 
             $getDrNos = DB::table(
                             'lechon_de_cebu_delivery_receipts')
                             ->select( 
                             'lechon_de_cebu_delivery_receipts.id',
                             'lechon_de_cebu_delivery_receipts.user_id',
                             'lechon_de_cebu_delivery_receipts.dr_id',
                             'lechon_de_cebu_delivery_receipts.dr_no',
                             'lechon_de_cebu_delivery_receipts.sold_to',
                             'lechon_de_cebu_delivery_receipts.delivered_to',
                             'lechon_de_cebu_delivery_receipts.time',
                             'lechon_de_cebu_delivery_receipts.date',
                             'lechon_de_cebu_delivery_receipts.date_to_be_delivered',
                             'lechon_de_cebu_delivery_receipts.contact_person',
                             'lechon_de_cebu_delivery_receipts.mobile_num',
                             'lechon_de_cebu_delivery_receipts.qty',
                             'lechon_de_cebu_delivery_receipts.unit',
                             'lechon_de_cebu_delivery_receipts.description',
                             'lechon_de_cebu_delivery_receipts.price',
                             'lechon_de_cebu_delivery_receipts.total',
                             'lechon_de_cebu_delivery_receipts.special_instruction',
                             'lechon_de_cebu_delivery_receipts.consignee_name',
                             'lechon_de_cebu_delivery_receipts.consignee_contact_num',
                             'lechon_de_cebu_delivery_receipts.prepared_by',
                             'lechon_de_cebu_delivery_receipts.checked_by',
                             'lechon_de_cebu_delivery_receipts.received_by',
                             'lechon_de_cebu_delivery_receipts.duplicate_status',
                             'lechon_de_cebu_delivery_receipts.created_by',
                             'lechon_de_cebu_codes.lechon_de_cebu_code',
                             'lechon_de_cebu_codes.module_id',
                             'lechon_de_cebu_codes.module_code',
                             'lechon_de_cebu_codes.module_name')
                             ->join('lechon_de_cebu_codes', 'lechon_de_cebu_delivery_receipts.id', '=', 'lechon_de_cebu_codes.module_id')
                             ->where('lechon_de_cebu_delivery_receipts.dr_id', NULL)
                             ->where('lechon_de_cebu_codes.module_name', $moduleName)
                             ->get();
     
          ?>
        const dr = $(this).children("option:selected").val();
        <?php foreach($getDrNos as $getDrNo ): ?>
             if(dr === "<?php echo $getDrNo->lechon_de_cebu_code?>"){
                <?php 
                    $getDrNosInsides = DB::table(
                                    'lechon_de_cebu_delivery_receipts')
                                    ->where('dr_no', $getDrNo->dr_no)
                                    ->get(); ?>

                 
                  <?php foreach($getDrNosInsides as $getDrNosInside):?>
                       $("#dataList").append(  
                          `<option value="<?php echo $getDrNosInside->id?>"><?php echo $getDrNosInside->id?></option>
                          `);
                        
                        $(".chooseDr").change(function(){
                            const cat  = $(this.options[this.selectedIndex]).closest('option:selected').val();
                            <?php 
                              $datas  = DB::table(
                                      'lechon_de_cebu_delivery_receipts')
                                      ->where('id', $getDrNosInside->id)
                                      ->get(); ?>

                               <?php foreach($datas as $data): ?>
                                     if(cat === "<?php echo $data->id?>"){
                                          $("#qty").html('<label>Qty</label><input type="text" name="qty" value="<?php echo $data->qty; ?>" class="form-control" readonly="readonly" />');
                                          $("#unit").html('<label>Unit</label><input type="text" name="unit" value="<?php echo $data->unit; ?>" class="form-control" readonly="readonly" />');
                                         
                                          $("#wholeLechon6000").html('<label>Whole Lechon</label><input type="text" name="wholeLechon6000" value="<?php echo $data->price; ?>" class="form-control" readonly="readonly" />');
                                          $("#descriptionDrNo").html('<label>Description</label><input type="text" name="descriptionDrNo" value="<?php echo $data->description; ?>" class="form-control" readonly="readonly" />');
            
                                     }
                               <?php endforeach;?>
                        });       

                    <?php endforeach; ?>    
                $("#qty").html('<label>Qty</label><input type="text" name="qty" value="<?php echo $getDrNo->qty; ?>" class="form-control" readonly="readonly" />');
                $("#unit").html('<label>Unit</label><input type="text" name="unit" value="<?php echo $getDrNo->unit; ?>" class="form-control" readonly="readonly" />');
                                        
                $("#wholeLechon6000").html('<label>Whole Lechon</label><input type="text" name="wholeLechon6000" value="<?php echo $getDrNo->price; ?>" class="form-control" readonly="readonly" />');
                $("#descriptionDrNo").html('<label>Description</label><input type="text" name="descriptionDrNo" value="<?php echo $getDrNo->description; ?>" class="form-control" readonly="readonly" />');
             }
           
        <?php endforeach; ?>
        
    
    
    });
</script>
<script>
  //choose
  new Vue({
  el: '#app-choose',

    data: {
      statuses:[
        { text:'Private-orders', value: 'Private-orders' },
        { text:'Ssp', value: 'Spp'}
      ]
    }
  })  

   //branch data
  new Vue({
  el: '#app-branch',
    data: {
      branches:[
        { text:'Terminal 1', value: 'Terminal 1' },
        { text:'Terminal 2', value: 'Terminal 2'}
      ]
    }
  })  
  
</script>
@endsection