@extends('layouts.ribos-bar-app')
@section('title', 'Delivery Receipt Lists| ')
@section('content')
<div id="wrapper">
	 @include('sidebar.sidebar-ribos-bar')
	  <div id="content-wrapper">
	  	<div class="container-fluid">
	  		<!-- Breadcrumbs-->
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">Ribo's Bar</a>
                </li>
                <li class="breadcrumb-item active">Delivery Receipt All Lists</li>
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
					  						
					  							<th>Action</th>
					  							<th>DR No</th>
					  							<th>Date</th>
					  							<th>Delivered To</th>
					  							<th>Address</th>
					  							<th>Product Id</th>
					  							<th>Qty</th>
					  							<th>Unit</th>
					  							<th>Item Description</th>
					  							<th>Unit Price</th>
					  							<th>Amount</th>
					  							<th>Created By</th>
						  						
						  					</thead>
						  					<tfoot>
						  						<th>Action</th>
					  							<th>DR No</th>
					  							<th>Date</th>
					  							<th>Delivered To</th>
					  							<th>Address</th>
					  							<th>Product Id</th>
					  							<th>Qty</th>
					  							<th>Unit</th>
					  							<th>Item Description</th>
					  							<th>Unit Price</th>
					  							<th>Amount</th>
					  							<th>Created By</th>
						  					</tfoot>
						  					<tbody>
				  							@foreach($getAllDeliveryReceipts as $getAllDeliveryReceipt)
					  						<tr id="deletedId{{ $getAllDeliveryReceipt['id'] }}">
					  							<td>
			               						 @if($user->role_type !== 3)
			  										<a href="{{ url('ribos-bar/edit-ribos-bar-delivery-receipt/'.$getAllDeliveryReceipt['id'] ) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
			               						 @endif
			              						@if($user->role_type == 1)
					  								<a id="delete" onClick="confirmDelete('{{ $getAllDeliveryReceipt['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
			              						@endif
									  				<a href="{{ url('ribos-bar/view-ribos-bar-delivery-receipt/'.$getAllDeliveryReceipt['id'])}}" title="View"><i class="fas fa-low-vision"></i></a>
						                         
			  									</td>
					  							<td>{{ $getAllDeliveryReceipt['dr_no']}}</td>
					  							<td>{{ $getAllDeliveryReceipt['date']}}</td>
					  							<td>{{ $getAllDeliveryReceipt['delivered_to']}}</td>
					  							<td>{{ $getAllDeliveryReceipt['address']}}</td>
					  							<td>{{ $getAllDeliveryReceipt['product_id']}}</td>
					  							<td>{{ $getAllDeliveryReceipt['qty']}}</td>
					  							<td>{{ $getAllDeliveryReceipt['unit']}}</td>
					  							<td>{{ $getAllDeliveryReceipt['item_description']}}</td>
					  							<td><?php echo number_format($getAllDeliveryReceipt['unit_price'], 2)?></td>
					  							<td><?php echo number_format($getAllDeliveryReceipt['amount'], 2)?></td>
					  							<td>{{ $getAllDeliveryReceipt['created_by'] }}</td>
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
	function confirmDelete(id){
        var x = confirm("Do you want to delete this?");
        if(x){
            $.ajax({
              type: "DELETE",
              url: '/mr-potato/delete-delivery-receipt/' + id,
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