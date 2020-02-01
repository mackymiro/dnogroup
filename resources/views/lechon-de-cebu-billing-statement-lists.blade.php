@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('content')
<div id="wrapper">
	<ul class="sidebar navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-cash-register"></i>
          <span>Sales Invoice</span>
        </a>
      </li>
     
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fab fa-first-order"></i>
          <span>Purchase order</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          @if($user->role_type == 1)
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/purchase-order') }}">P.O Form</a>
          @endif
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/purchase-order-lists') }}">Lists</a>
         
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-receipt"></i>
          <span>Statement of account</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/statement-of-account-form')}}">Statement of Account</a>
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/statement-of-account/lists') }}">Lists</a>
         
        </div>
      </li>
       <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-receipt"></i>
          <span>Billing statement</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          @if($user->role_type == 1)
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/billing-statement-form') }}">Billing Statement Form</a>
          @endif
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/billing-statement-lists') }}">Lists</a>
         
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-file-invoice"></i>
          <span>Cash vouchers</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-book"></i>
          <span>Check vouchers</span>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-apple-alt"></i>
          <span>Commissary</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          
          <a class="dropdown-item" href="login.html">RAW materials</a>
          <a class="dropdown-item" href="register.html">Production</a>
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/commissary/stocks-inventory') }}">Stocks inventory</a>     
          <a class="dropdown-item" href="forgot-password.html">Delivery Outlets</a>

          <a class="dropdown-item" href="forgot-password.html">Sales of outlets</a>

          <a class="dropdown-item" href="forgot-password.html">Inventory of stocks</a>
         
        </div>
      </li>
     
     
    </ul>
    <div id="content-wrapper">
    	<div class="container-fluid">
      		 <!-- Breadcrumbs-->
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">Lechon de Cebu</a>
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
				  						<th>Reference #</th>
                      <th>PO #</th>
				  						<th>Bill To</th>
				  						<th>Date</th>
				  						<th>Period Covered</th>
				  						<th>Created By</th>
			  						</thead>
			  						<tfoot>
			  							<th>Action</th>
				  						<th>Reference #</th>
                      <th>PO #</th>
				  						<th>Bill To</th>
				  						<th>Date</th>
				  						<th>Period Covered</th>
				  						<th>Created By</th>

			  						</tfoot>
			  						<tbody>
			  							@foreach($billingStatements as $billingStatement)
			  							<tr id="deletedId{{ $billingStatement['id'] }}">
			  								<td>
                          @if($user->role_type !== 3)
			  									<a href="{{ url('lolo-pinoy-lechon-de-cebu/edit-billing-statement/'.$billingStatement['id'] ) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                          @endif
                          @if($user->role_type == 1)
				  								<a id="delete" onClick="confirmDelete('{{ $billingStatement['id'] }}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                          @endif
				  								<a href="{{ url('lolo-pinoy-lechon-de-cebu/view-billing-statement/'.$billingStatement['id']) }}" title="View"><i class="fas fa-low-vision"></i></a>

			  								</td>
			  								<td><a href="#">#-{{ $billingStatement['reference_number'] }}</a></td>
                        <td><a href="#">#-{{ $billingStatement['p_o_number'] }}</a></td>
			  								<td>{{ $billingStatement['bill_to'] }}</td>
			  								<td>{{ $billingStatement['date'] }}</td>
			  								<td>{{ $billingStatement['period_cover'] }}</td>
			  								<td>{{ $billingStatement['created_by'] }}</td>
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
              url: '/lolo-pinoy-lechon-de-cebu/delete-billing-statement/' + id,
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