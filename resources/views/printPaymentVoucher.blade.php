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
               <img style="margin-left:150px;"src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}"   alt="Lechon de Cebu">
                 <p >
            Dino Compound, 3rd Floor Dino Group Administration Bldg., No.88 Labogon Road, Barangay Labogon, Mandaue City, 6014 Cebu, Philippines<br>
            Tel. Nos. (63-32) 346-2567; 420-5639 / Fax No. (63-32) 346-0341<br>

            Email Address: admin@dnogroup.ph / sales@dnogroup.ph / marketing@dnogroup.ph
                 </p>
                 <h4 ><u>PAYMENT VOUCHER</u></h4>
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
                                              <th width="30%">Reference Number</th>
                                              <th>{{ $printPaymentVoucher->reference_number }}</th>
                                          </tr>
                                          <tr>
                                              <th>Paid To</th>
                                              <th>{{ $printPaymentVoucher->paid_to }}</th>
                                          </tr>
                                          <tr>
                                              <th>Account Number</th>
                                              <th>{{ $printPaymentVoucher->account_no }}</th>
                                          </tr>
                                      </thead>
                                      
                                  </table>   
                             </div>
                            <div style="float:right; width: 50%; margin-right: 100px;">
                                <table >
                                     <thead>
                                        <tr>
                                            <th width="30%">Date</th>
                                            <th>{{ $printPaymentVoucher->date }}</th>
                                        </tr>
                                        <tr>
                                            <th>Method Of Payment</th>
                                            <th>{{ $printPaymentVoucher->method_of_payment }}</th>
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
                                    <th style="height: 1%; text-align: center;">Particulars</th>
                                    <th style="height: 1%; text-align: center;">Amount</th>
                                  </tr>
                                </thead>
                                  <tbody>
                                      <tr style="border:1px solid black;">
                                        <td style="text-align:center; border: 1px solid black;">{{ $printPaymentVoucher['particulars']}}</td>
                                        <td style="text-align:center; border: 1px solid black;"><?php echo number_format($printPaymentVoucher['amount'], 2);?></td>
                                      </tr>
                                       @foreach($pVouchers as $pVoucher)
                                        <tr style="border:1px solid black;">
                                            <td style="text-align:center; border: 1px solid black;">{{ $pVoucher['particulars']}}</td>
                                            <td style="text-align:center; border: 1px solid black;"
                                            ><?php echo number_format($pVoucher['amount'], 2);  ?></td>
                                        </tr> 
                                        @endforeach
                                      
                                        
                                         <tr style="border:1px solid black;">
                                          <td style="text-align:center; border: 1px solid black;"><strong>Total</strong></td>
                                          <td style=" text-align:center; border: 1px solid black;"><?php echo number_format($sum, 2)?></td>
                                        </tr>
                                  </tbody>
                          </table>
                           <div style="margin-top:100px;">
                              <table  >
                                <thead>
                                  <tr>
                                  <th style="width:30%;">Prepared By</th>
                                  <th>Approved By</th>
                                  <th>Received By</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>
                                      ________________________<br>
                                      {{ $printPaymentVoucher['created_by']}}

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


