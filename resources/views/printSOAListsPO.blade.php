<style type="text/css">
	table{
		border-collapse: collapse;
		width:100%;
		margin:0 auto;
		table-layout: fixed;
	}
	table, td, th{
		font-size:10px;
		padding:10px;
		max-width: 200px;
		max-height: 150px;
		overflow: hidden;
		text-align:left;
		
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
				 <img style="margin-left: 5px;" src="{{ asset('images/digitized-logos/lolo-pinoy-lechon-de-cebu-pdf-small.png')}}"   alt="Lechon de Cebu">
            	 	 <p style="margin-top:-50px; margin-left:110px;text-align:left;">
					  	Dino Compound
						Ground & 3rd Floors, Dino Group Administration Building,
						No. 88 Labogon Road, Barangay Labogon, Mandaue City, Cebu 6014
						Philippines<br>
						Tel. Nos. (63-32) 346-2567; 420-5639 / Fax No. (63-32) 346-0341<br>

						Email Address: admin@dnogroup.ph / sales@dnogroup.ph / marketing@dnogroup.ph
            	 	 </p>
	            	 <h4 ><u>STATEMENT OF ACCOUNT</u><br> Private Orders</h4>
	            </div>
				<div class="row">
					<div class="col-lg-12">
						 <div class="card-body">
				 			
                          <table style="margin-top:30px;border:1px solid black; width:100%; ">
                          		  <thead>
                                      <tr>
                                       	<th style="height: 1%; text-align: center; border: 1px solid black;">REF DR NO</th>
                                        <th style="height: 1%; text-align: center; border: 1px solid black;">SOA NO</th>
                                        <th style="height: 1%; text-align: center; border: 1px solid black;">BILL TO</th>
										<th style="height: 1%; text-align: center; border: 1px solid black;">BS NO</th>
										<th style="height: 1%; text-align: center;border: 1px solid black;">DR ADDRESS</th>
										<th style="height: 1%; text-align: center;border: 1px solid black;">DR DELIVERED FOR</th>
										<th style="height: 1%; text-align: center;border: 1px solid black;">QTY</th>
                                        <th style="height: 1%; text-align: center;border: 1px solid black;">PERIOD COVERED</th>
                                        <th style="height: 1%; text-align: center;border: 1px solid black;">STATUS</th>
                                        <th style="height: 1%; text-align: center;border: 1px solid black;">TOTAL AMOUNT</th>
                                        <th style="height: 1%; text-align: center;border: 1px solid black;">TOTAL BALANCE REMAINING</th>
                                        
                                      </tr>
                                    </thead>
                                  <tbody>
                                  	
                                  	 	 @foreach($printSOAStatements as $printSOAStatement)
										<?php $id = $printSOAStatement->id;  ?>
										<?php
											$getRefDrNos =  DB::table('lechon_de_cebu_statement_of_accounts')
														->select('*')
														->where('billing_statement_id', $id)
														->where('qty', '!=', '.')
														->get()->toArray();
											
											$getDeliveredFors =  DB::table('lechon_de_cebu_statement_of_accounts')
														->select('*')
														->where('billing_statement_id', $id)
														->where('qty', '!=', '.')
														->get()->toArray();	

											$getQty =  DB::table('lechon_de_cebu_statement_of_accounts')
														->select('*')
														->where('billing_statement_id', $id)
														->sum('lechon_de_cebu_statement_of_accounts.qty');

                                      
                                      ?>
                                        <tr style="border:1px solid black;">
                                         
										  <td style="text-align:center; border: 1px solid black;">
										  		{{ $printSOAStatement->dr_no }},
												<?php foreach($getRefDrNos as $getRefDrNo): ?>
													<?= $getRefDrNo->dr_no;?>, 
                                              	<?php endforeach; ?>
												  
										</td>
                                          <td style="text-align:center; border: 1px solid black;">{{ $printSOAStatement->lechon_de_cebu_code }}</td>
										  <td style="text-align:center; border: 1px solid black;">{{ $printSOAStatement->bill_to }}</td>
										  <td style="text-align:center; border: 1px solid black;">{{ $printSOAStatement->bs_no }}</td>
										
										  <td style="text-align:center; border: 1px solid black;">{{ $printSOAStatement->dr_address }}</td>
										  <td style="text-align:center; border: 1px solid black;">
										  
										  	{{ $printSOAStatement->dr_delivered_for }},
											<?php foreach($getDeliveredFors as $getDeliveredFor): ?>
                                                    <?= $getDeliveredFor->dr_delivered_for;?>, 
                                              <?php endforeach; ?>
										  </td>
										  <td style="text-align:center; border: 1px solid black;">
											<p>
                                             
                                              <?php $totl = $printSOAStatement->qty + $getQty;?>
                                              <?= $totl; ?>
                                              </p>
                                            
										  </td>
										  <td style="text-align:center; border: 1px solid black;">{{ $printSOAStatement->period_cover }}</td>
                                          <td style="text-align:center; border: 1px solid black;">
										 	 @if($printSOAStatement->total_remaining_balance == 0.00)
												PAID
											@endif
										  </td>
                                          <td style="text-align:center; border: 1px solid black;"><?= number_format($printSOAStatement->total_amount, 2);?></td>
                                         <td style="text-align:center; border: 1px solid black;"><?= number_format($printSOAStatement->total_remaining_balance, 2);?></td>
                                         
                                        </tr> 
                                        @endforeach
                                      
	                                
                                  </tbody>
                          </table>
						  <br>
						  <br>
						  <table style="border:1px solid black">
								<thead>
									<tr>
										<td style="height: 1%; text-align: center; border: 1px solid black; width:50%;"><strong>Total Balance</strong></td>
										<td style="height: 1%; text-align: center; border: 1px solid black; width:50%; font-size:18px;">
										 <?= number_format($totalBalance, 2)?>
										</td>
									</tr>
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


