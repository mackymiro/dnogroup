@extends('layouts.wlg-corporation-app')
@section('title', 'Purchase Order Lists |')
@section('content')
<div id="wrapper">
	<!-- Sidebar -->
	@include('sidebar.sidebar-wlg-corporation')
	<div id="content-wrapper">
		<div class="container-fluid">
			 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">WLG Corporation</a>
              </li>
              <li class="breadcrumb-item active">Purchase Lists</li>
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
					                          <a href="{{ url('wlg-corporation/edit-wlg-corporation-purchase-order/'.$purchaseOrder['id']) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
					                          @endif
					                          @if(Auth::user()['role_type'] == 1)
										  		<a id="delete" onClick="confirmDelete('{{ $purchaseOrder['id'] }}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
						                       @endif
				  								<a href="{{ url('wlg-corporation/view-wlg-corporation-purchase-order/'.$purchaseOrder['id']) }}" title="View"><i class="fas fa-low-vision"></i></a>
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