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
 		<div class="container-fluid"">
 				 <div style="width:50%; float:left;">
             <div style="float:left;">
               <img  src="{{ asset('images/pdf/mr-potato.png')}}"   alt="Mr Potato">    
               <br>
               <span style="width: 200px;">A Subsidiary of Ribo's Food <br> Corporation</span> 
            </div>
            <div style="float:right; width:500px; margin-right:230px; margin-top:50px;">
               <p style="font-size:12px; text-align: left;">
                Dino Compound, 3rd Floor Dino Group Administration Bldg., No.88 Labogon Road, Barangay Labogon, Mandaue City, 6014 Cebu, Philippines<br>
                Tel. Nos. (63-32) 346-2567; 420-5639 / Fax No. (63-32) 346-0341<br>

                Email Address: admin@dnogroup.ph / sales@dnogroup.ph / marketing@dnogroup.ph
                 </p>
            </div>
        </div>
      
        <div style="clear:both;"></div>
        <hr>
        <div style="border-style: groove; height: 80px; width:350px; height: 160px;">
        <div style="float:left; width:50%;">
             <table style="position: absolute; width: 360px;">
                <thead>
                    <tr  >
                        <th width="25%" style="font-size:16px; height: 1%; ">Delivered To: </th>
                        <th style="font-size:16px;">{{ $deliveryId[0]->delivered_to}}</th>
                    </tr>
                    <tr  > 
                        <th style="font-size:16px; height: 1%; ">Address: </th>
                        <th style="font-size:16px; height: 1%; ">{{ $deliveryId[0]->address }}</th>
                    </tr>
                   
                   
                </thead>
                
            </table>   
        </div>
        </div>
        <div style="border-style: groove; width:350px; height: 160px; margin-top: -170px; float:right; margin-right: 20px;">
        <div style="float:right; width: 50%;  ">
           <table style="position: absolute; width: 480px;  margin-left:-170px;">
                  <thead>
                     <tr >
                          <th style="font-size:16px; height: 1%; width: 25%;">DR No: </th>
                          <th style="font-size:16px; height: 1%; ">{{ $deliveryId[0]->module_code}}{{ $deliveryId[0]->mr_potato_code}}</th>
                       </tr>
                     
                      <tr >
                          <th style="font-size:16px; height: 1%; ">Date: </th>
                          <th style="font-size:16px; height: 1%; ">{{ $deliveryId[0]->date }}</th>
                       </tr>
                        
                  </thead>
              </table>
        </div>
        </div>
        <br>
        <br>
          <div style="border-style: groove; width: 700px; height: 300px; margin-top: 125px;">
          <table  style="margin-top:20px;">
               <thead>
                  <tr>
                    <th style="height: 1%; text-align: center;" >PRODUCT ID</th>
                    <th style="height: 1%; text-align: center;">QTY</th>
                    <th style="height: 1%; text-align: center;">UNIT</th>
                    <th style="height: 1%; text-align: center;">ITEM DESCRIPTION</th>
                    <th style="height: 1%; text-align: center;">UNIT PRICE</th>
                    <th style="height: 1%; text-align: center;">AMOUNT</th>
                  </tr>
                </thead>
                <tbody >
                   <tr style="border:1px solid black;">
                      <td style="text-align:center; font-size:16px; ">{{ $deliveryId[0]->product_id}}</td>
                      <td style="text-align:center; font-size:16px; ">{{ $deliveryId[0]->qty}}</td>
                      <td style="text-align:center; font-size:16px; ">{{ $deliveryId[0]->unit}}</td>
                      <td style="text-align:center; font-size:16px; ">{{ $deliveryId[0]->item_description}}</td>
                      <td style="text-align:center; font-size:16px; ">{{ $deliveryId[0]->unit_price}}</td>
                      <td style="text-align:center; font-size:16px; "><?php echo number_format($deliveryId[0]->amount, 2); ?></td>
                    </tr>
                     @foreach($deliveryReceipts as $deliveryReceipt)
                     <tr style="border:1px solid black;">
                        <td style="text-align:center; font-size:16px; ">{{ $deliveryReceipt['product_id']}}</td>
                        <td style="text-align:center; font-size:16px; ">{{ $deliveryReceipt['qty']}}</td>
                        <td style="text-align:center; font-size:16px; ">{{ $deliveryReceipt['unit']}}</td>
                        <td style="text-align:center; font-size:16px; ">{{ $deliveryReceipt['item_description']}}</td>
                        <td style="text-align:center; font-size:16px; ">{{ $deliveryReceipt['unit_price']}}</td>
                        <td style="text-align:center; font-size:16px; "><?php echo number_format($deliveryReceipt['amount'], 2); ?></td>
                     </tr>
                     @endforeach
                </tbody>
          </table>
          </div>
          
          <div style="border-style: groove; margin-top:-1px;  width:700px; height: 50px;">
          <div style="float:left; width:50%; margin-left: 10px;">
             <table >
                <thead>
                    <tr >
                        <th style="font-size:16px; height: 1%; width: 30%; ">Prepared By:</th>
                        <th style="font-size:16px; height: 1%; ">{{ $deliveryId[0]->created_by }}</th>
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
      </div>
        <br>
          <br>
          <br>
        <br>
        <div style="float:left; width:50%; margin-top:10px; ">
            <p style="font-size: 16px;">MAKE CHECK PAYMENTS PAYABLE TO  <u>RIBO'S FOOD CORPORATION</u></p>
        </div>
        <div style="float:right; width:50%;">
            <p style="font-size: 16px;">Received the above merchandise in good order and condition<br>
            ___________________________<br>
            Print Name and Signature/Date</p>
        </div>
 		</div>
	 </div>
</div>


