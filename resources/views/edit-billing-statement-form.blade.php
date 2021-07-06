@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Edit Billing Statement |')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });

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
     @include('sidebar.sidebar')
     <div id="content-wrapper"> 
     	<div class="container-fluid">
     		<!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lechon de Cebu</a>
              </li>
              <li class="breadcrumb-item active">Update Billing Statement Form</li>
            </ol>
             <a href="{{ url('lolo-pinoy-lechon-de-cebu/billing-statement-lists') }}">Back to Lists</a>
             <div class="col-lg-12">
            	 <img src="{{ asset('images/digitized-logos/lolo-pinoy-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
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
                                  <form action="{{ action('LoloPinoyLechonDeCebuController@updateBillingInfo', $billingStatement['id']) }}" method="post">

                                   {{csrf_field()}}
                                   <input name="_method" type="hidden" value="PATCH">
                                  <div class="form-group">
                                    <div class="form-row">
                                      <div class="col-lg-6">
                                        <label>Bill to</label>
                                        <input type="text" name="billTo" class="form-control" value="{{ $billingStatement['bill_to'] }}" />
                                        <label>Address</label>
                                        <input type="text" name="address" class="form-control" value="{{ $billingStatement['address'] }}" />
                                        <label>Period Covered</label>
                                        <input type="text" name="periodCovered" class="form-control" value="{{ $billingStatement['period_cover'] }}" />
                                          </div>
                                      <div class="col-lg-6">
                                      <label>Date</label>
                                        <input type="text" name="transactionDate" class="datepicker form-control" value="{{ $billingStatement['date'] }}" />
                                       
                                        <label>Branch</label>
                                         <div id="app-branch">
                                           <select name="branch" class="form-control">
                                               <option value="0">--Please Select--</option>
                                                <option v-for="branch in branches" v-bind:value="branch.value":selected="branch.value=={{json_encode($billingStatement['branch'])}}?true : false">
                                                  @{{ branch.text }}
                                                 </option>
                                          </select>
                                          <label>Terms</label>
                                          <input type="text" name="terms" class="form-control" required="required" value="{{ $billingStatement['terms'] }}" />
                                    
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <div class="form-row">
                                      <div class="col-lg-2">
                                        <label>Date</label>
                                        <input type="text" name="transactionDate" class="datepicker form-control" disabled="disabled" value="{{ $billingStatement['date_of_transaction'] }}" />
                                      </div>
                                      @if($billingStatement['order'] == "Private Order")
                                      <div class="col-lg-2">
                                        <label>Order</label>
                                        <input type="text" name="choose" class="form-control" disabled="disabled" value="{{ $billingStatement['order'] }}" />
                                      </div>
                                   
                                      @endif
                                      @if($billingStatement['order'] != "Private Order")
                                      <div class="col-lg-2">
                                        <label>Invoice #</label>
                                          <input type="text" name="invoiceNumber" class="form-control"  disabled="disabled" value="{{ $billingStatement['invoice_number'] }}"  />
                                      </div>
                                      @endif
                                      @if($billingStatement['order'] == "Private Order")
                                      <div class="col-lg-2">
                                        <label>DR No</label>
                                          <input type="text" name="invoiceNumber" class="form-control"  value="{{ $billingStatement['dr_no'] }}" readonly="readonly" />
                                      </div>
                                      <div class="col-lg-4">
                                        <label>DR Address</label>
                                          <input type="text" name="drAddress" class="form-control"  value="{{ $billingStatement['dr_address'] }}" readonly="readonly" />
                                      </div>
                                      <div class="col-lg-4">
                                        <label>DR Delivered For</label>
                                          <input type="text" name="drDeliveredFor" class="form-control"  value="{{ $billingStatement['dr_delivered_for'] }}" readonly="readonly" />
                                      </div>
                                      @endif
                                      @if($billingStatement['order'] == "Private Order")
                                      <div class="col-lg-2">
                                        <label>Whole Lechon </label>
                                        <input type="text" name="wholeLechon" class="form-control"  readonly="readonly" disabled="disabled" value="{{ $billingStatement['whole_lechon'] }}" />
                                      </div>
                                     
                                      @endif 

                                      <div  class="col-lg-1">
                                        <label>Qty</label>
                                        <input type="text" name="qty" class="form-control"  value="{{ $billingStatement['qty']}}" disabled />
                                      
                                      </div>
                                      @if($billingStatement['order'] == "Private Order")
                                      <div  class="col-lg-1">
                                        <label>Unit</label>
                                        <input type="text" name="unit" class="form-control"  value="{{ $billingStatement['unit']}}" disabled />
                                      
                                      </div>
                                      @endif
                                      @if($billingStatement['order'] == "Ssp")
                                      <div  class="col-lg-2">
                                        <label>Body {{ $getBody[0]['settings_for_body'] }}/kls</label>
                                        <input type="text" name="qty" class="form-control"  value="{{ $billingStatement['body']}}" disabled />
                                      
                                      </div>
                                      <div  class="col-lg-2">
                                        <label>Head and Feet {{ $getHead[1]['settings_head_feet'] }}/kls</label>
                                        <input type="text" name="qty" class="form-control"  value="{{ $billingStatement['head_and_feet']}}" disabled />
                                      
                                      </div>
                                      @endif
                                      <div id="description" class="col-lg-4">
                                        <label>Description</label>
                                          <input type="text" name="description" class="form-control"  disabled="disabled" value="{{ $billingStatement['description'] }}" />
                                      </div>
                                    
                                      <div id="amount" class="col-lg-1">
                                        <label>Amount</label>
                                        <input type="text" name="amount" class="form-control" disabled="disabled" value="<?php echo number_format($billingStatement['amount'], 2); ?>" />
                                      </div>
                                    <br>
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
                            Add</div>
                          <div class="card-body">
                               @if(session('SuccessAdd'))
                                   <p class="alert alert-success">{{ Session::get('SuccessAdd') }}</p>
                                  @endif 
                              
                                <form action="{{ action('LoloPinoyLechonDeCebuController@addNewBilling', $billingStatement['id']) }}" method="post">
                                <div class="form-group">
                                    {{csrf_field()}}
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                            <label>Date</label>
                                            <input type="text" name="transactionDate" class="datepicker form-control" required autocomplete="off" />
                                        </div>
                                        <div class="col-lg-12">
                                          <label>Order</label>
                                          <select name="choose" class="chooseOption form-control" >
                                              <option value="Ssp">Ssp</option>
                                              <option value="Private Order">Private Order</option>        
                                          </select>
                                                
                                        </div>
                                       
                                        <div id="invoiceNo" class="col-lg-12">
                                            <label>SI No</label>
                                            <select data-live-search="true" name="invoiceNumber" class="invoiceSelect form-control selectpicker">
                                              <option value="0">--Please Select--</option>
                                              @foreach($getAllSalesInvoices as $getAllSalesInvoice)
                                              <option value="{{ $getAllSalesInvoice->lechon_de_cebu_code}}">{{ $getAllSalesInvoice->lechon_de_cebu_code}}</option>
                                              @endforeach
                                            </select>
                                        </div>
                                        <div id="invoiceList" class="col-lg-12">
                                            <label>Invoice List Id</label>
                                            <select id="dataInvoice" name="invoiceListId" class="chooseInvoice form-control "> 
                                            </select>
                                        </div>
                                        <div id="drNo" class="col-lg-12">
                                            <label>DR #</label>
                                            <select data-live-search="true" name="drNo" class="drSelect form-control selectpicker">
                                              <option value="0">--Please Select--</option>
                                              @foreach($drNos as $drNo)
                                              <option value="{{ $drNo->lechon_de_cebu_code}}">{{ $drNo->lechon_de_cebu_code}}</option>
                                              @endforeach
                                            </select>	
                                        </div>
                                        <div id="drList" class="col-lg-12">
                                            <label>DR Lists Id</label>
                                            <select id="dataList" name="drList" class="chooseDr form-control "> 
                                              <option value="0">--Please Select--</option>
                                            </select>
                                        </div>
                                        <div id="drAdd" class="col-lg-12">
                                            <label>DR Address</label>
                                            <input type="text" nam="drAddress" class="form-control" disabled />
                                        </div>
                                        <div id="drDeliveredFor" class="col-lg-12">
                                            <label>DR Delivered For</label>
                                            <input type="text" name="drDeliveredFor" class="form-control" disabled />
                                        </div>
                                        <div id="invoiceNum" class="col-lg-12">
                                          <label>Invoice #</label>
                                          <input type="text" name="invoiceNum1" class="form-control"  readonly="readonly" />
                                        
                                        </div>
                                        <div id="qty" class="col-lg-12">
                                          <label>Qty</label>
                                          <input type="text" name="qty" class="form-control"  readonly="readonly" />
                                        
                                        </div>
                                        <div id="unit" class="col-lg-12">
                                          <label>Unit</label>
                                          <input type="text" name="unit" class="form-control"  readonly="readonly" />
                                        
                                        </div>
                                        <div id="body" class="col-lg-12">
                                          <label>Body {{ $getBody[0]['settings_for_body'] }}/kls</label>
                                          <input type="text" name="body" class="form-control"  readonly="readonly" />
                                        
                                        </div>
                                        <div id="headFeet" class="col-lg-12">
                                          <label>Head & Feet {{ $getHead[1]['settings_head_feet'] }}/KLS</label>
                                          <input type="text" name="headFeet" class="form-control"  readonly="readonly" />
                                        
                                        </div>
                                        <div id="descriptionAdd"  class="col-lg-12">
                                            <label>Description</label>
                                            <input type="text" name="description" class="form-control"  readonly="readonly" />
                                        </div>
                                        <div id="price" class="col-lg-12">
                                            <label>Whole Lechon</label>
                                            <input type="text" name="wholeLechon" class="form-control"  readonly="readonly" />
                                        </div>
                                       
                                        <div id="amountAdd"  class="col-lg-12">
                                            <label>Amount</label>
                                            <input type="text" name="amount"  class="form-control" readonly="readonly" />
                                        </div>
                                       
                                       
                                    </div>
                                </div>
                                <div>
                                
                                <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-plus"></i> Add</button>
                     
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
                               @if(session('SuccessEdit'))
                                   <p class="alert alert-success">{{ Session::get('SuccessEdit') }}</p>
                                  @endif 
                                @foreach($bStatements as $bStatement)
                                <form action="{{ action('LoloPinoyLechonDeCebuController@updateBillingStatement', $bStatement['id']) }}" method="post">
                                <div class="form-group">
                                    {{csrf_field()}}
                                    <input name="_method" type="hidden" value="PATCH">

                                    <div id="deletedId{{ $bStatement['id'] }}" class="form-row">
                                       
                                        <div class="col-lg-2">
                                            <label>Date</label>
                                            <input type="text" name="transactionDate" class="form-control" disabled="disabled" value="{{ $bStatement['date_of_transaction'] }}" />
                                        </div>
                                       
                                        @if($bStatement['order'] != "Private Order")
                                        <div class="col-lg-2">
                                            <label>Invoice #</label>
                                            <input type="text" name="invoiceNumber" class="form-control" disabled="disbled" value="{{ $bStatement['input_invoice_number'] }}" />
                                        </div>
                                       @endif
                                       @if($bStatement['order'] == "Private Order")
                                        <div class="col-lg-2">
                                            <label>DR No</label>
                                            <input type="text" name="drNo" class="form-control" disabled="disbled" value="{{ $bStatement['dr_no'] }}" />
                                        </div>
                                        <div class="col-lg-4">
                                            <label>DR Address</label>
                                            <input type="text" name="drAddress" class="form-control" disabled="disbled" value="{{ $bStatement['dr_address'] }}" />
                                        </div>
                                        <div class="col-lg-4">
                                            <label>DR Delivered For</label>
                                            <input type="text" name="drDeliveredFor" class="form-control" disabled="disbled" value="{{ $bStatement['dr_delivered_for'] }}" />
                                        </div>
                                       @endif
                                       <div class="col-lg-2">
                                            <label>Qty</label>
                                            <input type="text" name="qty" class="form-control" value="{{ $bStatement['qty'] }}" disabled="diasabled" />
                                        </div>
                                        @if($bStatement['order'] == "Private Order")
                                        <div class="col-lg-2">
                                            <label>Unit</label>
                                            <input type="text" name="Unit" class="form-control" value="{{ $bStatement['unit'] }}" disabled="diasabled" />
                                        </div>
                                        @endif
                                        @if($bStatement['order'] == "Ssp")
                                        <div class="col-lg-2">
                                            <label>Body {{ $getBody[0]['settings_for_body'] }}/kls</label>
                                            <input type="text" name="body" class="form-control" value="{{ $bStatement['body'] }}" disabled="diasabled" />
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Head and Feet {{ $getHead[1]['settings_head_feet'] }}/kls</label>
                                            <input type="text" name="body" class="form-control" value="{{ $bStatement['head_and_feet'] }}" disabled="diasabled" />
                                        </div>
                                        @endif 
                                        @if($bStatement['order'] == "Private Order")
                                        <div class="col-lg-4">
                                            <label>Whole Lechon</label>
                                            <input type="text" name="wholeLechon" class="form-control" readonly="readonly" value="{{ $bStatement['whole_lechon'] }}" />
                                        </div>
                                        @endif
                                       
                                        <div class="col-lg-6">
                                            <label>Description</label>
                                            <input type="text" name="description" class="form-control"  disabled="disabled" value="{{ $bStatement['description'] }}" />
                                        </div>
                                       
                                        <div class="col-lg-2">
                                            <label>Amount</label>
                                            <input type="text" name="amount" class="form-control" disabled="disabled" value="<?php echo number_format($bStatement['amount'], 2); ?>" />
                                        </div>
                                        <div class="col-lg-4">
                                          <br>
                                          <input type="hidden" id="billingStatementId" name="billingStatementId" value="{{ $billingStatement['id'] }}" />
                                         
                                          @if($bStatement['order'] != "Private Order")
                                         <!-- <input type="submit" class="btn btn-success" value="Update" />-->
                                          @endif
                                          @if(Auth::user()['role_type'] == 1)
                                         
                                          <a id="delete" onclick="confirmDelete('{{ $bStatement['id'] }}')" href="javascript:void" class="btn btn-danger">Remove</a>
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
  el: '#app-branch',
    data: {
      branches:[
        { text:'Terminal 1', value: 'Terminal 1' },
        { text:'Terminal 2', value: 'Terminal 2'}
      ]
    }
  }) 
