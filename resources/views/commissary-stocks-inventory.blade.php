@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Stocks Inventory |')
@section('content')
<div id="wrapper">
	 @include('sidebar.sidebar')
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