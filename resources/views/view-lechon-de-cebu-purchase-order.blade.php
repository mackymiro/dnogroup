@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'View Purchase Order |')
@section('content')
<div id="wrapper">
	<!-- Sidebar -->
    @include('sidebar.sidebar')
    <div id="content-wrapper">
    	<div class="container-fluid">
    		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lechon de Cebu</a>
              </li>
              <li class="breadcrumb-item active">View Purchase Order</li>
            </ol>
            <a href="{{ url('lolo-pinoy-lechon-de-cebu/purchase-order-lists') }}">Back to Lists</a>
             <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
            	 <h4 class="text-center"><u>VIEW PURCHASE ORDER</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                              <i class="fab fa-first-order" aria-hidden="true"></i>
                            View Purchase Order
                             <div class="float-right">
                                     <i class="fa fa-print fa-2x" aria-hidden="true"></i>
                              
                              </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="form-row">
                                  <div class="col-lg-6">
                                    <label>Paid to</label>
                                    <br>
                                   {{ $purchaseOrder['paid_to'] }}
                                  <br>
                                  <br>
                                  <label>Address</label>
                                  <br>
                                  Labogon Mandaue City
                                  
                                  </div>
                                  <div class="col-lg-6">
                                    <label>P.O Number</label>
                                    <br>
                                    <a href="#">P.O-{{ $purchaseOrder['p_o_number'] }}</a>
                                    <br>
                                    <br>
                                    <label>Date</label>
                                    <br>
                                    {{ $purchaseOrder['date'] }}
                                  </div>
                                </div>
                               </div>
                               <table class="table table-striped">
                                  <thead>
                                    <tr>
                                      <th>QUANTITY</th>
                                      <th>DESCRIPTION</th>
                                      <th>UNIT PRICE</th>
                                      <th>AMOUNT</th>
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
                                      <td>{{ $pOrder['quantity'] }}</td>
                                      <td>{{ $pOrder['description'] }}</td>
                                      <td>{{ $pOrder['unit_price'] }}</td>
                                      <td><?php echo number_format($pOrder['amount'], 2) ?></td>
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
                                        <label>Requested By</label>
                                      </div>
                                      <div class="col-lg-6">
                                        <label>Prepared By</label>
                                        <p>{{ $purchaseOrder['created_by'] }}</p>
                                      </div>
                                  </div>
                               </div>
                               <div class="form-group">
                                  <div class="form-row">
                                      <div class="col-lg-6">
                                        <label>Checked By</label>
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