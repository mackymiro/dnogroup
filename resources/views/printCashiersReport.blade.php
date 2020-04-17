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
            	 <img style="margin-left: 170px;" src="{{ asset('images/ribos.jpg')}}"   alt="Ribo's Bar">
            	 	 <p >
		 	 			Dino Compound, 3rd Floor Dino Group Administration Bldg., No.88 Labogon Road, Barangay Labogon, Mandaue City, 6014 Cebu, Philippines<br>
						Tel. Nos. (63-32) 346-2567; 420-5639 / Fax No. (63-32) 346-0341<br>

						Email Address: admin@dnogroup.ph / sales@dnogroup.ph / marketing@dnogroup.ph
            	 	 </p>
	            	 <h4 ><u>Cashier's Report Form</u></h4>
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
                                                <th width="25%">Date</th>
                                                <th> {{ $cashiersId['date'] }}</th>
                                            </tr>
                                            <tr>
                                                <th width="25%">Cashier's Name</th>
                                                <th>{{ $cashiersId['cashier_name'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>Bar Tender</th>
                                                <th> {{ $cashiersId['bar_tender_name'] }} </th>
                                            </tr>
                                            <tr>
                                                <th>Starting OS #</th>
                                                <th>{{ $cashiersId['starting_os'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>Closing OS #</th>
                                                <th>{{ $cashiersId['closing_os'] }}</th>
                                            </tr>
                                        </thead>
                                      
                                  </table>   
                             </div>
	                          <div style="float:right; width: 50%;;">
	                              <table >
	                                   <thead>
                                            <tr>
                                                <th width="20%">Cash Sales</th>
                                                <th>{{ $cashiersId['cash_sales'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>Credit Card Sales</th>
                                                <th> {{ $cashiersId['credit_card_sales'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>Signing Privilage Sales</th>
                                                <th>{{ $cashiersId['signing_privilage_sales'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>Total Reading</th>
                                                <th>{{ $cashiersId['total_reading'] }}</th>
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
                                        <th style="height: 1%; text-align: center;">ITEMS</th>
                                      
                                        <th style="height: 1%; text-align: center;">OPENING INVENTORY</th>
                                        <th style="height: 1%; text-align: center;">SOLD</th>
                                        <th style="height: 1%; text-align: center;">CLOSING</th>
                                        <th style="height: 1%; text-align: center;">TOTAL</th>
                                      </tr>
                                    </thead>
                                  <tbody>
                                  		
                                  	 	 @foreach($cashiersReports as $cashiersReport)
                                        <tr style="border:1px solid black;">
                                          <td style="text-align:center; border: 1px solid black;">{{ $cashiersReport['items'] }}</td>
                                          <td style="text-align:center; border: 1px solid black;">{{ $cashiersReport['opening_inventory'] }}</td>
                                          <td style="text-align:center; border: 1px solid black;">{{ $cashiersReport['sold'] }}</td>
                                          <td style="text-align:center; border: 1px solid black;">{{ $cashiersReport['closing'] }}</td>
                                          <td style="text-align:center; border: 1px solid black;"><?php echo number_format($cashiersReport['total'], 2); ?></td>
                                        </tr> 
                                        @endforeach
                                      
	                                      
	                                       <tr style="border:1px solid black;">
	                                        <td style=" border: 1px solid black;"></td>
                                            <td style=" border: 1px solid black;"></td>
                                            <td style=" border: 1px solid black;"></td>
	                                        <td style=" border: 1px solid black;"><strong>Total</strong></td>
	                                        <td style=" text-align:center; border: 1px solid black;"> <?php echo number_format($total, 2)?></td>
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
                           						{{ $cashiersId['created_by']}}

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


