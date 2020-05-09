@extends('layouts.ribos-bar-app')
@section('title', 'Store Stock - RAW Materials |')
@section('content')
<script>
  $(document).ready(function(){
    
      $('table.display').DataTable( {} );
  });   
</script>
<div id="wrapper">
     @include('sidebar.sidebar-ribos-bar')
     <div id="content-wrapper">
        <div class="container-fluid">
             <!-- Breadcrumbs-->
             <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">Ribo's Bar</a>
                </li>
                <li class="breadcrumb-item ">Store Stock</li>
                <li class="breadcrumb-item active">RAW Materials</li>
              </ol>
              <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            All Lists
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-12 ">
                                        <!-- Button trigger modal -->
                                        
                                        <a class="btn btn-primary" href="#" data-toggle="modal" data-target=".createRawMaterial" >Create RAW Materails </a>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered display"  width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
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
                                        </tr>
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
											<a href="{{ url('ribos-bar/store-stock/edit-raw-materials/'.$getRawMaterial['id']) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
											<a id="delete" href="javascript:void" onClick="confirmDelete('{{ $getRawMaterial['id'] }}')" title="Delete"><i class="fas fa-trash"></i></a>
										
											</td>
											<td>{{ $getRawMaterial['product_id_no'] }}</td>
											<td><p style="width: 180px;"><a href="{{ url('ribos-bar/store-stock/view-raw-material-details/'.$getRawMaterial['id']) }}">{{ $getRawMaterial['product_name'] }}</a></p></td>
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
    <!--Modal-->
    <div class="modal fade createRawMaterial" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add RAW Material</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-row">
                            <div id="validate" class="col-lg-12">
                                <p  class="alert alert-danger">Please Fill up the fields</p>
                            </div>
                            <div id="exists" class="col-lg-12"></div>
                            <div id="succAddRAW" class="col-lg-12"></div>
                            <div class="col-md-4">
                                <label>Branch </label>
                                <input type="text" id="branch" name="branch" class="form-control"  />
                            </div>
                            <div class="col-md-4">
                                <label>Product Name</label>
                                <input type="text" id="prductName" name="productName" class="form-control" required="required" />
                               
                            </div>
                            <div class="col-md-2">
                                <label>Unit Price</label>
                                <input type="text" id="unitPrice" name="unitPrice" class="form-control" />
                            </div>
                            <div class="col-md-2">
                                <label>Unit</label>
                                <input type="text" id="unit" name="unit" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-2">
                                <label>IN</label>
                                <input type="text" id="in" name="in" class="form-control" />
                            </div>
                            <div class="col-md-2">
                                <label>OUT</label>
                                <input type="text" id="out" name="out" class="form-control" />
                            </div>
                            <div class="col-md-4">
                                <label>Stock Out Amount</label>
                                <input type="text" id="stockOutAmount" name="stockAmount" class="form-control" />
                            </div>
                            <div class="col-md-4">
                                <label>Remaining Stock</label>
                                <input type="text" id="remainingStock"name="remainingStock" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-2">
                                <label>Amount</label>
                                <input type="text" id="amount" name="amount" class="form-control" />
                            </div>
                            <div class="col-md-4">
                                <label>Supplier</label>
                                <input type="text" id="supplier" name="supplier" class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeRAW()" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" onclick="addRAW()" class="btn btn-success">Add RAW Material </button>
                </div>
            </div>
        </div>
    </div><!-- end of Modal -->
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

    const addRAW = () =>{
        const branch = $("#branch").val();
        const prductName = $("#prductName").val();
        const unitPrice = $("#unitPrice").val();
        const unit = $("#unit").val();
        const inData = $("#in").val();
        const outData = $("#out").val();
        const stockOutAmount = $("#stockOutAmount").val();
        const remainingStock = $("#remainingStock").val();
        const amount = $("#amount").val();
        const supplier = $("#supplier").val();

        if(branch == "" || prductName == "" || supplier == ""){
            $("#validate").fadeIn().delay(3000).fadeOut();
        }else{
            //make ajax call
            $.ajax({
                type: 'POST',
                url: '/ribos-bar/store-stock/raw-materials/add-raw',
                data:{
                    _method:'post',
                    "_token":"{{ csrf_token() }}",
                    "branch":branch,
                    "prductName":prductName,
                    "unitPrice":unitPrice,
                    "unit":unit,
                    "inData":inData,
                    "outData":outData,
                    "stockOutAmount":stockOutAmount,
                    "remainingStock":remainingStock,
                    "amount":amount,
                    "supplier":supplier,

                },
                success:function(data){
                    console.log(data);
                    const getData = data;
                    const succData = getData.split(":");
                    const succDataArr = succData[0];
                    if(succDataArr == "Success"){
                       $("#succAddRAW").fadeIn().delay(3000).fadeOut();
                       $("#succAddRAW").html(`<p class="alert alert-success"> ${data}</p>`);
                      
                        setTimeout(function(){
                            document.location.reload();
                        }, 3000);
                    }else{
                        $("#exists").fadeIn().delay(3000).fadeOut();
                        $("#exists").html(`<p class="alert alert-danger">${data}</p>`);
                    }
                },
                error:function(data){
                    console.log('Error', data);
                }
            });
        }
    }
</script>
@endsection