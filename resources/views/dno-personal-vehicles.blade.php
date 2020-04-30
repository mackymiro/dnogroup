@extends('layouts.dno-personal-app')
@section('title', 'Utilities|')
@section('content')
<style>
.selcls { 
    padding: 9px; 
    border: solid 1px #517B97; 
    outline: 0; 
    background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #CAD9E3), to(#FFFFFF)); 
    background: -moz-linear-gradient(top, #FFFFFF, #CAD9E3 1px, #FFFFFF 25px); 
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px; 
    -moz-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px; 
    -webkit-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px; 
	} 
</style> 
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
</script>
<div id="wrapper">
      @include('sidebar.sidebar-dno-personal')
      <div id="content-wrapper">
         <div class="container-fluid">
                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">DNO Personal</a>
                    </li>
                    <li class="breadcrumb-item active">Utilties</li>
                    <li class="breadcrumb-item ">Vehicles</li>
                   
                </ol>
                <div class="row">
                    
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
                            <i class="fas fa-tools" aria-hidden="true"></i>
                                Utilities
						    </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12 float-right">
                                            <!-- Button trigger modal -->
                                          
                                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addVehicle">Add Vehicle</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                         <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Vehicle Unit</th>
                                                
                                                <th>Series</th>
                                                <th >Denomination</th>
                                                <th >Body Type</th>
                                                <th>Year Model</th>
                                                <th >Created By</th>
                                            </tr>
                                         </thead>
                                         <tfoot>
                                            <tr>
                                                <th>Action</th>
                                                <th>Vehicle Unit</th>
                                                
                                                <th>Series</th>
                                                <th >Denomination</th>
                                                <th >Body Type</th>
                                                <th>Year Model</th>
                                                <th >Created By</th>
                                            </tr>
                                         </tfoot>
                                         <tbody>
                                            @foreach($getVehicles as $getVehicle)
                                            <tr id="deletedId<?php echo $getVehicle['id'];?>">
                                                <td>
                                                  	@if($user->role_type !== 3)
                                                        <!-- Button trigger modal -->
                                                        <a data-toggle="modal" data-target="#vehicle<?php echo $getVehicle['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                    
                                                    @if($user->role_type == 1)
					  									<a id="delete" onClick="confirmDelete('{{ $getVehicle['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
				              						@endif
                                                </td>
                                                <td><a href="{{ url('dno-personal/vehicles/view/'.$getVehicle['id']) }}" title="{{ $getVehicle['vehicle_unit']}}">{{ $getVehicle['vehicle_unit']}}</a></td>
                                                <td>{{ $getVehicle['series']}}</td>
                                                <td>{{ $getVehicle['denomination']}}</td>
                                                <td>{{ $getVehicle['body_type']}}</td>
                                                <td>{{ $getVehicle['year_model']}}</td>
                                                <td>{{ $getVehicle['created_by']}}</td>
                                                
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
    <div class="modal fade" id="addVehicle" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Vehicle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="form-row">
                        <div id="validate" class="col-lg-12">
                            <p class="alert alert-danger">Please Fill up the fields</p>
                        </div>
                        <div id="exists" class="col-lg-12"></div>
                        <div id="succAdd" class="col-lg-12"></div>
                        <div class="col-lg-12">
                            <label>Vehicle Unit</label>
                            <input type="text" id="vehicleUnit" name="vehicleUnit" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Series</label>
                            <input type="text" id="series" name="series" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Denomination</label>
                            <input type="text" id="denomination" name="denomination" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Body Type</label>
                            <input type="text" id="bodyType" name="bodyType" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Year Model</label>
                            <input type="text" id="yearModel" name="yearModel" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>MV FILE NO</label>
                            <input type="text"  id="mVFile" name="mVFile" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Plate No</label>
                            <input type="text" id="plateNo" name="plateNo" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Engine No</label>
                            <input type="text" id="engineNo" name="engineNo" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Cr No</label>
                            <input type="text" id="crNo" name="crNo" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Location</label>
                            <input type="text" id="location" name="location" class="selcls form-control" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick=closeVehicle() type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button onclick=saveVehicle() type="button" class="btn btn-success">Add Vehicle</button>
            </div>
            </div>
        </div>
    </div><!-- end modal -->
    <!-- Modal -->
    @foreach($getVehicles as $getVehicle)
    <div class="modal fade" id="vehicle<?php echo $getVehicle['id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Vehicle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="form-row">
                       
                        <div class="col-lg-12">
                            <label>Vehicle Unit</label>
                            <input type="text" id="editVehicleUnit<?php echo $getVehicle['id'];?>" name="editVehicleUnit" class="selcls form-control" value="{{ $getVehicle['vehicle_unit']}}" />
                        </div>
                        <div class="col-lg-12">
                            <label>Series</label>
                            <input type="text" id="editSeries<?php echo $getVehicle['id'];?>" name="editSeries" class="selcls form-control" value="{{ $getVehicle['series']}}" />
                        </div>
                        <div class="col-lg-12">
                            <label>Denomination</label>
                            <input type="text" id="editDenomination<?php echo $getVehicle['id'];?>" name="editDenomination" class="selcls form-control" value="{{ $getVehicle['denomination']}}" />
                        </div>
                        <div class="col-lg-12">
                            <label>Body Type</label>
                            <input type="text" id="editBodyType<?php echo $getVehicle['id'];?>" name="editBodyType" class="selcls form-control" value="{{ $getVehicle['body_type']}}" />
                        </div>
                        <div class="col-lg-12">
                            <label>Year Model</label>
                            <input type="text" id="editYearModel<?php echo $getVehicle['id'];?>" name="editYearModel" class="selcls form-control" value="{{ $getVehicle['year_model']}}" />
                        </div>
                        <div class="col-lg-12">
                            <label>MV FILE NO</label>
                            <input type="text"  id="editMVFile<?php echo $getVehicle['id'];?>" name="editMVFile" class="selcls form-control" value="{{ $getVehicle['mv_file_no']}}" />
                        </div>
                        <div class="col-lg-12">
                            <label>Plate No</label>
                            <input type="text" id="editPlateNo<?php echo $getVehicle['id'];?>" name="editPlateNo" class="selcls form-control" value="{{ $getVehicle['plate_no']}}" />
                        </div>
                        <div class="col-lg-12">
                            <label>Engine No</label>
                            <input type="text" id="editEngineNo<?php echo $getVehicle['id'];?>" name="editEngineNo" class="selcls form-control" value="{{ $getVehicle['engine_no']}}"/>
                        </div>
                        <div class="col-lg-12">
                            <label>Cr No</label>
                            <input type="text" id="editCrNo<?php echo $getVehicle['id'];?>" name="editCrNo" class="selcls form-control" value="{{ $getVehicle['cr_no']}}" />
                        </div>
                        <div class="col-lg-12">
                            <label>Location</label>
                            <input type="text" id="editLocation<?php echo $getVehicle['id'];?>" name="editLocation" class="selcls form-control" value="{{ $getVehicle['location']}}" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick=closeVehicle() type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button onclick=updateVehicle(<?php echo $getVehicle['id']?>) type="button" class="btn btn-success">Update Vehicle</button>
            </div>
            </div>
        </div>
    </div><!-- end modal -->
    @endforeach
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
    $("#exists").hide();
    $("#succAdd").hide();
    $("#succUpdate").hide();

    const confirmDelete = (id) => {
        const x = confirm("Do you want to delete this?");
        if(x){
            $.ajax({
                type:"DELETE",
                url:'/dno-perosonal/vehicles/delete/' +id,
                data:{
                    _method:"delete",
                    "_token":"{{ csrf_token() }}",
                    "id":id
                },
                success:function(data){
                    $("#deletedId"+id).fadeOut('slow');
                
                },
                error:function(data){
                    console.log('Error:', data);
                }
            });
        }else{
            return false;
        }
    }

    const updateVehicle = (id) => {
        const editVehicleUnit = $("#editVehicleUnit"+id).val();
        const editSeries = $("#editSeries"+id).val();
        const editDenomination  = $("#editDenomination"+id).val();
        const editBodyType = $("#editBodyType"+id).val();
        const editYearModel = $("#editYearModel"+id).val();
        const editMVFile = $("#editMVFile"+id).val();
        const editPlateNo = $("#editPlateNo"+id).val();
        const editEngineNo = $("#editEngineNo"+id).val();
        const editCrNo = $("#editCrNo"+id).val();
        const editLocation = $("#editLocation"+id).val();

        //make ajax call
        $.ajax({
            type: "PATCH",
            url: '/dno-personal/vehicles/update-vehicle/' + id,
            data:{
                _method:'patch',
                "_token": "{{ csrf_token() }}",
                "id":id,
                "editVehicleUnit":editVehicleUnit,
                "editSeries":editSeries,
                "editDenomination":editDenomination,
                "editBodyType":editBodyType,
                "editYearModel":editYearModel,
                "editMVFile":editMVFile,
                "editPlateNo":editPlateNo,
                "editEngineNo":editEngineNo,
                "editCrNo":editCrNo,
                "editLocation":editLocation
            },
            success:function(data){
                location.reload('/dno-personal/vehicles');          
            },
            error:function(data){
                console.log('Error:', data);
            }

        });
    }

    const closeVehicle = () => {
        const vehicleUnit = $("#vehicleUnit").val('');
        const series = $("#series").val('');
        const denomination = $("#denomination").val('');
        const bodyType = $("#bodyType").val('');
        const yearModel = $("#yearModel").val('');
        const mVFile = $("#mVFile").val('');
        const plateNo = $("#plateNo").val('');
        const engineNo = $("#engineNo").val('');
        const crNo = $("#crNo").val('');
        const location = $("#location").val('');
    }

    const saveVehicle = () =>{
        const vehicleUnit = $("#vehicleUnit").val();
        const series = $("#series").val();
        const denomination = $("#denomination").val();
        const bodyType = $("#bodyType").val();
        const yearModel = $("#yearModel").val();
        const mVFile = $("#mVFile").val();
        const plateNo = $("#plateNo").val();
        const engineNo = $("#engineNo").val();
        const crNo = $("#crNo").val();
        const location = $("#location").val();

        if(vehicleUnit == "" || series == "" || denomination == "" || bodyType == "" || yearModel == "" 
        || mVFile == "" || plateNo == "" || engineNo =="" || crNo == "" || location == ""){
            $("#validate").fadeIn().delay(3000).fadeOut();
        }else{
            //save the data 
            $.ajax({
                type: "POST",
                url: '/dno-personal/vehicles/store-vehicles',
                data:{
                    _method: 'post',
                    "_token": "{{ csrf_token() }}",
                    "vehicleUnit":vehicleUnit,
                    "series":series,
                    "denomination":denomination,
                    "bodyType":bodyType,
                    "yearModel":yearModel,
                    "mVFile":mVFile,
                    "plateNo":plateNo,
                    "engineNo":engineNo,
                    "crNo":crNo,
                    "location":location
                },
                success: function(data){
                    console.log(data);
                    const getData = data
                    const succData = getData.split(":");
                    const succDataArr  = succData[0];

                    if(succDataArr == "Success"){
                       $("#succAdd").fadeIn().delay(3000).fadeOut();
                       $("#succAdd").html('<p class="alert alert-success">'+ data + '</p>');
                    
                    }else{
                        $("#exists").fadeIn().delay(3000).fadeOut();
                        $("#exists").html(' <p class="alert alert-danger">'+ data + '</p>');
                    }
                    

                },
                error: function(data){
                    console.log('Error:', data);
                }
            });
        }
        
    }


</script>
@endsection