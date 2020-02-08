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
       <li class="nav-item dropdown">
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
     <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-file-invoice"></i>
          <span>Payment vouchers</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/payment-voucher-form') }}">Payment Voucher Form</a>
            <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/cash-vouchers') }}">Cash Vouchers</a>
            <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/cheque-vouchers') }}">Cheque Vouchers</a>  
        </div>
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
                <li class="breadcrumb-item active">Statement Of Account All Lists</li>
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
      			  							<th>Date</th>
      			  							<th>Branch</th>
      			  							<th>Invoice#</th>
      			  							<th>Kilos</th>
      			  							<th>Unit Price</th>
      			  							<th>Payment Method Code</th>
      			  							<th>Amount</th>
      			  							<th>Status</th>
      			  							<th>Paid Amount</th>
      			  							<th>Created By</th>
      				  					</thead>
      				  					<tfoot>
      			  							<th>Action</th>
      			  							<th>Date</th>
      			  							<th>Branch</th>
      			  							<th>Invoice#</th>
      			  							<th>Kilos</th>
      			  							<th>Unit Price</th>
      			  							<th>Payment Method Code</th>
      			  							<th>Amount</th>
      			  							<th>Status</th>
      			  							<th>Paid Amount</th>
      			  							<th>Created By</th>
      				  					</tfoot>
      				  					<tbody>
      				  						@foreach($statementOfAccounts as $statementOfAccount)
      			  							<tr id="deletedId{{ $statementOfAccount['id'] }}">
      		  									<td>
      		  										<a href="{{ url('lolo-pinoy-lechon-de-cebu/edit-statement-of-account/'.$statementOfAccount['id']) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
      		  										<a id="delete" href="javascript:void" onClick="confirmDelete('{{ $statementOfAccount['id'] }}')" title="Delete"><i class="fas fa-trash"></i></a>
      		  										<a href="{{ url('lolo-pinoy-lechon-de-cebu/view-statement-account/'.$statementOfAccount['id']) }}" title="View"><i class="fas fa-low-vision"></i></a>
      		  									</td>
      		  									<td>{{ $statementOfAccount['date'] }}</td>
      		  									<td>{{ $statementOfAccount['branch'] }}</td>
      		  									<td>{{ $statementOfAccount['invoice_number'] }}</td>
      		  									<td>{{ $statementOfAccount['kilos'] }}</td>
      		  									<td>{{ $statementOfAccount['unit_price'] }}</td>
      		  									<td>{{ $statementOfAccount['payment_method'] }}</td>
      		  									<td><?php echo number_format($statementOfAccount['amount'], 2); ?></td>
      		  									<td>
      		  										@if($statementOfAccount['status'] == "Unpaid")
      		  										<span class="alert alert-danger">{{ $statementOfAccount['status'] }}</span>
      		  										@elseif($statementOfAccount['status'] == "Paid")
      		  										<span class="alert alert-success">{{ $statementOfAccount['status'] }}</span>

      		  										@endif
      		  									</td>
      		  									<td>{{ $statementOfAccount['paid_amount'] }}</td>
      		  									<td>{{ $statementOfAccount['created_by'] }}</td>
      		  								</tr>
      		  								@endforeach
      				  					</tbody>
      				  				</table>
    					  		</div>
    					  </div>
              			</div>
          			</div>
          			<div class="col-lg-12">
          					<div class="card mb-3">
          							<div class="card-header">
                      				<i class="far fa-money-bill-alt"></i>
            					  	Paid</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                    <th>Date</th>
                                    <th>Branch</th>
                                    <th>Invoice#</th>
                                    <th>Kilos</th>
                                    <th>Unit Price</th>
                                    <th>Payment Method Code</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Paid Amount</th>
                                    <th>Created By</th>
                                  </thead>
                                  <tfoot>
                                    <th>Date</th>
                                    <th>Branch</th>
                                    <th>Invoice#</th>
                                    <th>Kilos</th>
                                    <th>Unit Price</th>
                                    <th>Payment Method Code</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Paid Amount</th>
                                    <th>Created By</th>
                                  </tfoot>
                                  <tbody>
                                      @foreach($statementOfAccountPaids as $statementOfAccountPaid)
                                      <tr>
                                        <td>{{ $statementOfAccountPaid['date'] }}</td>
                                        <td>{{ $statementOfAccountPaid['branch']}}</td>
                                        <td>{{ $statementOfAccountPaid['invoice_number'] }}</td>
                                        <td>{{ $statementOfAccountPaid['kilos'] }}</td>
                                        <td>{{ $statementOfAccountPaid['unit_price'] }}</td>
                                        <td>{{ $statementOfAccountPaid['payment_method'] }}</td>
                                        <td><?php echo number_format($statementOfAccountPaid['amount'], 2); ?></td>
                                        <td>
                                            @if($statementOfAccountPaid['status'] == "Unpaid")
                                              <span class="alert alert-danger">{{ $statementOfAccountPaid['status'] }}</span>
                                            @elseif($statementOfAccountPaid['status'] == "Paid")
                                              <span class="alert alert-success">{{ $statementOfAccountPaid['status'] }}</span>

                                            @endif
                                        </td>
                                        <td>{{ $statementOfAccountPaid['paid_amount'] }}</td>
                                        <td>{{ $statementOfAccountPaid['created_by'] }}</td>
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
</div>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript">
    function confirmDelete(id){
        var x = confirm("Do you want to delete this?");
        if(x){
            $.ajax({
              type: "DELETE",
              url: '/lolo-pinoy-lechon-de-cebu/delete-statement-account/' + id,
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