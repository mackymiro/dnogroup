@extends('layouts.dong-fang-corporation-app')
@section('title', 'View Billing Statement |')
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
                <li class="breadcrumb-item active">View Billing List</li>
               
              </ol>
              <a href="{{ url('/dong-fang-corporation/billing-statement/list') }}">Back to Lists</a>
              <div class="col-lg-12">
                    <img src="{{ asset('images/dong-fang-corporation.png')}}" width="277" height="139" class="img-responsive mx-auto d-block" alt="DNO Personal">
                
                    <h4 class="text-center"><u>BILLING STATEMENT</u></h4>
              </div>
              <div class="row">
                <div class="col-lg-12">
                     <div class="card mb-3">
                         <div class="card-header">
                            <i class="fas fa-receipt"></i>
                            Billing Statement
                            <div class="float-right">
                               <a href=""><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                             </div>
                           
                         </div>
                         <div class="card-body">
                               <div class="form-group">
                                    <div class="form-row">
                                         <div class="col-lg-6">
                                            <table class="table table-bordered">  
                                                 <thead>
                                                        <tr>
                                                            <th width="30%">Date</th>
                                                            <th> {{ $viewBillingStatement['date'] }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Account No</th>
                                                            <th>{{ $viewBillingStatement['account_no'] }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Company Name</th>
                                                            <th> {{ $viewBillingStatement['company_name'] }} </th>
                                                        </tr>
                                                        <tr>
                                                            <th>Address</th>
                                                            <th>{{ $viewBillingStatement['address'] }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Billing Statement No</th>
                                                            <th>{{ $viewBillingStatement['billing_statement_no'] }}</th>
                                                        </tr>
                                                    </thead>
                                            </table>
                                         </div>
                                         <div class="col-lg-6">
                                             <table class="table table-bordered">  
                                                 <thead>
                                                        <tr>
                                                            <th width="30%">Attention</th>
                                                            <th> {{ $viewBillingStatement['attention'] }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Ref No</th>
                                                            <th>{{ $viewBillingStatement['ref_no'] }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>PO No</th>
                                                            <th> {{ $viewBillingStatement['po_no'] }} </th>
                                                        </tr>
                                                        <tr>
                                                            <th>Terms</th>
                                                            <th>{{ $viewBillingStatement['terms'] }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Due Date</th>
                                                            <th>{{ $viewBillingStatement['due_date'] }}</th>
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
                                        <th class="bg-info" style="color:white;">NO OF PAX</th>
                                        <th class="bg-info" style="color:white;">PARTICULAR</th>
                                        <th class="bg-info" style="color:white;">PRICE PER PAX</th>
                                        <th class="bg-info" style="color:white;">AMOUNT</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                      <td>{{ $viewBillingStatement['date'] }}</td>
                                      <td>{{ $viewBillingStatement['no_pax'] }}</td>
                                      <td>{{ $viewBillingStatement['particular'] }}</td>
                                      <td><?php echo number_format($viewBillingStatement['price_per_pax'], 2)?></td>
                                      <td><?php echo number_format($viewBillingStatement['amount'], 2); ?></td>
                                      </tr>
                                      @foreach($billingStatements as $billingStatement)
                                      <tr>
                                        <td>{{ $billingStatement['date'] }}</td>
                                        <td>{{ $billingStatement['no_pax'] }}</td>
                                        <td>{{ $billingStatement['particular'] }}</td>
                                        <td><?php echo number_format($billingStatement['price_per_pax'], 2)?></td>
                                        <td><?php echo number_format($billingStatement['amount'], 2); ?></td>
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