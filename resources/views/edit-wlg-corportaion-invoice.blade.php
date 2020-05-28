@extends('layouts.wlg-corporation-app')
@section('title', 'Edit Invoice  |')
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
<div id="wrapper">
    @include('sidebar.sidebar-wlg-corporation')
    <div id="content-wrapper">  
         <div class="container-fluid">
             <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">WLG Corporation</a>
                    </li>
                    <li class="breadcrumb-item active">Invoice</li>
                    @if(\Request::is('wlg-corporation/edit-invoice/'.$invoice['id']))
                    <li class="breadcrumb-item active">Edit Invoice</li>
                    @elseif(\Request::is('wlg-corporation/edit-pro-forma-invoice/'.$invoice['id']))
                    <li class="breadcrumb-item active">Edit Pro-Forma Invoice</li>
                     @elseif(\Request::is('wlg-corporation/edit-commercial-invoice/'.$invoice['id']))
                    <li class="breadcrumb-item active">Edit Commercial Invoice</li>
                    @elseif(\Request::is('wlg-corporation/edit-quotation-invoice/'.$invoice['id']))
                    <li class="breadcrumb-item active">Edit Quotation </li>
                    @elseif(\Request::is('wlg-corporation/edit-packing-list/'.$invoice['id']))
                    <li class="breadcrumb-item active">Edit Packing List </li>
                    @endif
                </ol>
                @if(\Request::is('wlg-corporation/edit-invoice/'.$invoice['id']))
                <a href="{{ url('wlg-corporation') }}">Back to List</a>
                @elseif(\Request::is('wlg-corporation/edit-pro-forma-invoice/'.$invoice['id']))
                <a href="{{ url('wlg-corporation/pro-forma-invoice/lists') }}">Back to List</a>
                @elseif(\Request::is('wlg-corporation/edit-commercial-invoice/'.$invoice['id']))
                <a href="{{ url('wlg-corporation/commercial-invoice/lists') }}">Back to List</a>
                @elseif(\Request::is('wlg-corporation/edit-quotation-invoice/'.$invoice['id']))
                <a href="{{ url('wlg-corporation/quotation-invoice/lists') }}">Back to List</a>
                @elseif(\Request::is('wlg-corporation/edit-packing-list/'.$invoice['id']))
                <a href="{{ url('wlg-corporation/packing-list/lists') }}">Back to List</a>
                @endif
                <div class="col-lg-12">
                    <img src="{{ asset('images/wlg-corporation.png')}}" width="235" height="114" class="img-responsive mx-auto d-block" alt="WLG Corporation">                
                    @if(\Request::is('wlg-corporation/edit-invoice/'.$invoice['id']))
                        <h4 class="text-center"><u>INVOICE FORM </u></h4>
                    @elseif(\Request::is('wlg-corporation/edit-pro-forma-invoice/'.$invoice['id']))
                    <h4 class="text-center"><u>PRO-FORMA INVOICE </u></h4>
                    @elseif(\Request::is('wlg-corporation/edit-commercial-invoice/'.$invoice['id']))
                    <h4 class="text-center"><u>COMMERCIAL INVOICE </u></h4>
                    @elseif(\Request::is('wlg-corporation/edit-quotation-invoice/'.$invoice['id']))
                    <h4 class="text-center"><u>QUOTATION </u></h4>
                    @elseif(\Request::is('wlg-corporation/edit-packing-list/'.$invoice['id']))
                    <h4 class="text-center"><u>PACKING LIST </u></h4>
                    @endif
                </div>
                @if(\Request::is('wlg-corporation/edit-invoice/'.$invoice['id']))
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <i class="fa fa-file-invoice" aria-hidden="true"></i>
                                Invoice Form                         
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-2">
                                            <label>Date</label>
                                            <input type="text" name="date" class="datepicker form-control" value="{{ $invoice['date'] }}" autocomplete="off" />
                                           
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Delivery Terms</label>
                                            <input type="text" name="deliveryTerms" class=" form-control" value="{{ $invoice['delivery_terms'] }}"/>
                                           
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Tranport By</label>
                                            <input type="text" name="transportBy" class=" form-control"  value="{{ $invoice['transport_by'] }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Invoice Number</label>
                                            <input type="text" name="invoiceNumber" class=" form-control" value="{{ $invoice['invoice_number'] }}" disabled="disabled" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-4">
                                            <label>Shipper</label>
                                            <input type="text" name="shipper" class="form-control" value="{{ $invoice['shipper'] }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Consignee</label>
                                            <input type="text" name="consignee" class=" form-control" value="{{ $invoice['consignee'] }}" />
                                        </div>
                                        <div class="col-lg-2 ">
                                            <label>Notify Party</label>
                                            <input type="text" name="notifyParty" class=" form-control" value="{{ $invoice['notify_party'] }}"  />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Attention</label>
                                            <input type="text" name="attention" class=" form-control"  value="{{ $invoice['attention'] }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-1">
                                            <label>No</label>
                                            <input type="text" name="no" class="form-control " value="{{ $invoice['number_of_goods'] }}" />
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Description of Goods</label>
                                            <input type="text" name="descGoods" class="form-control " value="{{ $invoice['description_of_goods'] }}"  />
                                           
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Qty</label>
                                            <input type="text" name="qty" class="form-control" value="{{ $invoice['qty'] }}"  />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Unit Price (USD)</label>
                                            <input type="text" name="unitPrice" class="form-control" value="{{ $invoice['unit_price'] }}"  />
                                        </div>
                                         <div class="col-lg-2">
                                            <label>Total Amount </label>
                                            <input type="text" name="totalAmount" class="form-control" value="{{ $invoice['total_amount'] }}"  />
                                        </div>
                                    </div>
                                </div>
                                <div class="float-right">
		  	 				      <button type="submit" class="btn btn-success " ><i class="fas fa-redo-alt"></i> Update Invoice</button>
                               </div>
                            </div>
                        </div>
                    </div>      
                </div><!-- end of row -->
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card mb-3">
                             <div class="card-header">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Add                       
                            </div>
                            <div class="card-body">
                                <form action="{{ action('WlgCorporationController@addNewInvoice', $invoice['id'] ) }}" method="post">
                                {{ csrf_field() }}
                                @if(session('successAdd'))
                                    <p class="alert alert-success">{{ Session::get('successAdd') }}</p>
                                @endif 
                                 <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                            <label>No</label>
                                            <input type="text" name="no" class="form-control" required/>
                                        </div>
                                        <div class="col-lg-12">
                                            <label>Description of Goods</label>
                                            <input type="text" name="descGoods" class="form-control " required />
                                          
                                        </div>
                                        <div class="col-lg-12">
                                            <label>Qty</label>
                                            <input type="text" name="qty" class="form-control " required/>
                                        </div>
                                        <div class="col-lg-12">
                                            <label>Unit Price (USD)</label>
                                            <input type="text" name="unitPrice" class="form-control " required/>
                                        </div>
                                         <div class="col-lg-12">
                                            <label>Total Amount </label>
                                            <input type="text" name="totalAmount" class="form-control " required/>
                                        </div>
                                    </div>
                                </div>
                                 <button type="submit" class="btn btn-primary " ><i class="fas fa-plus"></i> Add</button>
                               </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card mb-3">
                             <div class="card-header">
                                <i class="fa fa-file-invoice" aria-hidden="true"></i>
                                Edit Invoice                       
                            </div>
                            <div class="card-body">
                                @foreach($invoiceForms as $invoiceForm)
                                <form action="{{ action('WlgCorporationController@updateIF', $invoiceForm['id'] ) }}" method="post">
                                 {{csrf_field()}}
                                <input name="_method" type="hidden" value="PATCH">
                                @if(session('successEdit'))
                                    <p class="alert alert-success">{{ Session::get('successEdit') }}</p>
                                @endif 
                                <div id="deletedId{{ $invoiceForm['id'] }}">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-1">
                                            <label>No</label>
                                            <input type="text" name="no" class="form-control" value="{{ $invoiceForm['number_of_goods'] }}" />
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Description of Goods</label>
                                            <input type="text" name="descGoods" class="form-control " value="{{ $invoiceForm['description_of_goods'] }}" />
                                          
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Qty</label>
                                            <input type="text" name="qty" class="form-control" value="{{ $invoiceForm['qty'] }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Unit Price (USD)</label>
                                            <input type="text" name="unitPrice" class="form-control " value="{{ $invoiceForm['unit_price'] }}"/>
                                        </div>
                                         <div class="col-lg-2">
                                            <label>Total Amount </label>
                                            <input type="text" name="totalAmount" class="form-control " value="{{ $invoiceForm['total_amount'] }}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div>
                                            <input type="hidden" name="iFId" value="{{ $invoice['id'] }}" />
                                            <button type="submit" class="btn btn-success"> <i class="fas fa-redo-alt"></i></button>
                                            
                                            @if(Auth::user()['role_type'] == 1)
                                              <a href="javascript:void" onclick="confirmDelete('{{ $invoiceForm['id'] }}')" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                             @endif
                                        </div>
                                    </div>
                                </div>
                                </div>
                                </form>
                                @endforeach
                            </div><!-- end of card body -->
                        </div>
                    </div>
                </div><!-- end of row -->
                @elseif(\Request::is('wlg-corporation/edit-pro-forma-invoice/'.$invoice['id']))
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <i class="fa fa-file-invoice" aria-hidden="true"></i>
                                Invoice Form                         
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-2">
                                            <label>Date</label>
                                            <input type="text" name="date" class="datepicker form-control" value="{{ $invoice['date'] }}" autocomplete="off" />
                                           
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Delivery Terms</label>
                                            <input type="text" name="deliveryTerms" class=" form-control" value="{{ $invoice['delivery_terms'] }}"/>
                                           
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Tranport By</label>
                                            <input type="text" name="transportBy" class=" form-control"  value="{{ $invoice['transport_by'] }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Invoice Number</label>
                                            <input type="text" name="invoiceNumber" class=" form-control" value="{{ $invoice['invoice_number'] }}" disabled="disabled" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-4">
                                            <label>Shipper</label>
                                            <input type="text" name="shipper" class="form-control" value="{{ $invoice['shipper'] }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Consignee</label>
                                            <input type="text" name="consignee" class=" form-control" value="{{ $invoice['consignee'] }}" />
                                        </div>
                                        <div class="col-lg-2 ">
                                            <label>Notify Party</label>
                                            <input type="text" name="notifyParty" class=" form-control" value="{{ $invoice['notify_party'] }}"  />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Attention</label>
                                            <input type="text" name="attention" class=" form-control"  value="{{ $invoice['attention'] }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-1">
                                            <label>No</label>
                                            <input type="text" name="no" class="form-control " value="{{ $invoice['number_of_goods'] }}" />
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Description of Goods</label>
                                            <input type="text" name="descGoods" class="form-control " value="{{ $invoice['description_of_goods'] }}"  />
                                           
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Qty</label>
                                            <input type="text" name="qty" class="form-control" value="{{ $invoice['qty'] }}"  />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Unit Price (USD)</label>
                                            <input type="text" name="unitPrice" class="form-control" value="{{ $invoice['unit_price'] }}"  />
                                        </div>
                                         <div class="col-lg-2">
                                            <label>Total Amount </label>
                                            <input type="text" name="totalAmount" class="form-control" value="{{ $invoice['total_amount'] }}"  />
                                        </div>
                                    </div>
                                </div>
                                <div class="float-right">
		  	 				      <button type="submit" class="btn btn-success " ><i class="fas fa-redo-alt"></i> Update Invoice</button>
                               </div>
                            </div>
                        </div>
                    </div>      
                </div><!-- end of row -->
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card mb-3">
                             <div class="card-header">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Add                       
                            </div>
                            <div class="card-body">
                                <form action="{{ action('WlgCorporationController@addNewInvoiceProForma', $invoice['id'] ) }}" method="post">
                                {{ csrf_field() }}
                                @if(session('successAdd'))
                                    <p class="alert alert-success">{{ Session::get('successAdd') }}</p>
                                @endif 
                                 <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                            <label>No</label>
                                            <input type="text" name="no" class="form-control" required/>
                                        </div>
                                        <div class="col-lg-12">
                                            <label>Description of Goods</label>
                                            <input type="text" name="descGoods" class="form-control " required />
                                          
                                        </div>
                                        <div class="col-lg-12">
                                            <label>Qty</label>
                                            <input type="text" name="qty" class="form-control " required/>
                                        </div>
                                        <div class="col-lg-12">
                                            <label>Unit Price (USD)</label>
                                            <input type="text" name="unitPrice" class="form-control " required/>
                                        </div>
                                         <div class="col-lg-12">
                                            <label>Total Amount </label>
                                            <input type="text" name="totalAmount" class="form-control " required/>
                                        </div>
                                    </div>
                                </div>
                                 <button type="submit" class="btn btn-primary " ><i class="fas fa-plus"></i> Add</button>
                               </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card mb-3">
                             <div class="card-header">
                                <i class="fa fa-file-invoice" aria-hidden="true"></i>
                                Edit Invoice                       
                            </div>
                            <div class="card-body">
                                @foreach($invoiceForms as $invoiceForm)
                                <form action="{{ action('WlgCorporationController@updateProForma', $invoiceForm['id'] ) }}" method="post">
                                 {{csrf_field()}}
                                <input name="_method" type="hidden" value="PATCH">
                                @if(session('successEdit'))
                                    <p class="alert alert-success">{{ Session::get('successEdit') }}</p>
                                @endif 
                                <div id="deletedId{{ $invoiceForm['id'] }}">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-1">
                                            <label>No</label>
                                            <input type="text" name="no" class="form-control" value="{{ $invoiceForm['number_of_goods'] }}" />
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Description of Goods</label>
                                            <input type="text" name="descGoods" class="form-control " value="{{ $invoiceForm['description_of_goods'] }}" />
                                          
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Qty</label>
                                            <input type="text" name="qty" class="form-control" value="{{ $invoiceForm['qty'] }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Unit Price (USD)</label>
                                            <input type="text" name="unitPrice" class="form-control " value="{{ $invoiceForm['unit_price'] }}"/>
                                        </div>
                                         <div class="col-lg-2">
                                            <label>Total Amount </label>
                                            <input type="text" name="totalAmount" class="form-control " value="{{ $invoiceForm['total_amount'] }}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div>
                                            <input type="hidden" name="proFormaId" value="{{ $invoice['id'] }}" />
                                            <button type="submit" class="btn btn-success"> <i class="fas fa-redo-alt"></i></button>
                                            
                                            @if(Auth::user()['role_type'] == 1)
                                              <a href="javascript:void" onclick="confirmDelete('{{ $invoiceForm['id'] }}')" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                             @endif
                                        </div>
                                    </div>
                                </div>
                                </div>
                                </form>
                                @endforeach
                            </div><!-- end of card body -->
                        </div>
                    </div>
                </div><!-- end of row -->
                @elseif(\Request::is('wlg-corporation/edit-commercial-invoice/'.$invoice['id']))
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <i class="fa fa-file-invoice" aria-hidden="true"></i>
                                Invoice Form                         
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-2">
                                            <label>Date</label>
                                            <input type="text" name="date" class="datepicker form-control" value="{{ $invoice['date'] }}" autocomplete="off" />
                                           
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Delivery Terms</label>
                                            <input type="text" name="deliveryTerms" class=" form-control" value="{{ $invoice['delivery_terms'] }}"/>
                                           
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Tranport By</label>
                                            <input type="text" name="transportBy" class=" form-control"  value="{{ $invoice['transport_by'] }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Invoice Number</label>
                                            <input type="text" name="invoiceNumber" class=" form-control" value="{{ $invoice['invoice_number'] }}" disabled="disabled" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-4">
                                            <label>Shipper</label>
                                            <input type="text" name="shipper" class="form-control" value="{{ $invoice['shipper'] }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Consignee</label>
                                            <input type="text" name="consignee" class=" form-control" value="{{ $invoice['consignee'] }}" />
                                        </div>
                                        <div class="col-lg-2 ">
                                            <label>Notify Party</label>
                                            <input type="text" name="notifyParty" class=" form-control" value="{{ $invoice['notify_party'] }}"  />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Attention</label>
                                            <input type="text" name="attention" class=" form-control"  value="{{ $invoice['attention'] }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-1">
                                            <label>No</label>
                                            <input type="text" name="no" class="form-control " value="{{ $invoice['number_of_goods'] }}" />
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Description of Goods</label>
                                            <input type="text" name="descGoods" class="form-control " value="{{ $invoice['description_of_goods'] }}"  />
                                           
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Qty</label>
                                            <input type="text" name="qty" class="form-control" value="{{ $invoice['qty'] }}"  />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Unit Price (USD)</label>
                                            <input type="text" name="unitPrice" class="form-control" value="{{ $invoice['unit_price'] }}"  />
                                        </div>
                                         <div class="col-lg-2">
                                            <label>Total Amount </label>
                                            <input type="text" name="totalAmount" class="form-control" value="{{ $invoice['total_amount'] }}"  />
                                        </div>
                                    </div>
                                </div>
                                <div class="float-right">
		  	 				      <button type="submit" class="btn btn-success " ><i class="fas fa-redo-alt"></i> Update Invoice</button>
                               </div>
                            </div>
                        </div>
                    </div>      
                </div><!-- end of row -->
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card mb-3">
                             <div class="card-header">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Add                       
                            </div>
                            <div class="card-body">
                                <form action="{{ action('WlgCorporationController@addNewCommercialInvoice', $invoice['id'] ) }}" method="post">
                                {{ csrf_field() }}
                                @if(session('successAdd'))
                                    <p class="alert alert-success">{{ Session::get('successAdd') }}</p>
                                @endif 
                                 <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                            <label>No</label>
                                            <input type="text" name="no" class="form-control" required/>
                                        </div>
                                        <div class="col-lg-12">
                                            <label>Description of Goods</label>
                                            <input type="text" name="descGoods" class="form-control " required />
                                          
                                        </div>
                                        <div class="col-lg-12">
                                            <label>Qty</label>
                                            <input type="text" name="qty" class="form-control " required/>
                                        </div>
                                        <div class="col-lg-12">
                                            <label>Unit Price (USD)</label>
                                            <input type="text" name="unitPrice" class="form-control " required/>
                                        </div>
                                         <div class="col-lg-12">
                                            <label>Total Amount </label>
                                            <input type="text" name="totalAmount" class="form-control " required/>
                                        </div>
                                    </div>
                                </div>
                                 <button type="submit" class="btn btn-primary " ><i class="fas fa-plus"></i> Add</button>
                               </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card mb-3">
                             <div class="card-header">
                                <i class="fa fa-file-invoice" aria-hidden="true"></i>
                                Edit Invoice                       
                            </div>
                            <div class="card-body">
                                @foreach($invoiceForms as $invoiceForm)
                                <form action="{{ action('WlgCorporationController@updateCommercialInvoice', $invoiceForm['id'] ) }}" method="post">
                                 {{csrf_field()}}
                                <input name="_method" type="hidden" value="PATCH">
                                @if(session('successEdit'))
                                    <p class="alert alert-success">{{ Session::get('successEdit') }}</p>
                                @endif 
                                <div id="deletedId{{ $invoiceForm['id'] }}">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-1">
                                            <label>No</label>
                                            <input type="text" name="no" class="form-control" value="{{ $invoiceForm['number_of_goods'] }}" />
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Description of Goods</label>
                                            <input type="text" name="descGoods" class="form-control " value="{{ $invoiceForm['description_of_goods'] }}" />
                                          
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Qty</label>
                                            <input type="text" name="qty" class="form-control" value="{{ $invoiceForm['qty'] }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Unit Price (USD)</label>
                                            <input type="text" name="unitPrice" class="form-control " value="{{ $invoiceForm['unit_price'] }}"/>
                                        </div>
                                         <div class="col-lg-2">
                                            <label>Total Amount </label>
                                            <input type="text" name="totalAmount" class="form-control " value="{{ $invoiceForm['total_amount'] }}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div>
                                            <input type="hidden" name="commercialInvoiceId" value="{{ $invoice['id'] }}" />
                                            <button type="submit" class="btn btn-success"> <i class="fas fa-redo-alt"></i></button>
                                            
                                            @if(Auth::user()['role_type'] == 1)
                                              <a href="javascript:void" onclick="confirmDelete('{{ $invoiceForm['id'] }}')" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                             @endif
                                        </div>
                                    </div>
                                </div>
                                </div>
                                </form>
                                @endforeach
                            </div><!-- end of card body -->
                        </div>
                    </div>
                </div><!-- end of row -->
                @elseif(\Request::is('wlg-corporation/edit-quotation-invoice/'.$invoice['id']))
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <i class="fa fa-file-invoice" aria-hidden="true"></i>
                                Invoice Form                         
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-2">
                                            <label>Date</label>
                                            <input type="text" name="date" class="datepicker form-control" value="{{ $invoice['date'] }}" autocomplete="off" />
                                           
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Delivery Terms</label>
                                            <input type="text" name="deliveryTerms" class=" form-control" value="{{ $invoice['delivery_terms'] }}"/>
                                           
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Tranport By</label>
                                            <input type="text" name="transportBy" class=" form-control"  value="{{ $invoice['transport_by'] }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Invoice Number</label>
                                            <input type="text" name="invoiceNumber" class=" form-control" value="{{ $invoice['invoice_number'] }}" disabled="disabled" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-4">
                                            <label>Shipper</label>
                                            <input type="text" name="shipper" class="form-control" value="{{ $invoice['shipper'] }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Consignee</label>
                                            <input type="text" name="consignee" class=" form-control" value="{{ $invoice['consignee'] }}" />
                                        </div>
                                        <div class="col-lg-2 ">
                                            <label>Notify Party</label>
                                            <input type="text" name="notifyParty" class=" form-control" value="{{ $invoice['notify_party'] }}"  />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Attention</label>
                                            <input type="text" name="attention" class=" form-control"  value="{{ $invoice['attention'] }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-1">
                                            <label>No</label>
                                            <input type="text" name="no" class="form-control " value="{{ $invoice['number_of_goods'] }}" />
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Description of Goods</label>
                                            <input type="text" name="descGoods" class="form-control " value="{{ $invoice['description_of_goods'] }}"  />
                                           
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Qty</label>
                                            <input type="text" name="qty" class="form-control" value="{{ $invoice['qty'] }}"  />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Unit Price (USD)</label>
                                            <input type="text" name="unitPrice" class="form-control" value="{{ $invoice['unit_price'] }}"  />
                                        </div>
                                         <div class="col-lg-2">
                                            <label>Total Amount </label>
                                            <input type="text" name="totalAmount" class="form-control" value="{{ $invoice['total_amount'] }}"  />
                                        </div>
                                    </div>
                                </div>
                                <div class="float-right">
		  	 				      <button type="submit" class="btn btn-success " ><i class="fas fa-redo-alt"></i> Update Invoice</button>
                               </div>
                            </div>
                        </div>
                    </div>      
                </div><!-- end of row -->
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card mb-3">
                             <div class="card-header">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Add                       
                            </div>
                            <div class="card-body">
                                <form action="{{ action('WlgCorporationController@addNewQuotation', $invoice['id'] ) }}" method="post">
                                {{ csrf_field() }}
                                @if(session('successAdd'))
                                    <p class="alert alert-success">{{ Session::get('successAdd') }}</p>
                                @endif 
                                 <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                            <label>No</label>
                                            <input type="text" name="no" class="form-control" required/>
                                        </div>
                                        <div class="col-lg-12">
                                            <label>Description of Goods</label>
                                            <input type="text" name="descGoods" class="form-control " required />
                                          
                                        </div>
                                        <div class="col-lg-12">
                                            <label>Qty</label>
                                            <input type="text" name="qty" class="form-control " required/>
                                        </div>
                                        <div class="col-lg-12">
                                            <label>Unit Price (USD)</label>
                                            <input type="text" name="unitPrice" class="form-control " required/>
                                        </div>
                                         <div class="col-lg-12">
                                            <label>Total Amount </label>
                                            <input type="text" name="totalAmount" class="form-control " required/>
                                        </div>
                                    </div>
                                </div>
                                 <button type="submit" class="btn btn-primary " ><i class="fas fa-plus"></i> Add</button>
                               </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card mb-3">
                             <div class="card-header">
                                <i class="fa fa-file-invoice" aria-hidden="true"></i>
                                Edit Invoice                       
                            </div>
                            <div class="card-body">
                                @foreach($invoiceForms as $invoiceForm)
                                <form action="{{ action('WlgCorporationController@updateQuotation', $invoiceForm['id'] ) }}" method="post">
                                 {{csrf_field()}}
                                <input name="_method" type="hidden" value="PATCH">
                                @if(session('successEdit'))
                                    <p class="alert alert-success">{{ Session::get('successEdit') }}</p>
                                @endif 
                                <div id="deletedId{{ $invoiceForm['id'] }}">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-1">
                                            <label>No</label>
                                            <input type="text" name="no" class="form-control" value="{{ $invoiceForm['number_of_goods'] }}" />
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Description of Goods</label>
                                            <input type="text" name="descGoods" class="form-control " value="{{ $invoiceForm['description_of_goods'] }}" />
                                          
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Qty</label>
                                            <input type="text" name="qty" class="form-control" value="{{ $invoiceForm['qty'] }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Unit Price (USD)</label>
                                            <input type="text" name="unitPrice" class="form-control " value="{{ $invoiceForm['unit_price'] }}"/>
                                        </div>
                                         <div class="col-lg-2">
                                            <label>Total Amount </label>
                                            <input type="text" name="totalAmount" class="form-control " value="{{ $invoiceForm['total_amount'] }}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div>
                                            <input type="hidden" name="quotationId" value="{{ $invoice['id'] }}" />
                                            <button type="submit" class="btn btn-success"> <i class="fas fa-redo-alt"></i></button>
                                            
                                            @if(Auth::user()['role_type'] == 1)
                                              <a href="javascript:void" onclick="confirmDelete('{{ $invoiceForm['id'] }}')" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                             @endif
                                        </div>
                                    </div>
                                </div>
                                </div>
                                </form>
                                @endforeach
                            </div><!-- end of card body -->
                        </div>
                    </div>
                </div><!-- end of row -->
                @elseif(\Request::is('wlg-corporation/edit-packing-list/'.$invoice['id']))
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <i class="fa fa-file-invoice" aria-hidden="true"></i>
                                Invoice Form                         
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-2">
                                            <label>Date</label>
                                            <input type="text" name="date" class="datepicker form-control" value="{{ $invoice['date'] }}" autocomplete="off" />
                                           
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Delivery Terms</label>
                                            <input type="text" name="deliveryTerms" class=" form-control" value="{{ $invoice['delivery_terms'] }}"/>
                                           
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Tranport By</label>
                                            <input type="text" name="transportBy" class=" form-control"  value="{{ $invoice['transport_by'] }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Invoice Number</label>
                                            <input type="text" name="invoiceNumber" class=" form-control" value="{{ $invoice['invoice_number'] }}" disabled="disabled" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-4">
                                            <label>Shipper</label>
                                            <input type="text" name="shipper" class="form-control" value="{{ $invoice['shipper'] }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Consignee</label>
                                            <input type="text" name="consignee" class=" form-control" value="{{ $invoice['consignee'] }}" />
                                        </div>
                                        <div class="col-lg-2 ">
                                            <label>Notify Party</label>
                                            <input type="text" name="notifyParty" class=" form-control" value="{{ $invoice['notify_party'] }}"  />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Attention</label>
                                            <input type="text" name="attention" class=" form-control"  value="{{ $invoice['attention'] }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-1">
                                            <label>No</label>
                                            <input type="text" name="no" class="form-control " value="{{ $invoice['number_of_goods'] }}" />
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Description of Goods</label>
                                            <input type="text" name="descGoods" class="form-control " value="{{ $invoice['description_of_goods'] }}"  />
                                           
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Qty</label>
                                            <input type="text" name="qty" class="form-control" value="{{ $invoice['qty'] }}"  />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>KG(CBM)</label>
                                            <input type="text" name="kg" class="form-control "  value="{{ $invoice['kg_cbm']}}" />
                                        </div>
                                         <div class="col-lg-2">
                                            <label>Gross Weight </label>
                                            <input type="text" name="grossWeight" class="form-control " value="{{ $invoice['gross_weight'] }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="float-right">
		  	 				      <button type="submit" class="btn btn-success " ><i class="fas fa-redo-alt"></i> Update Invoice</button>
                               </div>
                            </div>
                        </div>
                    </div>      
                </div><!-- end of row -->
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card mb-3">
                             <div class="card-header">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Add                       
                            </div>
                            <div class="card-body">
                                <form action="{{ action('WlgCorporationController@addNewPackingList', $invoice['id'] ) }}" method="post">
                                {{ csrf_field() }}
                                @if(session('successAdd'))
                                    <p class="alert alert-success">{{ Session::get('successAdd') }}</p>
                                @endif 
                                 <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                            <label>No</label>
                                            <input type="text" name="no" class="form-control" required/>
                                        </div>
                                        <div class="col-lg-12">
                                            <label>Description of Goods</label>
                                            <input type="text" name="descGoods" class="form-control " required />
                                          
                                        </div>
                                        <div class="col-lg-12">
                                            <label>Qty</label>
                                            <input type="text" name="qty" class="form-control " required/>
                                        </div>
                                        <div class="col-lg-12">
                                            <label>KG(CBM)</label>
                                            <input type="text" name="kg" class="form-control "  required/>
                                        </div>
                                         <div class="col-lg-12">
                                            <label>Gross Weight </label>
                                            <input type="text" name="grossWeight" class="form-control " required />
                                        </div>
                                    </div>
                                </div>
                                 <button type="submit" class="btn btn-primary " ><i class="fas fa-plus"></i> Add</button>
                               </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card mb-3">
                             <div class="card-header">
                                <i class="fa fa-file-invoice" aria-hidden="true"></i>
                                Edit Invoice                       
                            </div>
                            <div class="card-body">
                                @foreach($invoiceForms as $invoiceForm)
                                <form action="{{ action('WlgCorporationController@updatePackingList', $invoiceForm['id'] ) }}" method="post">
                                 {{csrf_field()}}
                                <input name="_method" type="hidden" value="PATCH">
                                @if(session('successEdit'))
                                    <p class="alert alert-success">{{ Session::get('successEdit') }}</p>
                                @endif 
                                <div id="deletedId{{ $invoiceForm['id'] }}">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-1">
                                            <label>No</label>
                                            <input type="text" name="no" class="form-control" value="{{ $invoiceForm['number_of_goods'] }}" />
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Description of Goods</label>
                                            <input type="text" name="descGoods" class="form-control " value="{{ $invoiceForm['description_of_goods'] }}" />
                                          
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Qty</label>
                                            <input type="text" name="qty" class="form-control" value="{{ $invoiceForm['qty'] }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>KG(CBM)</label>
                                            <input type="text" name="kg" class="form-control "  value="{{ $invoiceForm['kg_cbm']}}" />
                                        </div>
                                         <div class="col-lg-2">
                                            <label>Gross Weight </label>
                                            <input type="text" name="grossWeight" class="form-control " value="{{ $invoiceForm['gross_weight'] }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div>
                                            <input type="hidden" name="packingListId" value="{{ $invoice['id'] }}" />
                                            <button type="submit" class="btn btn-success"> <i class="fas fa-redo-alt"></i></button>
                                            
                                            @if(Auth::user()['role_type'] == 1)
                                              <a href="javascript:void" onclick="confirmDelete('{{ $invoiceForm['id'] }}')" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                             @endif
                                        </div>
                                    </div>
                                </div>
                                </div>
                                </form>
                                @endforeach
                            </div><!-- end of card body -->
                        </div>
                    </div>
                </div><!-- end of row -->
                @endif
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
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript">
    const confirmDelete = (id) =>{
        const x = confirm("Do you want to delete this?");
        if(x){
            $.ajax({
              type: "DELETE",
              url: '/wlg-corporation/invoice/delete/' + id,
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