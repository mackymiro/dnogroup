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
 				<div  style="margin-top:-10px; float:left; ">
					<img style="margin-left: -30px;" src="{{ asset('images/pdf/mr-potato.png')}}"   alt="Mr Potato"> 
                		 <p style="width: 200px; text-align:justify;">
						 Dino Compound
						Ground & 3rd Floors, Dino Group Administration Building,
						No. 88 Labogon Road, Barangay Labogon, Mandaue City, Cebu 6014
						Philippines<br>
						Tel. Nos. (63-32) 346-2567; 420-5639 / Fax No. (63-32) 346-0341<br>

						Email Address: admin@dnogroup.ph / sales@dnogroup.ph / marketing@dnogroup.ph
            	 	 </p>
	            	
       			 </div>
				<div style="float:right; margin-right:100px;">
            	     <h2>
                        <u style="color:blue;">PURCHASE ORDER</u>
                           <br />
                           <span style="font-size: 14px;">PO #: {{ $purchaseOrder[0]->mr_potato_code }}</span>
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
                                                <th width="20%">Branch Location</th>
                                                <th>{{ $purchaseOrder[0]->branch_location }}</th>
                                            </tr>
                                            <tr>
                                                <th>Ordered By</th>
                                                <th>{{ $purchaseOrder[0]->ordered_by}}</th>
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
	                                   <th  style="height: 1%; text-align: center; background-color:blue; color:white;" >PARTICULARS</th>
                                      <th style="height: 1%; text-align: center; background-color:blue; color:white;" >QTY</th>
                                      <th style="height: 1%; text-align: center; background-color:blue; color:white;" >UNIT</th>
                                      <th style="height: 1%; text-align: center; background-color:blue; color:white;" >PRICE</th>
	                                  <th style="height: 1%; text-align: center; background-color:blue; color:white;" >SUBTOTAL</th>
	                                  </tr>
                                  </thead>
                                  <tbody>
                                  		<tr style="border:1px solid black;">
	                                  	 	<td style="text-align:center; border: 1px solid black;">{{ $purchaseOrder[0]->particulars}}</td>
	                                  	 	<td style="text-align:center; border: 1px solid black;">{{ $purchaseOrder[0]->qty}}</td>
                                            <td style="text-align:center; border: 1px solid black;">{{ $purchaseOrder[0]->unit}}</td>
                                            <td style="text-align:center; border: 1px solid black;"><?php echo number_format($purchaseOrder[0]->price, 2); ?></td>
                                  	 	
	                                  	 	<td style="text-align:center; border: 1px solid black;"><?php echo number_format($purchaseOrder[0]->subtotal, 2); ?></td>
                                  	 	</tr>
                                  	 	 @foreach($pOrders as $pOrder)
                                        <tr style="border:1px solid black;">
                                          <td style="text-align:center; border: 1px solid black;">{{ $pOrder['particulars'] }}</td>
                                          <td style="text-align:center; border: 1px solid black;">{{ $pOrder['qty'] }}</td>
                                          <td style="text-align:center; border: 1px solid black;">{{ $pOrder['unit'] }}</td>
                                          <td style="text-align:center; border: 1px solid black;"><?php echo number_format($pOrder['price'], 2) ?></td>
                                       
                                          <td style="text-align:center; border: 1px solid black;"><?php echo number_format($pOrder['subtotal'], 2) ?></td>
                                        </tr> 
                                        @endforeach
                                      
	                                      
	                                       <tr style="border:1px solid black;">
	                                        <td style=" border: 1px solid black;"></td>
	                                         <td style=" border: 1px solid black;"></td> 
                                           <td style=" border: 1px solid black;"><strong>Total</strong></td>
	                                        <td style=" text-align:center; border: 1px solid black;"> <?php echo number_format($sum, 2)?></td>
                                            <td></td>
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
						
                           <div style="margin-top:100px;">
                           		<table  >
                           			<thead>
                           				<tr>
                       						<th style="width:30%;">Prepared By</th>
                       						<th>Checked & Verified By</th>
                       						<th>Approved By</th>
                           				</tr>
                           			</thead>
                           			<tbody>
                           				<tr>
                           					<td>
                           						________________________<br>
                           						{{ $purchaseOrder[0]->created_by}}

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
								   <br />
								   <br />
								   <br />
								   <br />
								<table  >
                           			<thead>
                           				<tr>
											<th>Received & acknowledged By</th>
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


