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
 				<div  style="margin-top:60px;">
            	 <img style="margin-left: 240px;" src="{{ asset('images/dong-fang-corporation.png')}}"  alt="Dong Fang Corporaton">
            	 	 <p >
		 	 			Dino Compound, 3rd Floor Dino Group Administration Bldg., No.88 Labogon Road, Barangay Labogon, Mandaue City, 6014 Cebu, Philippines<br>
						Tel. Nos. (63-32) 346-2567; 420-5639 / Fax No. (63-32) 346-0341<br>

						Email Address: admin@dnogroup.ph / sales@dnogroup.ph / marketing@dnogroup.ph
            	 	 </p>
	            	 <h4 ><u>PAYMENT VOUCHER</u></h4>
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
                                                <th> {{ $payableId['paid_to'] }}</th>
                                            </tr>
											@if($payableId['method_of_payment']  == "Cheque")
											<tr>
                                                <th width="30%">Account No</th>
                                                <th> {{ $payableId['account_no'] }}</th>
                                            </tr>
											@endif
											@if($payableId['method_of_payment'] == "Cash")
											<tr>
                                                <th width="30%">Account Name</th>
                                                <th> {{ $payableId['account_name'] }}</th>
                                            </tr>
											@endif 
											
											<tr>
                                                <th>Voucher Ref No</th>
                                                <th> DP-{{ $payableId['voucher_ref_number'] }} </th>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <th>{{ $payableId['status'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>Date</th>
                                                <th> {{ $payableId['issued_date'] }} </th>
                                            </tr>                           
                                        </thead>
                                      
                                  </table>   
                             </div>
							 
	                          <div style="float:right; width: 50%">
	                              <table >
	                                   <thead>
                                            <tr>
                                                <th width="20%">Amount Due</th>
                                                <th><?php echo number_format($payableId['amount_due'], 2);?></th>
                                            </tr>
                                            <tr>
                                                <th>Invoice #</th>
                                                <th> {{ $payableId['invoice_number'] }}</th>
                                            </tr>
											<tr>
												<th>Payment Method</th>
												<th>{{ $payableId['method_of_payment']}}</th>
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
										<td style="text-align:center; border: 1px solid black;">{{ $payableId['issued_date']}}</td>
										<td style="text-align:center; border: 1px solid black;">{{ $payableId['particulars']}}</td>
										<td style="text-align:center; border: 1px solid black; font-size:18px;"><?php echo number_format($payableId['amount'], 2); ?></td>
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
						  @if($payableId['method_of_payment'] === "Cheque")
                          <table style="border:1px solid black;">
                          		  <thead>
                                      <tr>
                                        <th style="height: 1%; text-align: center;">CHEQUE NO ISSUED</th>
                                        <th style="height: 1%; text-align: center;">CHEQUE AMOUNT</th>
                                       
                                      </tr>
                                    </thead>
                                  <tbody>
                                  	
                                  	 	 @foreach($payablesVouchers as $payablesVoucher)
                                        <tr style="border:1px solid black;">
                                          <td style="text-align:center; border: 1px solid black;">{{ $payablesVoucher['cheque_number'] }}</td>
                                         
                                          <td style="text-align:center; border: 1px solid black; font-size:18px;"><?php echo number_format($payablesVoucher['cheque_amount'], 2);?></td>
                                        </tr> 
                                        @endforeach
                                      
	                                      
	                                       <tr style="border:1px solid black;">
	                                       
	                                        <td style=" text-align:center; border: 1px solid black;"><strong>Total</strong></td>
	                                        <td style=" text-align:center; border: 1px solid black; font-size:18px;"> <?php echo number_format($sum, 2)?></td>
	                                      </tr>
                                  </tbody>
                          </table>
						  @else
						  <table style="border:1px solid black;">
                          		  <thead>
                                      <tr>
                                        <th style="height: 1%; text-align: center;">CASH NO ISSUED</th>
                                        <th style="height: 1%; text-align: center;">CASH AMOUNT</th>
                                       
                                      </tr>
                                    </thead>
                                  <tbody>
                                  	
                                  	 	 @foreach($payablesVouchers as $payablesVoucher)
                                        <tr style="border:1px solid black;">
                                          <td style="text-align:center; border: 1px solid black;">{{ $payablesVoucher['cheque_number'] }}</td>
                                         
                                          <td style="text-align:center; border: 1px solid black; font-size:18px;" ><?php echo number_format($payablesVoucher['cheque_amount'], 2);?></td>
                                        </tr> 
                                        @endforeach
                                      
	                                      
	                                       <tr style="border:1px solid black;">
	                                       
	                                        <td style=" text-align:center; border: 1px solid black;"><strong>Total</strong></td>
	                                        <td style=" text-align:center; border: 1px solid black; font-size:18px;"> <?php echo number_format($sum, 2)?></td>
	                                      </tr>
                                  </tbody>
                          </table>

						  @endif
                           <div style="margin-top:100px;">
                           		<table  >
                           			<thead>
                           				<tr>
                       						<th style="width:30%;">Prepared By</th>
											<th>Checked By</th>
                       						<th>Approved By</th>
											<th>Date</th>
                           				</tr>
                           			</thead>
                           			<tbody>
                           				<tr>
                           					<td>
                           						________________________<br>
                           						{{ $payableId['created_by']}}

                           					</td>
											<td>
                           						________________________<br>
                           						Aprilane Maturan<br>
                           						Finance Officer
                           					</td>
                           					<td>
                           						________________________<br>
                           						
                           					</td>
											<td>
												________________________
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


