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
                 <img style="margin-left:200px;" src="{{ asset('images/dong-fang-corporation.png')}}" width="277" height="139" class="img-responsive mx-auto d-block" alt="DNO Personal">
	            	 
                 	 <p >
		 	 			Dino Compound, 3rd Floor Dino Group Administration Bldg., No.88 Labogon Road, Barangay Labogon, Mandaue City, 6014 Cebu, Philippines<br>
						Tel. Nos. (63-32) 346-2567; 420-5639 / Fax No. (63-32) 346-0341<br>

						Email Address: admin@dnogroup.ph / sales@dnogroup.ph / marketing@dnogroup.ph
            	 	 </p>
	            	<h4><u>SUPPLIER NAME</u><br>
                    {{ $viewSupplier[0]->supplier_name }}</h4>
	            </div>
				<div class="row">
					<div class="col-lg-12">
						 <div class="card-body">

						  <table style="border:1px solid black;">
								<thead>
									<tr>
										<th style="height: 1%; text-align: center;">INVOICE #</th>
										<th style="height: 1%; text-align: center;">PAID TO </th>
										<th style="height: 1%; text-align: center;">PROPERTY</th>
                                        <th style="height: 1%; text-align: center;">ISSUED DATE</th>
                                        <th style="height: 1%; text-align: center;">STATUS</th>
                                        <th style="height: 1%; text-align: center;">AMOUNT</th>
                                        <th style="height: 1%; text-align: center;">CREATED BY</th>
									</tr>
								</thead>
								<tbody>
									@foreach($printSuppliers as $printSupplier)
									<tr style="border:1px solid black;">
										<td style="text-align:center; border: 1px solid black;">{{ $printSupplier->invoice_number}}</td>
										<td style="text-align:center; border: 1px solid black;">{{ $printSupplier->paid_to}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $printSupplier->supplier_name}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $printSupplier->issued_date}}</td>
                                        <td style="text-align:center; border: 1px solid black;">
                                             <?php if($printSupplier->status === "FOR APPROVAL"): ?>
                                                UNPAID
                                            <?php elseif($printSupplier->status === "FOR CONFIRMATION"): ?>
                                                UNPAID
                                            <?php elseif($printSupplier->status === "FULLY PAID AND RELEASED"): ?>
                                                PAID
                                            <?php else: ?>
                                                UNPAID
                                            <?php endif;?>
                                        </td>
                                        <td style="text-align:center; border: 1px solid black;"><?php echo number_format($printSupplier->amount_due, 2);?></td>
										
										<td style="text-align:center; border: 1px solid black; ">{{ $printSupplier->created_by}}</td>
									</tr>
									@endforeach
								</tbody>
						  </table>
                          <br>
                        
						  <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="15%"  style="text-align:center; border: 1px solid black;">Remaining Balance:</th>
                                        <th  style="text-align:center; border: 1px solid black;"><?php echo number_format($totalAmountDue, 2);?></th>
                                    </tr>
                                </thead>
                             
                            </table>
                            <br>
                           <div style="margin-top:70px;">
                           		<table  >
                           			<thead>
                           				<tr>
                       						<th style="width:30%;">Prepared By</th>
											<th>Checked By</th>
                       						<th>Approved By</th>
											<th>Date</th>
                           				</tr>
                           			</thead>
                           			<tbody>
                           				<tr>
                           					<td>
                           						________________________<br>
                           						{{ $printSuppliers[0]->created_by}}

                           					</td>
											<td>
                           						________________________<br>
                           						Aprilane Q Maturan<br>
                           						Finance Officer
                           					</td>
                           					<td>
                           						________________________<br>
                           						
                           					</td>
											<td>
												________________________
											</td>
                           					
                           				</tr>
                           			</tbody>
                           		</table>
                           	
                           </div>
						   <div style="margin-top:100px;">
                           		<table  >
                           			<thead>
                           				<tr>
                       						<th style="width:30%;">Received By</th>
										
                           				</tr>
                           			</thead>
                           			<tbody>
                           				<tr>
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


