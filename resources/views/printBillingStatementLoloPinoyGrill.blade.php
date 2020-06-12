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
            	 <img style="margin-left: 250px;" src="{{ asset('images/pdf/lolo-pinoy-grill.jpg')}}"   alt="Lolo Pinoy Grill">
            	 	 <p >
		 	 			Dino Compound, 3rd Floor Dino Group Administration Bldg., No.88 Labogon Road, Barangay Labogon, Mandaue City, 6014 Cebu, Philippines<br>
						Tel. Nos. (63-32) 346-2567; 420-5639 / Fax No. (63-32) 346-0341<br>

						Email Address: admin@dnogroup.ph / sales@dnogroup.ph / marketing@dnogroup.ph
            	 	 </p>
	            	 <h4 ><u>BILLING STATEMENT</u></h4>
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
                                                <th width="30%">Bill To</th>
                                                <th> {{ $printBillingStatement['bill_to'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <th>{{ $printBillingStatement['address'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>Period Covered</th>
                                                <th> {{ $printBillingStatement['period_cover'] }} </th>
                                            </tr>
                                            <tr>
                                                <th>Date</th>
                                                <th>{{ $printBillingStatement['date'] }}</th>
                                            </tr>
                                        </thead>
                                      
                                  </table>   
                             </div>
	                          <div style="float:right; width: 50%">
	                              <table >
	                                   <thead>
                                            <tr>
                                                <th width="20%">Reference #</th>
                                                <th>{{ $printBillingStatement['reference_number'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>PO Number</th>
                                                <th> {{ $printBillingStatement['p_o_number'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>Terms</th>
                                                <th>{{ $printBillingStatement['terms'] }}</th>
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
                                        <th style="height: 1%; text-align: center;">INVOICE #</th>
                                        <th style="height: 1%; text-align: center;">WHOLE LECHON 500/KL</th>
                                        <th style="height: 1%; text-align: center;">DESCRIPTION</th>
                                        <th style="height: 1%; text-align: center;">AMOUNT</th>
                                      </tr>
                                    </thead>
                                  <tbody>
                                  		<tr style="border:1px solid black;">
                                      <td style="text-align:center; border: 1px solid black;">{{ $printBillingStatement['date_of_transaction'] }}</td>
                                      <td style="text-align:center; border: 1px solid black;">{{ $printBillingStatement['invoice_number'] }}</td>
                                      <td style="text-align:center; border: 1px solid black;">{{ $printBillingStatement['whole_lechon'] }}</td>
                                      <td style="text-align:center; border: 1px solid black;">{{ $printBillingStatement['description'] }}</td>
                                      <td style="text-align:center; border: 1px solid black;"><?php echo number_format($printBillingStatement['amount'], 2); ?></td>
                                  	 	</tr>
                                  	 	 @foreach($billingStatements as $billingStatement)
                                        <tr style="border:1px solid black;">
                                          <td style="text-align:center; border: 1px solid black;">{{ $billingStatement['date_of_transaction'] }}</td>
                                          <td style="text-align:center; border: 1px solid black;">{{ $billingStatement['invoice_number'] }}</td>
                                          <td style="text-align:center; border: 1px solid black;">{{ $billingStatement['whole_lechon'] }}</td>
                                          <td style="text-align:center; border: 1px solid black;">{{ $billingStatement['description'] }}</td>
                                          <td style="text-align:center; border: 1px solid black;"><?php echo number_format($billingStatement['amount'], 2);?></td>
                                        </tr> 
                                        @endforeach
                                      
	                                      
	                                       <tr style="border:1px solid black;">
	                                        <td style=" border: 1px solid black;"></td>
	                                        <td style=" border: 1px solid black;"></td>
                                          <td style=" border: 1px solid black;"></td>
	                                        <td style=" border: 1px solid black;"><strong>Total</strong></td>
	                                        <td style=" text-align:center; border: 1px solid black;"> <?php echo number_format($sum, 2)?></td>
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
                           						{{ $printBillingStatement['created_by']}}

                           					</td>
                           					<td>
                           						________________________<br>
                           						AprilAn Q Maturan<br>
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


