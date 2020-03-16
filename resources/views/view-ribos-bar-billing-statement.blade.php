@extends('layouts.ribos-bar-app')
@section('title', 'View Billing Statement |')
@section('content')
<script>
    function myFunction() {
      window.print();
    }
</script>
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
              <li class="breadcrumb-item active">View Billing Statement</li>
            </ol>
              <a href="{{ url('ribos-bar/billing-statement-lists') }}">Back to Lists</a>
          	<div class="col-lg-12">
            	 <img src="{{ asset('images/ribos.jpg')}}" width="390" height="250" class="img-responsive mx-auto d-block" alt="Ribo's Bar">
            	 
            	 <h4 class="text-center"><u>VIEW BILLING STATEMENT</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            View Billing Statment
                            <div class="float-right">
                               <a href="{{ action('LoloPinoyLechonDeCebuController@printBillingStatement', $viewBillingStatement['id'])}}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
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
                                                <th> {{ $viewBillingStatement['bill_to'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <th>{{ $viewBillingStatement['address'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>Period Covered</th>
                                                <th> {{ $viewBillingStatement['period_cover'] }} </th>
                                            </tr>
                                            <tr>
                                                <th>Date</th>
                                                <th>{{ $viewBillingStatement['date'] }}</th>
                                            </tr>
                                        </thead>
                                    </table>
                                  
                                  </div>
                                  <div class="col-lg-6">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="20%">Reference #</th>
                                                <th>{{ $viewBillingStatement['reference_number'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>PO Number</th>
                                                <th> {{ $viewBillingStatement['p_o_number'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>Terms</th>
                                                <th>{{ $viewBillingStatement['terms'] }}</th>
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
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                      <td>{{ $viewBillingStatement['date_of_transaction'] }}</td>
                                      <td>{{ $viewBillingStatement['invoice_number'] }}</td>
                                      <td>{{ $viewBillingStatement['whole_lechon'] }}</td>
                                      <td>{{ $viewBillingStatement['description'] }}</td>
                                      <td><?php echo number_format($viewBillingStatement['amount'], 2); ?></td>
                                      </tr>
                                      @foreach($billingStatements as $billingStatement)
                                      <tr>
                                        <td>{{ $billingStatement['date_of_transaction'] }}</td>
                                        <td>{{ $billingStatement['invoice_number'] }}</td>
                                        <td>{{ $billingStatement['whole_lechon'] }}</td>
                                        <td>{{ $billingStatement['description'] }}</td>
                                        <td><?php echo number_format($billingStatement['amount'], 2);?></td>
                                      </tr>
                                      @endforeach
                                      <tr>
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
                                                        <td>{{ $viewBillingStatement['created_by'] }}</td>
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