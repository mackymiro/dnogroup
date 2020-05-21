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
            	 <img  src="{{ asset('images/lolo-pinoy-grill.jpeg')}}" width="366" height="178"  alt="Lechon de Cebu">
            	 	 <p style="font-size:16px; text-align: left;">
		 	 			Dino Compound, 3rd Floor Dino Group Administration Bldg., No.88 Labogon Road, Barangay Labogon, Mandaue City, 6014 Cebu, Philippines<br>
						Tel. Nos. (63-32) 346-2567; 420-5639 / Fax No. (63-32) 346-0341<br>

						Email Address: admin@dnogroup.ph / sales@dnogroup.ph / marketing@dnogroup.ph
            	 	 </p>
	            	 <h4 ><u>DELIVERY RECEIPT</u></h4>
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
                                            <th width="30%">Delivered To</th>
                                            <th>{{ $deliveryId->delivered_to }}</th>
                                          </tr>
                                          <tr>
                                            <th>Address</th>
                                            <th>{{ $deliveryId->address }}</th>
                                          </tr>
                                      </thead>
                                      
                                  </table>   
                             </div>
	                          <div style="float:right; width: 50%">
	                              <table >
	                                  <thead>
                                        <tr>
                                          <th width="30%">DR No</th>
                                          <th>{{ $deliveryId->dr_no }}</th>
                                        </tr>
                                        <tr>
                                          <th>Date</th>
                                          <th>{{ $deliveryId->date }}</th>
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
	                                    <th style="height: 1%; text-align: center;">Product ID</th>
                                      <th style="height: 1%; text-align: center;">Qty</th>
                                      <th style="height: 1%; text-align: center;">Unit</th>
                                      <th style="height: 1%; text-align: center;">Item Description</th>
                                      <th style="height: 1%; text-align: center;">Unit Price</th>
                                      <th style="height: 1%; text-align: center;">Amount</th>
	                                  </tr>
                                  </thead>
                                  <tbody>
                                  		<tr style="border:1px solid black;">
	                                  	 	  <td style="text-align:center; border: 1px solid black;">{{ $deliveryId['product_id']}}</td>
                                          <td style="text-align:center; border: 1px solid black;">{{ $deliveryId['qty']}}</td>
                                          <td style="text-align:center; border: 1px solid black;">{{ $deliveryId['unit']}}</td>
                                          <td style="text-align:center; border: 1px solid black;">{{ $deliveryId['item_description']}}</td>
                                          <td style="text-align:center; border: 1px solid black;"><?php echo number_format($deliveryId['unit_price'], 2)?></td>
                                          <td style="text-align:center; border: 1px solid black;"><?php echo number_format($deliveryId['amount'], 2)?></td>
                                  	 	</tr>
                                  	 	 @foreach($deliveryReceipts as $deliveryReceipt)
  	                                      <tr style="border:1px solid black;">
  	                                        <td style="text-align:center; border: 1px solid black;">{{ $deliveryReceipt['product_id'] }}</td>
                                            <td style="text-align:center; border: 1px solid black;">{{ $deliveryReceipt['qty'] }}</td>
                                            <td style="text-align:center; border: 1px solid black;">{{ $deliveryReceipt['unit'] }}</td>
                                            <td style="text-align:center; border: 1px solid black;">{{ $deliveryReceipt['item_description'] }}</td>
                                            <td style="text-align:center; border: 1px solid black;"><?php echo number_format($deliveryReceipt['unit_price'], 2)?></td>
                                            <td style="text-align:center; border: 1px solid black;"><?php echo number_format($deliveryReceipt['amount'], 2)?></td>
  	                                     </tr>
                                  	
                                      
	                                       @endforeach
	                                       <tr style="border:1px solid black;">
	                                            <td style=" border: 1px solid black;"></td>
                                              <td style=" border: 1px solid black;"></td>
                                              <td style=" border: 1px solid black;"></td>
                                              <td style=" text-align:center; border: 1px solid black;"><strong>Total</strong></td>
                                              <td style=" text-align:center; border: 1px solid black;"><?php echo number_format($sum, 2)?></td>
                                              <td style=" text-align:center; border: 1px solid black;"><?php echo number_format($sum2, 2)?></td>
	                                      </tr>
                                  </tbody>
                          </table>
                           <div style="margin-top:100px;">
                           		<table  >
                           			<thead>
                           				<tr>
                       						<th style="width:30%;">Prepared By</th>
                       						<th>Checked By</th>
                       						<th>Received By</th>
                           				</tr>
                           			</thead>
                           			<tbody>
                           				<tr>
                           					<td>
                           						________________________<br>
                           						{{ $deliveryId['created_by']}}

                           					</td>
                           					<td>
                           						________________________<br>
                           						AprilAn Maturan<br>
                           						Finance Officer
                           					</td>
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


