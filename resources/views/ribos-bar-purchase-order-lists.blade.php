@extends('layouts.ribos-bar-app')
@section('title', 'Purchase Order Lists |')
@section('content')
<div id="wrapper">
	<!-- Sidebar -->

	 @include('sidebar.sidebar-ribos-bar')
     <div id="content-wrapper">
     	<div class="container-fluid">
     		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Ribo's Bar</a>
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
			  								<th>PO No</th>
			  								<th>Paid To</th>
			  								<th>Date</th>
			  								<th>Created by</th>
				  						</tr>
				  					</thead>
				  					<tfoot>
				  						<tr>
				  							<th>Action</th>
			  								<th>PO No</th>
			  								<th>Paid To</th>
			  								<th>Date</th>
			  								<th>Created by</th>
				  						</tr>
				  					</tfoot>
				  					<tbody>
                      @foreach($purchaseOrders as $purchaseOrder)
				  						<tr id="deletedId{{ $purchaseOrder->id }}">
				  							<td>
                          @if(Auth::user()['role_type'] != 3)
                          <a href="{{ url('ribos-bar/edit-ribos-bar-purchase-order/'.$purchaseOrder->id) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                          @endif
                          @if(Auth::user()['role_type'] == 1)
				  								<a id="delete" onClick="confirmDelete('{{ $purchaseOrder->id }}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                          @endif
				  								<a href="{{ url('ribos-bar/view-ribos-bar-purchase-order/'.$purchaseOrder->id) }}" title="View"><i class="fas fa-low-vision"></i></a>
				  							</td>
                        <td>{{ $purchaseOrder->module_code}}{{ $purchaseOrder->ribos_bar_code }}</td>
                        <td>{{ $purchaseOrder->paid_to }}</td>
                        <td>{{ $purchaseOrder->date }}</td>
                        <td>{{ $purchaseOrder->created_by }}</td>
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
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript">
    const confirmDelete = (id) => {
        const x = confirm("Do you want to delete this?");
          if(x){
              $.ajax({
                type: "DELETE",
                url: '/ribos-bar/delete/PO/' + id,
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