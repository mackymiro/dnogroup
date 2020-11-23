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
		 	 		    Dino Compound
                        Ground & 3rd Floors, Dino Group Administration Building,
                        No. 88 Labogon Road, Barangay Labogon, Mandaue City, Cebu 6014
                        Philippines<br>
						Tel. Nos. (63-32) 346-2567; 420-5639 / Fax No. (63-32) 346-0341<br>

						Email Address: admin@dnogroup.ph / sales@dnogroup.ph / marketing@dnogroup.ph
            	 	 </p>
	            	 <h4 ><u>SUMMARY REPORT FOR 
                     <?php if($uri0 != "" || $uri1 != ""): ?>
                        {{ $uri0 }} To {{ $uri1 }}
                     <?php else: ?>
                        <?php if($getDateToday): ?>
                                {{ $getDateToday}}
                        <?php elseif($date != ""):?>
                            {{ $date}}
                        <?php endif; ?>
                    <?php endif; ?>
                     </u><br>Lolo Pinoy Grill Commissary</h4>
	            </div>
				<div class="row">
					<div class="col-lg-12">
						 <div class="card-body">
				 			<div class="form-group">
                        <h1>Delivery Receipt</h1>
                        <table style="border:1px solid black;">
								<thead>
									<tr>
										<th style="height: 1%; text-align: center;">DR NO</th>
										<th style="height: 1%; text-align: center;">DATE</th>
                                        <th style="height: 1%; text-align: center;">DELIVERED TO</th>
                                        <th style="height: 1%; text-align: center;">ADDRESS</th>
                                        <th style="height: 1%; text-align: center;">PRODUCT ID</th>
                                        <th style="height: 1%; text-align: center;">QTY</th>
                                        <th style="height: 1%; text-align: center;">UNIT</th>
                                        <th style="height: 1%; text-align: center;">ITEM DESCRIPTION</th>
                                        <th style="height: 1%; text-align: center;">UNIT PRICE</th>
                                        <th style="height: 1%; text-align: center;">AMOUNT</th>
                                        <th style="height: 1%; text-align: center;">CREATED BY</th>
									</tr>
								</thead>
								<tbody>
									 @foreach($getAllDeliveryReceipts as $getAllDeliveryReceipt)
									<tr style="border:1px solid black;">
										<td style="text-align:center; border: 1px solid black;">{{ $getAllDeliveryReceipt->module_code}}{{ $getAllDeliveryReceipt->lolo_pinoy_grill_code}}</td>
										<td style="text-align:center; border: 1px solid black;">{{ $getAllDeliveryReceipt->date}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getAllDeliveryReceipt->delivered_to}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getAllDeliveryReceipt->address}}</td>
                                        <td style="text-align:center; border: 1px solid black;">
                                            <?php
                                                    $prodArr = $getAllDeliveryReceipt->product_id;
                                                    $prodExp = explode("-", $prodArr);
                                                    
                                                ?>
                                                {{ $prodExp[1] }}
                                        </td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getAllDeliveryReceipt->qty}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getAllDeliveryReceipt->unit}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getAllDeliveryReceipt->item_description}}</td>
                                        <td style="text-align:center; border: 1px solid black;"><?= number_format($getAllDeliveryReceipt->unit_price, 2);?></td>
                                       
                                        <td style="text-align:center; border: 1px solid black;"><?= number_format($getAllDeliveryReceipt->total_amount, 2);?></td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getAllDeliveryReceipt->created_by }}</td>
									</tr>
									@endforeach
								</tbody>	
						    </table>
                            <br>
                            <table class="table table-bordered">
                                <thead>
                                    <tr  style="border:1px solid black;">
                                        <th width="15%" style="text-align:center; border: 1px solid black;">Total:</th>
                                        <th  style="text-align:center; border: 1px solid black;"><?= number_format($totalDeliveryReceipt, 2);?></th>
                                    </tr>
                                </thead>
                            </table>
                    

						 </div>
					</div>
				</div>
 		</div>
	 </div>
</div>


