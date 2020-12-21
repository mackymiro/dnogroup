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
               <img  src="{{ asset('images/pdf/lolo-pinoys-lechon-de-cebu(6).png')}}"   alt="Lechon de Cebu">
               <br> 
               <span style="width: 200px;">A Subsidiary of Ribo's Food <br> Corporation</span>   
            </div>
            <div style="float:right; width:500px; margin-right:230px; margin-top:20px;">
               <p style="font-size:16px; text-align: left;">
                Dino Compound
                Ground & 3rd Floors, Dino Group Administration Building,
                No. 88 Labogon Road, Barangay Labogon, Mandaue City, Cebu 6014
                Philippines<br>
                Tel. Nos. (63-32) 346-2567; 420-5639 / Fax No. (63-32) 346-0341<br>

                Email Address: admin@dnogroup.ph / sales@dnogroup.ph / marketing@dnogroup.ph
                 </p>
            </div>
        </div>
        <!--<div style="width:50%; float:right; margin-right:590px; margin-top:20px; ">
            <p style="font-size:12px;">
                <strong>DELIVERY RECEIPT NO</strong><br>
            </p>

        </div>-->
        <div style="clear:both;"></div>
        <hr>
        <h1 style="text-align:center; margin-top:-140px;">DELIVERY RECEIPT</h1>
        <div style="border-style: groove; height: 80px; width:350px; height: 160px;">
        <div style="float:left; width:50%;">
             <table style="position: absolute; width: 360px;">
                <thead>
                    <tr >
                        <th style="font-size:16px; height: 1%; width:35%; ">Sold To: </th>
                        <th style="font-size:16px; height: 1%; ">{{ $deliveryId[0]->sold_to }}</th>
                    </tr>
                    <tr  >
                        <th style="font-size:16px; height: 1%; ">Delivered To: </th>
                        <th style="font-size:16px;">{{ $deliveryId[0]->delivered_to}}</th>
                    </tr>
                  
                     <tr >
                          <th style="font-size:16px; height: 1%; ">Mobile #: </th>
                          <th style="font-size:16px; height: 1%; ">{{ $deliveryId[0]->mobile_num}}</th>
                      </tr>
                    <tr >
                        <th style="font-size:16px; height: 1%; ">Time: </th>
                        <th style="font-size:16px; height: 1%; ">{{ $deliveryId[0]->time }}</th>
                    </tr>
                    <tr >
                          <th style="font-size:16px; height: 1%; ">Special Instruction: </th>
                          <th style="font-size:16px; height: 1%; ">{{ $deliveryId[0]->special_instruction }}</th>
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
                          <th style="font-size:30px; height: 1%; "><span style="color:black;">{{ $deliveryId[0]->lechon_de_cebu_code }}</span></th>
                       </tr>
                     
                      <tr >
                          <th style="font-size:16px; height: 1%; ">Date: </th>
                          <th style="font-size:16px; height: 1%; ">{{ $deliveryId[0]->date }}</th>
                       </tr>
                        <tr >
                          <th style="font-size:16px; height: 1%; ">Date To Be Delivered: </th>
                          <th style="font-size:16px; height: 1%; ">{{ $deliveryId[0]->date_to_be_delivered }}</th>
                       </tr>
                       <tr  > 
                        <th style="font-size:16px; height: 1%; ">Contact Person: </th>
                        <th style="font-size:16px; height: 1%; ">{{ $deliveryId[0]->contact_person }}</th>
                    </tr>
                        
                  </thead>
              </table>
        </div>
        </div>
        <br>
        <br>
        <div style="border-style: groove; height: 80px; width:700px; margin-top:125px;">
        <table style="margin-top:20px;position: absolute;">
                <thead>
                    <tr  style="border:1px solid black;">
                        <th style="font-size:16px; width: 25%">Consignee Name: </th>
                        <th style="font-size:16px;">{{ $deliveryId[0]->consignee_name }}</th>
                    </tr>
                    <tr  style="border:1px solid black;">
                        <th style="font-size:16px">Consignee Contact #: </th>
                         <th style="font-size:16px">{{ $deliveryId[0]->consignee_contact_num }}</th>
                    </tr>
                </thead>
               
          </table>
        </div>
          <br>
          <br>
          <div style="border-style: groove; width: 700px; height: 300px; margin-top: -40px;">
          <table  style="margin-top:20px;">
               <thead>
                  <tr>
                    <th style="height: 1%; text-align: center;" >QTY</th>
                    <th style="height: 1%; text-align: center;" >UNIT</th>
                    <th style="height: 1%; text-align: center;">DESCRIPTION</th>
                    <th style="height: 1%; text-align: center;">PRICE</th>
                  
                  </tr>
                </thead>
                <tbody >
                   <tr style="border:1px solid black;">
                      <td style="text-align:center; font-size:16px; ">{{ $deliveryId[0]->qty}}</td>
                      <td style="text-align:center; font-size:16px; ">{{ $deliveryId[0]->unit}}</td>
                      <td style="text-align:center; font-size:16px; ">{{ $deliveryId[0]->description}}</td>
                      <td style="text-align:center; font-size:16px; "><?php echo number_format($deliveryId[0]->price, 2); ?></td>
                    </tr>
                     @foreach($deliveryReceipts as $deliveryReceipt)
                     <tr style="border:1px solid black;">
                        <td style="text-align:center; font-size:16px; ">{{ $deliveryReceipt['qty']}}</td>
                        <td style="text-align:center; font-size:16px; ">{{ $deliveryReceipt['unit']}}</td>
                        <td style=" text-align:center; font-size:16px; ">{{ $deliveryReceipt['description']}}</td>
                        <td style=" text-align:center; font-size:16px;"><?php echo number_format($deliveryReceipt['price'], 2)?></td>
                     </tr>
                     @endforeach
                </tbody>
          </table>
          <br>
          <br>
          <br>
          <p style="font-size:16px; float:left; margin-left:10px; margin-top:120px;"><strong>Total Kilos: {{ $sumQty }}</strong></p>
          <div style="clear:both; "></div>
          </div>
          
          <div style="border-style: groove; margin-top:-1px;  width:700px; height: 90px;">
          <div style="float:left; width:50%; margin-left: 10px;">
             <table >
                <thead>
                    <tr >
                        <th style="font-size:16px; height: 1%; width: 30%; ">Prepared By:</th>
                        <th style="font-size:16px; height: 1%; ">_____________________</th>
                    </tr>
                    <tr  >
                        <th style="font-size:16px; height: 1%; ">&nbsp;</th>
                        <th style="font-size:16px;">{{ $deliveryId[0]->created_by }}</th>
                    </tr>
                    <tr >
                        <th style="font-size:16px; height: 1%; ">Checked By:</th>
                        <th style="font-size:16px; height: 1%; ">_____________________</th>
                    </tr>
                    <tr  >
                        <th style="font-size:16px; height: 1%; ">&nbsp;</th>
                        <th style="font-size:16px;">Aprilane Q Maturan</th>
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
        <div style="float:left; width:50%; margin-top:-40px; ">
            <p style="font-size: 16px;">MAKE CHECK PAYMENTS PAYABLE TO  <u>RIBO'S FOOD CORPORATION</u></p>
        </div>
        <div style="float:right; width:50%; margin-top:-4px;">
            <p style="font-size: 14px; margin-top:-30px;">Received the above merchandise in good order and condition<br>
            ___________________________<br>
            Print Name and Signature/Date</p>
        </div>
 		</div>
	 </div>
</div>


