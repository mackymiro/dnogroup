@extends('layouts.dno-food-ventures-app')
@section('title', 'Delivery Receipt Lists| ')
@section('content')

<div id="wrapper">
	 @include('sidebar.sidebar-dno-food-ventures')
	 <div id="content-wrapper">
	 	<div class="container-fluid">
 			 <!-- Breadcrumbs-->
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">DNO Food Ventures</a>
                </li>
                <li class="breadcrumb-item active">Delivery Receipt All Lists</li>
              </ol>
              <div class="row">
              		<div class="col-lg-12">
              			<div class="card mb-3">
              				<div class="card-header">
	    					  <i class="fa fa-receipt" aria-hidden="true"></i>
	    					  All Lists</div>
    					  	<div class="card-body">
					  			<div class="table-responsive">
					  				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					  					<thead>
					  						
				  							<th>Action</th>
											<th>Date</th>
				  							<th>DR No</th>
				  							<th>Delivered To</th>
				  							<th>Address</th>
				  							<th>Product Id</th>
				  							<th>Qty</th>
				  							<th>Unit</th>
				  							<th>Item Description</th>
				  							<th>Unit Price</th>
				  							<th>Amount</th>
					  						<th>Created By</th>
					  					</thead>
					  					<tfoot>
					  						<th>Action</th>
											<th>Date</th>
				  							<th>DR No</th>
				  							<th>Delivered To</th>
				  							<th>Address</th>
				  							<th>Product Id</th>
				  							<th>Qty</th>
				  							<th>Unit</th>
				  							<th>Item Description</th>
				  							<th>Unit Price</th>
				  							<th>Amount</th>
				  							<th>Created By</th>
					  					</tfoot>
					  					<tbody>
				  							@foreach($getAllDeliveryReceipts as $getAllDeliveryReceipt)
					  						<tr id="deletedId{{ $getAllDeliveryReceipt->id }}">
					  							<td>
			               						 @if(Auth::user()['role_type'] !== 3)
			  										<a href="/dno-food-ventures/{{$getAllDeliveryReceipt->id}}/edit-dno-food-ventures" title="Edit"><i class="fas fa-pencil-alt"></i></a>
			               						 @endif
			              						@if(Auth::user()['role_type'] == 1)
					  								<a id="delete" onClick="confirmDelete('{{ $getAllDeliveryReceipt->id}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
			              						@endif
									  				<a href="/dno-food-ventures/{{ $getAllDeliveryReceipt->id }}/view-dno-food-ventures-delivery-receipt" title="View"><i class="fas fa-low-vision"></i></a>
						                         
			  									</td>
					  						
					  							<td>{{ $getAllDeliveryReceipt->date}}</td>
												<td>
													@foreach($getAllDeliveryReceipt->delivery_receipts as $receipt)
														@if($receipt->module_name === "Delivery Receipt")
														{{ $receipt->module_code}}{{ $receipt->dno_food_venture_code}}
														@endif
													@endforeach
												</td>
					  							<td><p style="width:180px;">{{ $getAllDeliveryReceipt->delivered_to}}</p></td>
					  							<td>{{ $getAllDeliveryReceipt->address}}</td>
					  							<td>
					  								<?php
                                                        $prodArr = $getAllDeliveryReceipt->product_id;
                                                        $prodExp = explode("-", $prodArr);
                                                        
                                                    ?>
					  								<p style="width:180px;">{{ $prodExp[1] }}</p>
				  									
				  								</td>
					  							<td>{{ $getAllDeliveryReceipt->qty}}</td>
					  							<td>{{ $getAllDeliveryReceipt->unit}}</td>
					  							<td>{{ $getAllDeliveryReceipt->item_description}}</td>
					  							<td><?php echo number_format($getAllDeliveryReceipt->unit_price, 2)?></td>
					  							<td><?php echo number_format($getAllDeliveryReceipt->amount, 2)?></td>
					  							<td>{{ $getAllDeliveryReceipt->created_by}}</td>
					  						</tr>
					  						@endforeach
					  					</tbody>
					  				</table>
					  			</div>
    					  	</div>
              			</div>	
              		</div>
              </div>
			 	
	 	</div>
	 </div>
	  <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Ribos Food Corporation 2019</span>
            <br>
            <br>
            <span>Made with ❤️ at <a href="https://cebucodesolutions.com" target="_blank">Cebu Code Solutions</a></span>
          </div>
        </div>
      </footer>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript">

	const confirmDelete = (id) =>{
        var x = confirm("Do you want to delete this?");
        if(x){
            $.ajax({
              type: "DELETE",
              url: '/dno-food-ventures/delete/DR/' + id,
              data:{
                _method: 'delete', 
                "_token": "{{ csrf_token() }}",
                "id": id
              },
              success: function(data){
                console.log(data);
                $("#deletedId"+id).fadeOut('slow');
               
              },
              error: function(data){
                console.log('Error:', data);
              }

            });

        }else{
            return false;
        }
    }
</script>
@endsection