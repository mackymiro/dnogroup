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
            	 <img style="margin-left: 5px;" src="{{ asset('images/digitized-logos/dno-food-venture-pdf.png')}}"   alt="DNO Food Ventures">
            	 	 <p  style="margin-top:-50px; margin-left:110px;text-align:left;">
		 	 			Dino Compound, 3rd Floor Dino Group Administration Bldg., No.88 Labogon Road, Barangay Labogon, Mandaue City, 6014 Cebu, Philippines<br>
						Tel. Nos. (63-32) 346-2567; 420-5639 / Fax No. (63-32) 346-0341<br>

						Email Address: admin@dnogroup.ph / sales@dnogroup.ph / marketing@dnogroup.ph
            	 	 </p>
					 @if($payableId[0]->method_of_payment === "CASH")
	            	 <h4 ><u>PAYMENT CASH VOUCHER</u></h4>
					 @else
					 <h4 ><u>PAYMENT CHECK VOUCHER</u></h4>
					 @endif
	            </div>
				<div class="row">
					<div class="col-lg-12">
						 <div class="card-body">
				 			<div class="form-group">
                              <div style="width:980px; margin:0 auto;">
                                   <div style="float:left; width:50%">
                                    <table >
                                          <thead>
                                            <tr>
                                                <th width="30%">Paid To</th>
                                                <th> {{ $payableId[0]->paid_to }}</th>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <th>{{ $payableId[0]->status }}</th>
                                            </tr>
                                            <tr>
                                                <th>Date</th>
                                                <th> {{ $payableId[0]->issued_date }} </th>
                                            </tr>
											<tr>
                                                <th width="30%">Account Name</th>
                                                <th> {{ $payableId[0]->account_name }} </th>
                                            </tr>
                                           
                                        </thead>
                                      
                                  </table>   
                             </div>
							
	                          <div style="float:right; width: 50%">
	                              <table >
	                                   <thead>
                                            <tr>
                                                <th width="20%">Amount Due</th>
                                                <th><?php echo number_format($payableId[0]->amount_due, 2);?></th>
                                            </tr>
                                            <tr>
                                                <th>Invoice #</th>
                                                <th> {{ $payableId[0]->invoice_number }}</th>
                                            </tr>
											<tr>
                                                <th>PV No</th>
                                                <th>{{ $payableId[0]->module_code}}{{ $payableId[0]->dno_food_venture_code }}</th>
                                            </tr>
											<tr>
												<th width="30%">Payment Method</th>
												<th>{{ $payableId[0]->method_of_payment}}</th>
											</tr>
                                           
                                        </thead>
	                              </table>
	                          </div>
                          </div>
                          </div>
                          <br>
                          <br>
                          <br>
						  <br>
						  <br>
						  <table style="border:1px solid black;">
								<thead>
									<tr>
										<th style="height: 1%; text-align: center;">DATE</th>
										<th style="height: 1%; text-align: center;">PARTICULARS</th>
										<th style="height: 1%; text-align: center;">AMOUNT</th>
									</tr>
								</thead>
								<tbody>
									<tr style="border: 1px solid black;">
										<td style="text-align:center; border: 1px solid black;">{{ $payableId[0]->issued_date}}</td>
										<td style="text-align:center; border: 1px solid black;">{{ $payableId[0]->particulars}}</td>
										<td style="text-align:center; border: 1px solid black; font-size:18px;"><?php echo number_format($payableId[0]->amount, 2); ?></td>
									</tr>
									@foreach($getParticulars as $getParticular)
									<tr style="border:1px solid black;">
										<td style="text-align:center; border: 1px solid black;">{{ $getParticular['date']}}</td>
										<td style="text-align:center; border: 1px solid black;">{{ $getParticular['particulars']}}</td>
										<td style="text-align:center; border: 1px solid black; font-size:18px;"><?php echo number_format($getParticular['amount'], 2); ?></td>
									</tr>
									@endforeach
								</tbody>	
						  </table>
                          <br>
                          <br>
                          <br>
                          <table style="border:1px solid black;">
                          		  <thead>
                                      <tr>
									  	@if($payableId[0]->method_of_payment === "CASH")
                                        <th style="height: 1%; text-align: center;">CASH NO ISSUED</th>
                                        <th style="height: 1%; text-align: center;">CASH AMOUNT</th>
										@else
										<th style="height: 1%; text-align: center;">CHECK NO ISSUED</th>
                                        <th style="height: 1%; text-align: center;">CHECK AMOUNT</th>
										@endif
                                      </tr>
                                    </thead>
                                  <tbody>
                                  	
                                  	 	 @foreach($payablesVouchers as $payablesVoucher)
                                        <tr style="border:1px solid black;">
                                          <td style="text-align:center; border: 1px solid black;">{{ $payablesVoucher['cheque_number'] }}</td>
                                         
                                          <td style="text-align:center; border: 1px solid black;"><?php echo number_format($payablesVoucher['cheque_amount'], 2);?></td>
                                        </tr> 
                                        @endforeach
                                      
	                                      
	                                       <tr style="border:1px solid black;">
	                                       
	                                        <td style=" text-align:center; border: 1px solid black;"><strong>Total</strong></td>
	                                        <td style=" text-align:center; border: 1px solid black;"> <?php echo number_format($sum, 2)?></td>
	                                      </tr>
                                  </tbody>
                          </table>
						  <br>
						  <table style="border:1px solid black;">
								<thead>
									<tr>
									
									<td style="height: 1%; text-align: center; border: 1px solid black; width:50%;">Bank Name/Branch:</td>
									<td style="height: 1%; text-align: center; border: 1px solid black; width:50%;">&nbsp;</td>
									
									</tr>
								</thead>
								<tbody>
                                
									
									 <tr style="border:1px solid black;">
									 
									  <td style=" text-align:center; border: 1px solid black;">Check No</td>
									  <td style=" text-align:center; border: 1px solid black;"> </td>
									</tr>
							</tbody>
                                
                          </table>
                           <div style="margin-top:50px;">
                           		<table  >
                           			<thead>
                           				<tr>
                       						<th style="width:30%;">Prepared By</th>
											<th>Checked By</th></th>
                       						<th>Approved By</th>
											<th>Date</th>
											
                           				</tr>
                           			</thead>
                           			<tbody>
                           				<tr>
                           					<td>
                           						________________________<br>
                           						{{ $payableId[0]->created_by}}

                           					</td>
                           					<td>
                           						________________________<br>
                           						Aprilane Q Maturan<br>
                           						Finance Officer
                           					</td>
											<td>
                           						________________________<br>
                           						
                           					</td>
											<td>
                           						________________________<br>
                           						
                           					</td>
                           					
                           				</tr>
                           			</tbody>
                           		</table>
                           	
                           </div>
						   <div style="margin-top:30px;">
                           		<table  >
                           			<thead>
                           				<tr>
                       						<th style="width:30%;">Received By</th>
										
                           				</tr>
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


