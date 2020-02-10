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
                <li class="breadcrumb-item ">Commissary</li>
                <li class="breadcrumb-item active">Stocks Inventory</li>
              </ol>
              <div class="row">
              		<div class="col-lg-12">
              			<div class="card mb-3">
            					<div class="card-header">
          					  <i class="fa fa-tasks" aria-hidden="true"></i>
          					  All Lists</div>
    					    <div class="card-body">
                    <div class="float-right">
                        <a href="{{ url('lolo-pinoy-lechon-de-cebu/commissary/create-stocks')}}" title="Create Stocks" class="btn  btn-success">Create Stocks</a>
                    </div>
                    <br>
                    <br>
    					  		<div class="table-responsive">
    					  			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    					  				<thead>
  				  						<th>Action</th>
  				  						<th>Product Id No</th>
  				  						<th>Product Name</th>
  				  						<th>Unit Price</th>
  				  						<th>Unit</th>
  				  						<th class="alert alert-danger">IN</th>
  				  						<th>OUT</th>
  				  					  <th>Stock Out Amount</th>
                        <th>Remaining Stock</th>
                        <th>Amount</th>
  				  						<th>Created By</th>
			  						   </thead>
			  						<tfoot>
			  							<th>Action</th>
				  						<th>Product Id No</th>
				  						<th>Product Name</th>
				  						<th>Unit Price</th>
				  						<th>Unit</th>
				  						<th class="alert alert-danger">IN</th>
				  						<th>OUT</th>
				  						<th>Stock Out Amount</th>
                      <th>Remaining Stock</th>
                      <th>Amount</th>
				  						<th>Created By</th>

			  						</tfoot>
			  						<tbody>
                      @foreach($getStocksInventories as $getStocksInventory)
			  							<tr id="deletedId{{ $getStocksInventory['id']}}">
		  									<td>
                          <a href="{{ url('lolo-pinoy-lechon-de-cebu/commissary/edit-stocks-inventory/'.$getStocksInventory['id']) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
		  										<a id="delete" href="javascript:void" onClick="confirmDelete('{{ $getStocksInventory['id'] }}')" title="Delete"><i class="fas fa-trash"></i></a>
		  									
		  									</td>
                        <td>{{ $getStocksInventory['product_id_no'] }}</td>
                        <td>{{ $getStocksInventory['product_name'] }}</td>
                        <td>{{ $getStocksInventory['unit_price'] }}</td>
                        <td>{{ $getStocksInventory['unit'] }}</td>
                        <td class="alert alert-danger">{{ $getStocksInventory['in'] }}</td>
                        <td>{{ $getStocksInventory['out'] }}</td>
                        <td>{{ $getStocksInventory['stock_amount']}}</td>
                        <td>{{ $getStocksInventory['remaining_stock']}}</td>
                        <td><?php echo number_format($getStocksInventory['amount'], 2);?></td>
                        <td>{{ $getStocksInventory['created_by'] }}</td>
                        
		  								</tr>
                      @endforeach
                      
			  						</tbody>
					  			</table>
                  <table class="table">
                    <thead>
                        <tr>
                
                        <td>Stock Out Value: ₱ <?php echo number_format($countStockAmount, 2); ?></td>
                        <td></td>
                        <td>Total Stock Value: ₱ <?php echo number_format($countTotalAmount, 2);?></td>
                      </tr>
                    </thead>
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
              url: '/lolo-pinoy-lechon-de-cebu/delete-stocks-inventory/' + id,
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