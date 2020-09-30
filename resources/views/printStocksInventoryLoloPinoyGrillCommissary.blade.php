<style type="text/css">
	table{
		border-collapse: collapse;
		width:100%;
		margin:0 auto;
	}
	table, td, th{
		font-size:12px;
	}
	
	p{
		text-align:center;
		font-size:10px;
	}


	h4{
		text-align:center;

	}

</style>
<div id="wrapper">
	 <div id="content-wrapper">
 		<div class="container-fluid">
 				<div  style="margin-top:-10px;">
                 <img style="margin-left: 5px;" src="{{ asset('images/digitized-logos/lolo-pinoy-grill-pdf.png' )}}" alt="Lolo Pinoy Grill"> 
            	 	 <p style="margin-top:-50px; margin-left:110px;text-align:left;">
		 	 			Dino Compound, 3rd Floor Dino Group Administration Bldg., No.88 Labogon Road, Barangay Labogon, Mandaue City, 6014 Cebu, Philippines<br>
						Tel. Nos. (63-32) 346-2567; 420-5639 / Fax No. (63-32) 346-0341<br>

						Email Address: admin@dnogroup.ph / sales@dnogroup.ph / marketing@dnogroup.ph
            	 	 </p>
	            	<h4><u>Stocks Inventory</u></h4>
	            </div>
				<div class="row">
					<div class="col-lg-12">
						 <div class="card-body">

						  <table style="border:1px solid black;">
								<thead>
									<tr>
										<th style="height: 1%; text-align: center;">PRODCUT ID </th>
										<th style="height: 1%; text-align: center;">PRODUCT NAME </th>
										<th style="height: 1%; text-align: center;">UNIT PRICE</th>
                                        <th style="height: 1%; text-align: center;">UNIT</th>
                                        <th style="height: 1%; text-align: center;">IN </th>
                                        <th style="height: 1%; text-align: center;">OUT</th>
                                        <th style="height: 1%; text-align: center;">STOCK OUT AMOUNT</th>
                                        <th style="height: 1%; text-align: center;">REMAINING STOCK</th>
                                        <th style="height: 1%; text-align: center;">AMOUNT</th>
                                        <th style="height: 1%; text-align: center;">SUPPLIER</th>
                                        <th style="height: 1%; text-align: center;">CREATED BY</th>
									</tr>
								</thead>
								<tbody>
									@foreach($getStockInventories as $getStockInventory)
									<tr style="border:1px solid black;">
										<td style="text-align:center; border: 1px solid black;">{{ $getStockInventory->product_id_no}}</td>
										<td style="text-align:center; border: 1px solid black;">{{ $getStockInventory->product_name}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getStockInventory->unit_price}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getStockInventory->unit}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getStockInventory->in}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getStockInventory->out}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getStockInventory->stock_amount}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getStockInventory->remaining_stock}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getStockInventory->amount}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getStockInventory->supplier}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getStockInventory->created_by}}</td>
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


