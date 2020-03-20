@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'View Statement Of Account |')
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
              <li class="breadcrumb-item active">View Statement Of Account Details</li>
            </ol>
              <a href="{{ url('lolo-pinoy-lechon-de-cebu/statement-of-account/lists') }}">Back to Lists</a>
            <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
            	 <h4 class="text-center"><u>VIEW STATEMENT OF ACCOUNT</u></h4>
            </div>
            <div class="row">
        		<div class="col-lg-12">
        			 <div class="card mb-3">
    			 		        <div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            View Statement Of Account 
                            <div class="float-right">
                                 <button class="btn btn-success" > <i class="fa fa-print fa-2x" aria-hidden="true"></i></button>
                              
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
                                                <th> {{ $viewStatementAccount[0]['bill_to'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <th>{{ $viewStatementAccount[0]['address'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>Period Covered</th>
                                                <th> {{ $viewStatementAccount[0]['period_cover'] }} </th>
                                            </tr>
                                            <tr>
                                                <th>Date</th>
                                                <th>{{ $viewStatementAccount[0]['date'] }}</th>
                                            </tr>
                                        </thead>
                                    </table>
                                  
                                  </div>
                                  <div class="col-lg-6">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="20%">Reference #</th>
                                                <th>{{ $viewStatementAccount[0]['reference_number'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>PO Number</th>
                                                <th> {{ $viewStatementAccount[0]['p_o_number'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>Terms</th>
                                                <th>{{ $viewStatementAccount[0]['terms'] }}</th>
                                            </tr>
                                        </thead>

                                    </table>
                        
                                  </div>
                                </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-6">
                                           <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="30%">Branch</th>
                                                        <th>{{ $viewStatementAccount[0]['branch'] }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Payment Method</th>
                                                        <th> {{ $viewStatementAccount[0]['payment_method'] }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="bg-success" style="color:white;">Total Amount</th>
                                                        <th class="bg-success" style="color:white;">₱ <?php echo number_format($sum, 2);?></th>
                                                    </tr>
                                                     <tr>
                                                        <th class="bg-danger" style="color:white;">Total Remaining Amount </th>
                                                        <th class="bg-danger" style="color:white;">₱ <?php echo number_format($computeAll, 2);?></th>
                                                    </tr>
                                                      <tr>
                                                        <th>Cheque Amount</th>
                                                        <th><?php echo number_format($viewStatementAccount[0]['check_amount'], 2); ?></th>
                                                    </tr>
                                                
                                                </thead>

                                            </table>
                                        </div>
                                        <div class="col-lg-6">
                                            <table class="table table-bordered">
                                                 <thead>
                                                    <tr>
                                                        <th width="30%">Collection Date</th>
                                                        <th>{{ $viewStatementAccount[0]['collection_date'] }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Cheque Number</th>
                                                        <th> {{ $viewStatementAccount[0]['check_number'] }}</th>
                                                    </tr>
                                                  
                                                    <tr>
                                                        <th >OR Number</th>
                                                        <th >{{ $viewStatementAccount[0]['or_number'] }}</th>
                                                    </tr>
                                                   
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-striped">
                                     <thead>
                                        <tr>
                                          <th class="bg-info" style="color:white;">DATE</th>
                                          <th class="bg-info" style="color:white;">INVOICE #</th>
                                          <th class="bg-info" style="color:white;">WHOLE LECHON 500/KL</th>
                                          <th class="bg-info" style="color:white;">DESCRIPTION</th>
                                          <th class="bg-info" style="color:white;">AMOUNT</th>
                                          <th class="bg-info" style="color:white;">STATUS</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                          <tr>
                                          <td>{{ $viewStatementAccount[0]['transaction_date'] }}</td>
                                          <td>{{ $viewStatementAccount[0]['invoice_number'] }}</td>
                                          <td>{{ $viewStatementAccount[0]['whole_lechon'] }}</td>
                                          <td>{{ $viewStatementAccount[0]['description'] }}</td>
                                          <td><?php echo number_format($viewStatementAccount[0]['amount'], 2); ?></td>
                                          <td>{{ $viewStatementAccount[0]['status'] }}</td>
                                          </tr>
                                          @foreach($statementAccounts as $statementAccount)
                                          <tr>
                                            <td>{{ $statementAccount['transaction_date'] }}</td>
                                            <td>{{ $statementAccount['invoice_number'] }}</td>
                                            <td>{{ $statementAccount['whole_lechon'] }}</td>
                                            <td>{{ $statementAccount['description'] }}</td>
                                            <td><?php echo number_format($statementAccount['amount'], 2);?></td>
                                            <td>{{ $statementAccount['status']}}</td>
                                          </tr>
                                          @endforeach
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><strong>Total</strong></td>
                                            <td><strong>₱ <?php echo number_format($sum, 2)?></strong></td>
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