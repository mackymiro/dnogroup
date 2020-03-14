@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'Sales |')
@section('content')
<div id="wrapper">
	 @include('sidebar.sidebar-lolo-pinoy-grill')
	  <div id="content-wrapper">
	  		<div class="container-fluid">
  				  	<!-- Breadcrumbs-->
		            <ol class="breadcrumb">
		              <li class="breadcrumb-item">
		                <a href="#">Lolo Pinoy Grill Commissary</a>
		              </li>
		              <li class="breadcrumb-item active">Sales All Lists</li>
		            </ol>
		            <div class="row">
		            	<div class="col-lg-12">
		            		<div class="card mb-3">
		            			<div class="card-header">
		                            <i class="fa fa-cash-register" aria-hidden="true"></i>
		                            All Lists</div>
	                             <div class="card-body">
                             		 <div class="table-responsive">
                             		 	<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                             		 		<thead>
		                                        <th>Action</th>
		                                        <th>Invoice #</th>
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
		                                          <tr id="deletedId{{ $getAllSalesInvoice['id']}}">
		                                          <td>
		                                             @if($user->role_type !== 3)
		                                            <a href="{{ url('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-sales-invoice/'.$getAllSalesInvoice['id'] ) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
		                                             @endif
		                                            @if($user->role_type == 1)
		                                            <a id="delete" onClick="confirmDelete('{{ $getAllSalesInvoice['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
		                                            @endif
		                                            <a href="{{ url('lolo-pinoy-grill-commissary/view-lolo-pinoy-grill-sales-invoice/'.$getAllSalesInvoice['id']) }}" title="View"><i class="fas fa-low-vision"></i></a>
		                                           
		                                          </td>
		                                          <td>{{ $getAllSalesInvoice['invoice_number']}}</td>
		                                          <td>{{ $getAllSalesInvoice['date'] }}</td>
		                                          <td>{{ $getAllSalesInvoice['ordered_by'] }}</td>
		                                          <td>{{ $getAllSalesInvoice['address']}}</td>
		                                          <td>{{ $getAllSalesInvoice['qty']}}</td>
		                                          <td><?php echo number_format($getAllSalesInvoice['total_kls'], 2); ?></td>
		                                          <td>{{ $getAllSalesInvoice['item_description']}}</td>
		                                          <td><?php echo number_format($getAllSalesInvoice['unit_price'], 2);?></td>
		                                          <td><?php echo number_format($getAllSalesInvoice['amount'], 2); ?></td>
		                                          <td>{{ $getAllSalesInvoice['created_by']}}</td>
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

</div>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript">
	 function confirmDelete(id){
      var x = confirm("Do you want to delete this?");
      if(x){
        $.ajax({
                type: "DELETE",
                url: '/lolo-pinoy-grill-commissary/delete-sales-invoice/' + id,
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