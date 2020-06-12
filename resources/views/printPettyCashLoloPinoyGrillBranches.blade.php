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
            	 <img style="margin-left: 240px;" src="{{ asset('images/pdf/lolo-pinoy-grill.jpg')}}"  alt="Lechon de Cebu">
            	 	 <p >
		 	 			Dino Compound, 3rd Floor Dino Group Administration Bldg., No.88 Labogon Road, Barangay Labogon, Mandaue City, 6014 Cebu, Philippines<br>
						Tel. Nos. (63-32) 346-2567; 420-5639 / Fax No. (63-32) 346-0341<br>

						Email Address: admin@dnogroup.ph / sales@dnogroup.ph / marketing@dnogroup.ph
            	 	 </p>
                    
                      <h4 ><u>PETTY CASH</u></h4>
                      
	            </div>
				<div class="row">
					<div class="col-lg-12">
                          <div class="card-body">
                                <div class="form-group">
                                     <div style="width:980px; margin:0 auto;">
                                   <div style="float:left; width:40%">
                                    <table >
                                        <thead>
                                           <tr>
                                                <th width="30%">Petty Cash No</th>
                                                <th>Ptylpgc-{{ $getPettyCash['petty_cash_no'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>Date</th>
                                                <th>{{ $getPettyCash['date'] }}</th>
                                            </tr>
                                         
                                      </thead>
                                      
                                  </table>   
                             </div>
                            <div style="float:right; width: 50%; margin-right: 100px;">
                                <table >
                                     <thead>
                                         <tr>
                                                <th>Petty Cash Name</th>
                                                <th> {{ $getPettyCash['petty_cash_name'] }} </th>
                                            </tr>
                                            <tr>
                                                <th>Petty Cash Summary</th>
                                                <th>{{ $getPettyCash['petty_cash_summary'] }}</th>
                                            </tr>
                                       
                                    </thead>
                                </table>
                            </div>
                                </div>

                          <br>
                          <br>    
                          <table style="border:1px solid black;">
                          		  <thead>
                                      <tr>
                                        <th style="height: 1%; text-align: center;">DATE</th>
                                        <th style="height: 1%; text-align: center;">ITEM DESCRIPTION</th>
                                        <th style="height: 1%; text-align: center;">AMOUNT</th>
                                       
                                      </tr>
                                    </thead>
                                  <tbody>
                                  	
                                  	 	 @foreach($getPettyCashSummaries as $getPettyCashSummary)
                                        <tr style="border:1px solid black;">
                                         <td style="text-align:center; border: 1px solid black;">{{ $getPettyCashSummary['date'] }}</td>
                                         
                                          <td style="text-align:center; border: 1px solid black;">{{ $getPettyCashSummary['petty_cash_summary'] }}</td>
                                         
                                          <td style="text-align:center; border: 1px solid black;"><?php echo number_format($getPettyCashSummary['amount'], 2);?></td>
                                        </tr> 
                                        @endforeach
                                      
	                                      
	                                       <tr style="border:1px solid black;">
                                           <td style=" text-align:center; border: 1px solid black;"></td>
	                                        <td style=" text-align:center; border: 1px solid black;"><strong>Total</strong></td>
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
                           						{{ $getPettyCash['created_by']}}

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
</div>


