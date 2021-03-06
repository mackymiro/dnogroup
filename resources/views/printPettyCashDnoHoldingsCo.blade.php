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
 				<div style="margin-top:-10px;">
                 <img style="margin-left: 5px;" src="{{ asset('images/digitized-logos/dno-holdings-co.png')}}"  alt="DNO Holings & Co">
            	  	 <p  style="margin-top:-50px; margin-left:110px;text-align:left;">
					   Dino Compound
						Ground & 3rd Floors, Dino Group Administration Building,
						No. 88 Labogon Road, Barangay Labogon, Mandaue City, Cebu 6014
						Philippines<br>
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
                                                <th>
                                                    @foreach($getPettyCash[0]->petty_cashes as $pc)
                                                        @if($pc->module_name === "Petty Cash")
                                                        {{ $pc->module_code}}{{ $pc->dno_holdings_code }}</th>
                                         
                                                        @endif
                                                    @endforeach
                                                      </tr>
                                            <tr>
                                                <th>Date</th>
                                                <th>{{ $getPettyCash[0]->date }}</th>
                                            </tr>
                                         
                                      </thead>
                                      
                                  </table>   
                             </div>
                            <div style="float:right; width: 50%; margin-right: 100px;">
                                <table >
                                     <thead>
                                         <tr>
                                                <th width="30%">Petty Cash Name</th>
                                                <th> {{ $getPettyCash[0]->petty_cash_name }} </th>
                                            </tr>
                                            <tr>
                                                <th>Petty Cash Summary</th>
                                                <th>{{ $getPettyCash[0]->petty_cash_summary }}</th>
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
                                        <th style="height: 1%; text-align: center;">PETTY CASH SUMMARY</th>
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
                           						{{ $getPettyCash[0]->created_by}}

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
				</div><!-- end of row -->
 		</div>
	 </div>
</div>


