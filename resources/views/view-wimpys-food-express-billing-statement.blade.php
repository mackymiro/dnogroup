@extends('layouts.wimpys-food-express-app')
@section('title', 'View Billing Statement |')
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
              <li class="breadcrumb-item active">View Billing Statement</li>
            </ol>
              <a href="{{ url('wimpys-food-express/billing-statement-lists') }}">Back to Lists</a>
          	<div class="col-lg-12">
              <img src="{{ asset('images/digitized-logos/wimpys-logo1.jpg')}}" width="350" height="178" class="img-responsive mx-auto d-block" alt="Wimpy's Food Express">
            		 	  
            	 <h4 class="text-center"><u>VIEW BILLING STATEMENT</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            View Billing Statment
                            @if($viewBillingStatement[0]->deleted_at == NULL)
                            <div class="float-right">
                               <a href="{{ action('WimpysFoodExpressController@printBillingStatement', $viewBillingStatement[0]->id)}}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                             </div>
                             @endif
                        </div>
                        <div class="card-body">
                        @if($viewBillingStatement[0]->deleted_at != NULL)
                          <h1 style="color:red; font-size:28px; font-weight:bold">This Item Has Been Deleted! (CLERICAL ERROR)</h1>
                          @endif
                             <div class="form-group">
                                <div class="form-row">
                                  <div class="col-lg-6">
                                    <table class="table table-bordered">  
                                        <thead>
                                            <tr>
                                                <th width="30%">Bill To</th>
                                                <th> {{ $viewBillingStatement[0]->bill_to }}</th>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <th>{{ $viewBillingStatement[0]->address }}</th>
                                            </tr>
                                            <tr>
                                                <th>Period Covered</th>
                                                <th> {{ $viewBillingStatement[0]->period_cover }} </th>
                                            </tr>
                                            <tr>
                                                <th>Date</th>
                                                <th>{{ $viewBillingStatement[0]->date }}</th>
                                            </tr>
                                        </thead>
                                    </table>
                                  
                                  </div>
                                  <div class="col-lg-6">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="20%">BS #</th>
                                                <th>
                                                    @foreach($viewBillingStatement[0]->billing_statements as $statement)
                                                        @if($statement->module_name === "Billing Statement")
                                                            {{ $statement->module_code }}{{ $statement->wimpys_food_express_code}}
                                                        @endif
                                                    @endforeach
                                                </th>
                                            </tr>
                                           
                                            <tr>
                                                <th>Terms</th>
                                                <th>{{ $viewBillingStatement[0]->terms }}</th>
                                            </tr>
                                            <tr>
                                                <th>Order Type</th>
                                                <th>{{ $viewBillingStatement[0]->order }}</th>
                                            </tr>
                                        </thead>

                                    </table>
                        
                                  </div>
                                </div>
                                </div>
                                @if($viewBillingStatement[0]->order === $orFormCBF)
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
                                          
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>{{ $viewBillingStatement[0]->date_of_event }}</td>                  
                                        <td>{{ $viewBillingStatement[0]->no_of_people }}</td>                  
                                        <td>{{ $viewBillingStatement[0]->motiff }}</td> 
                                        <td>{{ $viewBillingStatement[0]->type_of_package }}</td> 
                                        <td>{{ $viewBillingStatement[0]->client }}</td>
                                        <td>{{ $viewBillingStatement[0]->place_of_event}}</td>
                                      
                                        <td><?= number_format($viewBillingStatement[0]->amount, 2); ?></td>

                                      </tr>
                                      @foreach($billingStatements as $billingStatement)
                                      <tr>
                                        <td>{{ $billingStatement['date_of_event'] }}</td>
                                        <td>{{ $billingStatement['no_of_people'] }}</td>
                                        <td>{{ $billingStatement['motiff'] }}</td>
                                        <td>{{ $billingStatement['type_of_package'] }}</td>
                                        <td>{{ $billingStatement['client'] }}</td>
                                        <td>{{ $billingStatement['place_of_event'] }}</td>
                                        <td><?= number_format($billingStatement['amount'], 2);?></td>
                                      </tr>
                                      @endforeach
                                      <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><strong>Total</strong></td>
                                        <td>₱ <?= number_format($sum, 2)?></td>
                                      </tr>
                                    </tbody>
                              </table>
                              @elseif($viewBillingStatement[0]->order === $orFormDR)
                              <table class="table table-striped">
                                    <thead>
                                      <tr>
                                        <th class="bg-info" style="color:white;">DATE</th>
                                        <th class="bg-info" style="color:white;">DR #</th>
                                        <th class="bg-info" style="color:white;">QTY</th>
                                        <th class="bg-info" style="color:white;">ITEM DESCRIPTION</th>
                                        <th class="bg-info" style="color:white;">UNIT</th>
                                        <th class="bg-info" style="color:white;">AMOUNT</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>{{ $viewBillingStatement[0]->date_of_transaction }}</td>                  
                                        
                                        <td>{{ $viewBillingStatement[0]->dr_no }}</td>
                                        <td>{{ $viewBillingStatement[0]->qty }}</td>
                                        <td>{{ $viewBillingStatement[0]->description}}</td>
                                        <td>{{ $viewBillingStatement[0]->unit }}</td>
                                        <td><?= number_format($viewBillingStatement[0]->amount, 2); ?></td>

                                      </tr>
                                      @foreach($billingStatements as $billingStatement)
                                      <tr>
                                        <td>{{ $billingStatement['date_of_transaction'] }}</td>
                                        <td>{{ $billingStatement['dr_no'] }}</td>
                                        <td>{{ $billingStatement['qty'] }}</td>
                                        <td>{{ $billingStatement['description'] }}</td>
                                        <td>{{ $billingStatement['unit'] }}</td>
                                        <td><?= number_format($billingStatement['amount'], 2);?></td>
                                      </tr>
                                      @endforeach
                                      <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                      
                                        <td><strong>Total</strong></td>
                                        <td>₱ <?= number_format($sum, 2)?></td>
                                      </tr>
                                    </tbody>
                              </table>


                              @endif
                               <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Prepared By</th>
                                                        <th>Approved By</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $viewBillingStatement[0]->created_by }}</td>
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