@extends('layouts.wlg-corporation-app')
@section('title', 'WLG Corporation|')
@section('content')
<div id="wrapper">
    @include('sidebar.sidebar-wlg-corporation')
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="#">WLG Corporation</a>
				</li>
                @if(\Request::is('wlg-corporation'))
				<li class="breadcrumb-item active">Invoice</li>
                @elseif(\Request::is('wlg-corporation/pro-forma-invoice/lists'))
                <li class="breadcrumb-item active">Pro-Forma Invoice</li>
                @elseif(\Request::is('wlg-corporation/commercial-invoice/lists'))
                <li class="breadcrumb-item active">Commercial Invoice</li>
                @elseif(\Request::is('wlg-corporation/quotation-invoice/lists'))
                <li class="breadcrumb-item active">Quotation</li>
                @elseif(\Request::is('wlg-corporation/packing-list/lists'))
                <li class="breadcrumb-item active">Packing List</li>
                @endif
			
			</ol>
            @if(\Request::is('wlg-corporation'))
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
							<i class="fa fa-file-invoice" aria-hidden="true"></i>
							Invoice List
                         
						</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    	<thead>
                                            <th>Action</th>
                                            <th>Invoice #</th>
                                            <th>Date</th>
                                            <th>Delivery Terms</th>
                                            <th>Transport By</th>
                                            <th>Created By</th>
                                          
                                        </thead>
                                        <tfoot>
                                            <th>Action</th>
                                            <th>Invoice #</th>
                                            <th>Date</th>
                                            <th>Delivery Terms</th>
                                            <th>Transport By</th>
                                            <th>Created By</th>
                                        </tfoot>
                                        <tbody>
                                            @foreach($invoices as $invoice)
                                            <tr id="deletedId{{ $invoice['id'] }}">
                                                <td>
                                                    @if(Auth::user()['role_type'] !== 3)
		                                            <a href="{{ url('wlg-corporation/edit-invoice/'.$invoice['id'] ) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
		                                             @endif
                                                     @if(Auth::user()['role_type'] == 1)
		                                            <a id="delete" onClick="confirmDelete('{{ $invoice['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
		                                            @endif
                                                </td>
                                                <td><a href="{{ url('wlg-corporation/view-invoice/'.$invoice['id']) }}">{{ $invoice['invoice_number']}}</a></td>
                                                <td>{{ $invoice['date'] }}</td>
                                                <td>{{ $invoice['delivery_terms']}}</td>
                                                <td>{{ $invoice['transport_by']}}</td>
                                                <td>{{ $invoice['created_by']}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end of row-->
            @elseif(\Request::is('wlg-corporation/pro-forma-invoice/lists'))
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
							<i class="fa fa-file-invoice" aria-hidden="true"></i>
							Invoice List
                         
						</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    	<thead>
                                            <th>Action</th>
                                            <th>Invoice #</th>
                                            <th>Date</th>
                                            <th>Delivery Terms</th>
                                            <th>Transport By</th>
                                            <th>Created By</th>
                                          
                                        </thead>
                                        <tfoot>
                                            <th>Action</th>
                                            <th>Invoice #</th>
                                            <th>Date</th>
                                            <th>Delivery Terms</th>
                                            <th>Transport By</th>
                                            <th>Created By</th>
                                        </tfoot>
                                        <tbody>
                                            @foreach($invoiceProFormas as $invoiceProForma)
                                            <tr id="deletedId{{ $invoiceProForma['id'] }}">
                                                <td>
                                                    @if(Auth::user()['role_type'] !== 3)
		                                            <a href="{{ url('wlg-corporation/edit-pro-forma-invoice/'.$invoiceProForma['id'] ) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
		                                             @endif
                                                     @if(Auth::user()['role_type'] == 1)
		                                            <a id="delete" onClick="confirmDelete('{{ $invoiceProForma['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
		                                            @endif
                                                </td>
                                                <td><a href="{{ url('wlg-corporation/view-pro-forma-invoice/'.$invoiceProForma['id']) }}">{{ $invoiceProForma['invoice_number']}}</a></td>
                                                <td>{{ $invoiceProForma['date'] }}</td>
                                                <td>{{ $invoiceProForma['delivery_terms']}}</td>
                                                <td>{{ $invoiceProForma['transport_by']}}</td>
                                                <td>{{ $invoiceProForma['created_by']}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end of row-->
            @elseif(\Request::is('wlg-corporation/commercial-invoice/lists'))
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
							<i class="fa fa-file-invoice" aria-hidden="true"></i>
							Commercial Invoice
                         
						</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    	<thead>
                                            <th>Action</th>
                                            <th>Invoice #</th>
                                            <th>Date</th>
                                            <th>Delivery Terms</th>
                                            <th>Transport By</th>
                                            <th>Created By</th>
                                          
                                        </thead>
                                        <tfoot>
                                            <th>Action</th>
                                            <th>Invoice #</th>
                                            <th>Date</th>
                                            <th>Delivery Terms</th>
                                            <th>Transport By</th>
                                            <th>Created By</th>
                                        </tfoot>
                                        <tbody>
                                             @foreach($invoiceCommercialInvoices as $invoiceCommercialInvoice)
                                            <tr id="deletedId{{ $invoiceCommercialInvoice['id'] }}">
                                                <td>
                                                    @if(Auth::user()['role_type'] !== 3)
		                                            <a href="{{ url('wlg-corporation/edit-commercial-invoice/'.$invoiceCommercialInvoice['id'] ) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
		                                             @endif
                                                     @if(Auth::user()['role_type'] == 1)
		                                            <a id="delete" onClick="confirmDelete('{{ $invoiceCommercialInvoice['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
		                                            @endif
                                                </td>
                                                <td><a href="{{ url('wlg-corporation/view-commercial-invoice/'.$invoiceCommercialInvoice['id']) }}">{{ $invoiceCommercialInvoice['invoice_number']}}</a></td>
                                                <td>{{ $invoiceCommercialInvoice['date'] }}</td>
                                                <td>{{ $invoiceCommercialInvoice['delivery_terms']}}</td>
                                                <td>{{ $invoiceCommercialInvoice['transport_by']}}</td>
                                                <td>{{ $invoiceCommercialInvoice['created_by']}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end of row-->
            @elseif(\Request::is('wlg-corporation/quotation-invoice/lists'))
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
							<i class="fa fa-file-invoice" aria-hidden="true"></i>
							Quotation Invoice
                         
						</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    	<thead>
                                            <th>Action</th>
                                            <th>Invoice #</th>
                                            <th>Date</th>
                                            <th>Delivery Terms</th>
                                            <th>Transport By</th>
                                            <th>Created By</th>
                                          
                                        </thead>
                                        <tfoot>
                                            <th>Action</th>
                                            <th>Invoice #</th>
                                            <th>Date</th>
                                            <th>Delivery Terms</th>
                                            <th>Transport By</th>
                                            <th>Created By</th>
                                        </tfoot>
                                        <tbody>
                                             @foreach($invoiceQuotations as $invoiceQuotation)
                                            <tr id="deletedId{{ $invoiceQuotation['id'] }}">
                                                <td>
                                                    @if(Auth::user()['role_type'] !== 3)
		                                            <a href="{{ url('wlg-corporation/edit-quotation-invoice/'.$invoiceQuotation['id'] ) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
		                                             @endif
                                                     @if(Auth::user()['role_type'] == 1)
		                                            <a id="delete" onClick="confirmDelete('{{ $invoiceQuotation['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
		                                            @endif
                                                </td>
                                                <td><a href="{{ url('wlg-corporation/view-quotation-invoice/'.$invoiceQuotation['id']) }}">{{ $invoiceQuotation['invoice_number']}}</a></td>
                                                <td>{{ $invoiceQuotation['date'] }}</td>
                                                <td>{{ $invoiceQuotation['delivery_terms']}}</td>
                                                <td>{{ $invoiceQuotation['transport_by']}}</td>
                                                <td>{{ $invoiceQuotation['created_by']}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end of row-->
            @elseif(\Request::is('wlg-corporation/packing-list/lists'))
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
							<i class="fa fa-file-invoice" aria-hidden="true"></i>
							Packing List
                         
						</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    	<thead>
                                            <th>Action</th>
                                            <th>Invoice #</th>
                                            <th>Date</th>
                                            <th>Delivery Terms</th>
                                            <th>Transport By</th>
                                            <th>Created By</th>
                                          
                                        </thead>
                                        <tfoot>
                                            <th>Action</th>
                                            <th>Invoice #</th>
                                            <th>Date</th>
                                            <th>Delivery Terms</th>
                                            <th>Transport By</th>
                                            <th>Created By</th>
                                        </tfoot>
                                        <tbody>
                                             @foreach($packingLists as $packingList)
                                            <tr id="deletedId{{ $packingList['id'] }}">
                                                <td>
                                                    @if(Auth::user()['role_type'] !== 3)
		                                            <a href="{{ url('wlg-corporation/edit-packing-list/'.$packingList['id'] ) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
		                                             @endif
                                                     @if(Auth::user()['role_type'] == 1)
		                                            <a id="delete" onClick="confirmDelete('{{ $packingList['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
		                                            @endif
                                                </td>
                                                <td><a href="{{ url('wlg-corporation/view-packing-list/'.$packingList['id']) }}">{{ $packingList['invoice_number']}}</a></td>
                                                <td>{{ $packingList['date'] }}</td>
                                                <td>{{ $packingList['delivery_terms']}}</td>
                                                <td>{{ $packingList['transport_by']}}</td>
                                                <td>{{ $packingList['created_by']}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end of row-->
            @endif
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
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript">
    const confirmDelete = (id) =>{
        const x = confirm("Do you want to delete this?");
		if(x){
        $.ajax({
                type: "DELETE",
                url: '/wlg-corporation/invoice/delete/' + id,
                data:{
                  _method: 'delete', 
                  "_token": "{{ csrf_token() }}",
                  "id": id
                },
                success: function(data){
                  console.log(data);
                  $("#deletedId"+id).fadeOut('slow');
                 
                },
                error: function(data){
                  console.log('Error:', data);
                }

              });
        }else{
            return false;
        }
    }
</script>
@endsection