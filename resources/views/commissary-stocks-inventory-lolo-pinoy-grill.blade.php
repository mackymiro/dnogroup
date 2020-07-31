@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'Stocks Inventory |')
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
    					  		<div class="table-responsive">
    					  			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    					  				<thead>
										  	<tr>
												<th>Product Id No</th>
												<th>Product Name</th>
												<th>Unit Price</th>
												<th>Unit</th>
												<th class="bg-danger" style="color:white;">IN</th>
												<th>OUT</th>
												<th>Stock Out Amount</th>
												<th>Remaining Stock</th>
												<th>Amount</th>
												<th>Supplier</th>
												<th>Created By</th>
											</tr>
			  						   </thead>
			  							<tfoot>
			  								<tr>
												<th>Product Id No</th>
												<th>Product Name</th>
												<th>Unit Price</th>
												<th>Unit</th>
												<th class="bg-danger" style="color:white;">IN</th>
												<th>OUT</th>
												<th>Stock Out Amount</th>
												<th>Remaining Stock</th>
												<th>Amount</th>
												<th>Supplier</th>
												<th>Created By</th>
											</tr>
			  							</tfoot>
			  							<tbody>
											@foreach($getRawMaterials as $getRawMaterial)
											<tr >
																	
												<td>{{ $getRawMaterial->product_id_no }}</td>
												<td><a href="{{ url('lolo-pinoy-grill-commissary/view-stock-inventory/'.$getRawMaterial->id)}}">{{ $getRawMaterial->product_name }}</a></td>
												<td>{{ $getRawMaterial->unit_price }}</td>
												<td>{{ $getRawMaterial->unit }}</td>
												<td class="bg-danger" style="color:white;">{{ $getRawMaterial->in }}</td>
												<td>{{ $getRawMaterial->out }}</td>
												<td>{{ $getRawMaterial->stock_amount}}</td>
												<td>{{ $getRawMaterial->remaining_stock}}</td>
												<td><?php echo number_format($getRawMaterial->amount, 2);?></td>
												<td>{{ $getRawMaterial->supplier}}</td>
												<td>{{ $getRawMaterial->created_by }}</td>
												
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