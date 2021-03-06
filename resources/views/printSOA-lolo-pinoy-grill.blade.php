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
                 <img style="margin-left: 5px;" src="{{ asset('images/digitized-logos/lolo-pinoy-grill-pdf.png' )}}" alt="Lolo Pinoy Grill">
					 	 <p style="margin-top:-50px; margin-left:110px;text-align:left;">
		 	 			Dino Compound
                        Ground & 3rd Floors, Dino Group Administration Building,
                        No. 88 Labogon Road, Barangay Labogon, Mandaue City, Cebu 6014
                        Philippines<br>
						Tel. Nos. (63-32) 346-2567; 420-5639 / Fax No. (63-32) 346-0341<br>

						Email Address: admin@dnogroup.ph / sales@dnogroup.ph / marketing@dnogroup.ph
            	 	 </p>
	            	 <h4 ><u>STATEMENT OF ACCOUNT</u></h4>
	            </div>
				<div class="row">
					<div class="col-lg-12">
						 <div class="card-body">
				 			<div class="form-group">
                  <div clsass="form-row">
                              <div style="width:980px; margin:0 auto;">
                                   <div style="float:left; width:50%">
                                    <table >
                                          <thead>
                                            <tr>
                                                <th width="25%">Bill To</th>
                                                <th> {{ $Soa[0]->bill_to }}</th>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <th>{{ $Soa[0]->address }}</th>
                                            </tr>
                                            <tr>
                                                <th>Period Covered</th>
                                                <th> {{ $Soa[0]->period_cover }} </th>
                                            </tr>
                                            <tr>
                                                <th>Date</th>
                                                <th>{{ $Soa[0]->date }}</th>
                                            </tr>
                                             <tr>
                                                <th>Branch</th>
                                                <th>{{ $Soa[0]->branch }}</th>
                                            </tr>
                                             <tr>
                                                <th>Payment Method</th>
                                                <th>{{ $Soa[0]->payment_method }}</th>
                                            </tr>
                                            <tr>
                                                <th>Total Amount</th>
                                                <th><?php echo number_format($sum, 2);?></th>
                                            </tr>
                                           
                                        </thead>
                                      
                                  </table>
                                </div>   
                             </div>
	                          <div style="float:right; width: 50%">
	                              <table >
	                                   <thead>
                                            <tr>
                                                <th width="20%">SOA No</th>
                                                <th>{{ $Soa[0]->module_code }}{{ $Soa[0]->lolo_pinoy_grill_code }}</th>
                                            </tr>
                                          
                                            <tr>
                                                <th>Terms</th>
                                                <th>{{ $Soa[0]->terms }}</th>
                                            </tr>
                                             <tr>
                                                <th>Collection Date</th>
                                                <th>{{ $Soa[0]->collection_date }}</th>
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
                          <table style="margin-top:80px;border:1px solid black;">
                          		  <thead>
                                      <tr>
                                        <th style="height: 1%; text-align: center;">DATE</th>
                                        @if($Soa[0]->order === "Delivery Receipt")
										<th style="height: 1%; text-align: center;">ORDER</th>
										<th style="height: 1%; text-align: center;">QTY</th>
										<th style="height: 1%; text-align: center;">UNIT PRICE</th>
										<th style="height: 1%; text-align: center;">UNIT</th>
										@else
                                        <th style="height: 1%; text-align: center;">INVOICE #</th>
										<th style="height: 1%; text-align: center;">QTY</th>
										<th style="height: 1%; text-align: center;">TOTAL KLS</th>
										<th style="height: 1%; text-align: center;">UNIT PRICE</th>

                                        @endif
                                        <th style="height: 1%; text-align: center;">DESCRIPTION</th>
                                        <th style="height: 1%; text-align: center;">AMOUNT</th>
                                        <th style="height: 1%; text-align: center;">STATUS</th>
                                      </tr>
                                    </thead>
                                  <tbody>
                                    <tr style="border:1px solid black;">
                                      <td style="text-align:center; border: 1px solid black;">{{ $Soa[0]->date_of_transaction }}</td>
                                      @if($Soa[0]->order === "Delivery Receipt")
										<td style="text-align:center; border: 1px solid black;">{{ $Soa[0]->dr_no }}</td>
										<td style="text-align:center; border: 1px solid black;">{{ $Soa[0]->qty }}</td>
										<td style="text-align:center; border: 1px solid black;">{{ $Soa[0]->unit_price }}</td>
										<td style="text-align:center; border: 1px solid black;">{{ $Soa[0]->unit }}</td>
									  @else
                                      <td style="text-align:center; border: 1px solid black;">{{ $Soa[0]->invoice_number }}</td>
									  <td style="text-align:center; border: 1px solid black;">{{ $Soa[0]->qty }}</td>
									  <td style="text-align:center; border: 1px solid black;">{{ $Soa[0]->total_kls }}</td>
									  <td style="text-align:center; border: 1px solid black;">{{ $Soa[0]->unit_price }}</td>
								
								
                                      @endif
                                      <td style="text-align:center; border: 1px solid black;">{{ $Soa[0]->description }}</td>
                                      <td style="text-align:center; border: 1px solid black;"><?= number_format($Soa[0]->amount, 2); ?></td>
                                       <td style="text-align:center; border: 1px solid black;">{{ $Soa[0]->status }}</td>
                                    </tr>
                                  	 	 @foreach($statementAccounts as $statementAccount)
                                        <tr style="border:1px solid black;">
                                          <td style="text-align:center; border: 1px solid black;">{{ $statementAccount['date_of_transaction'] }}</td>
                                          @if($statementAccount['order'] === "Delivery Receipt")
											<td style="text-align:center; border: 1px solid black;">{{ $statementAccount['dr_no'] }}</td>
											<td style="text-align:center; border: 1px solid black;">{{ $statementAccount['qty'] }}</td>
											<td style="text-align:center; border: 1px solid black;">{{ $statementAccount['unit_price'] }}</td>
											<td style="text-align:center; border: 1px solid black;">{{ $statementAccount['unit'] }}</td>
										  @else
                                          <td style="text-align:center; border: 1px solid black;">{{ $statementAccount['invoice_number'] }}</td>
                                          <td style="text-align:center; border: 1px solid black;">{{ $statementAccount['qty'] }}</td>
											<td style="text-align:center; border: 1px solid black;">{{ $statementAccount['total_kls'] }}</td>
											<td style="text-align:center; border: 1px solid black;">{{ $statementAccount['unit_price'] }}</td>
										
                                          @endif
                                          <td style="text-align:center; border: 1px solid black;">{{ $statementAccount['whole_lechon'] }}</td>
                                          <td style="text-align:center; border: 1px solid black;">{{ $statementAccount['description'] }}</td>
                                          <td style="text-align:center; border: 1px solid black;"><?= number_format($statementAccount['amount'], 2);?></td>
                                           <td style="text-align:center; border: 1px solid black;">{{ $Soa['status'] }}</td>
                                        </tr> 
                                        @endforeach
                                      
	                                      
                                        <tr style="border:1px solid black;">
	                                        <td style=" border: 1px solid black;"></td>
	                                        <td style=" border: 1px solid black;"></td>
											<td style=" border: 1px solid black;"></td>
											<td style=" border: 1px solid black;"></td>
											<td style=" border: 1px solid black;"></td>
	                                        <td style="text-align:center; border: 1px solid black;"><strong>Total</strong></td>
	                                        <td style=" text-align:center; border: 1px solid black;"> <?= number_format($sum, 2)?></td>
                                          <td  style=" border: 1px solid black;"></td>
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
                           						{{ $Soa[0]->created_by }}

                           					</td>
                           					<td>
                           						________________________<br>
                           						Aprilane Q Maturan<br>
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


