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
                             <div class="float-right">
                               
                                 <a href="{{ action('WlgCorporationController@printPO', $purchaseOrder['id'])}}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                               
                              </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="form-row">
                                  <div class="col-lg-6">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="20%">Paid To</th>
                                                <th>{{ $purchaseOrder['paid_to'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <th>{{ $purchaseOrder['address']}}</th>
                                            </tr>
                                        </thead>

                                    </table>
                                   
                                  </div>
                                  <div class="col-lg-6">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="20%">P.O Number</th>
                                                <th><a href="#">P.O-{{ $purchaseOrder['p_o_number'] }}</a></th>
                                            </tr>
                                            <tr>
                                                <th>Date</th>
                                                <th> {{ $purchaseOrder['date'] }}</th>
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
                                      <td>{{ $purchaseOrder['model']}}</td>
                                      <td>{{ $purchaseOrder['particulars']}}</td>
                                      <td>{{ $purchaseOrder['quantity']}}</td>
                                      <td>{{ $purchaseOrder['unit_price']}}</td>
                                      <td><?php echo number_format($purchaseOrder['amount'], 2); ?></td>
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
                                                    <th>{{ $purchaseOrder['created_by'] }}</th>
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