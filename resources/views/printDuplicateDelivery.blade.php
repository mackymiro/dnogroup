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
            	 <img  src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}"   alt="Lechon de Cebu">
            	 	 <p >
		 	 			Dino Compound, 3rd Floor Dino Group Administration Bldg., No.88 Labogon Road, Barangay Labogon, Mandaue City, 6014 Cebu, Philippines<br>
						Tel. Nos. (63-32) 346-2567; 420-5639 / Fax No. (63-32) 346-0341<br>

						Email Address: admin@dnogroup.ph / sales@dnogroup.ph / marketing@dnogroup.ph
            	 	 </p>
	            	 <h4 ><u>DUPLICATE COPY DELIVERY RECEIPT</u></h4>
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
                                              <th width="30%">Sold To</th>
                                              <th>{{ $deliveryDuplicateId->sold_to }}</th>
                                          </tr>
                                          <tr>
                                              <th>Delivered To</th>
                                              <th>{{ $deliveryDuplicateId->delivered_to}}</th>
                                          </tr>
                                          <tr> 
                                              <th>Contact Person</th>
                                              <th>{{ $deliveryDuplicateId->contact_person }}</th>
                                          </tr>
                                          <tr>
                                              <th>Time</th>
                                              <th>{{ $deliveryDuplicateId->time }}</th>
                                          </tr>
                                         
                                      </thead>
                                      
                                  </table>   
                             </div>
	                          <div style="float:right; width: 50%">
	                              <table >
	                                  <thead>
	                                      <tr>
	                                          <th width="20%">Mobile #</th>
	                                          <th>{{ $deliveryDuplicateId->mobile_num}}</th>
	                                      </tr>
	                                      <tr> 
	                                          <th>DR No</th>
	                                          <th>{{ $deliveryDuplicateId->dr_no }}</th>
	                                      </tr> 
	                                       <tr>
	                                          <th>Date</th>
	                                          <th>{{ $deliveryDuplicateId->date }}</th>
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
	                                    <th style="height: 1%; text-align: center;" >QTY</th>
	                                    <th style="height: 1%; text-align: center;">DESCRIPTION</th>
	                                    <th style="height: 1%; text-align: center;">PRICE</th>
	                                  
	                                  </tr>
                                  </thead>
                                  <tbody>
                                  		<tr style="border:1px solid black;">
	                                  	 	<td style="text-align:center; border: 1px solid black;">{{ $deliveryDuplicateId['qty']}}</td>
	                                  	 	<td style="text-align:center; border: 1px solid black;">{{ $deliveryDuplicateId['description']}}</td>
	                                  	 	<td style="text-align:center; border: 1px solid black;"><?php echo number_format($deliveryDuplicateId['price'], 2); ?></td>
                                  	 	</tr>
                                  	 	 @foreach($deliveryReceiptDuplicates as $deliveryReceiptDuplicate)
	                                     <tr style="border:1px solid black;">
	                                        <td style="text-align:center; border: 1px solid black;">{{ $deliveryReceiptDuplicate['qty']}}</td>
	                                        <td style=" text-align:center; border: 1px solid black;">{{ $deliveryReceiptDuplicate['description']}}</td>
	                                        <td style=" text-align:center; border: 1px solid black;"><?php echo number_format($deliveryReceiptDuplicate['price'], 2)?></td>
	                                     </tr>
                                  	
                                      
	                                       @endforeach
	                                       <tr style="border:1px solid black;">
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
                       						<th>Checked By</th>
                       						<th>Received By</th>
                           				</tr>
                           			</thead>
                           			<tbody>
                           				<tr>
                           					<td>
                           						________________________<br>
                           						{{ $deliveryDuplicateId['created_by']}}

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
                           	
                           </div>

						 </div>
					</div>
				</div>
 		</div>
	 </div>
</div>


