@extends('layouts.dno-food-ventures-app')
@section('title', 'DNO Food Ventures|')
@section('content')
<div id="wrapper">
    @include('sidebar.sidebar-dno-food-ventures')
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="#">DNO Food Ventures</a>
				</li>
				<li class="breadcrumb-item active">Sales All Lists</li>			
			</ol>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            All Lists
                        </div>
                        <div class="card-body">
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
                                                <tr id="deletedId{{ $getAllSalesInvoice->id }}">
                                                <td>
                                                    @if(Auth::user()['role_type'] !== 3)
                                                <a href="/dno-food-ventures/{{ $getAllSalesInvoice->id}}/edit-sales-invoice" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                @if(Auth::user()['role_type'] == 1)
                                                <a id="delete" onClick="confirmDelete('{{ $getAllSalesInvoice->id }}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                                                @endif
                                                <a href="/dno-food-ventures/{{ $getAllSalesInvoice->id}}/view-sales-invoice" title="View"><i class="fas fa-low-vision"></i></a>
                                                
                                                </td>
                                                <td>{{ $getAllSalesInvoice->invoice_number}}</td>
                                                <td>
                                                    @foreach($getAllSalesInvoice->sales_invoices as $salesInvoice)
                                                        @if($salesInvoice->module_name === "Sales Invoice")
                                                            {{ $salesInvoice->module_code}}{{ $salesInvoice->dno_food_venture_code}}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>{{ $getAllSalesInvoice->date }}</td>
                                                <td>{{ $getAllSalesInvoice->ordered_by }}</td>
                                                <td>{{ $getAllSalesInvoice->address}}</td>
                                                <td>{{ $getAllSalesInvoice->qty }}</td>
                                                <td><?php echo number_format($getAllSalesInvoice->total_kls, 2); ?></td>
                                                <td>{{ $getAllSalesInvoice->item_description}}</td>
                                                <td><?php echo number_format($getAllSalesInvoice->unit_price, 2); ?></td>
                                                <td><?php echo number_format($getAllSalesInvoice->amount, 2); ?></td>
                                                <td>{{ $getAllSalesInvoice->created_by }}</td>
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
<script>    
    const confirmDelete = (id) =>{
		const x = confirm("Do you want to delete this?");
		if(x){
			$.ajax({
					type: "DELETE",
					url: '/dno-food-ventures/delete-sales-invoice/' + id,
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