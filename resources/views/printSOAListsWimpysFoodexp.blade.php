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
                 <img style="margin-left:5px;" src="{{ asset('images/digitized-logos/wimpys-logo1.png')}}"  alt="Wimpy's Food Express">
            	 	 	 	 <p  style="margin-top:-50px; margin-left:150px;text-align:left;">
		 	 			Dino Compound, 3rd Floor Dino Group Administration Bldg., No.88 Labogon Road, Barangay Labogon, Mandaue City, 6014 Cebu, Philippines<br>
						Tel. Nos. (63-32) 346-2567; 420-5639 / Fax No. (63-32) 346-0341<br>

						Email Address: admin@dnogroup.ph / sales@dnogroup.ph / marketing@dnogroup.ph
            	 	 </p>
	            	 <h4 ><u>STATEMENT OF ACCOUNT</u></h4>
	            </div>
				<div class="row">
					<div class="col-lg-12">
						 <div class="card-body">
				 			
                          <table style="margin-top:30px;border:1px solid black;">
                          		  <thead>
                                      <tr>
                                        <th style="height: 1%; text-align: center;">DATE</th>
                                        <th style="height: 1%; text-align: center;">SOA NO</th>
                                        <th style="height: 1%; text-align: center;">BILL TO</th>
										<th style="height: 1%; text-align: center;">BS NO</th>
                                        <th style="height: 1%; text-align: center;">PERIOD COVERED</th>
                                        <th style="height: 1%; text-align: center;">STATUS</th>
                                        <th style="height: 1%; text-align: center;">TOTAL AMOUNT</th>
                                        <th style="height: 1%; text-align: center;">TOTAL BALANCE REMAINING</th>
                                        <th style="height: 1%; text-align: center;">CREATED BY</th>
                                      </tr>
                                    </thead>
                                  <tbody>
                                  	
                                  	 	 @foreach($printSOAStatements as $printSOAStatement)
                                        <tr style="border:1px solid black;">
                                          <td style="text-align:center; border: 1px solid black;">{{ $printSOAStatement->date }}</td>
                                          <td style="text-align:center; border: 1px solid black;">
                                                @foreach($printSOAStatement->statement_of_accounts as $account )
                                                    @if($account->module_name == "Statement Of Account")
                                                        {{ $account->wimpys_food_express_code }}
                                                    @endif
                                                @endforeach
                                          </td>
										  <td style="text-align:center; border: 1px solid black;">{{ $printSOAStatement->bill_to }}</td>
										  <td style="text-align:center; border: 1px solid black;">{{ $printSOAStatement->bs_no }}</td>
										  <td style="text-align:center; border: 1px solid black;">{{ $printSOAStatement->period_cover }}</td>
                                          <td style="text-align:center; border: 1px solid black;">
										 	 @if($printSOAStatement->total_remaining_balance == 0.00)
												PAID
											@endif
										  </td>
                                          <td style="text-align:center; border: 1px solid black;"><?= number_format($printSOAStatement->total_amount, 2);?></td>
                                         <td style="text-align:center; border: 1px solid black;"><?= number_format($printSOAStatement->total_remaining_balance, 2);?></td>
                                         <td style="text-align:center; border: 1px solid black;">{{ $printSOAStatement->created_by }}</td>
                                        </tr> 
                                        @endforeach
                                      
	                                
                                  </tbody>
                          </table>
						  <br>
						  <br>
						  <table style="border:1px solid black">
								<thead>
									<tr>
										<td style="height: 1%; text-align: center; border: 1px solid black; width:50%;"><strong>Total Paid Amount</strong></td>
										<td style="height: 1%; text-align: center; border: 1px solid black; width:50%; font-size:18px;">
										 <?= number_format($totalAmount, 2)?>
										</td>
									</tr>
									<tr>
										<td style="height: 1%; text-align: center; border: 1px solid black; width:50%;"><strong>Total Unpaid Amount</strong></td>
										<td style="height: 1%; text-align: center; border: 1px solid black; width:50%; font-size:18px;">
											<?= number_format($totalRemainingBalance, 2);?>
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


