@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
</script>
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
              <li class="breadcrumb-item active">View Payment Voucher</li>
            </ol>
            
            <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
            	 <h4 class="text-center"><u>VIEW PAYMENT VOUCHER</u></h4>
            </div>
             <div class="row">
             	<div class="col-lg-12">
             		<div class="card mb-3">
         				       <div class="card-header">
                              <i class="fas fa-file-invoice" aria-hidden="true"></i>
                            View Payment Voucher 
                           <div class="float-right">
                               <a href="{{ action('LoloPinoyLechonDeCebuController@printPaymentVoucher', $paymentVoucher['id'])}}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                             </div>
                        </div>
                         <div class="card-body">
                         	<div class="form-group">
                         		<div class="form-row">
                         			<div class="col-lg-6">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="30%">Reference Number</th>
                                            <th>{{ $paymentVoucher['reference_number']}}</th>
                                        </tr>
                                        <tr>
                                            <th>Paid To</th>
                                            <th>{{ $paymentVoucher['paid_to']}}</th>
                                        </tr>
                                        <tr>
                                            <th>Account Number</th>
                                            <th>{{ $paymentVoucher['account_no']}}</th>
                                        </tr>
                                    </thead>
                                </table>
                         			
                         			</div>
                         			<div class="col-lg-6">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>{{ $paymentVoucher['date']}}</th>
                                        </tr>
                                        <tr>
                                            <th>Method Of Payment</th>
                                            <th>{{ $paymentVoucher['method_of_payment']}}</th>
                                        </tr>
                                    </thead>
                                </table>
                         				
                         			</div>
                         		</div>
                         	</div>
                         	<div class="table-responsive">
                         		<table class="table table-striped">
                         			<thead>
                         				<tr>
                         					<th class="bg-info" style="color:white;">Particulars</th>
                         					<th class="bg-info" style="color:white;">Amount</th>
                         				</tr>
                         			</thead>
                         			<tbody>
                         				<tr>
                         				
                         					<td>{{ $paymentVoucher['particulars']}}</td>
                         					<td><?php echo number_format($paymentVoucher['amount'], 2);?></td>
                         				</tr>
                         				@foreach($pVouchers as $pVoucher)
                         				<tr>
                         					
                         					<td>{{ $pVoucher['particulars']}}</td>
                         					<td><?php echo number_format($pVoucher['amount'], 2);  ?></td>
                         				</tr>
                         				@endforeach
                         				<tr>
	                                      
	                                      <td><strong>Total</strong></td>
	                                      <td>₱ <?php echo number_format($sum, 2)?></td>
	                                    </tr>
                         			</tbody>
                         		</table>
                         		
                         	</div>
                         	<div class="form-group">
                     				<div class="form-row">
                     					<div class="col-lg-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Prepared/Checked By</th>
                                            <th>Approved By</th>
                                            <th>Received By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td> {{ $paymentVoucher['date_approved']}}</td>
                                            <td> {{ $paymentVoucher['prepared_by']}}</td>
                                            <td>{{ $paymentVoucher['approved_by'] }}</td>
                                            <td>{{ $paymentVoucher['received_by_date'] }}</td>
                                        </tr>
                                    </tbody>
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