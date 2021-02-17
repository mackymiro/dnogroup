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
 				<div   style="margin-top:-10px;">
                 <img style="margin-left:5px;" src="{{ asset('images/digitized-logos/wimpys-logo1.png')}}"  alt="Wimpy's Food Express">
            	 	
                     <p  style="margin-top:-50px; margin-left:140px;text-align:left;">
		 	 			Dino Compound, 3rd Floor Dino Group Administration Bldg., No.88 Labogon Road, Barangay Labogon, Mandaue City, 6014 Cebu, Philippines<br>
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
                     </u></h4>
	            </div>
				<div class="row">
					<div class="col-lg-12">
						 <div class="card-body">
				 			<div class="form-group">
                            <h1>Delivery Receipt</h1>
                            <table style="border:1px solid black;">
								<thead>
									<tr>
										<th style="height: 1%; text-align: center;">DATE</th>
										<th style="height: 1%; text-align: center;">DR NO</th>
                                        <th style="height: 1%; text-align: center;">SOLD TO</th>
                                        <th style="height: 1%; text-align: center;">TIME</th>
                                        <th style="height: 1%; text-align: center;">PRODUCT ID</th>
                                        <th style="height: 1%; text-align: center;">DATE TO BE DELIVERED</th>
                                        <th style="height: 1%; text-align: center;">QTY</th>
                                        <th style="height: 1%; text-align: center;">DESCRIPTION</th>
                                        <th style="height: 1%; text-align: center;">PRICE</th>
                                        <th style="height: 1%; text-align: center;">CREATED BY</th>
									</tr>
								</thead>
								<tbody>
                                @foreach($getDeliveryReceipts as $getDeliveryReceipt)
                                    <tr  style="border:1px solid black;">
                                        <td style="text-align:center; border: 1px solid black;">{{ $getDeliveryReceipt->date}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getDeliveryReceipt->module_code}}{{ $getDeliveryReceipt->wimpys_food_express_code}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getDeliveryReceipt->sold_to }}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getDeliveryReceipt->time}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getDeliveryReceipt->product_id}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getDeliveryReceipt->date_to_be_delivered}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getDeliveryReceipt->qty}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getDeliveryReceipt->description}}</td>
                                        <td style="text-align:center; border: 1px solid black;"><?= number_format($getDeliveryReceipt->total, 2)?></td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getDeliveryReceipt->created_by }}</td>
                                    </tr>
                                @endforeach
								</tbody>	
						    </table>
                            <br>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="15%"  style="text-align:center; border: 1px solid black;">Total:</th>
                                        <th  style="text-align:center; border: 1px solid black;"><?= number_format($totalDR, 2);?></th>
                                    </tr>
                                </thead>
                            </table>
                        
						 </div>
					</div>
				</div>
 		</div>
	 </div>
</div>


