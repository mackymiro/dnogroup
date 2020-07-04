@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'View Sales Invoice |')
@section('content')
<div id="wrapper">
	<!-- Sidebar -->
  	 @include('sidebar.sidebar-mr-potato')
  	  <div id="content-wrapper">
  	  		<div class="container-fluid">
  	  			<!-- Breadcrumbs-->
	            <ol class="breadcrumb">
	              <li class="breadcrumb-item">
	                <a href="#">Mr Potato</a>
	              </li>
	              <li class="breadcrumb-item active">View Sales Invoice</li>
	            </ol>
	             <a href="{{ url('mr-potato/') }}">Back to Lists</a>
	            <div class="col-lg-12">
	            	  <img src="{{ asset('images/mr-potato.png')}}" width="390" height="250" class="img-responsive mx-auto d-block" alt="Mr Potato">
	            	 
	            	 <h4 class="text-center"><u>VIEW SALES INVOICE</u></h4>
	            </div>
	            <div class="row">
	            	<div class="col-lg-12">
	            		<div class="card mb-3">
            				<div class="card-header">
                     			 <i class="fas fa-cash-register" aria-hidden="true"></i>
                           	 	View Sales Invoice
								@if($viewSalesInvoice[0]->deleted_at == NULL)
                            	<div class="float-right">
                               		 <i class="fa fa-print fa-2x" aria-hidden="true"></i>
                          
                           		 </div>
								@endif
                            </div>
                            <div class="card-body">
							@if($viewSalesInvoice[0]->deleted_at != NULL)
                              <h1 style="color:red; font-size:28px; font-weight:bold">This Item Has Been Deleted! (CLERICAL ERROR)</h1>
                              @endif
                            	<table class="table table-bordered">
                            	 	<thead>
                                        <tr>
                                            <th width="20%">Invoice #</th>
                                            <th>{{ $viewSalesInvoice[0]->invoice_number }}</th>
                                        </tr>
										<tr>
                                            <th>SI No</th>
                                            <th>{{ $viewSalesInvoice[0]->module_code}}{{ $viewSalesInvoice[0]->mr_potato_code }}</th>
                                        </tr>
                                          <tr>
                                            <th>Date</th>
                                            <th>{{ $viewSalesInvoice[0]->date }}</th>
                                        </tr>
                                        <tr>
                                            <th>Ordered By</th>
                                            <th>{{ $viewSalesInvoice[0]->ordered_by }}</th>
                                        </tr>
                                        <tr>
                                            <th>Address</th>
                                            <th>{{ $viewSalesInvoice[0]->address }}</th>
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
                        	 						<td>{{ $viewSalesInvoice[0]->qty }}</td>
                        	 						<td>{{ $viewSalesInvoice[0]->total_kls }}</td>
                        	 						<td>{{ $viewSalesInvoice[0]->item_description }}</td>
                        	 						<td><?php echo number_format($viewSalesInvoice[0]->unit_price, 2)?></td>
                        	 						<td><?php echo number_format($viewSalesInvoice[0]->amount, 2)?></td>
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