@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'Suppliers |')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
      
  });
  $(function() {
    $( ".datepicker" ).datepicker();
  });
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div id="wrapper">
     @include('sidebar.sidebar-lolo-pinoy-grill')
     <div id="content-wrapper">
        <div class="container-fluid">
             <!-- Breadcrumbs-->
             <ol class="breadcrumb">
                <li class="breadcrumb-item">
                <a href="#">Lolo Pinoy Grill Commissary</a>
                </li>
                <li class="breadcrumb-item active">Supplier</li>
                <li class="breadcrumb-item ">Supplier's  List</li>
            </ol>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                         <div class="card-header">
                             <i class="fa fa-industry" aria-hidden="true"></i>
	    					 Supplier's List
                        </div>
                        <div class="card-body">
                             <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                             <!-- Button trigger modal -->
                                             <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addSupplier"><i class="fas fa-plus"></i> Add Supplier</a>
                                      
                                        </div>
                                    </div>
                            </div>
                            <div class="table-responsive">
                                 <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                          <thead>
					  						<tr>
				  								
                                                <th>Supplier Name/Service Provider</th>
                                                <th>Date</th>
                                                
												<th>Created By</th>
					  						</tr>
				  						</thead>
                                        <tfoot>
					  						<tr>
				  								
                                                <th>Supplier Name/Service Provider</th>
                                                <th>Date</th>
                                               
												<th>Created By</th>
					  						</tr>
				  						</tfoot>
                                        <tbody>
                                           @foreach($suppliers as $supplier)
                                            <tr>
                                                <td><a href="{{ url('lolo-pinoy-grill-commissary/suppliers/view/'.$supplier['id']) }}">{{ $supplier['supplier_name']}}</a></td>
                                                <td>{{ $supplier['date']}}</td>
                                                <td>{{ $supplier['created_by']}}</td>
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
      <!-- Modal -->
    <div class="modal fade" id="addSupplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 <div id="validate" class="col-lg-12">
                    <p class="alert alert-danger">Please Fill up the fields</p>
                </div>
                <div id="succAdd"></div>
                <div id="succExists"></div>
                <div class="form-group">
                    <div class="form-row">
                       
                        <div class="col-lg-6">
                            <label>Date</label>
                            <input type="text" id="date" name="date" class="datepicker form-control"/>
                        </div>
                        <div class="col-lg-6">
                            <label>Supplier Name</label>
                            <input type="text" id="supplierName" name="supplierName" class="form-control" />
                        </div>
                       
                    </div>
                </div>
              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Close</button>
                <button type="button" onclick="saveSupplier()" class="btn btn-success"><i class="fas fa-plus"></i> Add Supplier</button>
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
<script type="text/javascript">
     $("#validate").hide();

     const saveSupplier = () =>{
        const date = $("#date").val();
        const supplierName = $("#supplierName").val();

        if(date.length === 0 || supplierName.length === 0){
            $("#validate").fadeIn().delay(3000).fadeOut();
        }else{
            //make ajax call
            $.ajax({
                type:"POST",
                url:'/lolo-pinoy-grill-commissary/supplier/add',
                data:{
                    _method:'post',
                    "_token":"{{ csrf_token() }}",
                    "date":date,
                    "supplierName":supplierName,
                   
                },
                success: function(data){
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
        }

     }
</script>
@endsection