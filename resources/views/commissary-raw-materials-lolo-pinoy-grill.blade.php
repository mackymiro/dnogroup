@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'RAW Materials |')
@section('content')

<div id="wrapper">
	 @include('sidebar.sidebar-lolo-pinoy-grill')
	 <div id="content-wrapper">

		<div class="container-fluid">
			 <!-- Breadcrumbs-->
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">Lolo Pinoy Grill Commissary</a>
                </li>
                <li class="breadcrumb-item ">Commissary</li>
                <li class="breadcrumb-item active">RAW Materials</li>
              </ol>
              <div class="row">
              		<div class="col-lg-12">
              			<div class="card mb-3">
              				<div class="card-header">
          					  <i class="fa fa-tasks" aria-hidden="true"></i>
          					  All Lists</div>
      					  	<div class="card-body">
  					  			 <div class="float-right">
			                        <a href="{{ url('lolo-pinoy-grill-commissary/commissary/create-raw-materials')}}" title="Create Stocks" class="btn  btn-success">Create RAW Materials</a>
			                    </div>
			                     <br>
                    			 <br>
                			 	<div class="table-responsive">
                			 		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                			 			<thead>
	  				  						<th>Action</th>
	  				  						<th>Product Id No</th>
	  				  						<th>Product Name</th>
	  				  						<th>Unit Price</th>
	  				  						<th>Unit</th>
	  				  						<th class="bg-danger" style="color:white;">IN</th>
	  				  						<th>OUT</th>
	  				  					  	<th>Stock Out Amount</th>
					                        <th>Remaining Stock</th>
					                        <th>Amount</th>
                                   <th>Supplier</th>
	  				  						<th>Created By</th>
			  						   </thead>
			  						   <tfoot>
				  							<th>Action</th>
					  						<th>Product Id No</th>
					  						<th>Product Name</th>
					  						<th>Unit Price</th>
					  						<th>Unit</th>
					  						<th class="bg-danger" style="color:white;">IN</th>
					  						<th>OUT</th>
					  						<th>Stock Out Amount</th>
						                    <th>Remaining Stock</th>
						                    <th>Amount</th>
                                 <th>Supplier</th>
					  						<th>Created By</th>
										</tfoot>
										<tbody>
              					@foreach($getRawMaterials as $getRawMaterial)
			  							<tr id="deletedId{{ $getRawMaterial['id']}}">
		  									<td>
                        <a href="{{ url('lolo-pinoy-grill-commissary/commissary/edit-raw-materials/'.$getRawMaterial['id']) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
	  										<a id="delete" href="javascript:void" onClick="confirmDelete('{{ $getRawMaterial['id'] }}')" title="Delete"><i class="fas fa-trash"></i></a>
	  									
		  									</td>
	                        <td>{{ $getRawMaterial['product_id_no'] }}</td>
	                        <td><p style="width: 180px;"><a href="{{ url('lolo-pinoy-grill-commissary/view-raw-material-details/'.$getRawMaterial['id']) }}">{{ $getRawMaterial['product_name'] }}</a></p></td>
	                        <td>{{ $getRawMaterial['unit_price'] }}</td>
	                        <td>{{ $getRawMaterial['unit'] }}</td>
	                        <td class="bg-danger" style="color:white;">{{ $getRawMaterial['in'] }}</td>
	                        <td>{{ $getRawMaterial['out'] }}</td>
	                        <td><?php echo number_format($getRawMaterial['stock_amount'], 2); ?></td>
	                        <td>{{ $getRawMaterial['remaining_stock']}}</td>
	                        <td><?php echo number_format($getRawMaterial['amount'], 2);?></td>
                          <td><p style="width:180px;">{{ $getRawMaterial['supplier']}}</p></td>
                          <td><p style="width: 100px;">{{ $getRawMaterial['created_by'] }}</p></td>
					                        
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
	 function confirmDelete(id){
        var x = confirm("Do you want to delete this?");
        if(x){
            $.ajax({
              type: "DELETE",
              url: '/lolo-pinoy-grill-commissary/delete-raw-materials/' + id,
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