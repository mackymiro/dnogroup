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
 				 <div style="width:50%; float:left;">
             <div style="float:left;">
               <img  src="{{ asset('images/pdf/lolo-pinoys-lechon-de-cebu(6).png')}}"   alt="Lechon de Cebu">    
            </div>
            <div style="float:right; width:400px; margin-right:230px; margin-top:20px;">
               <p style="font-size:12px; text-align: left;">
                Dino Compound, 3rd Floor Dino Group Administration Bldg., No.88 Labogon Road, Barangay Labogon, Mandaue City, 6014 Cebu, Philippines<br>
                Tel. Nos. (63-32) 346-2567; 420-5639 / Fax No. (63-32) 346-0341<br>

                Email Address: admin@dnogroup.ph / sales@dnogroup.ph / marketing@dnogroup.ph
                 </p>
            </div>
        </div>
        <div style="width:50%; float:right; margin-right:650px; margin-top:20px; ">
            <p style="font-size:12px;">
                <strong>DELIVERY RECEIPT NO</strong><br>
                {{ $deliveryId->dr_no }}
            </p>

        </div>
        <div style="clear:both;"></div>
        <hr>
        <div style="float:left; width:50%">
             <table >
                <thead>
                    <tr >
                        <th style="font-size:16px; height: 1%; ">Sold To</th>
                        <th style="font-size:16px; height: 1%; ">{{ $deliveryId->sold_to }}</th>
                    </tr>
                    <tr  >
                        <th style="font-size:16px; height: 1%; ">Delivered To</th>
                        <th style="font-size:16px;">{{ $deliveryId->delivered_to}}</th>
                    </tr>
                    <tr  > 
                        <th style="font-size:16px; height: 1%; ">Contact Person</th>
                        <th style="font-size:16px; height: 1%; ">{{ $deliveryId->contact_person }}</th>
                    </tr>
                    <tr >
                        <th style="font-size:16px; height: 1%; ">Time</th>
                        <th style="font-size:16px; height: 1%; ">{{ $deliveryId->time }}</th>
                    </tr>
                   
                </thead>
                
            </table>   
        </div>
        <div style="float:right; width: 50%; margin-right: 400px">
           <table>
                  <thead>
                      <tr >
                          <th style="font-size:16px; height: 1%; ">Mobile #</th>
                          <th style="font-size:16px; height: 1%; ">{{ $deliveryId->mobile_num}}</th>
                      </tr>
                      <tr >
                          <th style="font-size:16px; height: 1%; ">Date</th>
                          <th style="font-size:16px; height: 1%; ">{{ $deliveryId->date }}</th>
                       </tr>
                  </thead>
              </table>
        </div>
        <br>
        <br>
         <table style="margin-top:70px;">
                <thead>
                    <tr  style="border:1px solid black;">
                        <th style="font-size:16px">Consignee Name: </th>
                    </tr>
                    <tr  style="border:1px solid black;">
                        <th style="font-size:16px">Consignee Contact #</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border:1px solid black;">
                        <th style="font-size:16px"></th>
                    </tr>
                    <tr  style="border:1px solid black;">
                        <th style="font-size:16px"></th>
                    </tr>
                </tbody>
          </table>
          <br>
          <br>
          <table  style="border:1px solid black;">
               <thead>
                  <tr>
                    <th style="height: 1%; text-align: center;" >QTY</th>
                    <th style="height: 1%; text-align: center;">DESCRIPTION</th>
                    <th style="height: 1%; text-align: center;">PRICE</th>
                  
                  </tr>
                </thead>
                <tbody >
                   <tr style="border:1px solid black;">
                      <td style="text-align:center; font-size:16px; border: 1px solid black;">{{ $deliveryId['qty']}}</td>
                      <td style="text-align:center; font-size:16px; border: 1px solid black;">{{ $deliveryId['description']}}</td>
                      <td style="text-align:center; font-size:16px; border: 1px solid black;"><?php echo number_format($deliveryId['price'], 2); ?></td>
                    </tr>
                     @foreach($deliveryReceipts as $deliveryReceipt)
                     <tr style="border:1px solid black;">
                        <td style="text-align:center; font-size:16px; border: 1px solid black;">{{ $deliveryReceipt['qty']}}</td>
                        <td style=" text-align:center; font-size:16px; border: 1px solid black;">{{ $deliveryReceipt['description']}}</td>
                        <td style=" text-align:center; font-size:16px; border: 1px solid black;"><?php echo number_format($deliveryReceipt['price'], 2)?></td>
                     </tr>
                     @endforeach
                </tbody>
          </table>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <div style="float:left; width:50%">
             <table >
                <thead>
                    <tr >
                        <th style="font-size:16px; height: 1%; ">Prepared By:</th>
                        <th style="font-size:16px; height: 1%; ">{{ $deliveryId['created_by'] }}</th>
                    </tr>
                    <tr  >
                        <th style="font-size:16px; height: 1%; ">Checked By:</th>
                        <th style="font-size:16px;"></th>
                    </tr>
                   
                   
                </thead>
                
            </table>   
        </div>
        <div style="float:right; width: 50%; margin-right: 400px">
           <table>
                  <thead>
                      <tr >
                          <th style="font-size:16px; height: 1%; ">Total</th>
                          <th style="font-size:16px; height: 1%; "><?php echo number_format($sum, 2)?></th>
                      </tr>
                     
                  </thead>
              </table>
        </div>
        <br>
          <br>
          <br>
          <br>
           <div style=" margin-top:270px; float:left; width:50%">
             <table >
                <thead>
                    <tr >
                        <th style="font-size:16px; height: 1%; ">ALL PAYMENTS SHOULD BE MADE IN FAVOR
                        OF LOLO PINOY LECHON DE CEBU</th>
                        
                    </tr>
                   
                   
                </thead>
                
            </table>   
        </div>
        <div style="  margin-top:270px;float:right; width: 50%; margin-right: 400px">
           <table>
                  <thead>
                      <tr >
                          <th style="font-size:16px; height: 1%; ">Received the Above Merchandise In Good
                          Order And Condition</th>
                          
                      </tr>
                      <tr >
                          <th style="font-size:16px; height: 1%; ">_____________________________</th>
                          
                      </tr>
                      <tr >
                          <th style="font-size:16px; height: 1%; ">Printed Name and Signature/Date</th>
                          
                      </tr>
                  </thead>
              </table>
        </div>
 		</div>
	 </div>
</div>


