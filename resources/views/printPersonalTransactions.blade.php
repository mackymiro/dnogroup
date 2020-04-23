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
            	 <img style="margin-left: 240px;" src="{{ asset('images/DIC-LOGO.png')}}"  alt="DNO Personal">
            	 	 <p >
		 	 			Dino Compound, 3rd Floor Dino Group Administration Bldg., No.88 Labogon Road, Barangay Labogon, Mandaue City, 6014 Cebu, Philippines<br>
						Tel. Nos. (63-32) 346-2567; 420-5639 / Fax No. (63-32) 346-0341<br>

						Email Address: admin@dnogroup.ph / sales@dnogroup.ph / marketing@dnogroup.ph
            	 	 </p>
                    
                      <h4 ><u>PERSONAL TRANSACTION</u></h4>
                      
	            </div>
				<div class="row">
					<div class="col-lg-12">
						 <div class="card-body">
				 			<div class="form-group">
                              <div style="width:800px; margin:0 auto;">
                                   <div style="float:left; width:50%">
                                    <table >
                                          <thead>
                                            <tr>
                                                <th width="30%">Paid To</th>
                                                <th> {{ $personalExpenses['paid_to'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>Invoice #</th>
                                                <th>{{ $personalExpenses['invoice_number'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>Amount Due</th>
                                                <th><?php echo number_format($personalExpenses['amount_due'], 2)?></th>
                                            </tr>
                                            <tr>
                                                <th>Voucher Ref #</th>
                                                <th> {{ $personalExpenses['voucher_ref_number'] }} </th>
                                            </tr>
                                              
                                        </thead>
                                      
                                  </table>   
                             </div>
	                          <div style="float:right; width: 50%; margin-left:-100px; ">
	                              <table >
	                                   <thead>
                                            <tr>
                                                <th>Account Name</th>
                                                <th>{{ $personalExpenses['account_name']}}</th>
                                            </tr>
                                                                       
                                            <tr>
                                                <th>Payment Method</th>
                                                <th> {{ $personalExpenses['method_of_payment'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <th> {{ $personalExpenses['status'] }}</th>
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
                                        <th style="height: 1%; text-align: center;">PARTICULARS</th>
                                        <th style="height: 1%; text-align: center;">AMOUNT</th>
                                       
                                      </tr>
                                    </thead>
                                  <tbody>
                                  	
                                         <tr style="border:1px solid black;">
                                          <td style="text-align:center; border: 1px solid black;">{{ $personalExpenses['particulars'] }}</td>
                                         
                                          <td style="text-align:center; border: 1px solid black;"><?php echo number_format($personalExpenses['amount'], 2);?></td>
                                        </tr> 
                                  	 	 @foreach($particulars as $particular)
                                        <tr style="border:1px solid black;">
                                          <td style="text-align:center; border: 1px solid black;">{{ $particular['particulars'] }}</td>
                                         
                                          <td style="text-align:center; border: 1px solid black;"><?php echo number_format($particular['amount'], 2);?></td>
                                        </tr> 
                                        @endforeach
                                      
	                                      
	                                       <tr style="border:1px solid black;">
    
	                                        <td style=" text-align:center; border: 1px solid black;"><strong>Total</strong></td>
	                                        <td style=" text-align:center; border: 1px solid black;"> <?php echo number_format($sum, 2)?></td>
	                                      </tr>
                                  </tbody>
                          </table>
                          <table style="margin-top:30px; border:1px solid black;">>
                                <thead>
                                    <tr>
                                    <th style="height: 1%; text-align: center;">PAYMENT CHEQUE NUMBER</th>
                                    <th style="height: 1%; text-align: center;">CHEQUE AMOUNT</th>
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                    <tr style="border:1px solid #000;">
                                        <td  style="text-align:center; border: 1px solid black;">{{ $payment['cheque_number'] }}</td>
                                        <td  style="text-align:center; border: 1px solid black;">
                                            <?php echo number_format($payment['cheque_amount']); ?>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr style="border:1px solid black;">
    
                                        <td style=" text-align:center; border: 1px solid black;"><strong>Total</strong></td>
                                        <td style=" text-align:center; border: 1px solid black;"> <?php echo number_format($sumCheque, 2)?></td>
                                    </tr>
                                </tbody>
                          </table>
                           <div style="margin-top:100px;">
                           		<table  >
                           			<thead>
                           				<tr>
                       						<th style="width:30%;">Prepared By</th>
                       						<th>Approved By</th>
                           				</tr>
                           			</thead>
                           			<tbody>
                           				<tr>
                           					<td>
                           						________________________<br>
                           						{{ $personalExpenses['created_by']}}

                           					</td>
                           					<td>
                           						________________________<br>
                           						AprilAn Maturan<br>
                           						Finance Officer
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


