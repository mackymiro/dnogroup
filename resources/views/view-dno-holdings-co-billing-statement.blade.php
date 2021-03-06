@extends('layouts.dno-holdings-co-app')
@section('title', 'View Billing Statement |')
@section('content')
<script>
    function myFunction() {
      window.print();
    }
</script>
<div id="wrapper">
	<!-- Sidebar -->
   @include('sidebar.sidebar-dno-holdings-co')
    <div id="content-wrapper">
    	<div class="container-fluid">
    		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">DNO Holdings & Co</a>
              </li>
              <li class="breadcrumb-item active">View Billing Statement</li>
            </ol>
              <a href="{{ url('dno-holdings-co/billing-statement-lists') }}">Back to Lists</a>
          	<div class="col-lg-12">
            	<img src="{{ asset('images/digitized-logos/dno-holdings-co.jpg')}}" width="390" height="250" class="img-responsive mx-auto d-block" alt="DNO Holdings & Co">
            	  
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
                               <a href="{{ action('DnoHoldingsCoController@printBillingStatement', $viewBillingStatement[0]->id)}}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
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
                                                            {{ $statement->module_code }}{{ $statement->dno_holdings_code}}
                                                        @endif
                                                    @endforeach
                                                </th>
                                            </tr>
                                           
                                            <tr>
                                                <th>Terms</th>
                                                <th>{{ $viewBillingStatement[0]->terms }}</th>
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
                                        <th class="bg-info" style="color:white;">DR #</th>
                                        <th class="bg-info" style="color:white;">ITEM DESCRIPTION</th>
                                        <th class="bg-info" style="color:white;">UNIT PRICE</th>
                                        <th class="bg-info" style="color:white;">AMOUNT</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>{{ $viewBillingStatement[0]->date_of_transaction }}</td>                  
                                        
                                        <td>{{ $viewBillingStatement[0]->dr_no }}</td>
                                        <td>{{ $viewBillingStatement[0]->description}}</td>
                                        <td>{{ $viewBillingStatement[0]->unit_price }}</td>
                                        <td><?= number_format($viewBillingStatement[0]->amount, 2); ?></td>

                                      </tr>
                                      @foreach($billingStatements as $billingStatement)
                                      <tr>
                                        <td>{{ $billingStatement['date_of_transaction'] }}</td>
                                        <td>{{ $billingStatement['dr_no'] }}</td>
                                        <td>{{ $billingStatement['description'] }}</td>
                                        <td>{{ $billingStatement['unit_price'] }}</td>
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