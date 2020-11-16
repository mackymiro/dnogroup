@extends('layouts.wimpys-food-express-app')
@section('title', 'RAW Materials |')
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
                <li class="breadcrumb-item ">Stock Inventory</li>
                <li class="breadcrumb-item active">RAW Order Form Materials</li>
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
									Create RAW Order Form Materials
								</button>
			                     <br>
                    			 <br>
                			 	<div class="table-responsive">
                			 		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                			 			<thead>
	  				  						<th>Action</th>
	  				  						<th>Product Name</th>
											<th>Unit</th>
											<th>Price</th>
	  				  						<th class="bg-success" style="color:white;">Category</th>
	  				  						<th>Created By</th>
			  						   </thead>
			  						   <tfoot>
				  							<th>Action</th>
	  				  						<th>Product Name</th>
											<th>Unit</th>
											<th>Price</th>
	  				  						<th class="bg-success" style="color:white;">Category</th>
	  				  						<th>Created By</th>
										</tfoot>
										<tbody>
                      						@foreach($getMaterials as $getMaterial)
                      						<tr>
  												<td>
  													 <!-- Button trigger modal -->
													<a data-toggle="modal" data-target="" href="#rawM<?= $getMaterial['id']?>" title="Edit"><i class="fas fa-pencil-alt"></i></a>
										
												</td>
												<td>{{ $getMaterial['product_name'] }}</td>
												<td>{{ $getMaterial['unit']}}</td>
												<td>{{ $getMaterial['price'] }}</td>
												<td class="bg-success" style="color:white;">{{ $getMaterial['category'] }}</td>
												<td>{{ $getMaterial['created_by']}}</td>
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
	 @foreach($getMaterials as $getMaterial)
  	<!-- Modal -->
	<div class="modal fade" id="rawM<?= $getMaterial['id']; ?>" tabindex="<?= $getMaterial['id'] ?>" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Update RAW Materials</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
  				<div id="success<?= $getMaterial['id'];?>"></div>
				<div class="form-group">
					
					<div class="form-row">
					
						
						<div class="col-md-4">
							<label>Product Name</label>
							<input type="text" id="productName1<?= $getMaterial['id']?>" name="productName1" class="form-control" value="{{ $getMaterial['product_name'] }}" />
							
						</div>
						<div class="col-md-4">
  							<label>Unit</label>
							<input type="text" id="unit1<?= $getMaterial['id']?>" name="unit1" class="form-control" value="{{ $getMaterial['unit']}}" />
						</div>
						<div class="col-md-2">
							<label>Price</label>
							<input type="text"  id="price1<?= $getMaterial['id']?>" name="price1" class="form-control" onkeypress="return isNumber(event)" value="{{ $getMaterial['price'] }}"/>
						</div>
					
						<div class="col-md-4">
							<label>Category</label>
							<select class="form-control" id="category1<?= $getMaterial['id'];?>" name="category">
                                <option value="Kitchen" {{ ( "Kitchen" == $getMaterial['category']) ? 'selected' : '' }}>Kitchen</option>
                                <option value="Dessert" {{ ( "Dessert" == $getMaterial['category']) ? 'selected' : '' }}>Dessert</option>
                                <option value="Decor" {{ ( "Decor" == $getMaterial['category']) ? 'selected' : '' }}>Decor</option>
                                <option value="Equipment and Supplies" {{ ( "Equipment and Supplies" == $getMaterial['category']) ? 'selected' : '' }}>Equipment and Supplies</option>
                            </select>
						</div>					
						
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
				<button type="button" onclick="updateRaw(<?= $getMaterial['id']?>)" class="btn btn-success btn-lg">Update</button>
			</div>
			</div>
		</div>
		</div>


	 @endforeach
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
					<p class="alert alert-danger">Please fill up the field</p>
				</div>
				<div class="form-group">
					
					<div class="form-row">
						<div class="col-md-4">
							<label>Product Name</label>
							<input type="text" id="productName" name="productName" class="form-control" required="required" />
							
						</div>
						<div class="col-md-4">
  							<label>Unit</label>
							<input type="text" id="unit" name="unit" class="form-control" />
						</div>
						<div class="col-md-2">
							<label>Price</label>
							<input type="text"  id="price" name="price" class="form-control" onkeypress="return isNumber(event)"/>
						</div>
						
						
                        <div class="col-md-4">
                            <label>Category</label>
                            <select class="form-control" id="category" name="category">
                                <option value="Kitchen">Kitchen</option>
                                <option value="Dessert">Dessert</option>
                                <option value="Decor">Decor</option>
                                <option value="Equipment and Supplies">Equipment and Supplies</option>
                            </select>
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
		const productName = $("#productName1" +id).val();
		const price = $("#price1" +id).val();
		const category = $("#category1" +id).val();

		//make ajax call
		$.ajax({
			type: "PUT",
			url: '/wimpys-food-express/update-raw-material/' + id,
			data:{
				_method: 'put',
				"_token": "{{ csrf_token() }}",
				"id":id,
				"productName":productName,
				"price":price,
				"category":category,
			},
			success: function(data){
				console.log(data);
				const getData = data;
				const succData = getData.split(":");
				const succDataArr = succData[0];

				if(succDataArr == "Success"){
					$("#success"+id).fadeIn().delay(3000).fadeOut();
					$("#success"+id).html(`<p class="alert alert-success">${data}</p>`);
					
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
		const productName = $("#productName").val();
		const unit = $("#unit").val();
		const price = $("#price").val();
		const category = $("#category").val();

		if(productName.length === 0 || price.length === 0){
			$("#validate").fadeIn().delay(3000).fadeOut();
		}else{
			//make ajax call
			$.ajax({
                type:"POST",
                url:'/wimpys-food-express/add-raw-material',
                data:{
                    _method:'post',
                    "_token":"{{ csrf_token() }}",
					"productName":productName,
					"unit":unit,
                    "price":price,
					"category":category,
                },
                success:function(data){
                    console.log(data);
					const getData = data;
                    const succData = getData.split(":");
                    const succDataArr = succData[0];

					if(succDataArr == "Success"){
						$("#succAdd").fadeIn().delay(3000).fadeOut();
						$("#succAdd").html(`<p class="alert alert-success">${data}</p>`);
						
						setTimeout(function(){
							document.location.reload();
						}, 3000);
					}else{
						$("#succExists").fadeIn().delay(3000).fadeOut();
                        $("#succExists").html(`<p class="alert alert-danger">${data}</p>`);
					}
                    
                    
                },
                error:function(data){
                    console.log('Error:', data);
                }
           });

			$("#productName").val('');
			$("#price").val('');

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