</script>
<script type="text/javascript">
   const confirmDelete = (id) =>{
     const billingStatementId =  $("#billingStatementId").val();
      var x = confirm("Do you want to delete this?");
        if(x){
            $.ajax({
              type: "DELETE",
              url: '/lolo-pinoy-lechon-de-cebu/delete-data-billing-statement/' + id,
              data:{
                _method: 'delete', 
                "_token": "{{ csrf_token() }}",
                "id": id,
                "billingStatementId":billingStatementId,
                
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

    $("#drNo").hide();
    $("#price").hide();
    $("#descriptionDrNo").hide();
    $("#drList").hide();
    $("#unit").hide();

    $("#drAdd").hide();
    $("#drDeliveredFor").hide();  

    $(".chooseOption").change(function(){
         const cat  = $(this.options[this.selectedIndex]).closest('option:selected').val();
         if(cat === "Ssp"){
             $("#invoiceNo").show();
             $("#wholeLechon").show();
             $("#description").show();
             $("#invoiceList").show();
             $("#qty").show();
             $("#body").show();
             $("#headFeet").show();
             $("#invoiceNum").show();

             $("#drNo").hide();
             $("#price").hide();
             $("#description").hide();
             $("#drList").hide();
             $("#unit").hide();
             $("#drAdd").hide();
             $("#drDeliveredFor").hide();
         }else if(cat === "Private Order"){
             $("#drNo").show();
             $("#price").show();
             $("#description").show();
             $("#drList").show();
             $("#qty").show();
             $("#unit").show();

             $("#drAdd").show();
             $("#drDeliveredFor").show();

             $("#invoiceNo").hide();
             $("#invoiceList").hide();

             $("#body").hide();
             $("#headFeet").hide();
             $("#amountAdd").hide();
             $("#wholeLechon").hide();
             $("#description").hide();
             $("#invoiceNum").hide();
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
                          `<option value="<?php echo $getSIInside->id?>"><?= $getSIInside->id?></option>
                          `);
                  $(".chooseInvoice").change(function(){
                      const cat  = $(this.options[this.selectedIndex]).closest('option:selected').val();
                      <?php 
                              $datas  = DB::table(
                                      'lechon_de_cebu_sales_invoices')
                                      ->where('id', $getSIInside->id)
                                      ->get(); ?>

                      <?php foreach($datas as $data): ?>
                            if(cat === "<?= $data->id?>"){
                              $("#invoiceNum").html('<label>Invoice #</label><input type="text" name="invoiceNum1" class="form-control" value="<?= $data->invoice_number;?>" readonly="readonly">');
                              $("#qty").html('<label>Qty</label><input type="text" name="qty" value="<?= $data->qty; ?>" class="form-control" readonly="readonly" />');
                              $("#body").html('<label> Body 400/kls</label><input type="text" name="body" value="<?= $data->body; ?>" class="form-control" readonly="readonly" />');
                              $("#headFeet").html('<label> Head & Feet 200/KLS</label><input type="text" name="headFeet" value="<?= $data->head_and_feet; ?>" class="form-control" readonly="readonly" />');
                              
                              $("#descriptionAdd").html('<label>Description</label><input type="text" name="description" value="<?= $data->item_description; ?>" class="form-control" readonly="readonly" />');
                              $("#amountAdd").html('<label>Amount</label><input type="text" name="amount" value="<?= $data->amount; ?>" class="form-control" readonly="readonly" />');
         
                            }
                      <?php endforeach;?>
                  });
              <?php endforeach; ?>

            $("#invoiceNum").html('<label>Invoice #</label><input type="text" name="invoiceNum1" class="form-control" value="<?= $data->invoice_number;?>" readonly="readonly">');
                          
            $("#qty").html('<label>Qty</label><input type="text" name="qty" value="<?= $salesInvoice->qty; ?>" class="form-control" readonly="readonly" />');
            $("#body").html('<label> Body 400/kls</label><input type="text" name="body" value="<?= $salesInvoice->body; ?>" class="form-control" readonly="readonly" />');
            $("#headFeet").html('<label> Head & Feet 200/KLS</label><input type="text" name="headFeet" value="<?= $salesInvoice->head_and_feet; ?>" class="form-control" readonly="readonly" />');
            
            $("#descriptionAdd").html('<label>Description</label><input type="text" name="description" value="<?= $salesInvoice->item_description; ?>" class="form-control" readonly="readonly" />');
            $("#amountAdd").html('<label>Amount</label><input type="text" name="amount" value="<?= $salesInvoice->amount; ?>" class="form-control" readonly="readonly" />');
         
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
                             'lechon_de_cebu_delivery_receipts.delivered_for',
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

        var dr = $(this).children("option:selected").val();
        <?php foreach($getDrNos as $key=>$getDrNo ): ?>
             if(dr === "<?php echo $getDrNo->lechon_de_cebu_code?>"){
              <?php 
                    $getDrNosInsides = DB::table(
                                    'lechon_de_cebu_delivery_receipts')
                                    ->where('dr_no', $getDrNo->dr_no)
                                    
                                    ->get(); ?>
                
                <?php foreach($getDrNosInsides as $getDrNosInside):?>
                      $("#dataList").append(  
                          `
                           <option value="<?= $getDrNosInside->id?>"><?= $getDrNosInside->id?></option>
                          `);
                        
                        $(".chooseDr").change(function(){
                            const cat  = $(this.options[this.selectedIndex]).closest('option:selected').val();
                            <?php 
                              $datas  = DB::table(
                                      'lechon_de_cebu_delivery_receipts')
                                      ->where('id', $getDrNosInside->id)
                                      ->get(); ?>

                               <?php foreach($datas as $data): ?>
                                     if(cat === "<?= $data->id?>"){
                                          $("#qty").html('<label>Qty</label><input type="text" name="qty" value="<?= $data->qty; ?>" class="form-control" readonly="readonly" />');
                                          $("#unit").html('<label>Unit</label><input type="text" name="unit" value="<?= $data->unit; ?>" class="form-control" readonly="readonly" />');
                                         
                                          $("#price").html('<label>Whole Lechon</label><input type="text" name="price" value="<?= $data->price; ?>" class="form-control" readonly="readonly" />');
                                          $("#descriptionAdd").html(`<label>Description</label><input type="text" name="description" value="<?= $data->description; ?>" class="form-control" readonly="readonly" />`);
            
                                     }
                               <?php endforeach;?>
                        });       

                  <?php endforeach; ?>  

                $("#drAdd").html(`<label>DR Address</label><input type="text" name="drAddress" value="<?= $getDrNo->delivered_to; ?>" class="form-control" readonly="readonly" />`);
                 $("#drDeliveredFor").html(`<label>DR Delivered For</label><input type="text" name="drDeliveredFor" value="<?= $getDrNo->delivered_for; ?>" class="form-control" readonly="readonly" />`);
               
                $("#qty").html('<label>Qty</label><input type="text" name="qty" value="<?= $data->qty; ?>" class="form-control" readonly="readonly" />');
                $("#unit").html('<label>Unit</label><input type="text" name="unit" value="<?= $data->unit; ?>" class="form-control" readonly="readonly" />');
                                         
                $("#price").html('<label>Whole Lechon</label><input type="text" name="price" value="<?= $getDrNo->price; ?>" class="form-control" readonly="readonly" />');
                $("#descriptionAdd").html(`<label>Description</label><input type="text" name="description" value="<?= $getDrNo->description; ?>" class="form-control" readonly="readonly" />`);
             }
           
        <?php endforeach; ?>
    });

</script>
@endsection