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
                            <h1>Statement Of Account</h1>
                            <table style="border:1px solid black;">
								<thead>
									<tr>
										<th style="height: 1%; text-align: center;">DATE</th>
										<th style="height: 1%; text-align: center;">SOA NO</th>
                                        <th style="height: 1%; text-align: center;">ORDER</th>
                                        <th style="height: 1%; text-align: center;">BILL TO</th>
                                        <th style="height: 1%; text-align: center;">BS NO</th>
                                        <th style="height: 1%; text-align: center;">PERIOD COVER</th>
                                        <th style="height: 1%; text-align: center;">STATUS</th>
                                        <th style="height: 1%; text-align: center;">TOTAL AMOUNT</th>
                                        <th style="height: 1%; text-align: center;">TOTAL REMAINING BALANCE</th>
                                        <th style="height: 1%; text-align: center;">CREATED BY</th>
									</tr>
								</thead>
								<tbody>
                                @foreach($getStatementOfAccounts as $getStatementOfAccount)
                                    <tr  style="border:1px solid black;">
                                        <td style="text-align:center; border: 1px solid black;">{{ $getStatementOfAccount->date }}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getStatementOfAccount->module_code}}{{ $getStatementOfAccount->wimpys_food_express_code}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getStatementOfAccount->order }}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getStatementOfAccount->bill_to}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getStatementOfAccount->bs_no}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getStatementOfAccount->period_cover}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getStatementOfAccount->status}}</td>
                                        <td style="text-align:center; border: 1px solid black;"><?= number_format($getStatementOfAccount->total_amount, 2)?></td>
                                        <td style="text-align:center; border: 1px solid black;"><?= number_format($getStatementOfAccount->total_remaining_balance, 2)?></td>
                     
                                        <td style="text-align:center; border: 1px solid black;">{{ $getStatementOfAccount->created_by }}</td>
                                    </tr>
                                @endforeach
								</tbody>	
						    </table>
                            <br>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="15%"  style="text-align:center; border: 1px solid black;">Total:</th>
                                        <th  style="text-align:center; border: 1px solid black;"><?php //number_format($totalAmountCashes, 2);?></th>
                                    </tr>
                                </thead>
                            </table>
                        
						 </div>
					</div>
				</div>
 		</div>
	 </div>
</div>


