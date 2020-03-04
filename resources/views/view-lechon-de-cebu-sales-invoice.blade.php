@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'View Sales Invoice |')
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
	              <li class="breadcrumb-item active">View Sales Invoice</li>
	            </ol>
	             <a href="{{ url('lolo-pinoy-lechon-de-cebu/') }}">Back to Lists</a>
             	<div class="col-lg-12">
	            	 <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
	            	 
	            	 <h4 class="text-center"><u>VIEW SALES INVOICE</u></h4>
	            </div>
	             <div class="row">
	             	<div class="col-lg-12">
	             		<div class="card mb-3">
             				<div class="card-header">
	                              <i class="fas fa-cash-register" aria-hidden="true"></i>
	                            View Sales Invoice
                                <div class="float-right">
                                    <button class="btn btn-success" onclick="myFunction()"> <i class="fa fa-print fa-2x" aria-hidden="true"></i></button>
                              
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="20%">Invoice #</th>
                                            <th>{{ $viewSalesInvoice['invoice_number'] }}</th>
                                        </tr>
                                          <tr>
                                            <th>Date</th>
                                            <th>{{ $viewSalesInvoice['date'] }}</th>
                                        </tr>
                                        <tr>
                                            <th>Ordered By</th>
                                            <th>{{ $viewSalesInvoice['ordered_by'] }}</th>
                                        </tr>
                                        <tr>
                                            <th>Address</th>
                                            <th>{{ $viewSalesInvoice['address'] }}</th>
                                        </tr>
                                    </thead>
                                   
                                </table>
                            	
                            	 <table class="table table-striped">
                        	 		<thead>
                        	 			<tr>
                    	 					<th class="bg-info" style="color:white;">QTY</th>
                    	 					<th class="bg-info" style="color:white;">TOTAL KLS</th>
                    	 					<th class="bg-info" style="color:white;">ITEM DESCRIPTION</th>
                    	 					<th class="bg-info" style="color:white;">UNIT PRICE</th>
                    	 					<th class="bg-info" style="color:white;">AMOUNT</th>
                        	 			</tr>
                        	 		</thead>
                        	 		<tbody>
                    	 				<tr>
                	 						<td>{{ $viewSalesInvoice['qty'] }}</td>
                	 						<td>{{ $viewSalesInvoice['total_kls'] }}</td>
                	 						<td>{{ $viewSalesInvoice['item_description'] }}</td>
                	 						<td><?php echo number_format($viewSalesInvoice['unit_price'], 2)?></td>
                	 						<td><?php echo number_format($viewSalesInvoice['amount'], 2)?></td>
                    	 				</tr>
                    	 				@foreach($salesInvoices as $salesInvoice)
                    	 				<tr>
                    	 					<td>{{ $salesInvoice['qty']}}</td>
                    	 					<td>{{ $salesInvoice['total_kls'] }}</td>
                    	 					<td>{{ $salesInvoice['item_description']}}</td>
                    	 					<td><?php echo number_format($salesInvoice['unit_price'], 2)?></td>
                	 						<td><?php echo number_format($salesInvoice['amount'], 2)?></td>
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
</div>
@endsection