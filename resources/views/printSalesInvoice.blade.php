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
            	 <img style="margin-left: 5px;" src="{{ asset('images/digitized-logos/lolo-pinoy-lechon-de-cebu-pdf-small.png')}}"   alt="Lechon de Cebu">
            	 	 <p style="margin-top:-50px; margin-left:110px;text-align:left;">
					  	Dino Compound
						Ground & 3rd Floors, Dino Group Administration Building,
						No. 88 Labogon Road, Barangay Labogon, Mandaue City, Cebu 6014
						Philippines<br>
						Tel. Nos. (63-32) 346-2567; 420-5639 / Fax No. (63-32) 346-0341<br>

						Email Address: admin@dnogroup.ph / sales@dnogroup.ph / marketing@dnogroup.ph
            	 	 </p>
	            	 <h4 ><u>SALES INVOICE</u></h4>
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
                                                <th width="30%">Oredered By</th>
                                                <th> {{ $printSales[0]->ordered_by }}</th>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <th>{{ $printSales[0]->address }}</th>
                                            </tr>
                                          
                                            <tr>
                                                <th>Date</th>
                                                <th>{{ $printSales[0]->date }}</th>
                                            </tr>
                                        </thead>
                                      
                                  </table>   
                             </div>
	                          <div style="float:right; width: 50%">
	                              <table >
	                                   <thead>
                                            <tr>
                                                <th width="20%">Invoice #</th>
                                                <th>{{ $printSales[0]->invoice_number }}</th>
                                            </tr>
											<tr>
                                                <th width="20%">SI No</th>
                                                <th>{{ $printSales[0]->module_code }}{{ $printSales[0]->lechon_de_cebu_code }}</th>
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
                                        <th style="height: 1%; text-align: center;">QTY</th>
                                        <th style="height: 1%; text-align: center;">TOTAL KLS</th>
                                      
                                        <th style="height: 1%; text-align: center;">ITEM DESCRIPTION</th>
                                         <th style="height: 1%; text-align: center;">UNIT PRICE</th>
                                        <th style="height: 1%; text-align: center;">AMOUNT</th>
                                      </tr>
                                    </thead>
                                  <tbody>
                                  		<tr style="border:1px solid black;">
                                      <td style="text-align:center; border: 1px solid black;">{{ $printSales[0]->qty }}</td>
                                      <td style="text-align:center; border: 1px solid black;">{{ $printSales[0]->total_kls }}</td>
                                      <td style="text-align:center; border: 1px solid black;">{{ $printSales[0]->item_description }}</td>
                                      <td style="text-align:center; border: 1px solid black;">{{ $printSales[0]->unit_price }}</td>
                                      <td style="text-align:center; border: 1px solid black;"><?php echo number_format($printSales[0]->amount, 2); ?></td>
                                  	 	</tr>
                                  	 	 @foreach($salesInvoices as $salesInvoice)
                                        <tr style="border:1px solid black;">
                                          <td style="text-align:center; border: 1px solid black;">{{ $salesInvoice['qty'] }}</td>
                                          <td style="text-align:center; border: 1px solid black;">{{ $salesInvoice['total_kls'] }}</td>
                                          <td style="text-align:center; border: 1px solid black;">{{ $salesInvoice['item_description'] }}</td>
                                          <td style="text-align:center; border: 1px solid black;">{{ $salesInvoice['unit_price'] }}</td>
                                          <td style="text-align:center; border: 1px solid black;"><?php echo number_format($salesInvoice['amount'], 2); ?></td>
                                        </tr> 
                                        @endforeach
                                      
	                                      
	                                       <tr style="border:1px solid black;">
	                                        <td style=" border: 1px solid black;"></td>
	                                        <td style=" border: 1px solid black;"></td>
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
                       						<th>Approved By</th>
                           				</tr>
                           			</thead>
                           			<tbody>
                           				<tr>
                           					<td>
                           						________________________<br>
                           						{{ $printSales[0]->created_by }}

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


