@extends('layouts.mr-potato-app')
@section('title', 'Purchase Order Lists |')
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
              <li class="breadcrumb-item active">Purchase Order All Lists</li>
            </ol>
            <div class="row">
            	<div class="col-lg-12">
            		<div class="card mb-3">
            			<div class="card-header">
        					  <i class="fa fa-tasks" aria-hidden="true"></i>
        					  All Lists</div>
					  	<div class="card-body">
					  		<div class="table-responsive">
					  			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					  				<thead>
				  						<tr>
				  							<th>Action</th>
			  								<th>PO #</th>
			  								<th>Branch Location</th>
			  								<th>Date</th>
			  								<th>Created by</th>
				  						</tr>
				  					</thead>
				  					<tfoot>
				  						<tr>
				  							<th>Action</th>
			  								<th>PO #</th>
			  								<th>Branch Location</th>
			  								<th>Date</th>
			  								<th>Created by</th>
				  						</tr>
				  					</tfoot>
				  					<tbody>
				  						@foreach($purchaseOrders as $purchaseOrder)
				  						<tr id="deletedId{{ $purchaseOrder['id'] }}">
				  							<td>
			  								  @if($user->role_type != 3)
					                          <a href="{{ url('mr-potato/edit-mr-potato-purchase-order/'.$purchaseOrder['id']) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
					                          @endif
					                          @if($user->role_type == 1)
										  		<a id="delete" onClick="confirmDelete('{{ $purchaseOrder['id'] }}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
						                       @endif
				  								<a href="{{ url('mr-potato/view-mr-potato-purchase-order/'.$purchaseOrder['id']) }}" title="View"><i class="fas fa-low-vision"></i></a>
				  							</td>
				  							 <td><a href="#">P.O-{{ $purchaseOrder['p_o_number'] }}</a></td>
					                        <td>{{ $purchaseOrder['branch_location'] }}</td>
					                        <td>{{ $purchaseOrder['date'] }}</td>
					                        <td>{{ $purchaseOrder['created_by'] }}</td>
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
	const confirmDelete = (id) => {
		const x = confirm("Do you want to delete this?");
          if(x){
              $.ajax({
                type: "DELETE",
                url: '/mr-potato/delete/' + id,
                data:{
                  _method: 'delete', 
                  "_token": "{{ csrf_token() }}",
                  "id": id
                },
                success: function(data){
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