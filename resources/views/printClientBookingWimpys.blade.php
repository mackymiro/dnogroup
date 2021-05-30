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
                 <img style="margin-left:5px;" src="{{ asset('images/digitized-logos/wimpys-logo1.png')}}"  alt="Wimpy's Food Express">
            	  	 <p style="margin-top:-50px; margin-left:160px;text-align:left;">
		 	 			Dino Compound, 3rd Floor Dino Group Administration Bldg., No.88 Labogon Road, Barangay Labogon, Mandaue City, 6014 Cebu, Philippines<br>
						Tel. Nos. (63-32) 346-2567; 420-5639 / Fax No. (63-32) 346-0341<br>

						Email Address: admin@dnogroup.ph / sales@dnogroup.ph / marketing@dnogroup.ph
            	 	 </p>
	            	 <h4 ><u>CLIENT BOOKING FORM</u></h4>
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
                                                <th width="20%">Date of Event</th>
                                                <th>{{ $printCB[0]->date_of_event }}</th>
                                            </tr>
                                            <tr>
                                                <th>Time of Event</th>
                                                <th>{{ $printCB[0]->time_of_event }}</th>
                                            </tr>
                                            <tr>
                                                <th>No of People</th>
                                                <th>{{ $printCB[0]->no_of_people }}</th>
                                            </tr>
                                            <tr>
                                                <th>Motiff</th>
                                                <th>{{ $printCB[0]->motiff }}</th>
                                            </tr>
                                            <tr>
                                                <th>Type of Package</th>
                                                <th>{{ $printCB[0]->type_of_package }}</th>
                                            </tr>
                                            <tr>
                                                <th>Place of Event</th>
                                                <th>{{ $printCB[0]->place_of_event }}</th>
                                            </tr>
                                        </thead>
                                      
                                  </table>   
                             </div>
	                          <div style="float:right; width: 50%">
	                              <table >
	                                   <thead>
                                             <tr>
                                                <th width="20%">Client Booking No</th>
                                                <th>
                                                   @foreach($printCB[0]->client_bookings as $clientBooking)
                                                        @if($clientBooking->module_name === "Client Booking")          
                                                            {{ $clientBooking->module_code }} {{ $clientBooking->wimpys_food_express_code}}
                                                        @endif
                                                    @endforeach
                                                </th>
                                            </tr>
                                            <tr>
                                                <th width="20%">CBF No</th>
                                                <th>
                                                   @foreach($printCB[0]->client_bookings as $clientBooking)
                                                        @if($clientBooking->module_name === "Client Booking")          
                                                            {{ $clientBooking->cbf_no }}                                                        @endif
                                                    @endforeach
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Client</th>
                                                <th> {{ $printCB[0]->client }}</th>
                                            </tr>
                                          
                                            <tr>
                                                <th>Mobile Number</th>
                                                <th>{{ $printCB[0]->mobile_number }}</th>
                                            </tr>
                                            <tr>
                                                <th>Email Address</th>
                                                <th>{{ $printCB[0]->email }}</th>
                                            </tr>
                                            <tr>
                                                <th>Special Requests</th>
                                                <th>{{ $printCB[0]->special_requests }}</th>
                                            </tr>
                                            <tr>
                                                <th>Total Amount</th>
                                                <th><?= number_format( $printCB[0]->total, 2) ?></th>
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
                          @if($printCB[0]->type_of_package != "Cooking Charge - 0.00" && $printCB[0]->type_of_package != "Staff Meals - 0.00")
                          <table style="border:1px solid black;">
                          		  <thead>
	                                  <tr>
	                                   <th   colspan="2" style="height: 1%; text-align: center;" >MENU</th>
                                    
	                                  
	                                  </tr>
                                  </thead>
                                  <tbody>
                                  		<tr style="border:1px solid black;">
	                                  	 
                                            <th style="text-align:center; border: 1px solid black; width:20%">Soup</th>
                                            <td style="text-align:center; border: 1px solid black;">
                                                @foreach($getMenuItems as $getMenuItem)
                                                @if($getMenuItem['menu_cat'] === "Soup")
                                                <p >{{ $getMenuItem['menu']}} </p>
                                                @endif
                                                @endforeach
                                            </td>

                                        </tr>
                                        <tr style="border:1px solid black;">
	                                  	 
                                            <th style="text-align:center; border: 1px solid black; width:20%">Salad</th>
                                            <td style="text-align:center; border: 1px solid black;">
                                                @foreach($getMenuItems as $getMenuItem)
                                                @if($getMenuItem['menu_cat'] === "Salad")
                                                <p >{{ $getMenuItem['menu']}} </p>
                                                @endif
                                                @endforeach
                                            </td>

                                        </tr>
                                        <tr style="border:1px solid black;">
	                                  	 
                                           <th style="text-align:center; border: 1px solid black; width:20%">Entrees</th>
                                           <td style="text-align:center; border: 1px solid black;">
                                               @foreach($getMenuItems as $getMenuItem)
                                               @if($getMenuItem['menu_cat'] === "Entrees")
                                               <p >{{ $getMenuItem['menu']}} </p>
                                               @endif
                                               @endforeach
                                           </td>

                                       </tr>
                                       <tr style="border:1px solid black;">
	                                  	 
                                           <th style="text-align:center; border: 1px solid black; width:20%">Vegetables</th>
                                           <td style="text-align:center; border: 1px solid black;">
                                               @foreach($getMenuItems as $getMenuItem)
                                               @if($getMenuItem['menu_cat'] === "Vegetables")
                                               <p >{{ $getMenuItem['menu']}} </p>
                                               @endif
                                               @endforeach
                                           </td>

                                       </tr>
                                       <tr style="border:1px solid black;">
	                                  	 
                                           <th style="text-align:center; border: 1px solid black; width:20%">Noodles</th>
                                           <td style="text-align:center; border: 1px solid black;">
                                               @foreach($getMenuItems as $getMenuItem)
                                               @if($getMenuItem['menu_cat'] === "Noodles")
                                               <p >{{ $getMenuItem['menu']}} </p>
                                               @endif
                                               @endforeach
                                           </td>

                                       </tr>
                                       <tr style="border:1px solid black;">
	                                  	 
                                           <th style="text-align:center; border: 1px solid black; width:20%">Rice</th>
                                           <td style="text-align:center; border: 1px solid black;">
                                               @foreach($getMenuItems as $getMenuItem)
                                               @if($getMenuItem['menu_cat'] === "Rice")
                                               <p >{{ $getMenuItem['menu']}} </p>
                                               @endif
                                               @endforeach
                                           </td>

                                       </tr>
                                       <tr style="border:1px solid black;">
	                                  	 
                                           <th style="text-align:center; border: 1px solid black; width:20%">Dessert</th>
                                           <td style="text-align:center; border: 1px solid black;">
                                               @foreach($getMenuItems as $getMenuItem)
                                               @if($getMenuItem['menu_cat'] === "Dessert")
                                               <p >{{ $getMenuItem['menu']}} </p>
                                               @endif
                                               @endforeach
                                           </td>

                                       </tr>
                                       <tr style="border:1px solid black;">
	                                  	 
                                           <th style="text-align:center; border: 1px solid black; width:20%">Drinks</th>
                                           <td style="text-align:center; border: 1px solid black;">
                                               @foreach($getMenuItems as $getMenuItem)
                                               @if($getMenuItem['menu_cat'] === "Drinks")
                                               <p >{{ $getMenuItem['menu']}} </p>
                                               @endif
                                               @endforeach
                                           </td>

                                       </tr>
                                       <tr style="border:1px solid black;">
	                                  	 
                                           <th style="text-align:center; border: 1px solid black; width:20%">Additional Orders</th>
                                           <td style="text-align:center; border: 1px solid black;">
                                               @foreach($getMenuItems as $getMenuItem)
                                               @if($getMenuItem['menu_cat'] === "Additional Order")
                                               <p >{{ $getMenuItem['menu']}}, Qty - {{ $getMenuItem['qty']}}, Amount - {{ $getMenuItem['amount']}} </p>
                                               @endif
                                               @endforeach
                                           </td>

                                       </tr>
	                                   
                                  </tbody>
                          </table>
                          @endif
                          @if($printCB[0]->type_of_package === "Cooking Charge - 0.00" || $printCB[0]->type_of_package === "Staff Meals - 0.00")
                            <table style="border:1px solid black;">
                          		  <thead>
	                                  <tr style="border:1px solid black;">
	                                   <th style="text-align:center; border: 1px solid black;" >Qty</th>
                                       <th style="text-align:center; border: 1px solid black;">Item</th>
                                       <th style="text-align:center; border: 1px solid black;">Amount</th>
	                                  </tr>
                                  </thead>
                                  <tbody>
                                   @foreach($getMenuItems as $getMenuItem)
                                     <tr style="border:1px solid black;">
                                        <td style="text-align:center; border: 1px solid black;">{{ $getMenuItem['qty']}}</td>
                                        <td style="text-align:center; border: 1px solid black;">{{ $getMenuItem['item']}}</td>
                                        <td style="text-align:center; border: 1px solid black;">
                                            {{ $getMenuItem['amount'] }}

                                        </td>

                                       </tr>
                                       @endforeach
                                  </tbody>

                            </table>
                            <br>
                            <br>
                            <table style="border:1px solid black;">
                                   <thead>
	                                  <tr style="border:1px solid black;">
	                                   <th width="25%" style="text-align:center; border: 1px solid black;" >Total</th>
                                       <th style="text-align:right; border: 1px solid black;"></th>
                                       <th style="text-align:right; border: 1px solid black;" >
                                            <?= number_format($printCB[0]->total, 2)?>
                                       </th>
	                                  </tr>
                                      <tr style="border:1px solid black;">
	                                   <th width="25%" style="text-align:center; border: 1px solid black;" >Less</th>
                                       <th style="text-align:right; border: 1px solid black;">{{ $printCB[0]->description }}</th>
                                       <th style="text-align:right; border: 1px solid black;" >
                                       
                                        <?= number_format($printCB[0]->less, 2)?>
                                       </th>
                                    
	                                  </tr>
                                      <tr style="border:1px solid black;">
                                        <?php
                                            $total = $printCB[0]->total - $printCB[0]->less;
                                          ?>
                                       <th width="25%" style="text-align:center; border: 1px solid black;" >Balance</th>
                                       <th style="text-align:right; border: 1px solid black;"></th>
                                       <th style="text-align:right; border: 1px solid black;" >
                                          <?= number_format($total, 2) ?>
                                       </th>
                                    
	                                  </tr>
                                  </thead>
                            </table>
                            @endif
                            <br>
                            <br>
                            <br>
                            <br>
                            <table  >
                           			<thead>
                           				<tr>
                       						<th style="width:30%;">Prepared By</th>
                                            <th style="width:30%;">Checked By</th>
                                            <th style="width:30%;">Conformed By</th>
                           				</tr>
                           			</thead>
                           			<tbody>
                           				<tr>
                           					<td>
                           						________________________<br>
                           						{{ $printCB[0]->created_by}}

                           					</td>
                                               <td>
                           						________________________<br>
                           					    Antonia Cara S. Osmeña	

                           					</td>
                           					<td>
                           						________________________<br>
                           						{{ $printCB[0]->client }}
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


