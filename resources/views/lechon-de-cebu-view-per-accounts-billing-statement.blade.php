@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'View Per Accounts |')
@section('content')
<script type="text/javascript">
    $(document).ready(function() {
        $('table.display').dataTable();
    });
</script>
<div id="wrapper">
	 @include('sidebar.sidebar')
    <div id="content-wrapper">
    	<div class="container-fluid">
      		 <!-- Breadcrumbs-->
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">Lechon de Cebu</a>
                </li>
                 <li class="breadcrumb-item active">Billing Statement</li>
                <li class="breadcrumb-item ">View Per Accounts</li>
              </ol>
            <div class="row">
                	<div class="col-lg-12">
                    		<div class="card mb-3">
                        			<div class="card-header">
              					           <i class="fa fa-tasks" aria-hidden="true"></i>
                					        SSP FOOD AVENUE TERMINAL 1 List
                              </div>
                					  <div class="card-body">
                    					  	<div class="table-responsive">
                    				  				<table class="table table-bordered display"  width="100%" cellspacing="0">
                      				  					<thead>
                      				  						<th>Action</th>
                                            <th >Invoice #</th>
                                            <th>Date</th>
                                            <th >Bill To</th>
                                            <th>Address</th>
                                            <th>Qty</th>
                                            <th >Total KLS</th>
                                            <th >Item Description</th>
                                          
                                            <th>Unit Price</th>
                                            <th>Amount</th>
                                            <th >Created By</th>
                      			  						</thead>
                      			  						<tfoot>
                      			  							<th>Action</th>
                                            <th >Invoice #</th>
                                            <th>Date</th>
                                            <th >Bill To</th>
                                            <th>Address</th>
                                            <th>Qty</th>
                                            <th >Total KLS</th>
                                            <th>Item Description</th>
                                          
                                            <th>Unit Price</th>
                                            <th>Amount</th>
                                            <th >Created By</th>

                      			  						</tfoot>
                      			  						<tbody>
                  			  						    @foreach($statementOfAccountT1s as $statementOfAccountT1) 
                                                <tr>
                                                    <td>
                                                       <a href="{{ url('lolo-pinoy-lechon-de-cebu/billing-statement/view-ssps/'.$statementOfAccountT1['id']) }}" title="View"><i class="fas fa-low-vision"></i></a>
                                                    </td>
                                                    <td>{{ $statementOfAccountT1['invoice_number']}}</td>
                                                    <td>{{ $statementOfAccountT1['date']}}</td>
                                                    <td>{{ $statementOfAccountT1['ordered_by']}}</td>
                                                    <td>{{ $statementOfAccountT1['address']}}</td>
                                                    <td>{{ $statementOfAccountT1['qty']}}</td>
                                                    <td>{{ $statementOfAccountT1['total_kls']}}</td>
                                                    <td>{{ $statementOfAccountT1['item_description']}}</td>
                                                   
                                                    <td>{{ $statementOfAccountT1['unit_price']}}</td>
                                                    <td><?php echo number_format($statementOfAccountT1['amount'], 2)?></td>

                                                    <td>{{ $statementOfAccountT1['created_by']}}</td>
                                                </tr>
                                            @endforeach
                      			  						</tbody>
                    			  					</table>
                    					  	</div>
                					  </div>
                    		</div>
                	</div>
            </div>
            <div class="row">
                  <div class="col-lg-12">
                        <div class="card mb-3">
                              <div class="card-header">
                                   <i class="fa fa-tasks" aria-hidden="true"></i>
                                  SSP FOOD AVENUE TERMINAL 2 List
                              </div>
                            <div class="card-body">
                                  <div class="table-responsive">
                                      <table class="table table-bordered display"width="100%" cellspacing="0">
                                          <thead>
                                            <th>Action</th>
                                            <th>Invoice #</th>
                                            <th>Date</th>
                                            <th>Bill To</th>
                                            <th>Address</th>
                                            <th>Qty</th>
                                            <th>Total KLS</th>
                                            <th>Item Description</th>
                                            <th>Unit Price</th>
                                            <th>Amount</th>
                                            <th>Created By</th>
                                          </thead>
                                          <tfoot>
                                            <th>Action</th>
                                            <th>Invoice #</th>
                                            <th>Date</th>
                                            <th>Bill To</th>
                                            <th>Address</th>
                                            <th>Qty</th>
                                            <th>Total KLS</th>
                                            <th>Item Description</th>
                                            <th>Unit Price</th>
                                            <th>Amount</th>
                                            <th>Created By</th>

                                          </tfoot>
                                          <tbody>
                                          @foreach($statementOfAccountT2s as $statementOfAccountT2) 
                                                <tr>
                                                    <td>
                                                       <a href="{{ url('lolo-pinoy-lechon-de-cebu/billing-statement/view-ssps/'.$statementOfAccountT1['id']) }}" title="View"><i class="fas fa-low-vision"></i></a>
                                                    </td>
                                                    <td>{{ $statementOfAccountT2['invoice_number']}}</td>
                                                    <td>{{ $statementOfAccountT2['date']}}</td>
                                                    <td>{{ $statementOfAccountT2['ordered_by']}}</td>
                                                    <td>{{ $statementOfAccountT2['address']}}</td>
                                                    <td>{{ $statementOfAccountT2['qty']}}</td>
                                                    <td>{{ $statementOfAccountT2['total_kls']}}</td>
                                                    <td>{{ $statementOfAccountT2['item_description']}}</td>
                                                   
                                                    <td>{{ $statementOfAccountT2['unit_price']}}</td>
                                                    <td><?php echo number_format($statementOfAccountT2['amount'], 2)?></td>

                                                    <td>{{ $statementOfAccountT2['created_by']}}</td>
                                                </tr>
                                            @endforeach
                                          </tbody>
                                      </table>
                                  </div>
                            </div>
                        </div>
                  </div>
            </div>
             <div class="row">
                  <div class="col-lg-12">
                        <div class="card mb-3">
                              <div class="card-header">
                                   <i class="fa fa-tasks" aria-hidden="true"></i>
                                 Delivery Receipt List
                              </div>
                            <div class="card-body">
                                  <div class="table-responsive">
                                      <table class="table table-bordered display" width="100%" cellspacing="0">
                                          <thead>
                                            <th>Action</th>
                                            <th>DR #</th>
                                            <th>Date</th>
                                            <th>Bill To</th>
                                            <th>Time</th>
                                            <th>Date TO Be Delivered</th>
                                            <th>Delivered To</th>
                                            <th>Qty</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Created By</th>
                                          </thead>
                                          <tfoot>
                                            <th>Action</th>
                                            <th>DR #</th>
                                            <th>Date</th>
                                            <th>Bill To</th>
                                            <th>Time</th>
                                            <th>Date TO Be Delivered</th>
                                            <th>Delivered To</th>
                                            <th>Qty</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Created By</th>

                                          </tfoot>
                                          <tbody> 
                                          @foreach($getAllDeliveryReceipts as $getAllDeliveryReceipt)
                                            <tr >
                                              <td><p >
                                    
                                              <a href="{{ url('lolo-pinoy-lechon-de-cebu/billing-statement/view-per-account-delivery-receipt/'.$getAllDeliveryReceipt['id'])}}" title="View"><i class="fas fa-low-vision"></i></a>
                                              </p>
                                              </td>
                                              <td>{{ $getAllDeliveryReceipt['dr_no']}}</td>
                                              <td>{{ $getAllDeliveryReceipt['date']}}</td>
                                              <td><p style="width: 170px;">{{ $getAllDeliveryReceipt['sold_to']}}</p></td>
                                              <td><p style="width: 110px;">{{ $getAllDeliveryReceipt['time']}}</p></td>
                                              <td><p style="width: 140px;">{{ $getAllDeliveryReceipt['date_to_be_delivered']}}</p></td>
                                              <td><p style="width: 200px;">{{ $getAllDeliveryReceipt['delivered_to']}}</p></td>
                                              <td>{{ $getAllDeliveryReceipt['qty']}}</td>
                                              <td><p style="width: 200px;">{{ $getAllDeliveryReceipt['description']}}</p></td>
                                              <td><?php echo number_format($getAllDeliveryReceipt['price']);?></td>
                                              <td><p style="width: 120px;">{{ $getAllDeliveryReceipt['created_by']}}</p></td>
                                              
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