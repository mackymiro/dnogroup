@extends('layouts.wimpys-food-express-app')
@section('title', 'View Statement Of Account |')
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
              <li class="breadcrumb-item active">View Statement Of Account Details</li>
            </ol>
              <a href="{{ url('wimpys-food-express/statement-of-account/lists') }}">Back to Lists</a>
            <div class="col-lg-12">
            <img src="{{ asset('images/digitized-logos/wimpys-logo1.jpg')}}" width="350" height="178" class="img-responsive mx-auto d-block" alt="Wimpy's Food Express">
             <h4 class="text-center"><u>VIEW STATEMENT OF ACCOUNT</u></h4>
            </div>
            <div class="row">
        		<div class="col-lg-12">
        			 <div class="card mb-3">
    			 		        <div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            View Statement Of Account 
                              <div class="float-right">
                               <a href="{{ action('WimpysFoodExpressController@printSOA', $viewStatementAccount[0]->id) }}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
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
                                                <th> {{ $viewStatementAccount[0]->bill_to }}</th>
                                            </tr>
                                          
                                            <tr>
                                                <th>Period Covered</th>
                                                <th> {{ $viewStatementAccount[0]->period_cover }} </th>
                                            </tr>
                                            <tr>
                                                <th>Date</th>
                                                <th>{{ $viewStatementAccount[0]->date }}</th>
                                            </tr>
                                        </thead>
                                    </table>
                                  
                                  </div>
                                  <div class="col-lg-6">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="20%">SOA No</th>
                                                <th>
                                                    @foreach($viewStatementAccount[0]->statement_of_accounts as $statement)
                                                        @if($statement->module_name === "Statement Of Account")
                                                            {{ $statement->module_code}}{{ $statement->wimpys_food_express_code}}
                                                        @endif
                                                    @endforeach
                                                </th>
                                            </tr>
                                            
                                            <tr>
                                                <th>Terms</th>
                                                <th>{{ $viewStatementAccount[0]->terms }}</th>
                                            </tr>
                                            <tr>
                                                <th>Order Type</th>
                                                <th>{{ $viewStatementAccount[0]->order }}</th>
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
                                                        <th>Payment Method</th>
                                                        <th> {{ $viewStatementAccount[0]->payment_method }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="bg-success" style="color:white;">Total Amount</th>
                                                        <th class="bg-success" style="color:white;">₱ <?php echo number_format($sum, 2);?></th>
                                                    </tr>
                                                     <tr>
                                                        <th class="bg-danger" style="color:white;">Total Remaining Amount </th>
                                                        <th class="bg-danger" style="color:white;">₱ <?php echo number_format($computeAll, 2);?></th>
                                                    </tr>
                                                    
                                                
                                                </thead>

                                            </table>
                                        </div>
                                        <div class="col-lg-6">
                                            <table class="table table-bordered">
                                                 <thead>
                                                    <tr>
                                                        <th width="30%">Collection Date</th>
                                                        <th>{{ $viewStatementAccount[0]->collection_date }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Cheque Number</th>
                                                        <th> {{ $viewStatementAccount[0]->check_number }}</th>
                                                    </tr>
                                                  
                                                    <tr>
                                                        <th >OR Number</th>
                                                        <th >{{ $viewStatementAccount[0]->or_number }}</th>
                                                    </tr>
                                                   
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @if($viewStatementAccount[0]->order === $orFormCBF)
                                <table class="table table-striped">
                                     <thead>
                                        <tr>
                                          <th class="bg-info" style="color:white;">DATE OF EVENT</th>
                                          <th class="bg-info" style="color:white;">NO OF PEOPLE</th>
                                          <th class="bg-info" style="color:white;">MOTIFF</th>
                                          <th class="bg-info" style="color:white;">TYPE OF PACKAGE</th>
                                          <th class="bg-info" style="color:white;">CLIENT</th>
                                          <th class="bg-info" style="color:white;">PLACE OF EVENT</th>
                                          <th class="bg-info" style="color:white;">AMOUNT</th>
                                          <th class="bg-info" style="color:white;">STATUS</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                          <tr>
                                          <td>{{ $viewStatementAccount[0]->date_of_event }}</td>
                                          <td>{{ $viewStatementAccount[0]->no_of_people }}</td>
                                          <td>{{ $viewStatementAccount[0]->motiff }}</td>
                                          <td>{{ $viewStatementAccount[0]->type_of_package }}</td>
                                          <td>{{ $viewStatementAccount[0]->client }}</td>
                                          <td>{{ $viewStatementAccount[0]->place_of_event }}</td>
                                          <td><?php echo number_format($viewStatementAccount[0]->amount, 2); ?></td>
                                          <td>{{ $viewStatementAccount[0]->status }}</td>
                                          </tr>
                                          @foreach($statementAccounts as $statementAccount)
                                          <tr>
                                            <td>{{ $statementAccount['date_of_event'] }}</td>
                                            <td>{{ $statementAccount['no_of_people'] }}</td>
                                            <td>{{ $statementAccount['motiff'] }}</td>
                                            <td>{{ $statementAccount['type_of_package'] }}</td>
                                            <td>{{ $statementAccount['client'] }}</td>
                                            
                                            <td>{{ $statementAccount['place_of_event'] }}</td>
                                            <td><?= number_format($statementAccount['amount'], 2);?></td>
                                            <td>{{ $statementAccount['status'] }}</td>
                                          </tr>
                                          @endforeach
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><strong>Total</strong></td>
                                            <td style="width:70px;"><strong>₱ <?= number_format($sum, 2)?></strong></td>
                                            <td></td>
                                          </tr>
                                        </tbody>
                                </table>
                                @elseif($viewStatementAccount[0]->order === $orFormDR)
                                <table class="table table-striped">
                                     <thead>
                                        <tr>
                                          <th class="bg-info" style="color:white;">DATE</th>
                                          <th class="bg-info" style="color:white;">DR #</th>
                                          <th class="bg-info" style="color:white;">DESCRIPTION</th>
                                          <th class="bg-info" style="color:white;">UNIT</th>
                                          <th class="bg-info" style="color:white;">AMOUNT</th>
                                          <th class="bg-info" style="color:white;">STATUS</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                          <tr>
                                          <td>{{ $viewStatementAccount[0]->date_of_transaction }}</td>
                                          <td>{{ $viewStatementAccount[0]->dr_no }}</td>
                                          <td>{{ $viewStatementAccount[0]->description }}</td>
                                          <td>{{ $viewStatementAccount[0]->unit }}</td>
                                          <td><?php echo number_format($viewStatementAccount[0]->amount, 2); ?></td>
                                          <td>{{ $viewStatementAccount[0]->status }}</td>
                                          </tr>
                                          @foreach($statementAccounts as $statementAccount)
                                          <tr>
                                            <td>{{ $statementAccount['date_of_transaction'] }}</td>
                                            <td>{{ $statementAccount['dr_no'] }}</td>
                                            <td>{{ $statementAccount['description'] }}</td>
                                            <td>{{ $statementAccount['unit'] }}</td>
                                            <td><?= number_format($statementAccount['amount'], 2);?></td>
                                            <td>{{ $statementAccount['status'] }}</td>
                                          </tr>
                                          @endforeach
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><strong>Total</strong></td>
                                            <td><strong>₱ <?= number_format($sum, 2)?></strong></td>
                                          </tr>
                                        </tbody>
                                </table>
                                @endif
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