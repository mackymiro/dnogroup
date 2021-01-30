@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'RAW Materials |')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
</script>
<div id="wrapper">
	 @include('sidebar.sidebar')
	 <div id="content-wrapper">

		<div class="container-fluid">
			 <!-- Breadcrumbs-->
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">Lechon de Cebu</a>
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
								<!-- Button trigger modal -->
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createRaw">
									Create RAW Materials
								</button>
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
	  				  						<th class="bg-success" style="color:white;">IN</th>
	  				  						<th>OUT</th>
	  				  					  	<th>Stock Out Amount</th>
					                        <th class="bg-success" style="color:white;">Remaining Stock</th>
					                        <th>Amount</th>+
                                 	 		<th>Supplier</th>
	  				  						<th>Created By</th>
			  						   </thead>
			  						   <tfoot>
				  							<th>Action</th>
					  						<th>Product Id No</th>
					  						<th>Product Name</th>
					  						<th>Unit Price</th>
					  						<th>Unit</th>
					  						<th class="bg-success" style="color:white;">IN</th>
					  						<th>OUT</th>
					  						<th>Stock Out Amount</th>
						                    <th class="bg-success" style="color:white;">Remaining Stock</th>
						                    <th>Amount</th>
                                				<th>Supplier</th>
					  						<th>Created By</th>
										</tfoot>
										<tbody>
                      					@foreach($getRawMaterials as $getRawMaterial)
			  							<tr id="deletedId{{ $getRawMaterial->id}}">
		  									<td>
											  <!-- Button trigger modal -->
											  <a data-toggle="modal" data-target="#rawM<?php echo $getRawMaterial->id?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
											
					                      	<?php if(Auth::user()['role_type'] != 3): ?>
											<!--  <a id="delete" href="javascript:void" onClick="confirmDelete('{{ $getRawMaterial->id }}')" title="Delete"><i class="fas fa-trash"></i></a>
											  -->
											  <?php endif;?>
		  									</td>
					                        <td>{{ $getRawMaterial->product_id_no }}</td>
					                        <td ><p style="width:200px;"><a  href="{{ url('lolo-pinoy-lechon-de-cebu/view-raw-material-details/'.$getRawMaterial->id) }}">{{ $getRawMaterial->product_name }}</a></p></td>
					                        <td>{{ $getRawMaterial->unit_price }}</td>
					                        <td>{{ $getRawMaterial->unit }}</td>
					                        <td class="bg-success" style="color:white;">{{ $getRawMaterial->in }}</td>
					                        <td>{{ $getRawMaterial->out }}</td>
					                        <td><?php echo number_format($getRawMaterial->stock_amount, 2);?></td>
					                        <td class="bg-success" style="color:white;">{{ $getRawMaterial->remaining_stock}}</td>
					                        <td><?php echo number_format($getRawMaterial->amount, 2);?></td>
											<td><p style="width:200px;">{{ $getRawMaterial->supplier}}</p></td>
					                        <td><p style="width: 100px;">{{ $getRawMaterial->created_by }}</p></td>
					                        
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
	 @foreach($getRawMaterials as $getRawMaterial)
  	<!-- Modal -->
	<div class="modal fade" id="rawM<?php echo $getRawMaterial->id; ?>" tabindex="<?php echo $getRawMaterial->id?>" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Update RAW Materials</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
  				<div id="success<?php echo $getRawMaterial->id;?>"></div>
				<div class="form-group">
					
					<div class="form-row">
						<div class="col-md-4">
							<label>Branch </label>
							<input type="text" id="branch1<?= $getRawMaterial->id?>" name="branch" class="form-control" value="{{ $getRawMaterial->branch }}" disabled />
						</div>
						
						<div class="col-md-4">
							<label>Product Name</label>
							<input type="text" id="productName1<?= $getRawMaterial->id?>" name="productName" class="form-control" value="{{ $getRawMaterial->product_name }}" />
							
						</div>
						<div class="col-md-2">
							<label>Unit Price</label>
							<input type="text"  id="unitPrice1<?= $getRawMaterial->id?>" name="unitPrice" class="form-control" onkeypress="return isNumber(event)" value="{{ $getRawMaterial->unit_price }}"/>
						</div>
						<div class="col-md-2">
							<label>Unit</label>
							<input type="text" id="unit1<?= $getRawMaterial->id?>" name="unit" class="form-control" value="{{ $getRawMaterial->unit }}"  />
						</div>
						<div class="col-md-4">
							<label>IN (input number only)</label>
							<input type="text" id="in1<?= $getRawMaterial->id?>" name="in" class="form-control" onkeypress="return isNumber(event)" value="{{ $getRawMaterial->in }}" />
						</div>
					
						<div class="col-md-4">
							<label>Supplier</label>
							<input type="text" id="supplier1<?= $getRawMaterial->id?>" name="supplier" class="form-control" value="{{ $getRawMaterial->supplier }}" />
						</div>					
						
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
				<button type="button" onclick="updateRaw(<?= $getRawMaterial->id?>)" class="btn btn-success btn-lg">Update</button>
			</div>
			</div>
		</div>
		</div>


	 @endforeach
	  <!-- Modal -->
	<div class="modal fade" id="createRaw" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Add RAW Materials</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
  				<div id="succAdd"></div>
				<div id="succExists"></div>

				<div id="validate" class="col-lg-12">
					<p class="alert alert-danger">Please Fill up Branch and Product Name field</p>
				</div>
				<div class="form-group">
					
					<div class="form-row">
						<div class="col-md-4">
							<label>Branch </label>
							<input type="text" id="branch" name="branch" class="form-control"  />
						</div>
						
						<div class="col-md-4">
							<label>Product Name</label>
							<input type="text" id="productName" name="productName" class="form-control" required="required" />
							
						</div>
						<div class="col-md-2">
							<label>Unit Price</label>
							<input type="text"  id="unitPrice" name="unitPrice" class="form-control" onkeypress="return isNumber(event)"/>
						</div>
						<div class="col-md-2">
							<label>Unit</label>
							<input type="text" id="unit" name="unit" class="form-control"  />
						</div>
						<div class="col-md-4">
							<label>IN (input number only)</label>
							<input type="text" id="in" name="in" class="form-control" onkeypress="return isNumber(event)"/>
						</div>
				
						<div class="col-md-4">
							<label>Supplier</label>
							<input type="text" id="supplier" name="supplier" class="form-control" />
						</div>					
						
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
				<button type="button" onclick="saveRaw()" class="btn btn-success btn-lg">Save</button>
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
	$("#validate").hide();
	
	const updateRaw = (id) =>{
		const productName1 = $("#productName1" +id).val();
		const unitPrice1 = $("#unitPrice1" +id).val();
		const unit1 = $("#unit1" +id).val();
		const stockIn1 = $("#in1" +id).val();
		const supplier1 = $("#supplier1" +id).val();

		//make ajax call
		$.ajax({
			type: "PATCH",
			url: '/lolo-pinoy-lechon-de-cebu/commissary/update-raw-material/' + id,
			data:{
				_method: 'patch',
				"_token": "{{ csrf_token() }}",
				"id":id,
				"productName1":productName1,
				"unitPrice1":unitPrice1,
				"unit1":unit1,
				"stockIn1":stockIn1,
				"supplier1":supplier1,
			},
			success: function(data){
				console.log(data);
				const getData = data;
				const succData = getData.split(":");
				const succDataArr = succData[0];

				if(succDataArr == "Success"){
					$("#success"+id).fadeIn().delay(3000).fadeOut();
					$("#success"+id).html(`<p class="alert alert-success">Succesfully updated.</p>`);
					
					setTimeout(function(){
						document.location.reload();
					}, 3000);
				}
			},
			error: function(data){
				console.log('Error:', data);
			}

		});

	}

	const saveRaw = () =>{
		const branch = $("#branch").val();
		const productName = $("#productName").val();
		const unitPrice = $("#unitPrice").val();
		const unit = $("#unit").val();
		const stockIn = $("#in").val();
		const supplier = $("#supplier").val();

		if(branch.length === 0 || productName.length === 0){
			$("#validate").fadeIn().delay(3000).fadeOut();
		}else{
			//make ajax call
			$.ajax({
                type:"POST",
                url:'/lolo-pinoy-lechon-de-cebu/commissary/add-raw-material',
                data:{
                    _method:'post',
                    "_token":"{{ csrf_token() }}",
                    "branch":branch,
                    "productName":productName,
                    "unitPrice":unitPrice,
					"unit":unit,
					"stockIn":stockIn,
					"supplier":supplier,
                },
                success:function(data){
                    console.log(data);
					const getData = data;
                    const succData = getData.split(":");
                    const succDataArr = succData[0];

					if(succDataArr == "Success"){
						$("#succAdd").fadeIn().delay(3000).fadeOut();
						$("#succAdd").html(`<p class="alert alert-success">Succesfully added.</p>`);
						
						setTimeout(function(){
							document.location.reload();
						}, 3000);
					}else{
						$("#succExists").fadeIn().delay(3000).fadeOut();
                        $("#succExists").html(`<p class="alert alert-danger">Supplier already exists.</p>`);
					}
                    
                    
                },
                error:function(data){
                    console.log('Error:', data);
                }
           });
		   $("#branch").val('');
			$("#productName").val('');
			$("#unitPrice").val('');
			$("#unit").val('');
			$("#in").val('');
			$("#out").val('');
			$("#stockAmount").val('');
			$("#remainingStock").val('');
			$("#amount").val('');
			$("#supplier").val('');

		}
	}

	const isNumber =(evt) => {
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}
	

	const confirmDelete = (id) =>{
        const x = confirm("Do you want to delete this?");
        if(x){
            $.ajax({
              type: "DELETE",
              url: '/lolo-pinoy-lechon-de-cebu/delete-raw-materials/' + id,
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