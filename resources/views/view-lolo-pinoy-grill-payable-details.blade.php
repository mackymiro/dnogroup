@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'Payment Details|')
@section('content')

<div id="wrapper">
	<!-- Sidebar -->
    @include('sidebar.sidebar-lolo-pinoy-grill')
     <div id="content-wrapper">
 		 <div class="container-fluid">
 			 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lolo Pinoy Grill Commissary</a>
              </li>
              <li class="breadcrumb-item active">Payables</li>
              <li class="breadcrumb-item ">Payment Details</li>
            </ol>
             <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoy-grill.jpeg')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lolo Pinoy Grill">
            	 
            	 <h4 class="text-center"><u>PAYMENT DETAILS (PAYMENT VOUCHER)</u></h4>
            </div>
            <div class="row">
            	<div class="col-lg-12">
            		 <div class="card mb-3">
            		 	        <div class="card-header">
                              <i class="fas fa-file-invoice" aria-hidden="true"></i>
                            Payment Details
                            <div class="float-right">
                               <a href="{{ action('LoloPinoyGrillCommissaryController@printPayables', $viewPaymentDetail['id']) }}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                             </div>
                          </div>
                          
                       
                         <div class="card-body">
                              <div class="form-group">  
                                  <div class="form-row">
                                       <div class="col-lg-6">
                                          <table class="table table-bordered">
                                              <thead>
                                                   <tr>
                                                      <th class="bg-info" style="color:white;">Paid To</th>
                                                      <th class="bg-info" style="color:white;">{{ $viewPaymentDetail['paid_to']}}</th>
                                                  </tr>
                                                  <tr>
                                                      <th class="bg-success" style="color:white;" width="15%">Status</th>
                                                      <th class="bg-success" style="color:white;">{{ $viewPaymentDetail['status']}}</th>
                                                  </tr>
                                                  <tr>
                                                      <th width="15%">Date</th>
                                                      <th>{{ $viewPaymentDetail['issued_date']}}</th>
                                                  </tr>
                                                  <tr>
                                                      <th width="30%">Account Name</th>
                                                      <th>{{ $viewPaymentDetail['account_name']}}</th>
                                                  </tr>
                                              </thead>
                                          </table>
                                      </div>
                                       <div class="col-lg-6">
                                          <table class="table table-bordered">
                                              <thead>
                                                  <tr>
                                                      <th width="20%">Amount Due</th>
                                                      <th><?php echo number_format($viewPaymentDetail['amount_due'], 2); ?></th>
                                                  </tr>
                                                  <tr>
                                                      <th width="20%">Invoice #</th>
                                                      <th>{{ $viewPaymentDetail['invoice_number']}}</th>
                                                  </tr>
                                                  <tr>
                                                      <th width="30%">Voucher Ref #</th>
                                                      <th>LPGC-{{ $viewPaymentDetail['voucher_ref_number']}}</th>
                                                  </tr>
                                                  <tr>
                                                      <th width="30%">Payment Method</th>
                                                      <th>{{ $viewPaymentDetail['method_of_payment']}}</th>
                                                  </tr>
                                                 
                                              </thead>
                                          </table>
                                      </div>
                                  </div>
                              </div>
                             
                              <table class="table table-striped ">
                                    <thead>
                                        <tr>
                                             @if($viewPaymentDetail['method_of_payment'] === "Cash")
                                            <th>CASH NO ISSUED</th>
                                            <th>CASH AMOUNT</th>
                                            @else
                                            <th>CHEQUE NO ISSUED</th>
                                            <th>CHEQUE AMOUNT</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($getViewPaymentDetails as $getViewPaymentDetail)
                                        <tr>
                                           <td>{{ $getViewPaymentDetail['cheque_number']}}</td>
                                           <td><?php echo number_format($getViewPaymentDetail['cheque_amount'], 2)?></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                              </table>
                              <br>
                              <br>

                               <table class="table table-striped ">
                                    <thead>
                                        <tr>
                                            <th width="30%">PREPARED BY</th>
                                            <th>{{ $viewPaymentDetail['created_by']}}</th>
                                        </tr>
                                    </thead>
                                  
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