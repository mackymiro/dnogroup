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
										
										<th style="height: 1%; text-align: center;">REF DR No</th>
                                        <th style="height: 1%; text-align: center;">SOA NO</th>
                                        <th style="height: 1%; text-align: center;">BS NO</th>
                                        <th style="height: 1%; text-align: center;">BILL TO</th>
										<th style="height: 1%; text-align: center;">DR ADDRESS</th>
										<th style="height: 1%; text-align: center;">DR DELIVERED FOR</th>
										<th style="height: 1%; text-align: center;">QTY</th>
                                        
                                        <th style="height: 1%; text-align: center;">STATUS</th>
                                        <th style="height: 1%; text-align: center;">PERIOD COVERED</th>
                                        <th style="height: 1%; text-align: center;">TOTAL AMOUNT</th>
                                        <th style="height: 1%; text-align: center;">TOTAL REMAINING BALANCE</th>
										<th style="height: 1%; text-align: center;">REMARKS</th>
									</tr>
								</thead>
								<tbody>
                                @foreach($statementOfAccounts as $statementOfAccount)
									<?php $id = $statementOfAccount->id;  ?>
									<?php
											$getRefDrNos =  DB::table('lechon_de_cebu_statement_of_accounts')
															->select('lechon_de_cebu_statement_of_accounts.dr_no')
															->where('billing_statement_id', $id)
															->where('qty', '!=', '.')
															->groupBy('lechon_de_cebu_statement_of_accounts.dr_no')
															->get();

											$getDeliveredFors =  DB::table('lechon_de_cebu_statement_of_accounts')
															->select('lechon_de_cebu_statement_of_accounts.dr_delivered_for')
															->where('billing_statement_id', $id)
															->where('qty', '!=', '.')
															->groupBy('dr_delivered_for')
														->get()->toArray();

											$getQty =  DB::table('lechon_de_cebu_statement_of_accounts')
														->select('*')
														->where('billing_statement_id', $id)
														->sum('lechon_de_cebu_statement_of_accounts.qty');

								  
                                      ?>
									<tr style="border:1px solid black;">
                                    
										<td style="text-align:center; border: 1px solid black;">
											{{ $statementOfAccount->dr_no}}, 
											<?php foreach($getRefDrNos as $getRefDrNo): ?>
													<?= $getRefDrNo->dr_no;?>, 
                                              	<?php endforeach; ?>
										</td>
										<td style="text-align:center; border: 1px solid black;">{{ $statementOfAccount->module_code}}{{ $statementOfAccount->lechon_de_cebu_code}}</td>
										<td style="text-align:center; border: 1px solid black;">{{ $statementOfAccount->bs_no}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $statementOfAccount->bill_to}}</td>
										<td style="text-align:center; border: 1px solid black;">{{ $statementOfAccount->dr_address}}</td>
										<td style="text-align:center; border: 1px solid black;">
											{{ $statementOfAccount->dr_delivered_for}}
											<?php foreach($getDeliveredFors as $getDeliveredFor): ?>
                                                    <?= $getDeliveredFor->dr_delivered_for;?>, 
                                              <?php endforeach; ?>
										</td>
										<td style="text-align:center; border: 1px solid black;">
												<p>
                                             
                                              <?php $totl = $statementOfAccount->qty + $getQty;?>
                                              <?= $totl; ?>
                                              </p>
                                            
										  </td>
                                        
                                        <td style="text-align:center; border: 1px solid black;">{{ $statementOfAccount->status}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $statementOfAccount->period_cover}}</td>
                                        <td style="text-align:center; border: 1px solid black;"><?= number_format($statementOfAccount->total_amount, 2);?></td>
                                        
                                        <td style="text-align:center; border: 1px solid black;"><?= number_format($statementOfAccount->total_remaining_balance, 2);?></td>
										<td style="text-align:center; border: 1px solid black;"></td>
                      
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


