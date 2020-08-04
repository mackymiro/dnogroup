@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'Billing Statement Lists |')
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
                <li class="breadcrumb-item active">Billing Statement All Lists</li>
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
						  						<th>BS No</th>
						  						<th>Bill To</th>
						  						<th>Date</th>
						  						<th>Period Covered</th>
						  						<th>Created By</th>
			  								</thead>
			  								<tfoot>
					  							<th>Action</th>
						  						<th>BS No</th>
						  						<th>Bill To</th>
						  						<th>Date</th>
						  						<th>Period Covered</th>
						  						<th>Created By</th>

					  						</tfoot>
					  						<tbody>
			  								@foreach($billingStatements as $billingStatement)
				  							<tr id="deletedId{{ $billingStatement->id }}">
												<td>
												@if(Auth::user()['role_type'] !== 3)
													<a href="{{ url('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-billing-statement/'.$billingStatement->id ) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
												@endif
												@if(Auth::user()['role_type']== 1)
													<a id="delete" onClick="confirmDelete('{{ $billingStatement->id }}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
												@endif
													<a href="{{ url('lolo-pinoy-grill-commissary/view-lolo-pinoy-grill-billing-statement/'.$billingStatement->id) }}" title="View"><i class="fas fa-low-vision"></i></a>

				  								</td>
				  								<td>{{ $billingStatement->module_code}}{{ $billingStatement->lolo_pinoy_grill_code}}</td>
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
              url: '/lolo-pinoy-grill-commissary/delete-billing-statement/' + id,
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