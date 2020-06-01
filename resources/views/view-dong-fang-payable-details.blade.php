@extends('layouts.dong-fang-corporation-app')
@section('title', 'Payment Details|')
@section('content')

<div id="wrapper">
	<!-- Sidebar -->
    @include('sidebar.sidebar-dong-fang-corporation')
     <div id="content-wrapper">
 		 <div class="container-fluid">
 			 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Dong Fang Corporation</a>
              </li>
              <li class="breadcrumb-item active">Payables</li>
              <li class="breadcrumb-item ">Payment Details</li>
            </ol>
             <div class="col-lg-12">
            	   <img src="{{ asset('images/dong-fang-corporation.png')}}" width="255" height="172" class="img-responsive mx-auto d-block" alt="DNO Personal">
                 
            	 
            	 <h4 class="text-center"><u>PAYMENT DETAILS (PAYMENT VOUCHER)</u></h4>
            </div>
            <div class="row">
            	<div class="col-lg-12">
            		 <div class="card mb-3">
            		 	 <div class="card-header">
                              <i class="fas fa-file-invoice" aria-hidden="true"></i>
                            Payment Details
                             <div class="float-right">
                               <a href="{{ action('DongFangCorporationController@printPayablesDongFang', $viewPaymentDetail['id']) }}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
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
                                                  @if($viewPaymentDetail['method_of_payment'] == "Cheque")
                                                  <tr>
                                                      <th class="bg-info" style="color:white;">Account No</th>
                                                      <th class="bg-info" style="color:white;">{{ $viewPaymentDetail['account_no']}}</th>
                                                  </tr>
                                                  @endif
                                                  @if($viewPaymentDetail['method_of_payment'] == "Cash")
                                                  <tr>
                                                       <th width="30%" class="bg-info" style="color:white;">Account Name</th>
                                                      <th class="bg-info" style="color:white;">{{ $viewPaymentDetail['account_name']}}</th>
                                                  
                                                  </tr>
                                                  @endif
                                                  <tr>
                                                      <th class="bg-success" style="color:white;" width="15%">Status</th>
                                                      <th class="bg-success" style="color:white;">{{ $viewPaymentDetail['status']}}</th>
                                                  </tr>
                                                  <tr>
                                                      <th width="15%">Date</th>
                                                      <th>{{ $viewPaymentDetail['issued_date']}}</th>
                                                  </tr>
                                                 
                                              </thead>
                                          </table>
                                      </div>
                                       <div class="col-lg-6">
                                          <table class="table table-bordered">
                                              <thead>
                                                  <tr>
                                                      <th width="20%" class="bg-danger" style="color:#fff;">Amount Due</th>
                                                      <th class="bg-danger" style="color:#fff;"><?php echo number_format($viewPaymentDetail['amount_due'], 2); ?></th>
                                                  </tr>
                                                  <tr>  
                                                     <th width="35%" class="bg-danger" style="color:#fff;">Payment Method</th> 
                                                     <th class="bg-danger" style="color:#fff;">{{ $viewPaymentDetail['method_of_payment']}}</th>
                                                  </tr>
                                                  <tr>
                                                      <th width="35%">Invoice #</th>
                                                      <th>{{ $viewPaymentDetail['invoice_number']}}</th>
                                                  </tr>
                                                  <tr>
                                                      <th width="35%">Voucher Ref #</th>
                                                      <th>DP-{{ $viewPaymentDetail['voucher_ref_number']}}</th>
                                                  </tr>
                                                 
                                              </thead>
                                          </table>
                                      </div>
                                  </div>
                              </div>
                              <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>DATE</th>
                                            <th>PARTICULARS</th>
                                            <th>AMOUNT</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                         <tr>	
  											<td>{{ $viewPaymentDetail['issued_date']}}</td>
  											<td>{{ $viewPaymentDetail['particulars']}}</td>
											<td><?php echo number_format($viewPaymentDetail['amount'], 2); ?></td>
										</tr>
                                        @foreach($getParticulars as $getParticular)
                                        <tr>
                                            <td>{{ $getParticular['date']}}</td>
                                            <td>{{ $getParticular['particulars']}}</td>
                                            <td><?php echo number_format($getParticular['amount'], 2) ?></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                              </table>
                              
                              @if($viewPaymentDetail['method_of_payment'] === "Cheque")
                              <table class="table table-striped ">
                                    <thead>
                                        <tr>
                                            <th>CHEQUE NO ISSUED</th>
                                            <th>CHEQUE AMOUNT</th>
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
                              @else
                              <table class="table table-striped ">
                                    <thead>
                                        <tr>
                                            <th>CASH NO ISSUED</th>
                                            <th>CASH AMOUNT</th>
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

                              @endif
                              <br>
                              <br>

                               <table class="table table-striped ">
                                    <thead>
                                        <tr>
                                            <th width="15%">Prepared By</th>
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