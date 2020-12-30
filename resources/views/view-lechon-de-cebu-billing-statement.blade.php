@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'View Billing Statement |')
@section('content')
<script>
    function myFunction() {
      window.print();
    }
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
              <li class="breadcrumb-item active">View Billing Statement</li>
            </ol>
              <a href="{{ url('lolo-pinoy-lechon-de-cebu/billing-statement-lists') }}">Back to Lists</a>
          	<div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
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
                               <a href="{{ action('LoloPinoyLechonDeCebuController@printBillingStatement', $viewBillingStatement[0]->id)}}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
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
                                                <th width="30%">BS #</th>
                                                <th>{{ $viewBillingStatement[0]->lechon_de_cebu_code }}</th>
                                            </tr>
                                           
                                            <tr>
                                                <th>Terms</th>
                                                <th>{{ $viewBillingStatement[0]->terms }}</th>
                                            </tr>
                                            <tr>
                                                <th>DR Address</th>
                                                <th>{{ $viewBillingStatement[0]->dr_address }}</th>
                                            </tr>
                                            <tr>
                                                <th>DR Delivered For</th>
                                                <th>{{ $viewBillingStatement[0]->dr_delivered_for }}</th>
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
                                        @if($viewBillingStatement[0]->order === "Private Order")
                                        <th class="bg-info" style="color:white;">DR No</th>
                                        <th class="bg-info" style="color:white;">QTY</th>
                                        <th class="bg-info" style="color:white;">UNIT</th>
                                        @else
                                        <th class="bg-info" style="color:white;">INVOICE #</th>
                                        @endif
                                        <th class="bg-info" style="color:white;">DESCRIPTION</th>
                                        <th class="bg-info" style="color:white;">AMOUNT</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                      <td>{{ $viewBillingStatement[0]->date_of_transaction }}</td>
                                      @if($viewBillingStatement[0]->order == "Private Order")
                                      <td>{{ $viewBillingStatement[0]->dr_no }}</td>
                                      <td>{{ $viewBillingStatement[0]->qty }}</td>
                                      <td>{{ $viewBillingStatement[0]->unit }}</td>
                                      @else
                                      <td>{{ $viewBillingStatement[0]->invoice_number }}</td>
                                      @endif
                                     
                                      <td>{{ $viewBillingStatement[0]->description }}</td>
                                      <td><?php echo number_format($viewBillingStatement[0]->amount, 2); ?></td>
                                      </tr>
                                      @foreach($billingStatements as $billingStatement)
                                      <tr>
                                        <td>{{ $billingStatement['date_of_transaction'] }}</td>
                                        @if($billingStatement['order'] == "Private Order")
                                        <td>{{ $billingStatement['dr_no']}}</td>
                                        <td>{{ $billingStatement['qty'] }}</td>
                                        <td>{{ $billingStatement['unit'] }}</td>
                                        @else
                                        <td>{{ $billingStatement['invoice_number'] }}</td>
                                        @endif
                                       
                                        <td>{{ $billingStatement['description'] }}</td>
                                        <td><?php echo number_format($billingStatement['amount'], 2);?></td>
                                      </tr>
                                      @endforeach
                                      <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><strong>Total</strong></td>
                                        <td>₱ <?php echo number_format($sum, 2)?></td>
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