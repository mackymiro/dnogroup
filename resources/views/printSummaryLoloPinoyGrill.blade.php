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
            	 <img style="margin-left: 270px;" src="{{ asset('images/pdf/lolo-pinoy-grill.jpg')}}"   alt="Lolo Pinoy Grill">
            	 	 <p >
		 	 			Dino Compound, 3rd Floor Dino Group Administration Bldg., No.88 Labogon Road, Barangay Labogon, Mandaue City, 6014 Cebu, Philippines<br>
						Tel. Nos. (63-32) 346-2567; 420-5639 / Fax No. (63-32) 346-0341<br>

						Email Address: admin@dnogroup.ph / sales@dnogroup.ph / marketing@dnogroup.ph
            	 	 </p>
	            	 <h4 ><u>SUMMARY REPORT FOR 
                     <?php if($getDateToday): ?>
                            {{ $getDateToday}}
                     <?php elseif($date != ""):?>
                        {{ $date}}
                     <?php endif; ?>
                     </u></h4>
	            </div>
				<div class="row">
					<div class="col-lg-12">
						 <div class="card-body">
				 			<div class="form-group">
                                <h1>Sales Invoice</h1>
                                <table style="border:1px solid black;">
								<thead>
									<tr>
										<th style="height: 1%; text-align: center;">ORDER SLIP NO</th>
										<th style="height: 1%; text-align: center;">SI NO</th>
										<th style="height: 1%; text-align: center;">DATE</th>
                                        <th style="height: 1%; text-align: center;">ORDERED BY</th>
                                        <th style="height: 1%; text-align: center;">AMOUNT</th>
                                        <th style="height: 1%; text-align: center;">CREATED BY</th>
									</tr>
								</thead>
								<tbody>
									@foreach($getAllSalesInvoices as $getAllSalesInvoice)
									<tr style="border:1px solid black;">
                                        <td style="text-align:center; border: 1px solid black;">{{ $getAllSalesInvoice->invoice_number}}</td>
										<td style="text-align:center; border: 1px solid black;">{{ $getAllSalesInvoice->module_code}}{{ $getAllSalesInvoice->lolo_pinoy_grill_code}}</td>
										<td style="text-align:center; border: 1px solid black;">{{ $getAllSalesInvoice->date}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getAllSalesInvoice->ordered_by}}</td>
                                        <td style="text-align:center; border: 1px solid black;"><?php echo number_format($getAllSalesInvoice->amount, 2); ?></td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getAllSalesInvoice->created_by }}</td>
									</tr>
									@endforeach
								</tbody>	
						    </table>
                          <br>
                        <table class="table table-bordered">
                            <thead>
                                <tr  style="border:1px solid black;">
                                    <th width="15%" style="text-align:center; border: 1px solid black;">Total:</th>
                                    <th  style="text-align:center; border: 1px solid black;"><?php echo number_format($totalSalesInvoice, 2);?></th>
                                </tr>
                            </thead>
                        </table>
                        <br>
                        <br>
                        <br>
                        <h1>Delivery Receipt</h1>
                        <table style="border:1px solid black;">
								<thead>
									<tr>
										<th style="height: 1%; text-align: center;">DR NO</th>
										<th style="height: 1%; text-align: center;">DATE</th>
                                        <th style="height: 1%; text-align: center;">AMOUNT</th>
                                        <th style="height: 1%; text-align: center;">CREATED BY</th>
									</tr>
								</thead>
								<tbody>
									 @foreach($getAllDeliveryReceipts as $getAllDeliveryReceipt)
									<tr style="border:1px solid black;">
										<td style="text-align:center; border: 1px solid black;">{{ $getAllDeliveryReceipt->module_code}}{{ $getAllDeliveryReceipt->lolo_pinoy_grill_code}}</td>
										<td style="text-align:center; border: 1px solid black;">{{ $getAllDeliveryReceipt->date}}</td>
                                        <td style="text-align:center; border: 1px solid black;"><?php echo number_format($getAllDeliveryReceipt->amount, 2);?></td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getAllDeliveryReceipt->created_by }}</td>
									</tr>
									@endforeach
								</tbody>	
						    </table>
                            <br>
                            <table class="table table-bordered">
                                <thead>
                                    <tr  style="border:1px solid black;">
                                        <th width="15%" style="text-align:center; border: 1px solid black;">Total:</th>
                                        <th  style="text-align:center; border: 1px solid black;"><?php echo number_format($totalDeliveryReceipt, 2);?></th>
                                    </tr>
                                </thead>
                            </table>
                        <br>
                        <br>
                        <br>
                        <h1>Purchase Order</h1>
                        <table style="border:1px solid black;">
								<thead>
									<tr>
										<th style="height: 1%; text-align: center;">PO NO</th>
										<th style="height: 1%; text-align: center;">DATE</th>
                                        <th style="height: 1%; text-align: center;">PAID TO</th>
                                        <th style="height: 1%; text-align: center;">AMOUNT</th>
                                        <th style="height: 1%; text-align: center;">CREATED BY</th>
									</tr>
								</thead>
								<tbody>
									@foreach($purchaseOrders as $purchaseOrder)
									<tr style="border:1px solid black;">
										<td style="text-align:center; border: 1px solid black;">{{ $purchaseOrder->module_code}}{{ $purchaseOrder->lolo_pinoy_grill_code}}</td>
										<td style="text-align:center; border: 1px solid black;">{{ $purchaseOrder->date}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $purchaseOrder->paid_to}}</td>
                                        <td style="text-align:center; border: 1px solid black;"><?php echo number_format($purchaseOrder->total_price, 2);?></td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $purchaseOrder->created_by }}</td>
									</tr>
									@endforeach
								</tbody>	
						    </table>
                            <br>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="15%" style="text-align:center; border: 1px solid black;">Total:</th>
                                        <th style="text-align:center; border: 1px solid black;"><?php echo number_format($totalPOrder, 2);?></th>
                                    </tr>
                                </thead>
                            </table>
                            <br>
                            <br>
                            <br>
                            <h1>Billing Statement</h1>
                            <table style="border:1px solid black;">
								<thead>
									<tr>
										<th style="height: 1%; text-align: center;">BS NO</th>
										<th style="height: 1%; text-align: center;">DATE</th>
                                        <th style="height: 1%; text-align: center;">BILL TO</th>
                                        <th style="height: 1%; text-align: center;">PERIOD COVERED</th>
                                        <th style="height: 1%; text-align: center;">AMOUNT</th>
                                        <th style="height: 1%; text-align: center;">CREATED BY</th>
									</tr>
								</thead>
								<tbody>
                               
								</tbody>	
						    </table>
                            <br>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="15%"  style="text-align:center; border: 1px solid black;">Total:</th>
                                        <th  style="text-align:center; border: 1px solid black;"><?php //echo number_format($totalBStatement, 2);?></th>
                                    </tr>
                                </thead>
                            </table>
                            <br>
                            <br>
                            <br>
                            <h1>Payment Cash Voucher</h1>
                            <table style="border:1px solid black;">
								<thead>
									<tr>
										<th style="height: 1%; text-align: center;">INVOICE NO</th>
										<th style="height: 1%; text-align: center;">PV NO</th>
                                        <th style="height: 1%; text-align: center;">ISSUED DATE</th>
                                        <th style="height: 1%; text-align: center;">PAID TO</th>
                                        <th style="height: 1%; text-align: center;">AMOUNT</th>
                                        <th style="height: 1%; text-align: center;">STATUS</th>
                                        <th style="height: 1%; text-align: center;">CREATED BY</th>
									</tr>
								</thead>
								<tbody>
                                @foreach($getTransactionListCashes as $getTransactionListCash)
                                <?php $id = $getTransactionListCash->id; ?>
                                <?php
                                    $amount1 = DB::table('lolo_pinoy_grill_commissary_payment_vouchers')
                                                ->select('*')
                                                ->where('id', $id)
                                                ->sum('amount');
                                    
                                    $amount2 = DB::table('lolo_pinoy_grill_commissary_payment_vouchers')
                                                ->select('*')
                                                ->where('pv_id', $id)
                                                ->sum('amount');
                                    $compute = $amount1 + $amount2;
                                ?>
                        
									<tr style="border:1px solid black;">
                                        <td style="text-align:center; border: 1px solid black;">{{ $getTransactionListCash->invoice_number }}</td>
										
										<td style="text-align:center; border: 1px solid black;">{{ $getTransactionListCash->module_code}}{{ $getTransactionListCash->lolo_pinoy_grill_code}}</td>
										<td style="text-align:center; border: 1px solid black;">{{ $getTransactionListCash->issued_date}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getTransactionListCash->paid_to}}</td>
                                        <td style="text-align:center; border: 1px solid black;"><?php echo number_format($compute, 2); ?></td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getTransactionListCash->status }}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getTransactionListCash->created_by }}</td>
									</tr>
									@endforeach
								</tbody>	
						    </table>
                            <br>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="15%"  style="text-align:center; border: 1px solid black;">Total:</th>
                                        <th  style="text-align:center; border: 1px solid black;"><?php echo number_format($totalAmountCash, 2);?></th>
                                    </tr>
                                </thead>
                            </table>
                            <br>
                            <br>
                            <br>
                            <h1>Payment Check Voucher</h1>
                            <table style="border:1px solid black;">
								<thead>
									<tr>
										<th style="height: 1%; text-align: center;">INVOICE NO</th>
										<th style="height: 1%; text-align: center;">PV NO</th>
                                        <th style="height: 1%; text-align: center;">ISSUED DATE</th>
                                        <th style="height: 1%; text-align: center;">PAID TO</th>
                                        <th style="height: 1%; text-align: center;">AMOUNT</th>
                                        <th style="height: 1%; text-align: center;">STATUS</th>
                                        <th style="height: 1%; text-align: center;">CREATED BY</th>
									</tr>
								</thead>
								<tbody>
                                @foreach($getTransactionListChecks as $getTransactionListCheck)
                                <?php $id = $getTransactionListCheck->id; ?>
                                <?php
                                    $amount1 = DB::table('lolo_pinoy_grill_commissary_payment_vouchers')
                                                ->select('*')
                                                ->where('id', $id)
                                                ->sum('amount');
                                    
                                    $amount2 = DB::table('lolo_pinoy_grill_commissary_payment_vouchers')
                                                ->select('*')
                                                ->where('pv_id', $id)
                                                ->sum('amount');
                                    $compute = $amount1 + $amount2;
                                ?>
                        
									<tr style="border:1px solid black;">
                                        <td style="text-align:center; border: 1px solid black;">{{ $getTransactionListCheck->invoice_number }}</td>
										
										<td style="text-align:center; border: 1px solid black;">{{ $getTransactionListCheck->module_code}}{{ $getTransactionListCheck->lolo_pinoy_grill_code}}</td>
										<td style="text-align:center; border: 1px solid black;">{{ $getTransactionListCheck->issued_date}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getTransactionListCheck->paid_to}}</td>
                                        <td style="text-align:center; border: 1px solid black;"><?php echo number_format($compute, 2); ?></td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getTransactionListCheck->status }}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getTransactionListCheck->created_by }}</td>
									</tr>
									@endforeach
								</tbody>	
						    </table>
                            <br>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="15%"  style="text-align:center; border: 1px solid black;">Total:</th>
                                        <th  style="text-align:center; border: 1px solid black;"><?php echo number_format($totalAmountCheck, 2);?></th>
                                    </tr>
                                </thead>
                            </table>
                        
						 </div>
					</div>
				</div>
 		</div>
	 </div>
</div>


