@extends('layouts.dno-personal-app')
@if(\Request::is('dno-personal/cebu-properties'))
    @section('title', 'Cebu Properties|')
@else
    @section('title', 'Manila Properties|')
@endif
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
                    <li class="breadcrumb-item active">Properties</li>
                    @if(\Request::is('dno-personal/cebu-properties'))
                    <li class="breadcrumb-item active">Cebu Properties</li>
                    @else
                    <li class="breadcrumb-item active">Manila Properties</li>
                    @endif
                </ol>
                <div class="row">
                    @if(\Request::is('dno-personal/cebu-properties'))
                        <div class="col-lg-12">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <i class="fas fa-building" aria-hidden="true"></i>
                                    Cebu Properties
                            
                                </div>
                                <div class="card-body"> 
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12 ">
                                            <!-- Button trigger modal -->
                                          
                                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addCebuProperty" >Add Property</a>
                                        </div>
                                    </div>
                                </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                
                                                    <th>Action</th>
                                                    <th>Property Name</th>
                                                    
                                                    <th>Property Account Code</th>
                                                    <th >Property Account Name</th>
                                                    <th >Address</th>
                                                    <th>Unit</th>
                                                    <th >Status</th>
                                                    <th>Created By</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                <th>Action</th>
                                                    <th>Property Name</th>
                                                    
                                                    <th>Property Account Code</th>
                                                    <th >Property Account Name</th>
                                                    <th >Address</th>
                                                    <th>Unit</th>
                                                    <th >Status</th>
                                                    <th>Created By</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @foreach($getCebuProperties as $getCebuProperty)
                                                <tr id="deletedId<?php echo $getCebuProperty['id']; ?>">
                                                    <td>
                                                         @if($user->role_type !== 3)
                                                            <!-- Button trigger modal -->
                                                            <a data-toggle="modal" data-target="#editCebuProp<?php echo $getCebuProperty['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                        @endif
                                                        @if($user->role_type == 1)
                                                            <a id="delete" onClick="confirmDelete('{{ $getCebuProperty['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>                                                        
                                                        @endif
                                                    </td>
                                                    <td><a href="{{ url('dno-personal/cebu-properties/view/'.$getCebuProperty['id'] ) }}"><p style="width:160px;">{{ $getCebuProperty['property_name'] }}</p></a></td>
                                                    <td><p style="width:200px;">{{ $getCebuProperty['property_account_code']}}</p></td>
                                                    <td><p style="width:200px;">{{ $getCebuProperty['property_account_name'] }}</p></td>
                                                    <td><p style="width:200px;">{{ $getCebuProperty['address']}}</p></td>
                                                    <td>{{ $getCebuProperty['unit']}}</td>
                                                    <td>{{ $getCebuProperty['status']}}</td>
                                                    <td>{{ $getCebuProperty['created_by']}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>    
                                        </table>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                    @else
                        <div class="col-lg-12">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <i class="fas fa-building" aria-hidden="true"></i>
                                    Manila Properties
                            
                                </div>
                                <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12 ">
                                            <!-- Button trigger modal -->
                                          
                                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addManilaProperty" >Add Property</a>
                                        </div>
                                    </div>
                                </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                
                                                    <th>Action</th>
                                                    <th>Property Name</th>
                                                    
                                                    <th>Property Account Code</th>
                                                    <th >Property Account Name</th>
                                                    <th >Address</th>
                                                    <th>Unit</th>
                                                    <th >Status</th>
                                                    <th>Created By</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                <th>Action</th>
                                                    <th>Property Name</th>
                                                    
                                                    <th>Property Account Code</th>
                                                    <th >Property Account Name</th>
                                                    <th >Address</th>
                                                    <th>Unit</th>
                                                    <th >Status</th>
                                                    <th>Created By</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                 @foreach($getManilaProperties as $getManilaProperty)
                                                    <tr id="deletedId<?php echo $getManilaProperty['id']; ?>">
                                                        <td>
                                                        @if($user->role_type !== 3)
                                                            <!-- Button trigger modal -->
                                                            <a data-toggle="modal" data-target="#manilaProp<?php echo $getManilaProperty['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                        @endif
                                                        @if($user->role_type == 1)
                                                            <a id="delete" onClick="confirmDelete('{{ $getManilaProperty['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>                                                        
                                                        @endif
                                                        </td>
                                                        
                                                        <td><a href="{{ url('dno-personal/manila-properties/view/'.$getManilaProperty['id']) }}"><p style="width:160px;">{{ $getManilaProperty['property_name'] }}</p></a></td>
                                                        <td><p style="width:200px;">{{ $getManilaProperty['property_account_code']}}</p></td>
                                                        <td><p style="width:200px;">{{ $getManilaProperty['property_account_name'] }}</p></td>
                                                        <td><p style="width:200px;">{{ $getManilaProperty['address']}}</p></td>
                                                        <td>{{ $getManilaProperty['unit']}}</td>
                                                        <td>{{ $getManilaProperty['status']}}</td>
                                                        <td>{{ $getManilaProperty['created_by']}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            
                            </div>
                        </div>

                    @endif
                </div>  
         </div> 
    </div> 
    @if(\Request::is('dno-personal/cebu-properties'))
    <!-- Modal -->
    @foreach($getCebuProperties as $getCebuProperty)
    <div class="modal fade" id="editCebuProp<?php echo $getCebuProperty['id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Edit Property</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <div class="form-group">
            <div class="form-row">
               
                <div id="succEditSky<?php echo $getCebuProperty['id']?>" class="col-lg-12"></div>
                <div class="col-lg-12">
                    <label>Property Name</label>
                    <input type="text" id="propNameUpdate<?php echo $getCebuProperty['id']?>" name="propName" class="selcls form-control"  value="{{ $getCebuProperty['property_name']}}" />
                </div>   
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
            <div class="col-lg-12">
                <label>Property Account Code</label>
                <input type="text" id="propAccountCodeUpdate<?php echo $getCebuProperty['id']?>" name="propAccountCode" class="selcls form-control" value="{{ $getCebuProperty['property_account_code']}}" />
            </div>
          
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col-lg-12">
                    <label>Property Account Name</label>
                    <input type="text" id="propAccountNameUpdate<?php echo $getCebuProperty['id']?>" name="propAccountName" class="selcls form-control" value="{{ $getCebuProperty['property_account_name']}}" />
                </div>
              
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col-lg-12">
                    <label>Address</label>
                    <input type="text" id="addressUpdate<?php echo $getCebuProperty['id']?>" name="address<?php echo $getCebuProperty['id']?>" class="selcls form-control" value="{{ $getCebuProperty['address']}}" />
                </div>
             
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col-lg-12">
                    <label>Unit </label>
                    <input type="text" id="unitUpdate<?php echo $getCebuProperty['id']?>" name="unit" class="selcls form-control" value="{{ $getCebuProperty['unit'] }}" />
                </div>
              
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col-lg-12">
                    <label>Status</label>
                    <input type="text" id="statusUpdate<?php echo $getCebuProperty['id']?>" name="status<?php echo $getCebuProperty['id']?>" class="selcls form-control"  value="{{ $getCebuProperty['status']}}" />
                   
                </div>
            </div>
        </div>
       
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button onclick="updateProperty(<?php echo $getCebuProperty['id']?>)" type="button" class="btn btn-success">Update Property</button>
        </div>
        </div>
    </div>
    </div><!-- end of Modal -->
    @endforeach
    <!-- Modal -->
    <div class="modal fade" id="addCebuProperty" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Add Property</h5>
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
                    <label>Property Name</label>
                    <input type="text" id="propName" name="propName" class="selcls form-control"  required/>
                </div>   
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
            <div class="col-lg-12">
                <label>Property Account Code</label>
                <input type="text" id="propAccountCode" name="propAccountCode" class="selcls form-control" required />
            </div>
          
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col-lg-12">
                    <label>Property Account Name</label>
                    <input type="text" id="propAccountName" name="propAccountName" class="selcls form-control" required />
                </div>
              
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col-lg-12">
                    <label>Address</label>
                    <input type="text" id="address" name="address" class="selcls form-control" required />
                </div>
             
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col-lg-12">
                    <label>Unit </label>
                    <input type="text" id="unit" name="unit" class="selcls form-control" required />
                </div>
              
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col-lg-12">
                    <label>Status</label>
                    <input type="text" id="status" name="status" class="selcls form-control"  />
                    <input type="hidden" id="flag" name="flag" value="Cebu Properties" />
                </div>
            </div>
        </div>
       
        </div>
        <div class="modal-footer">
            <button onclick=closeProperty() type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button onclick=saveProperty() type="button" class="btn btn-success">Add Property</button>
        </div>
        </div>
    </div>
    </div><!-- end of Modal -->
    @else
     <!-- Mdoal -->
     @foreach($getManilaProperties as $getManilaProperty)
     <div class="modal fade" id="manilaProp<?php echo $getManilaProperty['id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Edit Property</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <div class="form-group">
            <div class="form-row">
               
                <div id="succEditManila<?php echo $getManilaProperty['id']?>" class="col-lg-12"></div>
                <div class="col-lg-12">
                    <label>Property Name</label>
                    <input type="text" id="propNameManilaUpdate<?php echo $getManilaProperty['id'] ?>" name="propNameManilaUpdate" class="selcls form-control"  value="{{ $getManilaProperty['property_name'] }}" />
                </div>
              
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
            <div class="col-lg-12">
                <label>Property Account Code</label>
                <input type="text" id="propAccountCodeManilaUpdate<?php echo $getManilaProperty['id']?>" name="propAccountCodeManilaUpdate" class="selcls form-control" value="{{ $getManilaProperty['property_account_code'] }}" />
            </div>
          
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col-lg-12">
                    <label>Property Account Name</label>
                    <input type="text" id="propAccountNameManilaUpdate<?php echo $getManilaProperty['id']?>" name="propAccountNameManilaUpdate" class="selcls form-control" value="{{ $getManilaProperty['property_account_name'] }}" />
                </div>
              
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col-lg-12">
                    <label>Address</label>
                    <input type="text" id="manilaAddressUpdate<?php echo $getManilaProperty['id']?>" name="manilaAddressUpdate" class="selcls form-control" value="{{ $getManilaProperty['address'] }}" />
                </div>
             
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col-lg-12">
                    <label>Unit </label>
                    <input type="text" id="manilaUnitUpdate<?php echo $getManilaProperty['id']?>" name="manilaUnitUpdate" class="selcls form-control" value="{{ $getManilaProperty['unit'] }}" />
                </div>
              
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col-lg-12">
                    <label>Status</label>
                    <input type="text" id="manilaStatusUpdate<?php echo $getManilaProperty['id']?>" name="manilaStatusUpdate" class="selcls form-control" value="{{ $getManilaProperty['status'] }}" />
                  
                </div>
            </div>
        </div>
        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button onclick="updateManilaProperty(<?php echo $getManilaProperty['id'] ?>)" type="button" class="btn btn-success">Update Property</button>
        </div>
        </div>
    </div>
    </div><!-- end of modal -->
    @endforeach
    <!-- Mdoal -->
    <div class="modal fade" id="addManilaProperty" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Add Properties</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <div class="form-group">
            <div class="form-row">
                <div id="validateManila" class="col-lg-12">
                    <p class="alert alert-danger">Please Fill up the fields</p>
                </div>
                <div id="existsManila" class="col-lg-12"></div>
                <div id="succAddManila" class="col-lg-12"></div>
                <div class="col-lg-12">
                    <label>Property Name</label>
                    <input type="text" id="propNameManila" name="propNameManila" class="selcls form-control"  required/>
                </div>
              
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
            <div class="col-lg-12">
                <label>Property Account Code</label>
                <input type="text" id="propAccountCodeManila" name="propAccountCodeManila" class="selcls form-control" required />
            </div>
          
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col-lg-12">
                    <label>Property Account Name</label>
                    <input type="text" id="propAccountNameManila" name="propAccountNameManila" class="selcls form-control" required />
                </div>
              
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col-lg-12">
                    <label>Address</label>
                    <input type="text" id="manilaAddress" name="manilaAddress" class="selcls form-control" required />
                </div>
             
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col-lg-12">
                    <label>Unit </label>
                    <input type="text" id="manilaUnit" name="manilaUnit" class="selcls form-control" required />
                </div>
              
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col-lg-12">
                    <label>Status</label>
                    <input type="text" id="manilaStatus" name="manilaStatus" class="selcls form-control"  />
                    <input type="hidden" id="manilaFlag" name="manilaFlag" value="Manila Properties" />
                </div>
            </div>
        </div>
        
        </div>
        <div class="modal-footer">
            <button onclick=cancelManila() type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button onclick=saveManilaProperty() type="button" class="btn btn-success">Add Property</button>
        </div>
        </div>
    </div>
    </div><!-- end of modal -->
    @endif
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
    $("#validateManila").hide();

    const updateManilaProperty = (id) => {
        const propNameUpdate  = $("#propNameManilaUpdate"+id).val();
        const propAccountCodeUpdate = $("#propAccountCodeManilaUpdate"+id).val();
        const propAccountNameUpdate = $("#propAccountNameManilaUpdate"+id).val();
        const addressUpdate = $("#manilaAddressUpdate"+id).val();
        const unitUpdate = $("#manilaUnitUpdate"+id).val();
        const statusUpdate = $("#manilaStatusUpdate"+id).val();

         //make ajax call
         $.ajax({
            type:"PATCH",
            url:'/dno-personal/properties/update-property/' + id,
            data:{
                _method:'patch',
                "_token":"{{ csrf_token() }}",
                "id":id,
                "propNameUpdate":propNameUpdate,
                "propAccountCodeUpdate":propAccountCodeUpdate,
                "propAccountNameUpdate":propAccountNameUpdate,
                "addressUpdate":addressUpdate,
                "unitUpdate":unitUpdate,
                "statusUpdate":statusUpdate,
            },
            success:function(data){
                console.log(data);
                const getData = data;
                const succData = getData.split(":");
                const succDataArr = succData[0];
                if(succDataArr == "Success"){
                    $("#succEditManila"+id).fadeIn().delay(3000).fadeOut();
                    $("#succEditManila"+id).html(`<p class="alert alert-success"> ${data}</p>`);
                    
                    setTimeout(function(){
                        document.location.reload();
                    }, 3000);
                }
            },  
            error:function(data){
                console.log('Error:', data);
            } 
        });


    }

    const confirmDelete = (id) => {
        const x = confirm("Do you want to delete this?");
        if(x){
            $.ajax({
              type: "DELETE",
              url: '/dno-personal/delete-property/' + id,
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

    const updateProperty = (id) =>{
        const propNameUpdate  = $("#propNameUpdate"+id).val();
        const propAccountCodeUpdate = $("#propAccountCodeUpdate"+id).val();
        const propAccountNameUpdate = $("#propAccountNameUpdate"+id).val();
        const addressUpdate = $("#addressUpdate"+id).val();
        const unitUpdate = $("#unitUpdate"+id).val();
        const statusUpdate = $("#statusUpdate"+id).val();

        //make ajax call
        $.ajax({
            type:"PATCH",
            url:'/dno-personal/properties/update-property/' + id,
            data:{
                _method:'patch',
                "_token":"{{ csrf_token() }}",
                "id":id,
                "propNameUpdate":propNameUpdate,
                "propAccountCodeUpdate":propAccountCodeUpdate,
                "propAccountNameUpdate":propAccountNameUpdate,
                "addressUpdate":addressUpdate,
                "unitUpdate":unitUpdate,
                "statusUpdate":statusUpdate,
            },
            success:function(data){
                console.log(data);
                const getData = data;
                const succData = getData.split(":");
                const succDataArr = succData[0];
                if(succDataArr == "Success"){
                    $("#succEditSky"+id).fadeIn().delay(3000).fadeOut();
                    $("#succEditSky"+id).html(`<p class="alert alert-success"> ${data}</p>`);
                    
                    setTimeout(function(){
                        document.location.reload();
                    }, 3000);
                }
            },  
            error:function(data){
                console.log('Error:', data);
            } 
        });
    }

    const cancelManila = () =>{
        $("#propNameManila").val('');
        $("#propAccountCodeManila").val('');
        $("#propAccountNameManila").val('');
        $("#manilaAddress").val('');
        $("#manilaUnit").val('');
        $("#manilaStatus").val('');
        $("#manilaFlag").val('');


    }

    const saveManilaProperty = () =>{
        const propName = $("#propNameManila").val();
        const propAccountCode = $("#propAccountCodeManila").val();
        const propAccountName = $("#propAccountNameManila").val();
        const address = $("#manilaAddress").val();
        const unit = $("#manilaUnit").val();
        const status = $("#manilaStatus").val();
        const flag = $("#manilaFlag").val();

        if(propNameManila == "" || propAccountCode == "" || propAccountName == "" || address == "" 
        || unit == ""){
            $("#validateManila").fadeIn().delay(3000).fadeOut();
        }else{
            //make ajax call
            $.ajax({
                type: "POST",
                url: '/dno-personal/store-properties',
                data:{
                    _method: 'post',
                    "_token": "{{ csrf_token() }}",
                    "propName":propName,
                    "propAccountCode":propAccountCode,
                    "propAccountName":propAccountName,
                    "address":address,
                    "unit":unit,
                    "status":status,
                    "flag":flag
                },
                success:function(data){
                    console.log(data);
                    const getData = data;
                    const succData = getData.split(":");
                    const succDataArr = succData[0];
                    if(succDataArr == "Success"){
                       $("#succAddManila").fadeIn().delay(3000).fadeOut();
                       $("#succAddManila").html(`<p class="alert alert-success"> ${data}</p>`);
                      
                        setTimeout(function(){
                            document.location.reload();
                        }, 3000);
                    }else{
                        $("#existsManila").fadeIn().delay(3000).fadeOut();
                        $("#existsManila").html(`<p class="alert alert-danger">${data}</p>`);
                    }
                },
                error:function(data){
                    console.log('Error:', data);
                }
            });
        }
    }

    const closeProperty = () => {
        $("#propName").val('');
        $("#propAccountCode").val('');
        $("#propAccountName").val('');
        $("#address").val('');
        $("#unit").val('');
        $("#status").val('');
        $("#flag").val('');

    }

    const saveProperty = () => {
      
        const propName = $("#propName").val();
        const propAccountCode = $("#propAccountCode").val();
        const propAccountName = $("#propAccountName").val();
        const address = $("#address").val();
        const unit = $("#unit").val();
        const status = $("#status").val();
        const flag = $("#flag").val();

        if(propName == "" || propAccountCode == "" || propAccountName == "" || address == "" 
        || unit == ""){
            $("#validate").fadeIn().delay(3000).fadeOut();
        }else{
            //make ajax call
            $.ajax({
                type: "POST",
                url: '/dno-personal/store-properties',
                data:{
                    _method: 'post',
                    "_token": "{{ csrf_token() }}",
                    "propName":propName,
                    "propAccountCode":propAccountCode,
                    "propAccountName":propAccountName,
                    "address":address,
                    "unit":unit,
                    "status":status,
                    "flag":flag
                },
                success:function(data){
                    console.log(data);
                    const getData = data;
                    const succData = getData.split(":");
                    const succDataArr = succData[0];
                    if(succDataArr == "Success"){
                       $("#succAdd").fadeIn().delay(3000).fadeOut();
                       $("#succAdd").html(`<p class="alert alert-success"> ${data}</p>`);

                       setTimeout(function(){
                            document.location.reload();
                        }, 3000);
                    }else{
                        $("#exists").fadeIn().delay(3000).fadeOut();
                        $("#exists").html(`<p class="alert alert-danger">${data}</p>`);
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