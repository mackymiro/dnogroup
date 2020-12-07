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
                 <img style="margin-left:5px;" src="{{ asset('images/digitized-logos/wimpys-logo1.png')}}"  alt="Wimpy's Food Express">
            	 	 	 <p  style="margin-top:-50px; margin-left:150px;text-align:left;">
		 	 			Dino Compound, 3rd Floor Dino Group Administration Bldg., No.88 Labogon Road, Barangay Labogon, Mandaue City, 6014 Cebu, Philippines<br>
						Tel. Nos. (63-32) 346-2567; 420-5639 / Fax No. (63-32) 346-0341<br>

						Email Address: admin@dnogroup.ph / sales@dnogroup.ph / marketing@dnogroup.ph
            	 	 </p>
	            	 <h4 ><u>ORDER FORM</u></h4>
	            </div>
				<div class="row">
					<div class="col-lg-12">
						 <div class="card-body">
                              <div style="width:980px; margin:0 auto;">
                                   <div style="float:left; width:50%">
                                    <table >
                                          <thead>
                                            <tr >
                                                <th  width="25%">Date:</th>
                                                <th> {{ $viewOrder[0]->date }}</th>
                                            </tr>
                                            <tr >
                                                <th  width="15%">Time:</th>
                                                <th >{{ $viewOrder[0]->time }}</th>
                                            </tr>
                                            <tr>
                                                <th   width="15%">No of people:</th>
                                                <th  > {{ $viewOrder[0]->no_of_people }} </th>
                                            </tr>
                                          
                                        </thead>
                                      
                                  </table>   
                             </div>
	                          <div style="float:left; width:200px; margin-left:30px;">
	                              <table >
	                                   <thead>
                                            <tr >
                                                <th  width="50%">Order Form #:</th>
                                                <th >
                                                    {{ $viewOrder[0]->module_code}} {{ $viewOrder[0]->wimpys_food_express_code}}
												</th>
                                            </tr>
                                           
                                           
                                        </thead>
	                              </table>
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
									
                                        <th style="height: 1%; text-align: center;">QUANTITY</th>
									
                                        <th style="height: 1%; text-align: center;">UNIT</th>
                                        <th style="height: 1%; text-align: center;">PRICE</th>
                                        <th style="height: 1%; text-align: center;">TOTAL</th>
                                      </tr>
                                    </thead>
                                  <tbody>
                                  		<tr style="border:1px solid black;">
                                      <td style="text-align:center; border: 1px solid black;">{{ $viewOrder[0]->items }}</td>
                                      <td style="text-align:center; border: 1px solid black;">{{ $viewOrder[0]->qty }}</td>
									  <td style="text-align:center; border: 1px solid black;">{{ $viewOrder[0]->unit }}</td>
                                      <td style="text-align:center; border: 1px solid black;"><?= number_format($viewOrder[0]->price, 2); ?></td>
                                      <td style="text-align:center; border: 1px solid black;"><?= number_format($viewOrder[0]->total, 2); ?></td>
                                  	 	</tr>
                                  	 	 @foreach($viewOtherOrders as $viewOtherOrder)
                                        <tr style="border:1px solid black;">
                                          <td style="text-align:center; border: 1px solid black;">{{ $viewOtherOrder['items'] }}</td>
                                          <td style="text-align:center; border: 1px solid black;">{{ $viewOtherOrder['qty'] }}</td>
										  <td style="text-align:center; border: 1px solid black;">{{ $viewOtherOrder['unit'] }}</td>
                                          <td style="text-align:center; border: 1px solid black;"><?= number_format($viewOtherOrder['price'], 2);?></td>
                                          <td style="text-align:center; border: 1px solid black;"><?= number_format($viewOtherOrder['total'], 2);?></td>
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
                           <div style="margin-top:100px;">
                           		<table  >
                           			<thead>
                           				<tr>
                       						<th style="width:30%;">Ordered By</th>
                       						<th>Note By</th>
											
                           				</tr>
                           			</thead>
                           			<tbody>
                           				<tr>
                           					<td>
                           						________________________<br>
                           						{{ $viewOrder[0]->ordered_by}}

                           					</td>
                           					<td>
                           						________________________<br>
                           					    {{ $viewOrder[0]->noted_by}}
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


