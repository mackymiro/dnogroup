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
            	 	
                     <p  style="margin-top:-50px; margin-left:145px;text-align:left;">
		 	 			 Dino Compound
                        Ground & 3rd Floors, Dino Group Administration Building,
                        No. 88 Labogon Road, Barangay Labogon, Mandaue City, <br>Cebu 6014
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
                     </u></h4>
	            </div>
				<div class="row">
					<div class="col-lg-12">
						 <div class="card-body">
				 			<div class="form-group">
                            <h1>Client Booking Form</h1>
                            <table style="border:1px solid black;">
								<thead>
									<tr>
										<th style="height: 1%; text-align: center;">CLIENT BOOKING #</th>
										<th style="height: 1%; text-align: center;">DATE OF EVENT</th>
                                        <th style="height: 1%; text-align: center;">TIME OF EVENT</th>
                                        <th style="height: 1%; text-align: center;">NO OF PEOPLE</th>
                                        <th style="height: 1%; text-align: center;">MOTIFF</th>
                                        <th style="height: 1%; text-align: center;">TYPE OF PACKAGE</th>
                                        <th style="height: 1%; text-align: center;">TOTAL AMOUNT</th>
                                        <th style="height: 1%; text-align: center;">CREATED BY</th>
									</tr>
								</thead>
								<tbody>
                                @foreach($getTransactionCBFs as $getTransactionCBF)
                                    <tr  style="border:1px solid black;">
                                        <td style="text-align:center; border: 1px solid black;">{{ $getTransactionCBF->module_code}}{{ $getTransactionCBF->wimpys_food_express_code }}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getTransactionCBF->date_of_event}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getTransactionCBF->time_of_event }}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getTransactionCBF->no_of_people}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getTransactionCBF->motiff}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getTransactionCBF->type_of_package}}</td>
                                        <td style="text-align:center; border: 1px solid black;"><?= number_format($getTransactionCBF->total, 2)?></td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getTransactionCBF->created_by }}</td>
                                    </tr>
                                @endforeach
								</tbody>	
						    </table>
                            <br>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="15%"  style="text-align:center; border: 1px solid black;">Total:</th>
                                        <th  style="text-align:center; border: 1px solid black;"><?= number_format($totalCBF, 2);?></th>
                                    </tr>
                                </thead>
                            </table>
                        
						 </div>
					</div>
				</div>
 		</div>
	 </div>
</div>


