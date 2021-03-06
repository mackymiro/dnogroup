@extends('layouts.wlg-corporation-app')
@section('title', 'View Purchase Order |')
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
              <li class="breadcrumb-item active">View Purchase Order</li>
            </ol>
            <a href="{{ url('wlg-corporation/purchase-order-lists') }}">Back to Lists</a>
             <div class="col-lg-12">
             <img src="{{ asset('images/wlg-corporation.png')}}" width="235" height="114" class="img-responsive mx-auto d-block" alt="WLG Corporation">                
                <h4 class="text-center"><u>VIEW PURCHASE ORDER</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                              <i class="fab fa-first-order" aria-hidden="true"></i>
                            View Purchase Order
                            @if($purchaseOrder[0]->deleted_at == NULL)
                             <div class="float-right">
                               
                                 <a href="{{ action('WlgCorporationController@printPO', $purchaseOrder[0]->id)}}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                               
                              </div>
                            @endif
                        </div>
                        <div class="card-body">
                           @if($purchaseOrder[0]->deleted_at != NULL)
                                <h1 style="color:red; font-size:28px; font-weight:bold">This Item Has Been Deleted! (CLERICAL ERROR)</h1>
                              @endif
                            <div class="form-group">
                                <div class="form-row">
                                  <div class="col-lg-6">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="20%">Paid To</th>
                                                <th>{{ $purchaseOrder[0]->paid_to }}</th>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <th>{{ $purchaseOrder[0]->address}}</th>
                                            </tr>
                                        </thead>

                                    </table>
                                   
                                  </div>
                                  <div class="col-lg-6">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="20%">P.O Number</th>
                                                <th>{{ $purchaseOrder[0]->module_code}}{{ $purchaseOrder[0]->wlg_code}}</th>
                                            </tr>
                                            <tr>
                                                <th>Date</th>
                                                <th> {{ $purchaseOrder[0]->date }}</th>
                                            </tr>
                                        </thead>
                                    </table>
                                   
                                  </div>
                                </div>
                               </div>
                               <table class="table table-striped">
                                  <thead>
                                    <tr>
                                      <th class="bg-info" style="color:white;">MODEL</th>
                                      <th class="bg-info" style="color:white;">PARTICULARS</th>
                                      <th class="bg-info" style="color:white;">QUANTITY</th>
                                      <th class="bg-info" style="color:white;">UNIT PRICE</th>
                                      <th class="bg-info" style="color:white;">AMOUNT</th>
                                    </tr>
                                  </thead>
                                  <tbody>

                                    <tr>
                                      <td>{{ $purchaseOrder[0]->model}}</td>
                                      <td>{{ $purchaseOrder[0]->particulars}}</td>
                                      <td>{{ $purchaseOrder[0]->quantity}}</td>
                                      <td>{{ $purchaseOrder[0]->unit_price}}</td>
                                      <td><?php echo number_format($purchaseOrder[0]->amount, 2); ?></td>
                                    </tr>
                                    @foreach($pOrders as $pOrder)
                                    <tr>
                                      <td>{{ $pOrder['model'] }}</td>
                                      <td>{{ $pOrder['particulars'] }}</td>
                                      <td>{{ $pOrder['quantity']}}</td>
                                      <td>{{ $pOrder['unit_price'] }}</td>
                                      <td><?php echo number_format($pOrder['amount'], 2) ?></td>
                                    </tr> 
                                    @endforeach
                                    <tr>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td><strong>Total</strong></td>
                                      <td>₱ <?php echo number_format($sum, 2)?></td>
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
                                                    <th>{{ $purchaseOrder[0]->created_by }}</th>
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