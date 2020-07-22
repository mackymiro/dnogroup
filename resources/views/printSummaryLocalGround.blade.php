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
                 <img style="margin-left: 170px;" src="{{ asset('images/digitized-logos/local-ground.png')}}"  width="366" height="178" alt="Local Ground">
            	
            	 
            	 	 <p >
		 	 			Dino Compound, 3rd Floor Dino Group Administration Bldg., No.88 Labogon Road, Barangay Labogon, Mandaue City, 6014 Cebu, Philippines<br>
						Tel. Nos. (63-32) 346-2567; 420-5639 / Fax No. (63-32) 346-0341<br>

						Email Address: admin@dnogroup.ph / sales@dnogroup.ph / marketing@dnogroup.ph
            	 	 </p>
	            	 <h4 ><u>SUMMARY REPORT FOR 
                     <?php if($uri0 != "" || $uri1 != ""): ?>
                        {{ $uri0 }} To {{ $uri1 }}
                     <?php else: ?>
                        <?php if($getDateToday): ?>
                                {{ $getDateToday}}
                        <?php elseif($date != ""):?>
                            {{ $date}}
                        <?php endif; ?>
                    <?php endif; ?>
                     </u></h4>
	            </div>
				<div class="row">
					<div class="col-lg-12">
						 <div class="card-body">
				 			<div class="form-group">
                            <h1>Payment Cash Voucher</h1>
                            <table style="border:1px solid black;">
								<thead>
									<tr>
										<th style="height: 1%; text-align: center;">INVOICE NO</th>
										<th style="height: 1%; text-align: center;">PV NO</th>
                                        <th style="height: 1%; text-align: center;">ISSUED DATE</th>
                                        <th style="height: 1%; text-align: center;">PAID TO</th>
                                        <th style="height: 1%; text-align: center; width:130px;">Account Name/No</th>
                                        <th style="height: 1%; text-align: center;">BANK NAME/CHECK NO</th>
                                        <th style="height: 1%; text-align: center;">STATUS</th>
                                        <th style="height: 1%; text-align: center;">CREATED BY</th>
									</tr>
								</thead>
								<tbody>
                                @foreach($getTransactionListCashes as $getTransactionListCash)
                                <?php $id = $getTransactionListCash->id; ?>
                                <?php
                                    $amount1 = DB::table('local_ground_payment_vouchers')
                                                ->select('*')
                                                ->where('id', $id)
                                                ->sum('amount');
                                    
                                    $amount2 = DB::table('local_ground_payment_vouchers')
                                                ->select('*')
                                                ->where('pv_id', $id)
                                                ->sum('amount');
                                    $compute = $amount1 + $amount2;

                                        //get the check account no
                                    $getChecks = DB::table('local_ground_payment_vouchers')
                                        ->select('*')
                                        ->where('pv_id', $id)
                                        ->get()->toArray();
                                ?>
                        
									<tr style="border:1px solid black;">
                                        <td style="text-align:center; border: 1px solid black;">{{ $getTransactionListCash->invoice_number }}</td>
										
										<td style="text-align:center; border: 1px solid black;">{{ $getTransactionListCash->module_code}}{{ $getTransactionListCash->local_ground_code}}</td>
										<td style="text-align:center; border: 1px solid black;">{{ $getTransactionListCash->issued_date}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getTransactionListCash->paid_to}}</td>
                                        <td style="text-align:center; border: 1px solid black; width:130px;">
                                            <?php foreach($getChecks as $getCheck): ?>
                                                        <?php echo $getCheck->account_name_no; ?>
                                            <?php endforeach; ?>
                                        </td>
                                        <td style="text-align:center; border: 1px solid black;">
                                            <?php foreach($getChecks as $getCheck): ?>
                                                <?php echo $getCheck->cheque_number; ?>
                                            <?php endforeach; ?>
                                        </td>
                                        <td style="text-align:center; border: 1px solid black;"><?php echo number_format($getTransactionListCheck->cheque_total_amount, 2); ?></td>
                                    
                                      
                                        <td style="text-align:center; border: 1px solid black;">
                                            @if($getTransactionListCheck->status === "FULLY PAID AND RELEASED")
                                             <p >0</p>
                                             @else
                                            <?php echo number_format($compute, 2); ?>
                                            @endif 
                                        </td>
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
                                        <th  style="text-align:center; border: 1px solid black;"><?php echo number_format($totalAmountCashes, 2);?></th>
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
										 <th style="height: 1%; text-align: center; border: 1px solid black;">INVOICE NO</th>
										<th style="height: 1%; text-align: center; border: 1px solid black;">PV NO</th>
                                        <th style="height: 1%; text-align: center; border: 1px solid black;">ISSUED DATE</th>
                                        <th style="height: 1%; text-align: center; border: 1px solid black;">PAID TO</th>
                                        <th style="height: 1%; text-align: center; border: 1px solid black; width:130px;">Account Name/No</th>
                                        <th style="height: 1%; text-align: center; border: 1px solid black;">BANK NAME/CHECK NO</th>
                                        <th style="height: 1%; text-align: center; border: 1px solid black;">CURRENCY</th>
                                        <th style="height: 1%; text-align: center; border: 1px solid black;">PAID AMOUNT</th>
                                        <th style="height: 1%; text-align: center; border: 1px solid black;">BALANCE</th>
                                        <th style="height: 1%; text-align: center; border: 1px solid black;">STATUS</th>
                                        <th style="height: 1%; text-align: center; border: 1px solid black;">CREATED BY</th>
									</tr>
								</thead>
								<tbody>
                                @foreach($getTransactionListChecks as $getTransactionListCheck)
                                <?php $id = $getTransactionListCheck->id; ?>
                                <?php
                                     $amount1 = DB::table('local_ground_payment_vouchers')
                                     ->select('*')
                                     ->where('id', $id)
                                     ->sum('amount');
                         
                                    $amount2 = DB::table('local_ground_payment_vouchers')
                                                ->select('*')
                                                ->where('pv_id', $id)
                                                ->sum('amount');
                                    $compute = $amount1 + $amount2;

                                       //get the check account no
                                    $getChecks = DB::table('local_ground_payment_vouchers')
                                                ->select('*')
                                                ->where('pv_id', $id)
                                                ->get()->toArray();
                                   
                                ?>
                        
									<tr style="border:1px solid black;">
                                        <td style="text-align:center; border: 1px solid black;">{{ $getTransactionListCheck->invoice_number }}</td>
										
										<td style="text-align:center; border: 1px solid black;">{{ $getTransactionListCheck->module_code}}{{ $getTransactionListCheck->local_ground_code}}</td>
										<td style="text-align:center; border: 1px solid black;">{{ $getTransactionListCheck->issued_date}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getTransactionListCheck->paid_to}}</td>
                                        <td style="text-align:center; border: 1px solid black; width:130px;">
                                            <?php foreach($getChecks as $getCheck): ?>
                                                        <?php echo $getCheck->account_name_no; ?>
                                            <?php endforeach; ?>
                                        </td>
                                        <td style="text-align:center; border: 1px solid black;">
                                            <?php foreach($getChecks as $getCheck): ?>
                                                <?php echo $getCheck->cheque_number; ?>
                                            <?php endforeach; ?>
                                        </td>
                                        <td style="text-align:center; border: 1px solid black; font-size:10px;">{{ $getTransactionListCheck->currency }}</td>
                                      
                                        <td style="text-align:center; border: 1px solid black;"><?php echo number_format($getTransactionListCheck->cheque_total_amount, 2); ?></td>
                                      
                                    
                                        <td style="text-align:center; border: 1px solid black;">
                                             @if($getTransactionListCheck->status === "FULLY PAID AND RELEASED")
                                             <p >0</p>
                                             @else
                                            <?php echo number_format($compute, 2); ?>
                                            @endif
                                        </td>
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
                                        <th width="15%"  style="text-align:center; border: 1px solid black;">Remaining Balance:</th>
                                        <th  style="text-align:center; border: 1px solid black;"><?php echo number_format($totalAmountCheck, 2);?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                      <tr>
                                        <th width="15%"  style="text-align:center; border: 1px solid black;">Total Paid Amount:</th>
                                        <th  style="text-align:center; border: 1px solid black;"><?php echo number_format($totalPaidAmountCheck, 2);?></th>
                                    </tr>
                                    <tr>
                                        <th width="15%"  style="text-align:center; border: 1px solid black;">Remaining Balance (USD):</th>
                                        <th  style="text-align:center; border: 1px solid black;"><?php echo number_format($totalAmountCheckInUSD, 2);?></th>
                                    </tr>
                                    <tr>
                                        <th width="15%"  style="text-align:center; border: 1px solid black;">Total Paid Amount (USD):</th>
                                        <th  style="text-align:center; border: 1px solid black;"><?php echo number_format($totalPaidAmountCheckInUSD, 2);?></th>
                                    </tr>
                                </tbody>
                            </table>
                        
						 </div>
					</div>
				</div>
 		</div>
	 </div>
</div>


