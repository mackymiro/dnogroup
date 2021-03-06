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
          					  All Lists
                        <div class="float-right">
                          <a  href="{{ action('LoloPinoyLechonDeCebuController@printStocksInventory') }}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                        </div>
                      </div>
    					    <div class="card-body">
                    <br>
                    <br>
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
                      @foreach($getRawMaterials as $getRawMaterial)
			  							<tr >
		  									
                        <td>{{ $getRawMaterial->product_id_no }}</td>
                        <td><a href="{{ url('lolo-pinoy-lechon-de-cebu/view-stock-inventory/'.$getRawMaterial->id)}}">{{ $getRawMaterial->product_name }}</a></td>
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
                    <br>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="15%" class="bg-info" style="color:white;">Total Product Cost</th>
                                 <th class="bg-success" style="color:white;">
                                    ₱ <?php echo number_format($countTotalAmount, 2);?>
                                 </th>
                            </tr>
                        </thead>
                    </table>
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