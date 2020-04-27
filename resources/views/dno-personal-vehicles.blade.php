@extends('layouts.dno-personal-app')
@section('title', 'Utilitie|')
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
                        <div class="col-lg-12">
                            <label>Vehicle Unit</label>
                            <input type="text" name="vehicleUnit" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Series</label>
                            <input type="text" name="series" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Denomination</label>
                            <input type="text" name="deniomination" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Body Type</label>
                            <input type="text" name="bodyType" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Year Model</label>
                            <input type="text" name="yearModel" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>MV FILE NO</label>
                            <input type="text" name="mVFIle" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Plate No</label>
                            <input type="text" name="plateNo" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Engine No</label>
                            <input type="text" name="engineNo" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Cr No</label>
                            <input type="text" name="crNo" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Location</label>
                            <input type="text" name="location" class="selcls form-control" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success">Add Vehicle</button>
            </div>
            </div>
        </div>
    </div><!-- end modal -->
</div>

@endsection