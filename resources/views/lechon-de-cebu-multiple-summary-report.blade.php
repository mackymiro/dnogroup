@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Summary Reports |')
@section('content')
<style >
	.anchor{
		color:white;
	}

	.anchor:hover{
		color:black;
	}
</style>
<script>
  $(document).ready(function(){
      $('table.display').DataTable( {} );
  });  
  $(function() {
        $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd",
        });
      }); 
</script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div id="wrapper">
    @include('sidebar.sidebar')
    <div id="content-wrapper">
        <div class="container-fluid">
             <!-- Breadcrumbs-->
             <h1 class="mt-4">Summary Report(s)</h1>
             <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">Lechon de Cebu </a>
                </li>
                <li class="breadcrumb-item active">Summary Report(s)</li>
                
              </ol>
              <div class="row">
                   <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
                            <i class="fas fa-search"></i>
	    					  Search Date
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        
                                        <div class="col-lg-4">
                                                <form action="{{ action('LoloPinoyLechonDeCebuController@getSummaryReport') }}" method="get">
                                                {{ csrf_field() }}
                                            <h1>Search Date</h1>
                                            <input type="text" name="selectDate" class="datepicker form-control"  required/>
                                            <br>
                                            <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-search" aria-hidden="true"></i> Search Date</button>
                                            </form>
                                        </div>
                                        
                                    </div>
                                </div>
                                <form action="{{ action('LoloPinoyLechonDeCebuController@getSummaryReportMultiple')}}" method="get"> 
                                     {{ csrf_field() }}
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="col-lg-4">
                                            <h1>Search Start Date</h1>
                                            <input type="text" name="startDate" class="datepicker form-control"  required/>
                                                
                                            </div>
                                            <div class="col-lg-4">
                                            <h1>Search End Date</h1>
                                            <input type="text" name="endDate" class="datepicker form-control"  required/>
                                            
                                            </div>
                                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <br>
                                            <button type="submit" class="btn btn-success  btn-lg"><i class="fa fa-search" aria-hidden="true"></i> Search Date</button>
                                            
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                   </div>
              </div>
            
              <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                        	<div class="card-header">
                            <i class="fas fa-flag"></i>
	    					  Summary Reports
                            </div>
                            <div class="card-body">
                                <div>
                                    <h1>Search Result For: {{ $startDate }} TO {{ $endDate}}</h1>
                                </div>
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-salesInvoice" data-toggle="tab" href="#salesInvoice" role="tab" aria-controls="salesInvoice" aria-selected="true">Sales Invoice</a>
                                        <a class="nav-item nav-link" id="nav-deliveryReceipt" data-toggle="tab" href="#deliveryReceipt" role="tab" aria-controls="deliveryReceipt" aria-selected="false">Delivery Receipt</a>
                                        <a class="nav-item nav-link" id="nav-purchaseOrder" data-toggle="tab" href="#purchaseOrder" role="tab" aria-controls="purchaseOrder" aria-selected="false">Purchase Order</a>
                                        <a class="nav-item nav-link" id="nav-SOA" data-toggle="tab" href="#SOA" role="tab" aria-controls="SOA" aria-selected="false">Statement Of Account</a>
                                        <a class="nav-item nav-link" id="nav-billingStatement" data-toggle="tab" href="#billingStatement" role="tab" aria-controls="billingStatement" aria-selected="false">Billing Statement</a>
                                        <a class="nav-item nav-link" id="nav-pettyCash" data-toggle="tab" href="#pettyCash" role="tab" aria-controls="pettyCash" aria-selected="false">Petty Cash</a>
                                        <a class="nav-item nav-link" id="nav-payables" data-toggle="tab" href="#payables" role="tab" aria-controls="payables" aria-selected="false">Payables</a>
                                        <a class="nav-item nav-link" id="nav-all" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="false">All</a>
                                   
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="salesInvoice" role="tabpanel" aria-labelledby="salesInvoice-tab">
                                      <br>
                                       
                                       <div class="float-right">
                                           <a href="{{ action('LoloPinoyLechonDeCebuController@printMultipleSummarySalesInvoice', $startDate.'TO'.$endDate) }}"><i class="fa fa-print fa-4x" aria-hidden="true"></i></a>
                                       </div>
                                       <br>
                                       <br>
                                       <br>
                                        <div class="table-responsive">
                                             <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <th>Action</th>
                                                    <th>Invoice #</th>
                                                    <th>SI No</th>
                                                    <th>Date</th>
                                                    <th>Ordered By</th>
                                                    <th>Address</th>
                                                    <th>QTY</th>
                                                    <th>Total KLS</th>
                                                    <th>Item Description</th>
                                                    <th>Unit Price</th>
                                                    <th>Amount</th>
                                                    <th>Created By</th>
                                                </thead>
                                                <tfoot>
                                                    <th>Action</th>
                                                    <th>Invoice #</th>
                                                    <th>SI No</th>
                                                    <th>Date</th>
                                                    <th>Ordered By</th>
                                                    <th>Address</th>
                                                    <th>QTY</th>
                                                    <th>Total KLS</th>
                                                    <th>Item Description</th>
                                                    <th>Unit Price</th>
                                                    <th>Amount</th>
                                                    <th>Created By</th>
                                                </tfoot>
                                                <tbody>
                                                @foreach($getAllSalesInvoices as $getAllSalesInvoice)
                                                    <tr >
                                                    <td>
                                                    
                                                        <a href="{{ url('lolo-pinoy-lechon-de-cebu/edit-sales-invoice/'.$getAllSalesInvoice->id ) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                        
                                                        @if(Auth::user()['role_type'] == 1)
                                                        <a id="delete" onClick="confirmDelete('{{ $getAllSalesInvoice->id}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                                                        @endif
                                                        <a href="{{ url('lolo-pinoy-lechon-de-cebu/view-sales-invoice/'.$getAllSalesInvoice->id) }}" title="View"><i class="fas fa-low-vision"></i></a>
                                                    
                                                    </td>
                                                    <td>{{ $getAllSalesInvoice->invoice_number}}</td>
                                                    <td><p style="width:130px;">{{ $getAllSalesInvoice->module_code}}{{ $getAllSalesInvoice->lechon_de_cebu_code}}</p></td>
                                                    <td>{{ $getAllSalesInvoice->date }}</td>
                                                    <td>{{ $getAllSalesInvoice->ordered_by }}</td>
                                                    <td>{{ $getAllSalesInvoice->address}}</td>
                                                    <td>{{ $getAllSalesInvoice->qty}}</td>
                                                    <td><?php echo number_format($getAllSalesInvoice->total_kls, 2); ?></td>
                                                    <td>{{ $getAllSalesInvoice->item_description}}</td>
                                                    <td><?php echo number_format($getAllSalesInvoice->unit_price, 2);?></td>
                                                    <td><?php echo number_format($getAllSalesInvoice->amount, 2); ?></td>
                                                    <td>{{ $getAllSalesInvoice->created_by}}</td>
                                                    </tr>
                                          @endforeach

                                                </tbody>
                                             </table>
                                        </div>  
                                    </div>
                                    <div class="tab-pane fade" id="deliveryReceipt" role="tabpanel" aria-labelledby="deliveryReceipt-tab">
                                    <br>
                                       
                                       <div class="float-right">
                                           <a href="{{ action('LoloPinoyLechonDeCebuController@printMultipleSummaryDeliveryReceipt', $startDate.'TO'.$endDate) }}"><i class="fa fa-print fa-4x" aria-hidden="true"></i></a>
                                       </div>
                                       <br>
                                       <br>
                                       <br>
                                        <div class="table-responsive">
                                           <table class="table table-bordered display"  width="100%" cellspacing="0">
                                                <thead>
                                                    <th>Action</th>
                                                    <th>DR No</th>
                                                    <th>Date</th>
                                                    <th>Sold To</th>
                                                    <th>Time</th>
                                                    <th>Date To Be Delivered</th>
                                                    <th>Delivered To</th>
                                                    <th>Qty</th>
                                                    <th>Description</th>
                                                    <th>Price</th>
                                                    <th>Created By</th>
				  						        </thead>
                                                <tfoot>
                                                    <th>Action</th>
                                                    <th>DR No</th>
	                                                <th>Date</th>
					  						        <th>Sold To</th>
					  						        <th>Time</th>
                                                    <th>Date To Be Delivered</th>
                                                    <th>Delivered To</th>
                                                    <th>Qty</th>
                                                    <th>Description</th>
                                                    <th>Price</th>
                                                    <th>Created By</th>
                                                </tfoot>
                                                <tbody>
                                                @foreach($getAllDeliveryReceipts as $getAllDeliveryReceipt)
                                                    <tr>
                                                    <td>
                                    
                                                    <a href="{{ url('lolo-pinoy-lechon-de-cebu/edit-delivery-receipt/'.$getAllDeliveryReceipt->id ) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                    
                                                    @if(Auth::user()['role_type'] == 1)
                                                    <a id="delete" onClick="confirmDelete('{{ $getAllDeliveryReceipt->id}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                                                    @endif
                                                    <a href="{{ url('lolo-pinoy-lechon-de-cebu/view-delivery-receipt/'.$getAllDeliveryReceipt->id)}}" title="View"><i class="fas fa-low-vision"></i></a>
                                                
                                                    </td>
                                                   
                                                    <td>{{ $getAllDeliveryReceipt->module_code}}{{ $getAllDeliveryReceipt->lechon_de_cebu_code}}</td>
                                                    <td>{{ $getAllDeliveryReceipt->date}}</td>
                                                    <td><p style="width: 170px;">{{ $getAllDeliveryReceipt->sold_to}}</p></td>
                                                    <td><p style="width: 110px;">{{ $getAllDeliveryReceipt->time}}</p></td>
                                                    <td><p style="width: 140px;">{{ $getAllDeliveryReceipt->date_to_be_delivered}}</p></td>
                                                    <td><p style="width: 200px;">{{ $getAllDeliveryReceipt->delivered_to}}</p></td>
                                                    <td>{{ $getAllDeliveryReceipt->qty}}</td>
                                                    <td><p style="width: 200px;">{{ $getAllDeliveryReceipt->description}}</p></td>
                                                    <td><?php echo number_format($getAllDeliveryReceipt->price);?></td>
                                                    <td><p style="width: 120px;">{{ $getAllDeliveryReceipt->created_by}}</p></td>
                                                    
                                                    </tr>
			  								    @endforeach
                                                </tbody>
                                           </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="purchaseOrder" role="tabpanel" aria-labelledby="purchaseOrder-tab">
                                    <br>
                                       
                                       <div class="float-right">
                                           <a href="{{ action('LoloPinoyLechonDeCebuController@printMultipleSummaryPurchaseOrder', $startDate.'TO'.$endDate) }}"><i class="fa fa-print fa-4x" aria-hidden="true"></i></a>
                                       </div>
                                       <br>
                                       <br>
                                       <br>
                                       <div class="table-responsive">
                                            <table class="table table-bordered display" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Action</th>
                                                        <th>PO #</th>
                                                        <th>Paid to</th>
                                                        <th>Date</th>
                                                        <th>Created by</th>
                                                    </tr>
				  					            </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>Action</th>
                                                        <th>PO Number</th>
                                                        <th>Paid to</th>
                                                        <th>Date</th>
                                                        <th>Created by</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody> 
                                                @foreach($purchaseOrders as $purchaseOrder)
                                                <tr id="deletedId{{ $purchaseOrder->id }}">
                                                    <td>
                                                    
                                                    <a href="{{ url('lolo-pinoy-lechon-de-cebu/edit/'.$purchaseOrder->id) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    @if(Auth::user()['role_type'] == 1)
                                                        <a id="delete" onClick="confirmDelete('{{ $purchaseOrder->id }}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                                                    @endif
                                                        <a href="{{ url('lolo-pinoy-lechon-de-cebu/view/'.$purchaseOrder->id) }}" title="View"><i class="fas fa-low-vision"></i></a>
                                                    </td>
                                                    <td>{{ $purchaseOrder->module_code }}{{ $purchaseOrder->lechon_de_cebu_code }}</td>
                                                    <td>{{ $purchaseOrder->date }}</td>
                                                    <td>{{ $purchaseOrder->paid_to }}</td>
                                                    
                                                    <td>{{ $purchaseOrder->created_by }}</td>
				  						        </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="SOA" role="tabpanel" aria-labelledby="SOA-tab">
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table table-bordered display"  width="100%" cellspacing="0">
                                                <thead>
                                                    <th>Action</th>
                                                    <th>Date</th>
                                                    <th>Bill To</th>
                                                    <th>Branch</th>
                                                    <th>Reference #</th>
                                                    <th>Invoice#</th>
                                                    <th  class="bg-info" style="color:white;">Period Covered</th>
                                                    <th>Created By</th>
                                                </thead>
                                                <tfoot>
                                                    <th>Action</th>
                                                    <th>Date</th>
                                                    <th>Bill To</th>
                                                    <th>Branch</th>
                                                    <th>Reference #</th>
                                                    <th>Invoice#</th>
                                                    <th  class="bg-info" style="color:white;">Period Covered</th>
                                                    <th>Created By</th>
                                                </tfoot>
                                                <tbody>
                                                @foreach($statementOfAccounts as $statementOfAccount)
                                                <tr id="deletedId{{ $statementOfAccount->id}}">
                                                    <td>
                                                        @if(Auth::user()['role_type'] !== 3)
                                                        <a href="{{ url('lolo-pinoy-lechon-de-cebu/edit-statement-of-account/'.$statementOfAccount->id ) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                        @endif
                                                        
                                                        <a href="{{ url('lolo-pinoy-lechon-de-cebu/view-statement-account/'.$statementOfAccount->id) }}" title="View"><i class="fas fa-low-vision"></i></a>

                                                    </td>
                                                    <td>{{ $statementOfAccount->date }}</td>
                                                    <td>SOA-{{ $statementOfAccount->lechon_de_cebu_code}}</td>
                                                    <td>{{ $statementOfAccount->invoice_number}}</td>
                                                    <td>{{ $statementOfAccount->bill_to}}</td>
                                                    <td>{{ $statementOfAccount->branch}}</td>
                                                    
                                                    <td class="bg-info" style="color:white;">{{ $statementOfAccount->period_cover}}</td>
                                                    <td>{{ $statementOfAccount->created_by}}</td>
                                                    </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="billingStatement" role="tabpanel" aria-labelledby="billingStatement-tab">
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table table-bordered display"  width="100%" cellspacing="0">
                                            <thead>
                                                <th>Action</th>
                                                <th>BS No</th>
                                                <th>Date</th>
                                                <th>Bill To</th>
                                                
                                                <th>Period Covered</th>
                                                <th>Created By</th>
			  						        </thead>
                                            <tfoot>
                                                <th>Action</th>
                                                <th>BS No</th>
                                                <th>Date</th>
                                                <th>Bill To</th>
                                                
                                                <th>Period Covered</th>
                                                <th>Created By</th>

                                            </tfoot>
			  						        <tbody>
                                                @foreach($billingStatements as $billingStatement)
                                                <tr id="deletedId{{ $billingStatement->id }}">
                                                    <td>
                                                        @if(Auth::user()['role_type'] !== 3)
                                                        <a href="{{ url('lolo-pinoy-lechon-de-cebu/edit-billing-statement/'.$billingStatement->id ) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                        @endif
                                                        @if(Auth::user()['role_type'] == 1)
                                                        <a id="delete" onClick="confirmDelete('{{ $billingStatement->id }}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                                                        @endif
                                                        <a href="{{ url('lolo-pinoy-lechon-de-cebu/view-billing-statement/'.$billingStatement->id) }}" title="View"><i class="fas fa-low-vision"></i></a>

                                                    </td>
                                                    <td>{{ $billingStatement->module_code}}{{ $billingStatement->lechon_de_cebu_code }}</td>
            
                                                    <td>{{ $billingStatement->bill_to }}</td>
                                                    <td>{{ $billingStatement->date }}</td>
                                                    <td>{{ $billingStatement->period_cover }}</td>
                                                    <td>{{ $billingStatement->created_by }}</td>
                                                </tr>
                                                @endforeach
			  						            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pettyCash" role="tabpanel" aria-labelledby="pettyCash-tab">
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table table-bordered display" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th width="10%">Action</th>
                                                        <th>Date </th>
                                                        <th>Petty Cash No</th>
                                                        <th>Name</th>
                                                    
                                                        <th>Created By</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>Action</th>
                                                        <th>Date </th>
                                                        <th>Petty Cash No</th>
                                                        <th>Name</th>
                                                    
                                                        <th>Created By</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                @foreach($pettyCashLists as $pettyCashList)
                                                <tr id="deletedId{{ $pettyCashList->id}}">    
                                                    <td>
                                                    @if(Auth::user()['role_type'] != 3)
                                                        <a href="{{ url('lolo-pinoy-lechon-de-cebu/edit-petty-cash/'.$pettyCashList->id) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                        @endif
                                                    @if(Auth::user()['role_type'] == 1)
                                                        <a id="delete" onClick="confirmDelete('{{ $pettyCashList->id}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                                                    @endif
                                                    </td>
                                                    <td>{{ $pettyCashList->date}}</td>
                                                    <td>{{ $pettyCashList->module_code}}{{ $pettyCashList->lechon_de_cebu_code}}</td>
                                                    <td><a href="{{ url('lolo-pinoy-lechon-de-cebu/petty-cash/view/'.$pettyCashList->id) }}">{{ $pettyCashList->petty_cash_name}}</a></td>
                                                    <td>{{ $pettyCashList->created_by}}</td>
                                                </tr>   
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="payables" role="tabpanel" aria-labelledby="payables-tab">
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table table-bordered display" width="100%" cellspacing="0">
                                            <thead>
					  						<tr>
				  								<th>Action</th>
				  								<th>Invoice #</th>
				  								<th>PV No</th>
												<th  class="bg-info" style="color:#fff;">Category</th>
				  								<th>Issued Date</th>
												<th>Paid To</th>
												<th>Account Name</th>
				  								<th  class="bg-danger" style="color:white;">Amount Due</th>
				  								<th>Delivered Date</th>
												<th style="width:230px;">Payment Method</th>
				  								<th class="bg-success" style="color:white;">Status</th>
												<th>Created By</th>
                                                </tr>
                                            </thead>
				  						<tfoot>
				  							<tr>
				  								<th>Action</th>
				  								<th>Invoice #</th>
				  								<th>PV No</th>
												<th class="bg-info" style="color:#fff;">Category</th>
				  								<th>Issued Date</th>
												<th>Paid To</th>
												<th>Account Name</th>
				  								<th  class="bg-danger" style="color:white;">Amount Due</th>
				  								<th>Delivered Date</th>
												<th style="width:230px;">Payment Method</th>
				  								<th class="bg-success" style="color:white;">Status</th>
												<th>Created By</th>
					  						</tr>
				  						</tfoot>
				  						<tbody>
										  	<?php $sum = 0; ?>
				  							@foreach($getTransactionLists as $getTransactionList)
											<?php $id = $getTransactionList->id; ?>
											<?php
												$amount1 = DB::table('lechon_de_cebu_payment_vouchers')
															->select('*')
															->where('id', $id)
															->sum('amount');
												
												$amount2 = DB::table('lechon_de_cebu_payment_vouchers')
															->select('*')
															->where('pv_id', $id)
															->sum('amount');
												$compute = $amount1 + $amount2;
											?>
									
											
				  							<tr id="deletedId{{ $getTransactionList->id }}">
			  									<td width="2%">
			  										@if(Auth::user()['role_type'] == 1 || Auth::user()['role_type'] == 2)
					  									<a id="delete" onClick="confirmDelete('{{ $getTransactionList->id}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
				              						@endif
			  									</td>
			  									<td>
											    @if($getTransactionList->status != "FULLY PAID AND RELEASED")
                                                <p style="width:250px;">	
			  										<a href="{{ url('lolo-pinoy-lechon-de-cebu/edit-payables-detail/'.$getTransactionList->id) }}" title="Edit">{{ $getTransactionList->invoice_number}}</a>
												  	</p>
												  @else
													<p style="width:250px;">{{ $getTransactionList->invoice_number}}</p>
												@endif
			  									</td>
			  									<td><p style="width:140px;">{{ $getTransactionList->module_code}}{{ $getTransactionList->lechon_de_cebu_code}}</p></td>
												<td class="bg-info" style="color:#fff;"><p style="width:150px;">{{ $getTransactionList->category}}</p></td>
												<td><p style="width:130px;">{{ $getTransactionList->issued_date}}</p></td>
		
												<td><p style="width:200px;">{{ $getTransactionList->paid_to}}</p></td>
												
												<td><p style="width:200px;">{{ $getTransactionList->account_name}}</p></td>
												<td class="bg-danger" style="color:white;">												  
												  <p style="width:170px;"><?php echo number_format($compute, 2); ?></p></td>
			  									<td><p style="width:160px;">{{ $getTransactionList->delivered_date}}</p></td>
			  									<td><p style="width:190px;">{{ $getTransactionList->method_of_payment }}</p></td>
			  									
			  									<td class="bg-success" style="color:white; "><p style="width:240px;"><a class="anchor" href="{{ url('lolo-pinoy-lechon-de-cebu/view-payables-details/'.$getTransactionList->id) }}">{{ $getTransactionList->status }}</a></p></td>
			  									<td><p style="width:190px;">{{ $getTransactionList->created_by}}</p></td>
				  							    </tr>
											
				  							    @endforeach
                                            </table>        
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="all" role="tabpanel" aria-labelledby="all-tab">
                                         <br>
                                        
                                        <div class="float-right">
                                             <a href="{{ action('LoloPinoyLechonDeCebuController@printMultipleSummary', $startDate.'TO'.$endDate) }}"><i class="fa fa-print fa-4x" aria-hidden="true"></i></a>
                                        </div>
                                      
                                       
                                        <br>
                                        <div class="table-responsive">
                                            
                                            <h1>Sales Invoice</h1>
                                            <table class="table table-bordered display" width="100%" cellspacing="0">
                                                <thead>
                                                    <th>Invoice #</th>
                                                    <th>SI No</th>
                                                    <th>Date</th>
                                                    <th>Ordered By</th>
                                                    <th>Amount</th>
                                                    <th>Created By</th>
                                                </thead>
                                                <tfoot>
                                                    <th>Invoice #</th>
                                                    <th>SI No</th>
                                                    <th>Date</th>
                                                    <th>Ordered By</th>
                                                    <th>Amount</th>
                                                    <th>Created By</th>
                                                </tfoot>
                                                <tbody>
                                                @foreach($getAllSalesInvoices as $getAllSalesInvoice)
                                                    <tr >
                                                    
                                                    <td>{{ $getAllSalesInvoice->invoice_number}}</td>
                                                    <td><p style="width:130px;">{{ $getAllSalesInvoice->module_code}}{{ $getAllSalesInvoice->lechon_de_cebu_code}}</p></td>
                                                    <td>{{ $getAllSalesInvoice->date }}</td>
                                                    <td>{{ $getAllSalesInvoice->ordered_by }}</td>
                                                    <td><?php echo number_format($getAllSalesInvoice->total_amount, 2); ?></td>
                                                    <td>{{ $getAllSalesInvoice->created_by}}</td>
                                                    </tr>
                                                 @endforeach

                                                </tbody>
                                            </table>
                                            <br>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="15%" class="bg-info" style="color:white;">Total:</th>
                                                        <th class="bg-success" style="color:white"><?php echo number_format($totalSalesInvoice, 2);?></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <br>
                                        <div class="table-responsive">
                                            <h1>Delivery Receipt</h1>
                                            <table class="table table-bordered display" width="100%" cellspacing="0">
                                                <thead>
                                                    <th>DR No</th>
                                                    <th>Date</th>
                                                    <th>Amount</th>
                                                    <th>Created By</th>
				  						        </thead>
                                                <tfoot>
                                                    <th>DR No</th>
                                                    <th>Date</th>
                                                    <th>Amount</th>
                                                    <th>Created By</th>
                                                </tfoot>
                                                <tbody>
                                                @foreach($getAllDeliveryReceipts as $getAllDeliveryReceipt)
                                                    <tr >
                                                    <td>{{ $getAllDeliveryReceipt->module_code}}{{ $getAllDeliveryReceipt->lechon_de_cebu_code}}</td>
                                                    
                                                    <td>{{ $getAllDeliveryReceipt->date}}</td>
                                                    <td><?php echo number_format($getAllDeliveryReceipt->total, 2);?></td>
                                                    <td><p style="width: 120px;">{{ $getAllDeliveryReceipt->created_by}}</p></td>
                                                    
                                                    </tr>
			  								    @endforeach
                                                </tbody>
                                            </table>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="15%" class="bg-info" style="color:white;">Total:</th>
                                                        <th class="bg-success" style="color:white"><?php echo number_format($totalDeliveryReceipt, 2);?></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                            <div>
                                        </div>
                                        <br>
                                        <div class="table-responsive">
                                            <h1>Purchase Order</h1>
                                            <table class="table table-bordered display" width="100%" cellspacing="0">
                                                 <thead>
                                                    <th>PO No</th>
                                                    <th>Date</th>
                                                    <th>Paid To</th>
                                                    <th>Amount</th>
                                                    <th>Created By</th>
				  						        </thead>
                                                <tfoot>
                                                    <th>PO No</th>
                                                    <th>Date</th>
                                                    <th>Paid To</th>
                                                    <th>Amount</th>
                                                    <th>Created By</th>
                                                </tfoot>
                                                <tbody>
                                                @foreach($purchaseOrders as $purchaseOrder)
                                                    <tr>
                                                       
                                                        <td>{{ $purchaseOrder->module_code }}{{ $purchaseOrder->lechon_de_cebu_code }}</td>
                                                        <td>{{ $purchaseOrder->date }}</td>
                                                        <td>{{ $purchaseOrder->paid_to }}</td>
                                                        <td><?php echo number_format($purchaseOrder->total_price, 2)?></td>
                                                        <td>{{ $purchaseOrder->created_by }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                                </tbody>
                                            </table>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="15%" class="bg-info" style="color:white;">Total:</th>
                                                        <th class="bg-success" style="color:white"><?php echo number_format($totalPOrder, 2);?></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <br>
                                        <div class="table-responsive">
                                             <h1>Billing Statement </h1>
                                             <table class="table table-bordered display" width="100%" cellspacing="0">
                                                <thead>
                                                    <th>BS No</th>
                                                    <th>Date</th>
                                                    <th>Bill To</th>
                                                    <th>Period Covered</th>
                                                    <th>Amount</th>
                                                    <th>Created By</th>
                                                </thead>
                                                <tfoot>
                                                    <th>BS No</th>
                                                    <th>Date</th>
                                                    <th>Bill To</th>
                                                    <th>Period Covered</th>
                                                    <th>Amount</th>
                                                    <th>Created By</th>
                                                </tfoot>
                                                <tbody>
                                                @foreach($billingStatements as $billingStatement)
                                                <tr>
                                                    <td>{{ $billingStatement->module_code}}{{ $billingStatement->lechon_de_cebu_code }}</td>
                                                    <td>{{ $billingStatement->date }}</td>
                                                    <td>{{ $billingStatement->bill_to }}</td>
                                                    
                                                    <td>{{ $billingStatement->period_cover }}</td>
                                                    <td><?php echo number_format($billingStatement->total_amount, 2)?></td>
                                                    <td>{{ $billingStatement->created_by }}</td>
                                                </tr>
                                                @endforeach
                                                </tbody>
                                             </table>
                                             <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="15%" class="bg-info" style="color:white;">Total:</th>
                                                        <th class="bg-success" style="color:white"><?php echo number_format($totalBStatement, 2);?></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <br>
                                        <div class="table-responsive">
                                            <h1>Payment Cash Voucher </h1>
                                            <table class="table table-bordered display" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Invoice #</th>
                                                        <th>PV No</th>
                                                        <th>Issued Date</th>
                                                        <th>Paid To</th>
                                                        <th>Payment Method</th>
                                                        <th  class="bg-danger" style="color:white;">Amount Due</th>
                                                        <th class="bg-success" style="color:white;">Status</th>
                                                        <th>Created By</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                     <tr>
                                                        <th>Invoice #</th>
                                                        <th>PV No</th>
                                                        <th>Issued Date</th>
                                                        <th>Paid To</th>
                                                        <th>Payment Method</th>
                                                        <th  class="bg-danger" style="color:white;">Amount Due</th>
                                                        <th class="bg-success" style="color:white;">Status</th>
                                                        <th>Created By</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                <?php $sum = 0; ?>
                                                    @foreach($getTransactionListCashes as $getTransactionListCash)
                                                    <?php $id = $getTransactionListCash->id; ?>
                                                    <?php
                                                        $amount1 = DB::table('lechon_de_cebu_payment_vouchers')
                                                                    ->select('*')
                                                                    ->where('id', $id)
                                                                    ->sum('amount');
                                                        
                                                        $amount2 = DB::table('lechon_de_cebu_payment_vouchers')
                                                                    ->select('*')
                                                                    ->where('pv_id', $id)
                                                                    ->sum('amount');
                                                        $compute = $amount1 + $amount2;
                                                    ?>
                                            
                                                    
                                                    <tr >
                                                      
                                                        <td>
                                                        <p style="width:250px;">{{ $getTransactionListCash->invoice_number}}</p>
                                                       
                                                        </td>
                                                        <td><p style="width:140px;">{{ $getTransactionListCash->module_code}}{{ $getTransactionList->lechon_de_cebu_code}}</p></td>
                                                        <td><p style="width:130px;">{{ $getTransactionListCash->issued_date}}</p></td>
                
                                                        <td><p style="width:200px;">{{ $getTransactionListCash->paid_to}}</p></td>
                                                        
                                                        <td><p style="width:200px;">{{ $getTransactionListCash->method_of_payment}}</p></td>
                                                       
                                                        <td class="bg-danger" style="color:white;">												  
                                                        <p style="width:170px;"><?php echo number_format($compute, 2); ?></p></td>
                                                        
                                                        <td class="bg-success" style="color:white; "><p style="width:240px;"><a class="anchor" href="{{ url('lolo-pinoy-lechon-de-cebu/view-payables-details/'.$getTransactionList->id) }}">{{ $getTransactionList->status }}</a></p></td>
                                                        <td><p style="width:190px;">{{ $getTransactionListCash->created_by}}</p></td>
                                                        </tr>
                                                    
                                                        @endforeach
                                                </tbody>
                                               
                                            </table>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="15%" class="bg-info" style="color:white;">Total:</th>
                                                        <th class="bg-success" style="color:white"><?php echo number_format($totalAmountCashes, 2);?></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <br>
                                        <div class="table-responsive">
                                            <h1>Payment Check Voucher </h1>
                                            <table class="table table-bordered display" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Invoice #</th>
                                                        <th>PV No</th>
                                                        <th>Issued Date</th>
                                                        <th>Paid To</th>
                                                        <th>Bank Name/Check No</th>
                                                        <th>Payment Method</th>
                                                        <th class="bg-success" style="color:white;">Paid Amount</th>
                                                        <th class="bg-danger" style="color:white;">Balance</th>
                                                        <th class="bg-success" style="color:white;">Status</th>
                                                        <th>Created By</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                     <tr>
                                                        <th>Invoice #</th>
                                                        <th>PV No</th>
                                                        <th>Issued Date</th>
                                                        <th>Paid To</th>
                                                        <th>Bank Name/Check No</th>
                                                        <th>Payment Method</th>
                                                        <th class="bg-success" style="color:white;">Paid Amount</th>
                                                        <th class="bg-danger" style="color:white;">Balance</th>
                                                        <th class="bg-success" style="color:white;">Status</th>
                                                        <th>Created By</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                              
                                                    @foreach($getTransactionListChecks as $getTransactionListCheck)
                                                    <?php $id = $getTransactionListCheck->id; ?>
                                                    <?php
                                                        $amount1 = DB::table('lechon_de_cebu_payment_vouchers')
                                                                    ->select('*')
                                                                    ->where('id', $id)
                                                                    ->sum('amount');
                                                        
                                                        $amount2 = DB::table('lechon_de_cebu_payment_vouchers')
                                                                    ->select('*')
                                                                    ->where('pv_id', $id)
                                                                    ->sum('amount');
                                                        $compute = $amount1 + $amount2;

                                                          //get the check account no
                                                        $getChecks = DB::table('lechon_de_cebu_payment_vouchers')
                                                                    ->select('*')
                                                                    ->where('pv_id', $id)
                                                                    ->get()->toArray();
                                                    ?>
                                            
                                                    
                                                    <tr >
                                                      
                                                        <td>
                                                        <p style="width:250px;">{{ $getTransactionListCheck->invoice_number}}</p>
                                                       
                                                        </td>
                                                        <td><p style="width:140px;">{{ $getTransactionListCheck->module_code}}{{ $getTransactionListCheck->lechon_de_cebu_code}}</p></td>
                                                        <td><p style="width:130px;">{{ $getTransactionListCheck->issued_date}}</p></td>
                
                                                        <td><p style="width:200px;">{{ $getTransactionListCheck->paid_to}}</p></td>
                                                        <td>
                                                              <p style="width:190px;">
                                                                <?php foreach($getChecks as $getCheck): ?>
                                                                     <?php echo $getCheck->cheque_number; ?>
                                                                 <?php endforeach; ?>
                                                                </p>
                                                        </td>
                                                        <td><p style="width:200px;">{{ $getTransactionListCheck->method_of_payment}}</p></td>
                                                        <td class="bg-success" style="color:white"><p style="width:170px;"><?php echo number_format($getTransactionListCheck->cheque_total_amount, 2); ?></p></td>
                                                          
                                                        @if($getTransactionListCheck->status === "FULLY PAID AND RELEASED")
                                                            <td class="bg-danger" style="color:white;"> <p style="width:170px;">0</p></td>
                                                        @else
                                                        <td class="bg-danger" style="color:white;">												  
                                                            <p style="width:170px;"><?php echo number_format($compute, 2); ?></p>
                                                        </td>
                                                        @endif
                                                        <td class="bg-success" style="color:white; "><p style="width:240px;"><a class="anchor" href="{{ url('lolo-pinoy-lechon-de-cebu/view-payables-details/'.$getTransactionListCheck->id) }}">{{ $getTransactionListCheck->status }}</a></p></td>
                                                        <td><p style="width:190px;">{{ $getTransactionListCheck->created_by}}</p></td>
                                                        </tr>
                                                    
                                                        @endforeach
                                                </tbody>
                                                
                                            </table>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="15%" class="bg-info" style="color:white;">Total:</th>
                                                        <th class="bg-success" style="color:white"><?php echo number_format($totalAmountCheck, 2);?></th>
                                                    </tr>
                                                </thead>
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
