@extends('layouts.dno-personal-app')
@section('title', 'View Vehicles|')
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
      $('.alert-danger').fadeIn().delay(3000).fadeOut();

      $('table.display').DataTable( {} );
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
                    <li class="breadcrumb-item ">View Vehicle</li>
                   
                </ol>
                <div class="row">
                    <div class="col-lg-12">
                         <div class="card mb-3">
                             <div class="card-header">
                                <i class="fas fa-car" aria-hidden="true"></i>
                                    View Vehicle
						     </div>
                             <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-2">
                                            <label>Vehicle Unit</label>
                                            <input type="text" name="vehicleUnit" class="form-control selcls" value="{{ $getVehicle['vehicle_unit']}}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Series</label>
                                            <input type="text" name="series" class="form-control selcls" value="{{ $getVehicle['series'] }}" />
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Denomination</label>
                                            <input type="text" name="denomination" class="form-control selcls" value="{{ $getVehicle['denomination'] }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Body Type</label>
                                            <input type="text" name="bodyType" class="form-control selcls" value="{{ $getVehicle['body_type'] }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Year Model</label>
                                            <input type="text" name="yearModel" class="form-control selcls" value="{{ $getVehicle['year_model'] }}" />
                                        </div>
                                       
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                         <div class="col-lg-2">
                                            <label>MV File No</label>
                                            <input type="text" name="mVFile" class="form-control selcls" value="{{ $getVehicle['mv_file_no'] }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Plate No</label>
                                            <input type="text" name="plateNo" class="form-control selcls" value="{{ $getVehicle['plate_no'] }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Engine No</label>
                                            <input type="text" name="engineNo" class="form-control selcls" value="{{ $getVehicle['engine_no'] }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Cr No</label>
                                            <input type="text" name="crNo" class="form-control selcls" value="{{ $getVehicle['cr_no'] }}"/>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Location</label>
                                            <input type="text" name="location" class="form-control selcls" value="{{ $getVehicle['location'] }}" />
                                        </div>  
                                    </div>
                                </div>
                             </div>
                         </div>
                    </div>
                </div>  
                <div class="row">
                     <div class="col-lg-4">
                         <div class="card mb-3">
                             <div class="card-header">
                                <i class="fas fa-image" aria-hidden="true"></i>
                                    Upload Document (OR List)
						     </div>
                             <div class="card-body">
                                <form action="{{ action('DnoPersonalController@storeDocument', $getVehicle['id']) }}" method="post" enctype="multipart/form-data">
                                    {{csrf_field() }}
                                    <input name="_method" type="hidden" value="POST">
                                    @if(session('uploadDocu'))
                                        <p class="alert alert-success">{{ Session::get('uploadDocu') }}</p>
                                    @endif
                                    @if(session('err'))
                                        <p class="alert alert-danger">{{ Session::get('err') }}</p>
                                    @endif
                                    <div class="form-group">
                                        <div class="form-row">
                                             <div class="col-lg-12">
                                                <label>Document Name</label>
                                                <input type="text" name="docName" class="form-control selcls" required />
                                            </div>
                                            <div class="col-lg-12">
                                                <label>Upload File</label>
                                                <input type="file" name="document" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <input type="submit" class="btn btn-success"  value="Upload OR Document" />
                                        </div>
                                    </div>
                                </form>
                             </div>
                         </div>
                     </div>
                     <div class="col-lg-8">
                        <div class="card mb-3">
                             <div class="card-header">
                                <i class="fas fa-receipt" aria-hidden="true"></i>
                                    OR Lists
						     </div>
                             <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered display"  width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Document Name</th>
                                                <th>Document</th>
                                                <th>Date</th>
                                                <th>Created By</th>
                                            </tr>
                                         </thead>
                                         <tfoot>
                                            <tr>
                                                <th>Action</th>
                                                <th>Document Name</th>
                                                <th>Document</th>
                                                <th>Date</th>
                                                <th>Created By</th>
                                            </tr>
                                         </tfoot>
                                         <tbody>
                                            @foreach($getORDocuments as $getORDocument)
                                            <tr id="deletedId<?php echo $getORDocument['id'];?>">
                                                <td>
                                                    <a href="{{ url('dno-personal/vehicles/or-list/'.$getORDocument['id']) }}" title="View"><i class="fas fa-low-vision"></i></a>                                    
                                                    @if($user->role_type == 1)
                                                         <a id="delete" onClick="confirmDelete('{{ $getORDocument['id'] }}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                                                     @endif
                                                </td>
                                                <td>{{ $getORDocument['document_name']}}</td>
                                                <td>{{$getORDocument['upload_document']}}</td>
                                                <td>{{ $getORDocument['date']}}</td>
                                                <td>{{ $getORDocument['created_by']}}</td>
                                            </tr>
                                            @endforeach
                                         </tbody>
                                    </table>
                                </div>
                             </div>
                        </div>
                     </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                         <div class="card mb-3">
                             <div class="card-header">
                                <i class="fas fa-image" aria-hidden="true"></i>
                                    Upload Document (PMS)
                             </div>
                             <div class="card-body">
                                <form action="{{ action('DnoPersonalController@storePMSDocument', $getVehicle['id']) }}" method="post" enctype="multipart/form-data">
                                    {{csrf_field() }}
                                    <input name="_method" type="hidden" value="POST">
                                    @if(session('uploadPMSDocu'))
                                        <p class="alert alert-success">{{ Session::get('uploadPMSDocu') }}</p>
                                    @endif
                                    @if(session('errorUp'))
                                        <p class="alert alert-danger">{{ Session::get('errorUp') }}</p>
                                    @endif
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="col-lg-12">
                                                <label>Document Name</label>
                                                <input type="text" name="docName" class="form-control selcls" required />
                                            </div>
                                            <div class="col-lg-12">
                                                <label>Upload File</label>
                                                <input type="file" name="document" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <input type="submit" class="btn btn-success"  value="Upload PMS Document" />
                                        </div>
                                    </div>
                                </form>
                             </div>
                         </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card mb-3">
                            <div class="card-header">
                                  <i class="fas fa-receipt" aria-hidden="true"></i>
                                PMS List
                            </div>
                            <div class="card-body">
                                 <div class="table-responsive">
                                    <table class="table table-bordered display"  width="100%" cellspacing="0">
                                         <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Document Name</th>
                                                <th>Document</th>
                                                <th>Date</th>
                                                <th>Created By</th>
                                            </tr>
                                         </thead>
                                         <tfoot>
                                            <tr>
                                                <th>Action</th>
                                                <th>Document Name</th>
                                                <th>Document</th>
                                                <th>Date</th>
                                                <th>Created By</th>
                                            </tr>
                                         </tfoot>
                                         <tbody>
                                            @foreach($getPMSDocuments as $getPMSDocument)
                                            <tr id="deletedId<?php echo $getPMSDocument['id']?>">
                                                <td>
                                                    <a href="{{ url('dno-personal/vehicles/pms-list/'.$getPMSDocument['id']) }}" title="View"><i class="fas fa-low-vision"></i></a>                                    
                                                    @if($user->role_type == 1)
                                                         <a id="delete" onClick="confirmDelete('{{ $getPMSDocument['id'] }}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                                                     @endif
                                                </td>
                                                <td>{{ $getPMSDocument['document_name']}}</td>
                                                <td>{{ $getPMSDocument['upload_document']}}</td>
                                                <td>{{ $getPMSDocument['date']}}</td>
                                                <td>{{ $getPMSDocument['created_by']}}</td>
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
</script>
@endsection