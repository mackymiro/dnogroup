@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'View Statement Of Account |')
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
                            View Statement Of Account </div>
                        <div class="card-body">
                        	<div class="table-responsive">
                    			<table class="table table-striped">
                    				<thead>
                    					<tr>
                    						<th>Date</th>
          				  							<th>Branch</th>
          				  							<th>Invoice#</th>
          				  							<th>Kilos</th>
          				  							<th>Unit Price</th>
          				  							<th>Payment Method Code</th>
          				  							<th>Amount</th>
          				  							<th>Status</th>
          				  							<th>Paid Amount</th>
          				  							<th>Collection Date</th>
          				  							<th>Check Number</th>
          				  							<th>Check Amount</th>
          				  							<th>OR Number</th>
				  							
                    					</tr>
                    				</thead>
                    				<tbody>
                    					@foreach($getStatementAccounts as $getStatementAccount)
                    					<tr>
                    						<td>{{ $getStatementAccount['date'] }}</td>
                    						<td>{{ $getStatementAccount['branch']}}</td>
                    						<td>{{ $getStatementAccount['invoice_number'] }}</td>
                    						<td>{{ $getStatementAccount['kilos']}}</td>
                    						<td>{{ $getStatementAccount['unit_price']}}</td>
                    						<td>{{ $getStatementAccount['payment_method']}}</td>
                    						<td><?php echo number_format($getStatementAccount['amount'], 2); ?></td>
                    						<td>{{ $getStatementAccount['status']}}</td>
                    						<td>{{ $getStatementAccount['paid_amount']}}</td>
                    						<td>{{ $getStatementAccount['collection_date']}}</td>
                    						<td>{{ $getStatementAccount['check_number']}}</td>
                    						<td><?php echo number_format($getStatementAccount['check_amount'], 2); ?></td>
                    						<td>{{ $getStatementAccount['or_number']}}</td>
                    					</tr>
                    					@endforeach
                    				</tbody>
                    			</table>
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