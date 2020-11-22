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
                 <img style="margin-left: 5px;" src="{{ asset('images/digitized-logos/dno-foundation.png')}}"  alt="DNO Holings & Co">
            	 	 	 <p  style="margin-top:-50px; margin-left:110px;text-align:left;">
						   Dino Compound
							Ground & 3rd Floors, Dino Group Administration Building,
							No. 88 Labogon Road, Barangay Labogon, Mandaue City, Cebu 6014
							Philippines<br>
						Tel. Nos. (63-32) 346-2567; 420-5639 / Fax No. (63-32) 346-0341<br>

						Email Address: admin@dnogroup.ph / sales@dnogroup.ph / marketing@dnogroup.ph
            	 	 </p>
	            	 <h4 ><u>BILLING STATEMENT</u></h4>
	            </div>
				<div class="row">
					<div class="col-lg-12">
						 <div class="card-body">
                              <div style="width:980px; margin:0 auto;">
                                   <div style="float:left; width:50%">
                                    <table style="border:1px solid black;">
                                          <thead>
                                            <tr style="border:1px solid black;">
                                                <th style="border:1px solid black" width="25%">Bill To:</th>
                                                <th style="border:1px solid black"> {{ $printBillingStatement[0]->bill_to }}</th>
                                            </tr>
                                            <tr style="border:1px solid black;">
                                                <th  style="border:1px solid black" width="15%">Address:</th>
                                                <th  style="border:1px solid black">{{ $printBillingStatement[0]->address }}</th>
                                            </tr>
                                            <tr style="border:1px solid black;">
                                                <th  style="border:1px solid black" width="15%">Period Covered:</th>
                                                <th  style="border:1px solid black"> {{ $printBillingStatement[0]->period_cover }} </th>
                                            </tr>
                                            <tr style="border:1px solid black;">
                                                <th style="border:1px solid black;" width="15%">Date:</th>
                                                <th style="border:1px solid black">{{ $printBillingStatement[0]->date }}</th>
                                            </tr>
                                        </thead>
                                      
                                  </table>   
                             </div>
	                          <div style="float:left; width:200px; margin-left:30px; border:1px solid black;">
	                              <table >
	                                   <thead>
                                            <tr >
                                                <th  width="35%">BS No:</th>
                                                <th >
													@foreach($printBillingStatement[0]->billing_statements as $statement)
														@if($statement->module_name === "Billing Statement")	
															{{ $statement->module_code}} {{ $statement->dno_holdings_code}}
														@endif
													@endforeach
												</th>
                                            </tr>
                                           
                                            <tr>
                                                <th>Terms:</th>
                                                <th>{{ $printBillingStatement[0]->terms }}</th>
                                            </tr>
                                        </thead>
	                              </table>
	                          </div>
                          </div>
                       
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <table style="border:1px solid black;">
                          		  <thead>
                                      <tr>
                                        <th style="height: 1%; text-align: center;">DATE</th>
									
                                        <th style="height: 1%; text-align: center;">DR #</th>
									
                                        <th style="height: 1%; text-align: center;">ITEM DESCRIPTION</th>
                                        <th style="height: 1%; text-align: center;">UNIT PRICE</th>
                                        <th style="height: 1%; text-align: center;">AMOUNT</th>
                                      </tr>
                                    </thead>
                                  <tbody>
                                  		<tr style="border:1px solid black;">
                                      <td style="text-align:center; border: 1px solid black;">{{ $printBillingStatement[0]->date_of_transaction }}</td>
                                      <td style="text-align:center; border: 1px solid black;">{{ $printBillingStatement[0]->dr_no }}</td>
									  <td style="text-align:center; border: 1px solid black;">{{ $printBillingStatement[0]->description }}</td>
                                      <td style="text-align:center; border: 1px solid black;">{{ $printBillingStatement[0]->unit_price }}</td>
                                      <td style="text-align:center; border: 1px solid black;"><?= number_format($printBillingStatement[0]->amount, 2); ?></td>
                                  	 	</tr>
                                  	 	 @foreach($billingStatements as $billingStatement)
                                        <tr style="border:1px solid black;">
                                          <td style="text-align:center; border: 1px solid black;">{{ $billingStatement['date_of_transaction'] }}</td>
                                          <td style="text-align:center; border: 1px solid black;">{{ $billingStatement['dr_no'] }}</td>
										  <td style="text-align:center; border: 1px solid black;">{{ $billingStatement['description'] }}</td>
                                          <td style="text-align:center; border: 1px solid black;">{{ $billingStatement['unit_price'] }}</td>
                                          <td style="text-align:center; border: 1px solid black;"><?= number_format($billingStatement['amount'], 2);?></td>
                                        </tr> 
                                        @endforeach
                                      
	                                      
	                                       <tr style="border:1px solid black;">
	                                        <td style=" border: 1px solid black;"></td>
	                                        <td style=" border: 1px solid black;"></td>
                                          	<td style=" border: 1px solid black;"></td>
	                                        <td style=" border: 1px solid black;"><strong>Total</strong></td>
	                                        <td style=" text-align:center; border: 1px solid black;"> <?= number_format($sum, 2)?></td>
	                                      </tr>
                                  </tbody>
                          </table>
                           <div style="margin-top:100px;">
                           		<table  >
                           			<thead>
                           				<tr>
                       						<th style="width:30%;">Prepared By</th>
                       						<th>Checked By</th>
											<th>Conforme By</th>
                           				</tr>
                           			</thead>
                           			<tbody>
                           				<tr>
                           					<td>
                           						________________________<br>
                           						{{ $printBillingStatement[0]->created_by}}

                           					</td>
                           					<td>
                           						________________________<br>
                           						Aprilane Q Maturan<br>
                           						Finance Officer
                           					</td>
											<td>
                           						________________________<br>
                           						
                           					</td>

                           					
                           				</tr>
                           			</tbody>
                           		</table>
								<table style="margin-top:50px;" >
									<thead>
                           				<tr>
                       						<th style="width:30%;">Received By</th>
                       						
                           			</thead>
									<tbody>  
										<tr>
                           					<td>
                           						________________________<br>
                           					</td>
										</tr>
									</tbody>
								</table>
                           </div>

						 </div>
					</div>
				</div>
 		</div>
	 </div>
</div>


