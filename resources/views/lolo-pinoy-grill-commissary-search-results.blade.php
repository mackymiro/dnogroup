@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'Search Results |')
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css" >
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<div id="wrapper">
     @include('sidebar.sidebar-lolo-pinoy-grill')
     <div id="content-wrapper">
        <div class="container-fluid">
             <!-- Breadcrumbs-->
             <h1 class="mt-4">Search Number Code</h1>
             <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">Lolo Pinoy Grill Commissary </a>
                </li>
                <li class="breadcrumb-item active">Search Number Code</li>
                
              </ol>
              <div class="row">
                 <div class="col-lg-12">
                     <div class="card mb-3">
                        <div class="card-header">
                        <i class="fa fa-search" aria-hidden="true"></i>

	    					  Search Number Code
                        </div>
                        <div class="card-body">
                            <form action="{{ action('LoloPinoyLechonDeCebuController@search') }}" method="get">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="form-row">
                                     <div class="col-lg-4">
                                        <label>Search </label>
                                        <select data-live-search="true" name="searchCode" class="form-control selectpicker">
                                            @foreach($getAllCodes as $getAllCode)
                                            <option value="{{ $getAllCode['lolo_pinoy_grill_code']}}">{{ $getAllCode['lolo_pinoy_grill_code']  }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <br>
                                        
                                       <button class="btn btn-success btn-lg"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                     </div>
                 </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                     <div class="card mb-3">
                        <div class="card-header">
                         <i class="fa fa-search" aria-hidden="true"></i>
                             Search Result
                        </div>
                        <div class="card-body">
                            @if($module === "Sales Invoice")
                                @foreach($getSearchSalesInvoices as $getSearchSalesInvoice)
                                <p style="font-size:28px;">
                                    {{ $getSearchSalesInvoice->module_name}} <br>{{ $getSearchSalesInvoice->module_code }}{{ $getSearchSalesInvoice->lolo_pinoy_grill_code }}
                                    <a href="{{ url('lolo-pinoy-grill-commissary/view-sales-invoice/'.$getSearchSalesInvoice->id) }}">View Number Code</a> 
                                </p>
                                
                                @endforeach
                            @elseif($module === "Delivery Receipt")
                                 @foreach($getSearchDeliveryReceipts as $getSearchDeliveryReceipt)
                                    <p style="font-size:28px;">
                                        {{ $getSearchDeliveryReceipt->module_name}} <br>{{ $getSearchDeliveryReceipt->module_code }}{{ $getSearchDeliveryReceipt->lolo_pinoy_grill_code }}
                                        <a href="{{ url('/lolo-pinoy-grill-commissary/view-delivery-receipt/'.$getSearchDeliveryReceipt->id) }}">View Number Code</a> 
                                    </p>
                                @endforeach
                            @elseif($module === "Purchase Order")
                                 @foreach($getSearchPurchaseOrders as $getSearchPurchaseOrder)
                                    <p style="font-size:28px;">
                                        {{ $getSearchPurchaseOrder->module_name}} <br>{{ $getSearchPurchaseOrder->module_code }}{{ $getSearchPurchaseOrder->lolo_pinoy_grill_code }}
                                        <a href="{{ url('lolo-pinoy-grill-commissary/view/'.$getSearchPurchaseOrder->id) }}">View Number Code</a> 
                                    </p>
                                @endforeach
                            
                          
                             @elseif($module === "Petty Cash")
                                @foreach($getSearchPettyCashes as $getSearchPettyCash)
                                    <p style="font-size:28px;">
                                        {{ $getSearchPettyCash->module_name}} <br>{{ $getSearchPettyCash->module_code }}{{ $getSearchPettyCash->lolo_pinoy_grill_code }}
                                        <a href="{{ url('lolo-pinoy-grill-commissary/petty-cash/view/'.$getSearchPettyCash->id) }}">View Number Code</a> 
                                    </p>
                                @endforeach
                             @elseif($module === "Payment Voucher")
                                @foreach($getSearchPaymentVouchers as $getSearchPaymentVoucher)
                                    <p style="font-size:28px;">
                                        {{ $getSearchPaymentVoucher->module_name}} <br>{{ $getSearchPaymentVoucher->module_code }}{{ $getSearchPaymentVoucher->lolo_pinoy_grill_code }}
                                        <a href="">View Number Code</a> 
                                    </p>
                                @endforeach
                            @endif
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
@endsection