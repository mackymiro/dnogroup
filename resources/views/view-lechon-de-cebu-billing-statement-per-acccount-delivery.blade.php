@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'View Delivery |')
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
              <li class="breadcrumb-item active">Billing Statement</li>
              <li class="breadcrumb-item ">View Billing Statement Delivery</li>
            </ol>
             <a href="{{ url('lolo-pinoy-lechon-de-cebu/view-per-accounts-billing-statement') }}">Back to Lists</a>
            <div class="col-lg-12">
               <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
               
               <h4 class="text-center"><u>VIEW BILLING STATEMENT (DELIVERY)</u></h4>
            </div>
            <div class="row">
               <div class="col-lg-12">
                 <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-receipt" aria-hidden="true"></i>
                                  View Billing Statement Delivery
                             <div class="float-right">
                               
                                 <a href="{{ action('LoloPinoyLechonDeCebuController@printBillingDelivery', $viewDeliveryReceipt[0]->id) }}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                               
                              </div>
                        </div>
                        <div class="card-body">
                          <div class="form-group">
                              <div class="form-row">
                                   <div class="col-lg-6">
                                    <table class="table table-bordered">
                                      <thead>
                                          <tr>
                                              <th width="30%">Bill To</th>
                                              <th>{{ $viewDeliveryReceipt[0]->sold_to }}</th>
                                          </tr>
                                          <tr>
                                              <th>Delivered To</th>
                                              <th>{{ $viewDeliveryReceipt[0]->delivered_to }}</th>
                                          </tr>
                                          <tr> 
                                              <th>Contact Person</th>
                                              <th>{{ $viewDeliveryReceipt[0]->contact_person }}</th>
                                          </tr>
                                          <tr>
                                              <th>Time</th>
                                              <th>{{ $viewDeliveryReceipt[0]->time }}</th>
                                          </tr>
                                         
                                      </thead>
                                      
                                  </table>   
                             </div>
                          <div class="col-lg-6">
                              <table class="table table-bordered">
                                  <thead>
                                      <tr>
                                          <th width="30%">Mobile #</th>
                                          <th>{{ $viewDeliveryReceipt[0]->mobile_num}}</th>
                                      </tr>
                                      <tr> 
                                          <th>DR No</th>
                                          <th>{{ $viewDeliveryReceipt[0]->lechon_de_cebu_code }}</th>
                                      </tr> 
                                       <tr>
                                          <th>Date</th>
                                          <th>{{ $viewDeliveryReceipt[0]->date }}</th>
                                       </tr>
                                        <tr>
                                          <th>Date To Be Delivered</th>
                                          <th>{{ $viewDeliveryReceipt[0]->date_to_be_delivered }}</th>
                                       </tr>
                                  </thead>
                              </table>
                          </div>
                          </div>
                          </div>  
                           <table class="table table-striped">
                                 <thead>
                                    <tr>
                                      <th class="bg-info" style="color:white;">QTY</th>
                                      <th class="bg-info" style="color:white;">DESCRIPTION</th>
                                      <th class="bg-info" style="color:white;">PRICE</th>
                                    
                                    </tr>
                                  </thead>
                                  <tbody>
                                     <tr>
                                      <td>{{ $viewDeliveryReceipt[0]->qty}}</td>
                                      <td>{{ $viewDeliveryReceipt[0]->description}}</td>
                                      <td><?php echo number_format($viewDeliveryReceipt[0]->price, 2); ?></td>
                                     </tr>

                                     @foreach($deliveryReceipts as $deliveryReceipt)
                                     <tr>
                                        <td>{{ $deliveryReceipt['qty']}}</td>
                                        <td>{{ $deliveryReceipt['description']}}</td>
                                        <td><?php echo number_format($deliveryReceipt['price'], 2)?></td>
                                     </tr>
                                    
                                      
                                       @endforeach
                                       <tr>
                                        <td></td>
                                       
                                        <td><strong>Total</strong></td>
                                        <td>₱ <?php echo number_format($sum, 2)?></td>
                                      </tr>
                                  </tbody>

                           </table>
                           <br>
                           <br>
                           <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Prepared By:</th>
                                        <th>Checked By:</th>
                                        <th>Received By:</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $viewDeliveryReceipt[0]->created_by}}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                           </table>
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