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
 				<div  style="margin-top:-10px; float:left;">
            	 <img style="margin-left: 5px;" src="{{ asset('images/wlg-corporation.png')}}"   alt="WLG Philippines Corporation">
            	 	 <p style="width: 200px; text-align:justify;" >
		 	 			Dino Compound, 3rd Floor Dino Group Administration Bldg., No.88 Labogon Road, Barangay Labogon, Mandaue City, 6014 Cebu, Philippines<br>
						Tel. Nos. (63-32) 346-2567; 420-5639 / Fax No. (63-32) 346-0341<br>

						Email Address: admin@dnogroup.ph / sales@dnogroup.ph / marketing@dnogroup.ph
            	 	 </p>
	            	
        		</div>
				<div style="float:right; margin-right:100px;">
            	     <h2>
                        <u style="color:blue;">PURCHASE ORDER</u>
                           <br />
                           <span style="font-size: 14px;">
						   {{ $purchaseOrder[0]->module_code}}{{ $purchaseOrder[0]->wlg_code}}
						   </span>
                           <br />
                           <span style="font-size: 14px;">Date:  {{ $purchaseOrder[0]->date }} </span>
                    </h2>
                     
                </div>
				<div style="clear:both;"></div>
				<div class="row">
					<div class="col-lg-12">
						 <div class="card-body">
				 			<div class="form-group">
                              <div style="width:980px; margin:0 auto;">
                                   <div style="float:left; width:50%">
                                    <table >
                                         <thead>
										    <tr>
                                                <th colspan="2" style="height: 1%; text-align: center; background-color:blue; color:white;">VENDOR</th>
                                            </tr>
                                            <tr>
                                                <th width="20%">Paid To</th>
                                                <th>{{ $purchaseOrder[0]->paid_to }}</th>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <th>{{ $purchaseOrder[0]->address}}</th>
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
                                      <th  style="height: 1%; text-align: center; background-color:blue; color:white;" >MODEL</th>
	                                  <th  style="height: 1%; text-align: center; background-color:blue; color:white;" >PARTICULARS</th>
                                      <th style="height: 1%; text-align: center; background-color:blue; color:white;" >QUANTITY</th>
                                      <th style="height: 1%; text-align: center; background-color:blue; color:white;" >UNIT PRICE</th>
                                      <th style="height: 1%; text-align: center; background-color:blue; color:white;" >AMOUNT</th>
	                                  
	                                  </tr>
                                  </thead>
                                  <tbody>
                                  		<tr style="border:1px solid black;">
	                                  	 	<td style="text-align:center; border: 1px solid black;">{{ $purchaseOrder[0]->model}}</td>
	                                  	 	<td style="text-align:center; border: 1px solid black;">{{ $purchaseOrder[0]->particulars}}</td>
                                               <td style="text-align:center; border: 1px solid black;">{{ $purchaseOrder[0]->quantity}}</td>
                                          <td style="text-align:center; border: 1px solid black;">{{ $purchaseOrder[0]->unit_price}}</td>
	                                  	 	<td style="text-align:center; border: 1px solid black;"><?= number_format($purchaseOrder[0]->amount, 2); ?></td>
                                  	 	</tr>
                                  	 	 @foreach($pOrders as $pOrder)
                                        <tr style="border:1px solid black;">
                                          <td style="text-align:center; border: 1px solid black;">{{ $pOrder['model'] }}</td>
                                          <td style="text-align:center; border: 1px solid black;">{{ $pOrder['particulars'] }}</td>
                                          <td style="text-align:center; border: 1px solid black;">{{ $pOrder['quantity'] }}</td>
                                          <td style="text-align:center; border: 1px solid black;">{{ $pOrder['unit_price'] }}</td>
                                          <td style="text-align:center; border: 1px solid black;"><?= number_format($pOrder['amount'], 2) ?></td>
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
						  <br />
                          <br />
                          <br />
                          <br />
						
							<div style="border:1px solid black; width:300px; text-align: center; background-color:gray; color:white;">
								Comments or Special Instructions
							</div>  
							<div style="border:1px solid black; width:300px; height:100px;"></div> 
							
							<br />
							<br />
							<br />
                           <div style="margin-top:30px;">
                           		<table  >
                           			<thead>
                           				<tr>
                       						<th style="width:30%;">Prepared By:</th>
                       						<th>Checked & Verified By:</th>
											<th>Approved By:</th>
                           				</tr>
                           			</thead>
                           			<tbody>
                           				<tr>
                           					<td>
                           						________________________<br>
                           						{{ $purchaseOrder[0]->created_by}}

                           					</td>
                           					<td>
											   <br />
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
								   <br />
								   <br />
								   <br />
								   <br />
								<table  >
                           			<thead>
                           				<tr>
											<th>Received & Acknowledged By: </th>
                           				</tr>
                           			</thead>
                           			<tbody>
                           				<tr>
											<td>
                           						________________________<br>
                           						Printed name and signature
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


