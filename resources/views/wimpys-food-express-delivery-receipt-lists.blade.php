@extends('layouts.wimpys-food-express-app')
@section('title', 'Delivery Receipt Lists| ')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
</script>
<div id="wrapper">
     @include('sidebar.sidebar-wimpys-food-express')
    <div id="content-wrapper">
    	<div class="container-fluid">
    		 <!-- Breadcrumbs-->
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">Wimpy's Food Express</a>
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
                        
                                            <th>Sold To</th>
                                            <th>Time</th>
                                            <th>Product Id</th>
                                                <th>Date To Be Delivered</th>
                                            <th>Delivered To</th>
                                            <th>Qty</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Created By</th>
                                        </thead>
                                        <tfoot>
                                            <th>Action</th>
                                            <th>Date</th>
                                            <th>DR No</th>
                        
                                            <th>Sold To</th>
                                            <th>Time</th>
                                            <th>Product Id</th>
                                            <th>Date To Be Delivered</th>
                                            <th>Delivered To</th>
                                            <th>Qty</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Created By</th>

                                        </tfoot>
                                        <tbody>
                                            @foreach($getAllDeliveryReceipts as $getAllDeliveryReceipt)
                    
                                            <tr id="deletedId{{ $getAllDeliveryReceipt->id }}">
                                                <td>
                                                   
                                                    <a href="/wimpys-food-express/{{ $getAllDeliveryReceipt->id}}/edit-delivery-receipt" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                
                                                        @if(Auth::user()['role_type'] == 1)
                                                        <a id="delete" onClick="confirmDelete('{{ $getAllDeliveryReceipt->id}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                                                        @endif
                                                        <a href="/wimpys-food-express/{{ $getAllDeliveryReceipt->id}}/view-delivery-receipt" title="View"><i class="fas fa-low-vision"></i></a>
                                                  
                                                    
                                                    </td>
                                                   
                                                    <td >{{ $getAllDeliveryReceipt->date}}</td>
                                                    <td >{{ $getAllDeliveryReceipt->module_code}}{{ $getAllDeliveryReceipt->wimpys_food_express_code}}</td>
                                                    <td ><p style="width: 170px;">{{ $getAllDeliveryReceipt->sold_to}}</p></td>
                                                    <td ><p style="width: 110px;">{{ $getAllDeliveryReceipt->time}}</p></td>
                                                    <td>
                                                        <?php
                                                            $prodArr = $getAllDeliveryReceipt->product_id;
                                                            $prodExp = explode("-", $prodArr);
                                                        
                                                                                  ?>
                                                        <?php if(isset($prodExp)): ?>
                                                          <p style="width:180px;">{{ $prodExp[1] }}</p>
                                                        <?php else:?>
                                                          <p style="width:180px;">{{ $prodExp[1] }}</p>
                                                        <?php endif; ?>
				  									
                                                    </td>
                                                    <td ><p style="width: 140px;">{{ $getAllDeliveryReceipt->date_to_be_delivered}}</p></td>
                                                    <td ><p style="width: 200px;">{{ $getAllDeliveryReceipt->delivered_to}}</p></td>
                                                    <td >{{ $getAllDeliveryReceipt->qty}}</td>
                                                    <td ><p style="width: 200px;">{{ $getAllDeliveryReceipt->description}}</p></td>
                                                    <td ><?= number_format($getAllDeliveryReceipt->total);?></td>
                                                    
                                                    
                                                    <td >
                                                        {{ $getAllDeliveryReceipt->status }}
                                                    </td>
                                                    <td ><p style="width: 120px;">{{ $getAllDeliveryReceipt->created_by}}</p></td>
                                                                        
                                                  
                                
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
   const confirmDelete = (id) => {
        let x = confirm("Do you want to delete this?");
        if(x){
            $.ajax({
              type: "DELETE",
              url: `/wimpys-food-express/${id}/delete/dr/`,
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