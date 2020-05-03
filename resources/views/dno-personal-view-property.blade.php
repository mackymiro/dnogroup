@extends('layouts.dno-personal-app')
@section('title', 'View Property|')
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
                    <li class="breadcrumb-item active">Properties</li>
                    @if(\Request::is('dno-personal/cebu-properties/view/'.$viewProperty['id']))
                    <li class="breadcrumb-item active">View Cebu Property</li>
                    @else
                    <li class="breadcrumb-item active">View Manila Property</li>
                    @endif
                </ol>
                <div class="row">   
                    <div class="col-lg-12">
                        <div class="card mb-3">
                             <div class="card-header">
                                <i class="fas fa-building" aria-hidden="true"></i>
                                View My Property
                        
                             </div>
                             <div class="card-body">
                                 <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-2">
                                            <label>Property Name</label>
                                            <input type="text" name="propertyName" class="selcls form-control" value="{{ $viewProperty['property_name']}}" disabled="disabled" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Property Account Code</label>
                                            <input type="text" name="propertyAccountCode" class="selcls form-control" value="{{ $viewProperty['property_account_code'] }}"  disabled="disabled" />
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Property Account Name</label>
                                            <input type="text" name="propertyAccountName" class="selcls form-control" value="{{ $viewProperty['property_account_name'] }}"  disabled="disabled" />
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Address</label>
                                            <input type="text" name="address" class="selcls form-control" value="{{ $viewProperty['address']}}"  disabled="disabled" />
                                        </div>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <div class="form-row">
                                       
                                        <div class="col-lg-2">
                                            <label>Unit</label>
                                            <input type="text" name="unit" class="selcls form-control" value="{{ $viewProperty['unit']}}" disabled="disabled" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Status</label>
                                            <input type="text" name="status" class="selcls form-control" value="{{ $viewProperty['status'] }}" disabled="disabled" />
                                        </div>
                                    </div>
                                 </div>
                             </div>
                        </div>
                    </div>
                </div><!-- end of row-->
                <div class="row">
                     <div class="col-lg-12">
                         <div class="card mb-3">
                            <div class="card-header">
                                <i class="fas fa-bolt"></i>
                                Veco
                             </div>
                             <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12 ">
                                            <!-- Button trigger modal -->
                                          
                                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addVeco" >Add Veco </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered display"  width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Account ID</th>
                                                <th>Account Name</th>
                                                <th >Meter No</th>
                                                <th>Date</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                             <tr>
                                                <th>Action</th>
                                                <th>Account ID</th>
                                                <th>Account Name</th>
                                                <th >Meter No</th>
                                                <th>Date</th>
                                                <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody> 
                                            @foreach($vecoDocuments as $vecoDocument)
                                            <tr id="deletedId<?php echo $vecoDocument['id'];?>">
                                                <td >
                                                    @if($user->role_type !== 3)
                                                        <!-- Button trigger modal -->
                                                        <a data-toggle="modal" data-target="#editVeco<?php echo $vecoDocument['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                    @if($user->role_type == 1)
                                                        <a id="delete" onClick="confirmDelete('{{ $vecoDocument['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>                                                        
                                                    @endif
                                                </td>
                                                <td><a href="{{ url('dno-personal/cebu-properties/view-veco/'.$vecoDocument['id']) }}">{{ $vecoDocument['account_id']}}</a></td>
                                                <td>{{ $vecoDocument['account_name']}}</td>
                                                <td>{{ $vecoDocument['meter_no']}}</td>
                                                <td>{{ $vecoDocument['date']}}</td>
                                                <td>{{ $vecoDocument['created_by']}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                             </div> 
                         </div>
                     </div>
                </div><!-- end of row-->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                             <div class="card-header">
                                <i class="fas fa-water"></i>
                                MCWD
                             </div>
                             <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12 ">
                                            <!-- Button trigger modal -->
                                          
                                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addMCWD" >Add MCWD </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                <table class="table table-bordered display"  width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Account ID</th>
                                                <th>Account Name</th>
                                                <th >Meter No</th>
                                                <th>Date</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                             <tr>
                                                <th>Action</th>
                                                <th>Account ID</th>
                                                <th>Account Name</th>
                                                <th >Meter No</th>
                                                <th>Date</th>
                                                <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody> 
                                            @foreach($mcwdDocuments as $mcwdDocument)
                                            <tr id="deletedId<?php echo $mcwdDocument['id'];?>">
                                                <td>
                                                    @if($user->role_type !== 3)
                                                        <!-- Button trigger modal -->
                                                        <a data-toggle="modal" data-target="#editMCWD<?php echo $mcwdDocument['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                    @if($user->role_type == 1)
                                                        <a id="delete" onClick="confirmDelete('{{ $mcwdDocument['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>                                                        
                                                    @endif
                                                </td>
                                                <td><a href="{{ url('dno-personal/cebu-properties/view-mcwd/'.$mcwdDocument['id']) }}">{{ $mcwdDocument['account_id']}}</a></td>
                                                <td>{{ $mcwdDocument['account_name']}}</td>
                                                <td>{{ $mcwdDocument['meter_no']}}</td>
                                                <td>{{ $mcwdDocument['date']}}</td>
                                                <td>{{ $mcwdDocument['created_by']}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                             </div>
                        </div>
                    </div>  
                </div><!-- end of row-->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                             <div class="card-header">
                                <i class="fas fa-phone"></i>
                                PLDT
                             </div>
                             <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12 ">
                                            <!-- Button trigger modal -->
                                          
                                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addPLDT" >Add PLDT </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                <table class="table table-bordered display"  width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Account No</th>
                                                <th>Account Name</th>
                                                <th >Telephone No</th>
                                                <th>Date</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Action</th>
                                                <th>Account No</th>
                                                <th>Account Name</th>
                                                <th >Telephone No</th>
                                                <th>Date</th>
                                                <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody> 
                                            @foreach($PLDTDocuments as $PLDTDocument)
                                            <tr id="deletedId<?php echo $PLDTDocument['id']?>">
                                                <td>
                                                    @if($user->role_type !== 3)
                                                        <!-- Button trigger modal -->
                                                        <a data-toggle="modal" data-target="#editPLDT<?php echo $PLDTDocument['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                    @if($user->role_type == 1)
                                                        <a id="delete" onClick="confirmDelete('{{ $PLDTDocument['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>                                                        
                                                    @endif
                                                </td>
                                                <td><a href="{{ url('dno-personal/cebu-properties/view-pldt/'.$PLDTDocument['id']) }}">{{ $PLDTDocument['account_no']}}</a></td>
                                                <td>{{ $PLDTDocument['account_name']}}</td>
                                                <td>{{ $PLDTDocument['telephone_no']}}</td>
                                                <td>{{ $PLDTDocument['date']}}</td>
                                                <td>{{ $PLDTDocument['created_by']}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                             </div>
                        </div>
                    </div>  
                </div><!-- end of row-->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                             <div class="card-header">
                                <i class="fab fa-skyatlas"></i>
                                SKYCABLE
                             </div>
                             <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12 ">
                                            <!-- Button trigger modal -->
                                          
                                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addSky" >Add SkyCable </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                <table class="table table-bordered display"  width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Account No</th>
                                                <th>Account Name</th>
                                                <th>Date</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Action</th>
                                                <th>Account No</th>
                                                <th>Account Name</th>
                                                <th>Date</th>
                                                <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody> 
                                            @foreach($skyDocuments as $skyDocument)
                                            <tr id="deletedId<?php echo $skyDocument['id']?>">
                                               
                                                <td>
                                                    @if($user->role_type !== 3)
                                                        <!-- Button trigger modal -->
                                                        <a data-toggle="modal" data-target="#editSky<?php echo $skyDocument['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                    @if($user->role_type == 1)
                                                        <a id="delete" onClick="confirmDelete('{{ $skyDocument['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>                                                        
                                                    @endif
                                                </td>
                                                <td><a href="{{ url('dno-personal/cebu-properties/view-skycable/'.$skyDocument['id']) }}">{{ $skyDocument['account_no']}}</a></td>
                                                <td>{{ $skyDocument['account_name']}}</td>
                                                <td>{{ $skyDocument['date']}}</td>
                                                <td>{{ $skyDocument['created_by']}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                             </div>
                        </div>
                    </div>  
                </div><!-- end of row-->
                
                
         </div>
     </div>
      <!-- Modal -->
    @foreach($skyDocuments as $skyDocument)
    <div class="modal fade" id="editSky<?php echo $skyDocument['id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit SkyCable Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-row">
                            
                             <div id="succEditSky" class="col-lg-12"></div>
                            <div class="col-lg-12">
                                <label>Account No</label>
                                <input type="text" id="skyAccountNoUpdate<?php echo $skyDocument['id']?>" name="skyAccountNoUpdate" class="selcls form-control" value="{{ $skyDocument['account_no']}}" />
                            </div>
                            <div class="col-lg-12">
                                <label>Account Name</label>
                                <input type="text" id="skyAccountNameUpdate<?php echo $skyDocument['id']?>" name="skyAccountNameUpdate" class="selcls form-control"  value="{{ $skyDocument['account_name'] }}" />
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button  type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button onclick="updateSkyCable(<?php echo $skyDocument['id']?>)" type="button" class="btn btn-success">Update SkyCable</button>
                </div>
                </div>
            </div>
        </div><!-- end of MOdal -->
     @endforeach
     <!-- Modal -->
    <div class="modal fade" id="addSky" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add SkyCable Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-row">
                            <div id="validateSky" class="col-lg-12">
                                <p  class="alert alert-danger">Please Fill up the fields</p>
                            </div>
                            <div id="existsSky" class="col-lg-12"></div>
                             <div id="succAddSky" class="col-lg-12"></div>
                            <div class="col-lg-12">
                                <label>Account No</label>
                                <input type="text" id="skyAccountNo" name="accountNo" class="selcls form-control" />
                            </div>
                            <div class="col-lg-12">
                                <label>Account Name</label>
                                <input type="text" id="skyAccountName" name="skyAccountName" class="selcls form-control" />
                                <input type="hidden" id="flagSky" value="SkyCable" />
                                <input type="hidden" id="propIdSky" value="{{ $viewProperty['id'] }}" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="closeSkyCable()" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button onclick="saveSkyCable()" type="button" class="btn btn-success">Add SkyCable</button>
                </div>
                </div>
            </div>
        </div><!-- end of MOdal -->
      <!-- Modal -->
      @foreach($PLDTDocuments as $PLDTDocument)
      <div class="modal fade" id="editPLDT<?php echo $PLDTDocument['id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit PLDT Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="form-row">
                       
                         <div id="succEditPLDT" class="col-lg-12"></div>
                        <div class="col-lg-12">
                           
                            <label>Account Name</label>
                            <input type="text" id="accountNamePLDTUpdate<?php echo $PLDTDocument['id']?>" name="accountNamePLDTUpdate" class="selcls form-control"  value="{{ $PLDTDocument['account_name']}}" />
                        </div>
                        <div class="col-lg-12">
                            <label>Account No</label>
                            <input type="text" id="accountNoPLDTUpdate<?php echo $PLDTDocument['id']?>" name="accountNoPLDTUpdate" class="selcls form-control" value="{{ $PLDTDocument['account_no']}}"/>
                        </div>
                        <div class="col-lg-12">
                            <label>Telephone No</label>
                           
                            <input type="text" id="telephoneNOUpdate<?php echo $PLDTDocument['id']?>" name="telephoneNOUpdate" class="selcls form-control" value="{{ $PLDTDocument['telephone_no']}}" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button onclick="updatePLDT(<?php echo $PLDTDocument['id']?>)" type="button" class="btn btn-success">Update PLDT</button>
            </div>
            </div>
        </div>
    </div><!-- end of Modal -->
    @endforeach
      <!-- Modal -->
    
    <div class="modal fade" id="addPLDT" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add PLDT Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="form-row">
                        <div id="validatePLDT" class="col-lg-12">
                             <p  class="alert alert-danger">Please Fill up the fields</p>
                        </div>
                        <div id="existsPLDT" class="col-lg-12"></div>
                         <div id="succAddPLDT" class="col-lg-12"></div>
                        <div class="col-lg-12">
                           
                            <label>Account Name</label>
                            <input type="text" id="accountNamePLDT" name="accountNamePLDT" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Account No</label>
                            <input type="text" id="accountNoPLDT" name="accountNoPLDT" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Telephone No</label>
                            <input type="hidden" id="flagPLDT" value="PLDT" />
                            <input type="hidden" id="propIdPLDT" value="{{ $viewProperty['id'] }}" />
                            <input type="text" id="telephoneNO" name="telephoneNO" class="selcls form-control" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="closePLDT()" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button onclick="savePLDT()" type="button" class="btn btn-success">Add PLDT</button>
            </div>
            </div>
        </div>
    </div><!-- end of Modal -->
     <!-- Modal -->
     @foreach($mcwdDocuments as $mcwdDocument)
     <div class="modal fade" id="editMCWD<?php echo $mcwdDocument['id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit MCWD Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="form-row">
                       
                         <div id="succUpdateMCWD" class="col-lg-12"></div>
                        <div class="col-lg-12">
                           
                            <label>Account ID</label>
                            <input type="text" id="accountIdMCWDUpdate<?php echo $mcwdDocument['id']?>" name="accountIdMCWD" class="selcls form-control" value="{{ $mcwdDocument['account_id'] }}" />
                        </div>
                        <div class="col-lg-12">
                            <label>Account Name</label>
                            <input type="text" id="accountNameMCWDUpdate<?php echo $mcwdDocument['id']?>" name="accouaccountNameMCWDntName" class="selcls form-control" value="{{ $mcwdDocument['account_name'] }}" />
                        </div>
                        <div class="col-lg-12">
                            <label>Meter No</label>
                           
                            <input type="text" id="meterNoMCWDUpdate<?php echo $mcwdDocument['id']?>" name="meterNo" class="selcls form-control" value="{{ $mcwdDocument['meter_no'] }}"  />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button onclick="updateMCWD(<?php echo $mcwdDocument['id']?>)" type="button" class="btn btn-success">Update MCWD</button>
            </div>
            </div>
        </div>
    </div><!-- end of Modal -->
    @endforeach
      <!-- Modal -->
    <div class="modal fade" id="addMCWD" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add MCWD Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="form-row">
                        <div id="validateMCWD" class="col-lg-12">
                                <p  class="alert alert-danger">Please Fill up the fields</p>
                        </div>
                        <div id="exists" class="col-lg-12"></div>
                         <div id="succAdd" class="col-lg-12"></div>
                        <div class="col-lg-12">
                           
                            <label>Account ID</label>
                            <input type="text" id="accountIdMCWD" name="accountIdMCWD" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Account Name</label>
                            <input type="text" id="accountNameMCWD" name="accouaccountNameMCWDntName" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Meter No</label>
                            <input type="hidden" id="flagMCWD" value="MCWD" />
                            <input type="hidden" id="propIdMCWD" value="{{ $viewProperty['id'] }}" />
                            <input type="text" id="meterNoMCWD" name="meterNo" class="selcls form-control" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="closeMCWD()" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button onclick="saveMCWD()" type="button" class="btn btn-success">Add MCWD</button>
            </div>
            </div>
        </div>
    </div><!-- end of Modal -->

     <!-- Modal -->
     @foreach($vecoDocuments as $vecoDocument)
     <div class="modal fade" id="editVeco<?php echo $vecoDocument['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Veco Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="form-row">
                       
                        <div id="succUpdateVeco" class="col-lg-12"></div>
                        <div class="col-lg-12">
                           
                            <label>Account ID</label>
                            <input type="text" id="accountIdUpdate<?php echo $vecoDocument['id']?>" name="accountIdUpdate" class="selcls form-control" value="{{ $vecoDocument['account_id']}}" />
                        </div>
                        <div class="col-lg-12">
                            <label>Account Name</label>
                            <input type="text" id="accountNameUpdate<?php echo $vecoDocument['id']?>" name="accountNameUpdate" class="selcls form-control" value="{{ $vecoDocument['account_name']}}"  />
                        </div>
                        <div class="col-lg-12">
                            <label>Meter No</label>
                            <input type="text" id="meterNoUpdate<?php echo $vecoDocument['id']?>" name="meterNoUpdate" class="selcls form-control"  value="{{ $vecoDocument['meter_no']}}" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button onclick="updateVeco(<?php echo $vecoDocument['id']?>)" type="button" class="btn btn-success">Update Veco</button>
            </div>
            </div>
        </div>
    </div><!-- end of Modal -->
    @endforeach
    <!-- Modal -->
    <div class="modal fade" id="addVeco" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Veco Account</h5>
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
                        <div id="existsVeco" class="col-lg-12"></div>
                         <div id="succAddVeco" class="col-lg-12"></div>
                        <div class="col-lg-12">
                           
                            <label>Account ID</label>
                            <input type="text" id="accountId" name="accountId" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Account Name</label>
                            <input type="text" id="accountName" name="accountName" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Meter No</label>
                            <input type="hidden" id="flagVeco" value="Veco" />
                            <input type="hidden" id="propId" value="{{ $viewProperty['id'] }}" />
                            <input type="text" id="meterNo" name="meterNo" class="selcls form-control" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="closeVeco()" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button onclick="saveVeco()" type="button" class="btn btn-success">Add Veco</button>
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
   $("#validateMCWD").hide();
   $("#validatePLDT").hide();
   $("#validateSky").hide();

    const updateSkyCable = (id) => {
        const skyAccountNoUpdate = $("#skyAccountNoUpdate"+id).val();
        const skyAccountNameUpdate = $("#skyAccountNameUpdate"+id).val();

        //make ajax call
        $.ajax({
            type:"PATCH",
            url:'/dno-personal/properties/update-skycable/' + id,
            data:{
                _method:'patch',
                "_token":"{{ csrf_token() }}",
                "id":id,
                "skyAccountNoUpdate":skyAccountNoUpdate,
                "skyAccountNameUpdate":skyAccountNameUpdate,
            },
            success:function(data){
                console.log(data);
                const getData = data;
                const succData = getData.split(":");
                const succDataArr = succData[0];
                if(succDataArr == "Success"){
                    $("#succEditSky").fadeIn().delay(3000).fadeOut();
                    $("#succEditSky").html(`<p class="alert alert-success"> ${data}</p>`);
                    
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

    const updatePLDT = (id) => {
        const accountNamePLDTUpdate = $("#accountNamePLDTUpdate"+id).val();
        const accountNoPLDTUpdate = $("#accountNoPLDTUpdate"+id).val();
        const telephoneNOUpdate = $("#telephoneNOUpdate"+id).val();

        //make ajax call
        $.ajax({
            type:"PATCH",
            url:'/dno-personal/properties/update-pldt/' + id,
            data:{
                _method:'patch',
                "_token":"{{ csrf_token() }}",
                "id":id,
                "accountNamePLDTUpdate":accountNamePLDTUpdate,
                "accountNoPLDTUpdate":accountNoPLDTUpdate,
                "telephoneNOUpdate":telephoneNOUpdate,
            },
            success:function(data){
                console.log(data);
                const getData = data;
                const succData = getData.split(":");
                const succDataArr = succData[0];
                if(succDataArr == "Success"){
                    $("#succEditPLDT").fadeIn().delay(3000).fadeOut();
                    $("#succEditPLDT").html(`<p class="alert alert-success"> ${data}</p>`);
                    
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

    const updateMCWD = (id) => {
        const accountIdMCWDUpdate = $("#accountIdMCWDUpdate"+id).val();
        const accountNameMCWDUpdate = $("#accountNameMCWDUpdate"+id).val();
        const meterNoMCWDUpdate = $("#meterNoMCWDUpdate"+id).val();

        //make ajax call
        $.ajax({
            type:"PATCH",
            url:'/dno-personal/properties/update/' + id,
            data:{
                _method:'patch',
                "_token":"{{ csrf_token() }}",
                "id":id,
                "accountIdUpdate":accountIdMCWDUpdate,
                "accountNameUpdate":accountNameMCWDUpdate,
                "meterNoUpdate":meterNoMCWDUpdate,
            },
            success:function(data){
                console.log(data);
                const getData = data;
                const succData = getData.split(":");
                const succDataArr = succData[0];
                if(succDataArr == "Success"){
                    $("#succUpdateMCWD").fadeIn().delay(3000).fadeOut();
                    $("#succUpdateMCWD").html(`<p class="alert alert-success"> ${data}</p>`);
                    
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

    const updateVeco = (id) => {
        const accountIdUpdate = $("#accountIdUpdate" +id).val();
        const accountNameUpdate = $("#accountNameUpdate" +id).val();
        const meterNoUpdate = $("#meterNoUpdate"+id).val();

        //make ajax call
        $.ajax({
            type:"PATCH",
            url:'/dno-personal/properties/update/' + id,
            data:{
                _method:'patch',
                "_token":"{{ csrf_token() }}",
                "id":id,
                "accountIdUpdate":accountIdUpdate,
                "accountNameUpdate":accountNameUpdate,
                "meterNoUpdate":meterNoUpdate,
            },
            success:function(data){
                console.log(data);
                const getData = data;
                const succData = getData.split(":");
                const succDataArr = succData[0];
                if(succDataArr == "Success"){
                    $("#succUpdateVeco").fadeIn().delay(3000).fadeOut();
                    $("#succUpdateVeco").html(`<p class="alert alert-success"> ${data}</p>`);
                    
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
    
    const closeSkyCable = () => {
        $("#skyAccountNo").val('');
        $("#skyAccountName").val('');
    }

    const saveSkyCable = () => {
        const skyAccountNo  = $("#skyAccountNo").val();
        const skyAccountName = $("#skyAccountName").val();
        const propIdSky = $("#propIdSky").val();
        const flagSky = $("#flagSky").val();
        
        if(skyAccountNo == "" || skyAccountName == ""){
            $("#validateSky").fadeIn().delay(3000).fadeOut();
        }else{
            //make ajax call
            $.ajax({
                type: "POST",
                url: '/dno-persona/properties/add-skycable',
                data:{
                    _method: 'post',
                    "_token": "{{ csrf_token() }}",
                    "skyAccountNo":skyAccountNo,
                    "skyAccountName":skyAccountName,
                    "flagSky":flagSky,
                    "propIdSky":propIdSky
                },
                success:function(data){
                    console.log(data);
                    const getData = data;
                    const succData = getData.split(":");
                    const succDataArr = succData[0];
                    if(succDataArr == "Success"){
                       $("#succAddSky").fadeIn().delay(3000).fadeOut();
                       $("#succAddSky").html(`<p class="alert alert-success"> ${data}</p>`);
                      
                        setTimeout(function(){
                            document.location.reload();
                        }, 3000);
                    }else{
                        $("#existsSky").fadeIn().delay(3000).fadeOut();
                        $("#existsSky").html(`<p class="alert alert-danger">${data}</p>`);
                    }
                },
                error:function(data){
                    console.log('Error:', data);
                }
            });
        }       


    }

    const closePLDT = () =>{
        $("#accountNamePLDT").val('');
        $("#accountNoPLDT").val('');
        $("#telephoneNO").val('');
    }

    const savePLDT = () => {
        const accountNamePLDT = $("#accountNamePLDT").val();
        const accountNoPLDT = $("#accountNoPLDT").val();
        const telephoneNO = $("#telephoneNO").val();
        const flagPLDT = $("#flagPLDT").val();
        const propIdPLDT = $("#propIdPLDT").val();

        if(accountNamePLDT == "" || accountNoPLDT == "" || telephoneNO == ""){
            $("#validatePLDT").fadeIn().delay(3000).fadeOut();
        }else{
            //make ajax call
            $.ajax({
                type: "POST",
                url: '/dno-personal/properties/add-pldt',
                data:{
                    _method: 'post',
                    "_token": "{{ csrf_token() }}",
                    "accountNamePLDT":accountNamePLDT,
                    "accountNoPLDT":accountNoPLDT,
                    "telephoneNO":telephoneNO,
                    "flagPLDT":flagPLDT,
                    "propIdPLDT":propIdPLDT
                },
                success: function(data){
                    console.log(data);
                    const getData = data;
                    const succData = getData.split(":");
                    const succDataArr = succData[0];
                    if(succDataArr == "Success"){
                       $("#succAddPLDT").fadeIn().delay(3000).fadeOut();
                       $("#succAddPLDT").html(`<p class="alert alert-success"> ${data}</p>`);
                      
                        setTimeout(function(){
                            document.location.reload();
                        }, 3000);
                    }else{
                        $("#existsPLDT").fadeIn().delay(3000).fadeOut();
                        $("#existsPLDT").html(`<p class="alert alert-danger">${data}</p>`);
                    }
                },
                error:function(data){
                    console.log('Error:', data);
                }
            });
        }
    }

    const closeMCWD = () => {
        $("#accountIdMCWD").val('');
        $("#accountNameMCWD").val('');
        $("#meterNoMCWD").val('');
    }

    const saveMCWD = () =>{
        const accountId = $("#accountIdMCWD").val();
        const accountName = $("#accountNameMCWD").val();
        const meterNo = $("#meterNoMCWD").val();
        const flag = $("#flagMCWD").val();
        const propId = $("#propIdMCWD").val();
        
        if(accountId == "" || accountName == "" || meterNo == ""){
            $("#validateMCWD").fadeIn().delay(3000).fadeOut();
        }else{
            //make ajax call
            $.ajax({
                type: "POST",
                url: '/dno-personal/properties/add-bill',
                data:{
                    _method: 'post',
                    "_token": "{{ csrf_token() }}",
                    "accountId":accountId,
                    "accountName":accountName,
                    "meterNo":meterNo,
                    "flag":flag,
                    "propId":propId
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
   
    const closeVeco = () =>{
        $("#accountId").val('');
        $("#accountName").val('');
        $("#meterNo").val('');
    }

    const saveVeco = () => {
        const accountId = $("#accountId").val();
        const accountName = $("#accountName").val();
        const meterNo = $("#meterNo").val();
        const flag = $("#flagVeco").val();
        const propId = $("#propId").val();
       
        if(accountId == "" || accountName == ""  || meterNo == ""){
            $("#validate").fadeIn().delay(3000).fadeOut();
        }else{  

            //make ajax call
            $.ajax({
                type: "POST",
                url: '/dno-personal/properties/add-bill',
                data:{
                    _method: 'post',
                    "_token": "{{ csrf_token() }}",
                    "accountId":accountId,
                    "accountName":accountName,
                    "meterNo":meterNo,
                    "flag":flag,
                    "propId":propId
                },
                success:function(data){
                    console.log(data);
                    const getData = data;
                    const succData = getData.split(":");
                    const succDataArr = succData[0];
                    if(succDataArr == "Success"){
                       $("#succAddVeco").fadeIn().delay(3000).fadeOut();
                       $("#succAddVeco").html(`<p class="alert alert-success"> ${data}</p>`);
                      
                        setTimeout(function(){
                            document.location.reload();
                        }, 3000);
                    }else{
                        $("#existsVeco").fadeIn().delay(3000).fadeOut();
                        $("#existsVeco").html(`<p class="alert alert-danger">${data}</p>`);
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
