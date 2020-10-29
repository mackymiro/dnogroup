@extends('layouts.wimpys-food-express-app')
@section('title', 'Payment Details|')
@section('content')

<div id="wrapper">
	<!-- Sidebar -->
    @include('sidebar.sidebar-wimpys-food-express')
     <div id="content-wrapper">
 		 <div class="container-fluid">
 			 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Wimpy's Food Express</a>
              </li>
              <li class="breadcrumb-item active">Payables</li>
              <li class="breadcrumb-item ">Payment Details</li>
            </ol>
             <div class="col-lg-12">
                 <img src="{{ asset('images/digitized-logos/wimpys-logo1.jpg')}}"  class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	
            	 
            	 <h4 class="text-center"><u>PAYMENT DETAILS (PAYMENT VOUCHER)</u></h4>
            </div>
            <div class="row">
            	<div class="col-lg-12">
            		 <div class="card mb-3">
            		 	 <div class="card-header">
                              <i class="fas fa-file-invoice" aria-hidden="true"></i>
                            Payment Details
                            @if($viewPaymentDetail[0]->deleted_at == NULL)
                             <div class="float-right">
                               <a  href="{{ action('WimpysFoodExpressController@printPayables', $viewPaymentDetail[0]->id) }}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                             </div>
                            @endif
                        </div>
                          
                         <div class="card-body">
                                @if($viewPaymentDetail[0]->deleted_at != NULL)
                                    <h1 style="color:red; font-size:28px; font-weight:bold">This Item Has Been Deleted! (CLERICAL ERROR)</h1>
                                @endif
                              <div class="form-group">  
                                  <div class="form-row">
                                       <div class="col-lg-6">
                                          <table class="table table-bordered">
                                              <thead>
                                                  <tr>
                                                      <th class="bg-info" style="color:white;">Paid To</th>
                                                      <th class="bg-info" style="color:white;">{{ $viewPaymentDetail[0]->paid_to}}</th>
                                                  </tr>
                                                 
                                                  <?php if($viewPaymentDetail[0]->method_of_payment === "CHECK"): ?>
                                                  @if($viewPaymentDetail[0]->account_no != NULL)
                                                  <tr>
                                                     
                                                      <th  width="30%" class="bg-info" style="color:white;">Account No</th>
                                                      <th class="bg-info" style="color:white;">{{ $viewPaymentDetail[0]->account_no}}</th>
                                                           
                                                  </tr>
                                                 
                                                  @endif
                                                
                                                  <?php else: ?>
                                                    @if($viewPaymentDetail[0]->account_no != NULL)
                                                  <tr>
                                                     
                                                      <th  width="30%" class="bg-info" style="color:white;">Account No</th>
                                                      <th class="bg-info" style="color:white;">{{ $viewPaymentDetail[0]->account_no}}</th>
                                                           
                                                  </tr>
                                                 
                                                  @endif

                                                  <?php endif; ?>
                                                  <tr>
                                                    <th width="30%" class="bg-info" style="color:white;">Account Name</th>
                                                    <th class="bg-info" style="color:white;">{{ $viewPaymentDetail[0]->account_name}}</th>
                                                    
                                                </tr>
                                                 @if($viewPaymentDetail[0]->bank_card != 0)
                                                 <tr>
                                                     <?php
                                                        $bankName = $viewPaymentDetail[0]->bank_card;
                                                        $bankNameArr = explode("-", $bankName);
                                            
                                                     ?>
                                                     <th  width="30%" class="bg-info" style="color:white;">Bank Name</th>
                                                     <th class="bg-info" style="color:white;">{{ $bankNameArr[1]}}</th>
                                                          
                                                 </tr>
                                                @endif
                                                @if($viewPaymentDetail[0]->type_of_card != NULL)
                                                <tr>
                                                    <th width="30%" class="bg-info" style="color:white;">Type Of Card</th>
                                                    <th class="bg-info" style="color:white;">{{ $viewPaymentDetail[0]->type_of_card}}</th>
                                                    
                                                </tr>
                                                @endif
                                               

                                                  <tr>
                                                      <th class="bg-success" style="color:white;" width="15%">Status</th>
                                                      <th class="bg-success" style="color:white;">{{ $viewPaymentDetail[0]->status}}</th>
                                                  </tr>
                                                  <tr>
                                                      <th width="15%">Date issued</th>
                                                      <th>{{ $viewPaymentDetail[0]->issued_date}}</th>
                                                  </tr>
                                                 
                                              </thead>
                                          </table>
                                      </div>
                                       <div class="col-lg-6">
                                          <table class="table table-bordered">
                                              <thead>
                                                  <tr>
                                                      <th width="20%" class="bg-danger" style="color:#fff;">Amount Due</th>
                                                      <th class="bg-danger" style="color:#fff;"><?php echo number_format($sum, 2); ?></th>
                                                  </tr>
                                                  <tr>  
                                                     <th width="35%" class="bg-danger" style="color:#fff;">Payment Method</th> 
                                                     <th class="bg-danger" style="color:#fff;">{{ $viewPaymentDetail[0]->method_of_payment}}</th>
                                                  </tr>
                                                  <tr>
                                                      <th width="35%">Invoice #</th>
                                                      <th>{{ $viewPaymentDetail[0]->invoice_number}}</th>
                                                  </tr>
                                                  <tr>
                                                      <th width="35%">PV No</th>
                                                      <th>
                                                        @foreach($viewPaymentDetail[0]->payment_vouchers as $voucher)
                                                            @if($voucher->module_name === "Payment Voucher")
                                                                  {{ $voucher->module_code}}{{ $voucher->wimpys_food_express_code}}</th>
                                             
                                                            @endif
                                                        @endforeach
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
  											<td>{{ $viewPaymentDetail[0]->issued_date}}</td>
  											<td>{{ $viewPaymentDetail[0]->particulars}}</td>
											<td>
                                            @if($viewPaymentDetail[0]->currency === "PHP")
                                                ₱ 
                                            @elseif($viewPaymentDetail[0]->currency === "USD")
                                            $

                                            @endif 	
                                            <?php echo number_format($viewPaymentDetail[0]->amount, 2); ?></td>
										</tr>
                                        @foreach($getParticulars as $getParticular)
                                        <tr>
                                            <td>{{ $getParticular['date']}}</td>
                                            <td>{{ $getParticular['particulars']}}</td>
                                            <td>
                                            @if($getParticular['currency'] === "PHP")
                                                ₱ 
                                            @elseif($getParticular['currency'] === "USD")
                                            $

                                            @endif 	
                                            <?php echo number_format($getParticular['amount'], 2) ?></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                              </table>
                              
                              @if($viewPaymentDetail[0]->method_of_payment === "CHECK")
                              <table class="table table-striped ">
                                    <thead>
                                        <tr>
                                            <th>CHECK NO ISSUED</th>
                                            <th>CHECK AMOUNT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($getChequeNumbers as $getChequeNumber)
                                        <tr>
                                           <td>{{ $getChequeNumber['cheque_number']}}</td>
                                           <td><?php echo number_format($getChequeNumber['cheque_amount'], 2)?></td>
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
                                        @foreach($getCashAmounts as $getCashAmount)
                                        <tr>
                                           <td>{{ $getCashAmount['cheque_number']}}</td>
                                           <td>
                                           @if($getCashAmount['currency'] === "PHP")
                                                ₱ 
                                            @elseif($getCashAmount['currency'] === "USD")
                                            $

                                            @endif 	
                                           <?php echo number_format($getCashAmount['cheque_amount'], 2)?></td>
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
                                            <th>{{ $viewPaymentDetail[0]->created_by}}</th>
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