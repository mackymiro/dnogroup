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
			 	 	 	 <p  style="margin-top:-50px; margin-left:150px;text-align:left;">
		 	 			Dino Compound, 3rd Floor Dino Group Administration Bldg., No.88 Labogon Road, Barangay Labogon, Mandaue City, 6014 Cebu, Philippines<br>
						Tel. Nos. (63-32) 346-2567; 420-5639 / Fax No. (63-32) 346-0341<br>

						Email Address: admin@dnogroup.ph / sales@dnogroup.ph / marketing@dnogroup.ph
            	 	 </p>
	            	 <h4 ><u>BRANCH {{ $data }}</u></h4>
	            </div>
				<div class="row">
					<div class="col-lg-12">
						 <div class="card-body">
                           <h1>
                            @if($uri0 != "" || $uri1 != "")
                                Date: {{ $uri0 }} To {{ $uri1 }}
                            @else   
                                @if($uri != "")
                                Date: 
                                {{ $uri }}
                                @endif
                            @endif
                           
                           </h1>
                          <table style="margin-top:30px;border:1px solid black;">
                          		  <thead>
                                      <tr>
                                        <th style="height: 1%; text-align: center;">DATE</th>
                                        <th style="height: 1%; text-align: center;">PRODUCT NAME</th>
                                        <th style="height: 1%; text-align: center;">PRICE</th>
										<th style="height: 1%; text-align: center;">OPENING STOCK</th>
                                        <th style="height: 1%; text-align: center;">IN</th>
                                        <th style="height: 1%; text-align: center;">OUT</th>
                                        <th style="height: 1%; text-align: center;">SOLD</th>
                                        <th style="height: 1%; text-align: center;">REMAINING STOCK</th>
                                        <th style="height: 1%; text-align: center;">AMOUNT</th>
                                        <th style="height: 1%; text-align: center;">FLAG</th>
                                      </tr>
                                    </thead>
                                  <tbody>
                                  	
                                  	 	 @foreach($getStockInventories as $getStockInventory)
                                        <tr style="border:1px solid black;">
                                          <td style="text-align:center; border: 1px solid black;">{{ $getStockInventory->date }}</td>
                                          <td style="text-align:center; border: 1px solid black;">{{ $getStockInventory->product_name }}</td>
										  <td style="text-align:center; border: 1px solid black;"><?= number_format($getStockInventory->price, 2)?></td>
										  <td style="text-align:center; border: 1px solid black;"><?= number_format($getStockInventory->opening_stock, 2)?></td>
										  <td style="text-align:center; border: 1px solid black;"><?= number_format($getStockInventory->product_in, 2)?></td>
                                          <td style="text-align:center; border: 1px solid black;"><?= number_format($getStockInventory->product_out, 2)?></td>
                                        
                                          <td style="text-align:center; border: 1px solid black;"><?= number_format($getStockInventory->sold, 2);?></td>
                                         <td style="text-align:center; border: 1px solid black;"><?= number_format($getStockInventory->remaining_stock, 2);?></td>
                                         <td style="text-align:center; border: 1px solid black;"><?= number_format($getStockInventory->amount, 2);?></td>
                                         <td style="text-align:center; border: 1px solid black;">{{ $getStockInventory->flag }}</td>
                                        </tr> 
                                        @endforeach
                                      
	                                
                                  </tbody>
                          </table>
						  <br>
						  <br>
						  <table style="border:1px solid black">
								<thead>
									<tr>
										<td style="height: 1%; text-align: center; border: 1px solid black; width:50%;"><strong>Total Amount</strong></td>
										<td style="height: 1%; text-align: center; border: 1px solid black; width:50%; font-size:18px;">
										 <?= number_format($totalAmount, 2)?>
										</td>
									</tr>   
								</thead>
							</table>
						 </div>
					</div>
				</div>
 		</div>
	 </div>
</div>


