@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'View Billing Statement |')
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
                            View Billing Statment</div>
                        <div class="card-body">
                             <div class="form-group">
                                <div class="form-row">
                                  <div class="col-lg-6">
                                    <label>Bill to</label>
                                    <br>
                                    {{ $viewBillingStatement['bill_to'] }}
                                    <br>
                                    <br>
                                    <label>Address</label>
                                    <br>
                                    {{ $viewBillingStatement['address'] }}
                                    <br>
                                    <br>
                                    <label>Period Covered</label>
                                    <br>
                                    {{ $viewBillingStatement['period_cover'] }} 
                                  </div>
                                  <div class="col-lg-6">
                                    <label>Date</label>
                                    <br>
                                    {{ $viewBillingStatement['date'] }}
                                    <br>
                                    <br>
                                    <label>Reference #</label>
                                    <br>
                                    {{ $viewBillingStatement['reference_number'] }}
                                    <br>
                                    <br>
                                    <label>PO Number</label>
                                    <br>
                                    {{ $viewBillingStatement['p_o_number'] }}
                                    <br>
                                    <br>
                                    <label>Terms</label>
                                    <br>
                                    {{ $viewBillingStatement['terms'] }}
                                    <br>

                                  </div>
                                </div>
                                </div>
                                <table class="table table-striped">
                                    <thead>
                                      <tr>
                                        <th>DATE</th>
                                        <th>INVOICE #</th>
                                        <th>WHOLE LECHON 500/KL</th>
                                        <th>DESCRIPTION</th>
                                        <th>AMOUNT</th>
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
                                        <td></td>
                                      </tr>
                                    </tbody>
                              </table>
                               <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-6">
                                           <label>Prepared By</label>
                                          <p>{{ $viewBillingStatement['created_by'] }}</p>
                                        </div>
                                        <div class="col-lg-6">
                                           <label>Approved By</label>
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