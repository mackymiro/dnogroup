@extends('layouts.ribos-bar-app')
@section('title', 'View Purchase Order |')
@section('content')
<div id="wrapper">
	<!-- Sidebar -->
    @include('sidebar.sidebar-ribos-bar')
    <div id="content-wrapper">
    	<div class="container-fluid">
    		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Ribo's Bar</a>
              </li>
              <li class="breadcrumb-item active">View Purchase Order</li>
            </ol>
            <a href="{{ url('ribos-bar/purchase-order-lists') }}">Back to Lists</a>
             <div class="col-lg-12">
            	 <img src="{{ asset('images/ribos.jpg')}}" width="390" height="250" class="img-responsive mx-auto d-block" alt="Rib's Bar">
            	 
            	 <h4 class="text-center"><u>VIEW PURCHASE ORDER</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                              <i class="fab fa-first-order" aria-hidden="true"></i>
                            View Purchase Order
                             <div class="float-right">
                               
                                 <a href="{{ action('RibosBarController@printPO', $purchaseOrder['id'])}}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                               
                              </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="form-row">
                                  <div class="col-lg-6">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="25%">Paid To</th>
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
                                   
                                  </div
                                </div>
                               </div>
                               <table class="table table-striped">
                                  <thead>
                                    <tr>
                                        <th class="bg-info" style="color:white;">QUANTITY</th>
		                                      <th class="bg-info" style="color:white;">DESCRIPTION</th>
		                                      <th class="bg-info" style="color:white;">UNIT PRICE</th>
		                                      <th class="bg-info" style="color:white;">AMOUNT</th>
											                 
                                    </tr>
                                  </thead>
                                  <tbody>

                                    <tr>
                                        <td>{{ $purchaseOrder['quantity']}}</td>
                                        <td>{{ $purchaseOrder['description']}}</td>
                                        <td>{{ $purchaseOrder['unit_price']}}</td>
                                        <td><?php echo number_format($purchaseOrder['amount'], 2); ?></td>
												                 
                                    </tr>
                                    @foreach($pOrders as $pOrder)
                                    <tr>
                                        <td>{{ $pOrder['quantity']}}</td>
                                        <td>{{ $pOrder['description']}}</td>
                                        <td>{{ $pOrder['unit_price']}}</td>
                                        <td><?php echo number_format($pOrder['amount'], 2); ?></td>
                                    </tr> 
                                    @endforeach
                                    <tr>  
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