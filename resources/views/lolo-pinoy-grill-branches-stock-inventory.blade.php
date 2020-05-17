@extends('layouts.lolo-pinoy-grill-branches-app')
@section('title', 'Stock Inventory |')
@section('content')
<div id="wrapper">
     @include('sidebar.sidebar-lolo-pinoy-grill-branches')
     <div id="content-wrapper">
        <div class="container-fluid">
             <!-- Breadcrumbs-->
             <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">Lolo Pinoy Grill Branches</a>
                </li>
                <li class="breadcrumb-item ">Store Stock</li>
                <li class="breadcrumb-item active">Stock Inventory</li>
              </ol>
              <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
          					  <i class="fa fa-tasks" aria-hidden="true"></i>
          					  All Lists
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
	  				  						
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
			  						   </thead>
                                         <tfoot>
				  							
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
										</tfoot>
                                        <tbody>
                                            @foreach($getCommissaryRawMaterials as $getCommissaryRawMaterial)
                                            <tr>
                                                <td>{{ $getCommissaryRawMaterial['product_id_no']}}</td>
                                                <td><p style="width: 180px;"><a href="{{ url('lolo-pinoy-grill-branches/store-stock/view-stock-inventory/'.$getCommissaryRawMaterial['id']) }}"> {{ $getCommissaryRawMaterial['product_name']}}</a></p></td>
                                                <td>{{ $getCommissaryRawMaterial['unit_price']}}</td>
                                                <td>{{ $getCommissaryRawMaterial['unit']}}</td>
                                                <td>{{ $getCommissaryRawMaterial['in']}}</td>
                                                <td>{{ $getCommissaryRawMaterial['out']}}</td>
                                                <td><?php echo number_format($getCommissaryRawMaterial['stock_amount'], 2); ?></td>
                                                <td>{{ $getCommissaryRawMaterial['remaining_stock']}}</td>
                                                <td><?php echo number_format($getCommissaryRawMaterial['amount'], 2);?></td>
                                                <td><p style="width:180px;">{{ $getCommissaryRawMaterial['supplier']}}</p></td>
                                                <td><p style="width: 100px;">{{ $getCommissaryRawMaterial['created_by'] }}</p></td>
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