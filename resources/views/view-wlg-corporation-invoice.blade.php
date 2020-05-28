@extends('layouts.wlg-corporation-app')
@section('title', 'View Invoice |')
@section('content')
<div id="wrapper">
    <!-- Sidebar -->
    @include('sidebar.sidebar-wlg-corporation')
    <div id="content-wrapper">
        <div class="container-fluid">
             <!-- Breadcrumbs-->
             <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">WLG Corporation</a>
              </li>
              @if(\Request::is('wlg-corporation/view-invoice/'.$viewInvoice['id']))
              <li class="breadcrumb-item active">View Invoice</li>
              @elseif(\Request::is('wlg-corporation/view-pro-forma-invoice/'.$viewInvoice['id']))
              <li class="breadcrumb-item active">View Pro-Forma Invoice</li>
              @elseif(\Request::is('wlg-corporation/view-commercial-invoice/'.$viewInvoice['id']))
              <li class="breadcrumb-item active">View Commercial Invoice</li>
              @elseif(\Request::is('wlg-corporation/view-quotation-invoice/'.$viewInvoice['id']))
              <li class="breadcrumb-item active">View Quotation</li>
              @elseif(\Request::is('wlg-corporation/view-packing-list/'.$viewInvoice['id']))
              <li class="breadcrumb-item active">View Packing List</li>
              @endif
            </ol>
            @if(\Request::is('wlg-corporation/view-invoice/'.$viewInvoice['id']))
            <a href="{{ url('wlg-corporation/') }}">Back to Lists</a>
            @elseif(\Request::is('wlg-corporation/view-pro-forma-invoice/'.$viewInvoice['id']))
            <a href="{{ url('wlg-corporation/pro-forma-invoice/lists') }}">Back to Lists</a>
            @elseif(\Request::is('wlg-corporation/view-commercial-invoice/'.$viewInvoice['id']))
            <a href="{{ url('wlg-corporation/commercial-invoice/lists') }}">Back to Lists</a>
            @elseif(\Request::is('wlg-corporation/view-quotation-invoice/'.$viewInvoice['id']))
            <a href="{{ url('wlg-corporation/quotation-invoice/lists') }}">Back to Lists</a>
            @elseif(\Request::is('wlg-corporation/view-packing-list/'.$viewInvoice['id']))
            <a href="{{ url('wlg-corporation/packing-list/lists') }}">Back to Lists</a>
            @endif
            <div class="col-lg-12">
             <img src="{{ asset('images/wlg-corporation.png')}}" width="235" height="114" class="img-responsive mx-auto d-block" alt="WLG Corporation">                
                @if(\Request::is('wlg-corporation/view-invoice/'.$viewInvoice['id']))
                <h4 class="text-center"><u>VIEW INVOICE</u></h4>
                @elseif(\Request::is('wlg-corporation/view-pro-forma-invoice/'.$viewInvoice['id']))
                <h4 class="text-center"><u>VIEW PRO-FORMA INVOICE</u></h4>
                @elseif(\Request::is('wlg-corporation/view-commercial-invoice/'.$viewInvoice['id']))
                <h4 class="text-center"><u>VIEW COMMERCIAL INVOICE</u></h4>
                @elseif(\Request::is('wlg-corporation/view-quotation-invoice/'.$viewInvoice['id']))
                <h4 class="text-center"><u>VIEW QUOTATION</u></h4>
                @elseif(\Request::is('wlg-corporation/view-packing-list/'.$viewInvoice['id']))
                <h4 class="text-center"><u>VIEW PACKING LIST</u></h4>
                @endif
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                          <div class="card-header">
                              <i class="fab fa-first-order" aria-hidden="true"></i>
                            View Invoice
                             <div class="float-right">
                               
                                 <a href=""><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                             </div>
                          </div>
                          <div class="card-body">
                              <div class="form-group">
                                  <div class="form-row">
                                     <div class="col-lg-6">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="20%">Date</th>
                                                    <th>{{ $viewInvoice['date'] }}</th>
                                                </tr>
                                                <tr>
                                                    <th width="35%">Delivery Terms</th>
                                                    <th>{{ $viewInvoice['delivery_terms']}}</th>
                                                </tr>
                                                <tr>
                                                    <th width="35%">Transport By</th>
                                                    <th>{{ $viewInvoice['transport_by']}}</th>
                                                </tr>
                                                <tr>
                                                    <th width="35%">Invoice #</th>
                                                    <th>{{ $viewInvoice['invoice_number']}}</th>
                                                </tr>
                                            </thead>

                                        </table>
                                      
                                      </div>
                                      <div class="col-lg-6">
                                         <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="20%">Shipper</th>
                                                    <th>{{ $viewInvoice['shipper'] }}</th>
                                                </tr>
                                                <tr>
                                                    <th width="35%">Consignee</th>
                                                    <th>{{ $viewInvoice['consignee']}}</th>
                                                </tr>
                                                <tr>
                                                    <th width="35%">Notify Party</th>
                                                    <th>{{ $viewInvoice['notify_party']}}</th>
                                                </tr>
                                                <tr>
                                                    <th width="35%">Attention</th>
                                                    <th>{{ $viewInvoice['attention']}}</th>
                                                </tr>
                                            </thead>

                                        </table>
                                      </div>
                                  </div>
                              </div>
                              <table class="table table-striped">
                                <thead>
                                    <tr>
                                      <th class="bg-info" style="color:white;">NO</th>
                                      <th class="bg-info" style="color:white;">DESCRIPTION OF GOODS</th>
                                      <th class="bg-info" style="color:white;">QTY</th>
                                      @if(\Request::is('wlg-corporation/view-packing-list/'.$viewInvoice['id']))
                                      <th class="bg-info" style="color:white;">KG (CBM)</th>
                                      <th class="bg-info" style="color:white;">GROSS WEIGHT</th>
                                      @else
                                      <th class="bg-info" style="color:white;">UNIT PRICE (USD)</th>
                                      <th class="bg-info" style="color:white;">TOTAL AMOUNT</th>
                                      @endif
                                    </tr>
                                  </thead>
                                  <tbody>
                                      <tr>
                                        <td>{{$viewInvoice['number_of_goods']}}</td>
                                        <td>{{$viewInvoice['description_of_goods']}}</td>
                                        <td>{{$viewInvoice['qty']}}</td>
                                        @if(\Request::is('wlg-corporation/view-packing-list/'.$viewInvoice['id']))
                                        <td>{{$viewInvoice['kg_cbm']}}</td>
                                        <td>{{ $viewInvoice['gross_weight']}}</td>
                                        @else
                                        <td>{{$viewInvoice['unit_price']}}</td>
                                        <td><?php echo number_format($viewInvoice['total_amount'], 2)?></td>
                                        @endif
                                      </tr>
                                      @foreach($invoices as $invoice)
                                      <tr>
                                        <td>{{$invoice['number_of_goods']}}</td>
                                        <td>{{$invoice['description_of_goods']}}</td>
                                        <td>{{$invoice['qty']}}</td>
                                        <td>{{$invoice['unit_price']}}</td>
                                        <td><?php echo number_format($invoice['total_amount'], 2)?></td>
                                      </tr>
                                      @endforeach
                                      <tr>  
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        @if(\Request::is('wlg-corporation/view-packing-list/'.$viewInvoice['id']))
                                        <td></td>
                                        <td></td>
                                        @else
                                        <td><strong>Total</strong></td>
                                        <td>₱ <?php echo number_format($sum, 2)?></td>
                                        @endif
                                      </tr>
                                  </tbody>  
                              </table>
                              <div class="form-group">
                                  <div class="form-row">
                                      <div class="col-lg-6">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="30%">Requested By</th>
                                                    <th></th>
                                                </tr>
                                                 <tr>
                                                    <th>Checked By</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                        </table>
                                       
                                      </div>
                                      <div class="col-lg-6">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="20%">Prepared By</th>
                                                    <th>{{ $viewInvoice['created_by'] }}</th>
                                                </tr>
                                            </thead>
                                        </table>
                                       
                                      </div>
                                  </div>
                               </div>
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