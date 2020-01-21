@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('content')
<div id="wrapper">
	<!-- Sidebar -->

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
      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-receipt"></i>
          <span>Statement of account</span>
        </a>
      </li>
       <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-receipt"></i>
          <span>Billing statement</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          @if($user->role_type ==1)
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
          <a class="dropdown-item" href="forgot-password.html">Stocks inventory</a>     
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
			  								<th>PO Number</th>
			  								<th>Paid to</th>
			  								<th>Date</th>
			  								<th>Created by</th>
				  						</tr>
				  					</tfoot>
				  					<tbody>
                      @foreach($purchaseOrders as $purchaseOrder)
				  						<tr id="deletedId{{ $purchaseOrder['id'] }}">
				  							<td>
                          @if($user->role_type != 3)
                          <a href="{{ url('lolo-pinoy-lechon-de-cebu/edit/'.$purchaseOrder['id']) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                          @endif
                          @if($user->role_type == 1)
				  								<a id="delete" onClick="confirmDelete('{{ $purchaseOrder['id'] }}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                          @endif
				  								<a href="{{ url('lolo-pinoy-lechon-de-cebu/view/'.$purchaseOrder['id']) }}" title="View"><i class="fas fa-low-vision"></i></a>
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
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript">
    function confirmDelete(id){
        var x = confirm("Do you want to delete this?");
        if(x){
            $.ajax({
              type: "DELETE",
              url: '/lolo-pinoy-lechon-de-cebu/delete/' + id,
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