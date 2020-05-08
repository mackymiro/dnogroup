@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'Purchase Order Lists |')
@section('content')
<div id="wrapper">
	<!-- Sidebar -->
	@include('sidebar.sidebar-lolo-pinoy-grill')
	<div id="content-wrapper">
		<div class="container-fluid">
			 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lolo Pinoy Grill Commissary</a>
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
			  								<th>Paid to</th>
			  								<th>Date</th>
			  								<th>Created by</th>
				  						</tr>
				  					</thead>
				  					<tfoot>
				  						<tr>
				  							<th>Action</th>
			  								<th>PO #</th>
			  								<th>Paid to</th>
			  								<th>Date</th>
			  								<th>Created by</th>
				  						</tr>
				  					</tfoot>
				  					<tbody>
				  						@foreach($purchaseOrders as $purchaseOrder)
				  						<tr>
				  							<td>
			  								  @if(Auth::user()['role_type'] != 3)
					                          <a href="{{ url('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-purchase-order/'.$purchaseOrder['id']) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
					                          @endif
					                          @if(Auth::user()['role_type'] == 1)
										  		<a id="delete" onClick="confirmDelete('{{ $purchaseOrder['id'] }}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
						                       @endif
				  								<a href="{{ url('lolo-pinoy-grill-commissary/view-lolo-pinoy-grill-commissary-purchase-order/'.$purchaseOrder['id']) }}" title="View"><i class="fas fa-low-vision"></i></a>
				  							</td>
				  							 <td><a href="#">P.O-{{ $purchaseOrder['p_o_number'] }}</a></td>
					                        <td>{{ $purchaseOrder['paid_to'] }}</td>
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
@endsection