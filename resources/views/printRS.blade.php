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
            	 <img style="margin-left: 170px;"src="{{ asset('images/lolo-pinoy-grill.jpeg')}}"   alt="Lolo Pinoy Grill" width="366" height="178">
            	 	 <p >
		 	 			Dino Compound, 3rd Floor Dino Group Administration Bldg., No.88 Labogon Road, Barangay Labogon, Mandaue City, 6014 Cebu, Philippines<br>
						Tel. Nos. (63-32) 346-2567; 420-5639 / Fax No. (63-32) 346-0341<br>

						Email Address: admin@dnogroup.ph / sales@dnogroup.ph / marketing@dnogroup.ph
            	 	 </p>
	            	 <h4 ><u>REQUISITION SLIP</u></h4>
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
                                                <th width="20%">Requesting Department</th>
                                                <th>{{ $requisitionSlip['requesting_department'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>Request Date</th>
                                                <th>{{ $requisitionSlip['request_date']}}</th>
                                            </tr>
                                        </thead>
                                      
                                  </table>   
                             </div>
	                          <div style="float:right; width: 50%">
	                              <table >
	                                   <thead>
                                            <tr>
                                                <th width="20%">R.S Number</th>
                                                <th><a href="#">R.S-{{ $requisitionSlip['rs_number'] }}</a></th>
                                            </tr>
                                            <tr>
                                                <th>Date Released</th>
                                                <th> {{ $requisitionSlip['date_released'] }}</th>
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
	                                   <th  style="height: 1%; text-align: center;" >QUANTITY REQUESTED</th>
                                      <th style="height: 1%; text-align: center;" >UNIT</th>
                                      <th style="height: 1%; text-align: center;" >ITEM</th>
                                      <th style="height: 1%; text-align: center;" >QUANTITY GIVEN</th>
	                                  
	                                  </tr>
                                  </thead>
                                  <tbody>
                                  		<tr style="border:1px solid black;">
	                                  	 	<td style="text-align:center; border: 1px solid black;">{{ $requisitionSlip['quantity_requested']}}</td>
	                                  	 	<td style="text-align:center; border: 1px solid black;">{{ $requisitionSlip['unit']}}</td>
                                          <td style="text-align:center; border: 1px solid black;">{{ $requisitionSlip['item']}}</td>
	                                  	 	<td style="text-align:center; border: 1px solid black;">{{ $requisitionSlip['quantity_given']}}</td>
                                  	 	</tr>
                                  	 	 @foreach($rSlips as $rSlip)
                                        <tr style="border:1px solid black;">
                                        <td style="text-align:center; border: 1px solid black;">{{ $requisitionSlip['quantity_requested']}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $requisitionSlip['unit']}}</td>
                                          <td style="text-align:center; border: 1px solid black;">{{ $requisitionSlip['item']}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $requisitionSlip['quantity_given']}}</td>
                                        </tr> 
                                        @endforeach
                                      
	                                      
	                             
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
                           						{{ $requisitionSlip['created_by']}}

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


