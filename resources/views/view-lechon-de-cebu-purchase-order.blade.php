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
                            @if($purchaseOrder[0]->deleted_at == NULL)
                             <div class="float-right">
                               
                                 <a href="{{ action('LoloPinoyLechonDeCebuController@printPO', $purchaseOrder[0]->id)}}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                               
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
                                                <th>{{ $purchaseOrder[0]->lechon_de_cebu_code}}</th>
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
                                      <th class="bg-info" style="color:white;">QUANTITY</th>
                                      <th class="bg-info" style="color:white;">DESCRIPTION</th>
                                     
                                      <th class="bg-info" style="color:white;">UNIT PRICE</th>
                                      <th class="bg-info" style="color:white;">AMOUNT</th>
                                    </tr>
                                  </thead>
                                  <tbody>

                                    <tr>
                                      <td>{{ $purchaseOrder[0]->quantity}}</td>
                                      <td>{{ $purchaseOrder[0]->description}}</td>
                                     
                                      <td>{{ $purchaseOrder[0]->unit_price}}</td>
                                      <td><?php echo number_format($purchaseOrder[0]->amount, 2); ?></td>
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
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="30%">Requested By</th>
                                                    <th>{{ $purchaseOrder[0]->requested_by }}</th>
                                                </tr>
                                                 <tr>
                                                    <th>Checked By</th>
                                                    <th>{{ $purchaseOrder[0]->checked_by }}</th>
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