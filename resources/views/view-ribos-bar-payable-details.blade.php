@extends('layouts.ribos-bar-app')
@section('title', 'Payment Details|')
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
              <li class="breadcrumb-item active">Payables</li>
              <li class="breadcrumb-item ">Payment Details</li>
            </ol>
             <div class="col-lg-12">
            	   <img src="{{ asset('images/ribos.jpg')}}" width="390" height="250" class="img-responsive mx-auto d-block" alt="Rib's Bar">
                 
            	 
            	 <h4 class="text-center"><u>PAYMENT DETAILS</u></h4>
            </div>
            <div class="row">
            	<div class="col-lg-12">
            		 <div class="card mb-3">
            		 	 <div class="card-header">
                              <i class="fas fa-file-invoice" aria-hidden="true"></i>
                            Payment Details</div>
                          
                         <form action="{{ action('LoloPinoyLechonDeCebuController@paymentVoucherStore') }}" method="post">
                         	{{ csrf_field() }}
                         <div class="card-body">
                              <div class="form-group">  
                                  <div class="form-row">
                                       <div class="col-lg-6">
                                          <table class="table table-bordered">
                                              <thead>
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
                                                      <th width="20%">Amount Due</th>
                                                      <th><?php echo number_format($viewPaymentDetail['amount_due'], 2); ?></th>
                                                  </tr>
                                                 
                                              </thead>
                                          </table>
                                      </div>
                                  </div>
                              </div>
                             
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
                              <br>
                              <br>

                               <table class="table table-striped ">
                                    <thead>
                                        <tr>
                                            <th width="30%">USER WHO MAKE THE TRANSACTION</th>
                                            <th>{{ $viewPaymentDetail['created_by']}}</th>
                                        </tr>
                                    </thead>
                                  
                              </table>
                         </div>	
                     	</form>
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