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
                @if(\Request::is('dno-personal/cebu-properties/view/'.$viewProperty['id']))
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
                                          
                                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addVeco" ><i class="fa fa-plus" aria-hidden="true"></i> Add Veco </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered display"  width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Account Id</th>
                                                <th>Account Name</th>
                                                <th >Meter No</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                             <tr>
                                                <th>Action</th>
                                                <th>Account Id</th>
                                                <th>Account Name</th>
                                                <th >Meter No</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody> 
                                            @foreach($vecoDocuments as $vecoDocument)
                                            <tr class="deletedId<?php echo $vecoDocument['id'];?>">
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
                                                <?php
                                                    $viewParticulars  =  DB::table(
                                                                            'dno_personal_payment_vouchers')
                                                                        ->where('sub_category_account_id', $vecoDocument['id'])
                                                                        ->get();
                                               ?>   
                                                
                                               <?php if($viewParticulars === ""): ?>
                                                    <td class="bg-danger " style="color:#fff;">UNPAID</td>
                                               <?php else:?>
                                                @foreach($viewParticulars as $viewParticular)
                                                <?php if($viewParticular->status == "FOR APPROVAL" ): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewParticular->status == "FOR CONFIRMATION " ): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewParticular->status == "FULLY PAID AND RELEASED" ): ?>
                                                    <td class="bg-success" style="color:#fff;">PAID</td>
                                                <?php elseif($viewParticular->status == ""):?>
                                                    <t class="bg-danger" style="color:#fff;"d>UNPAID</td>
                                                <?php endif;?>
                                                
                                                @endforeach
                                                <?php endif;?>
                                             
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
                @elseif(\Request::is('dno-personal/manila-properties/view/'.$viewProperty['id']))
                <div class="row">
                     <div class="col-lg-12">
                         <div class="card mb-3">
                            <div class="card-header">
                                <i class="fas fa-bolt"></i>
                                MERALCO
                             </div>
                             <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12 ">
                                            <!-- Button trigger modal -->
                                          
                                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addMeralco" ><i class="fa fa-plus" aria-hidden="true"></i> Add Meralco </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered display"  width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Account Id</th>
                                                <th>Account Name</th>
                                                <th >Meter No</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                             <tr>
                                                <th>Action</th>
                                                <th>Account Id</th>
                                                <th>Account Name</th>
                                                <th >Meter No</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody> 
                                            @foreach($meralcoDocuments as $meralcoDocument)
                                            <tr class="deletedId<?php echo $meralcoDocument['id'];?>">
                                                <td >
                                                    @if(Auth::user()['role_type'] !== 3)
                                                        <!-- Button trigger modal -->
                                                        <a data-toggle="modal" data-target="#editMeralco<?php echo $meralcoDocument['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                    @if(Auth::user()['role_type'] == 1)
                                                        <a id="delete" onClick="confirmDelete('{{ $meralcoDocument['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>                                                        
                                                    @endif
                                                </td>
                                             
                                                <td><a href="{{ url('dno-personal/manila-properties/view-meralco/'.$meralcoDocument['id']) }}">{{ $meralcoDocument['account_id']}}</a></td>
                                               
                                                <td>{{ $meralcoDocument['account_name']}}</td>
                                                <td>{{ $meralcoDocument['meter_no']}}</td>
                                                <td>{{ $meralcoDocument['date']}}</td>
                                               
                                               <?php
                                                    $viewParticulars  =  DB::table(
                                                                            'dno_personal_payment_vouchers')
                                                                        ->where('sub_category_account_id', $meralcoDocument['id'])
                                                                        ->get();
                                               ?>   
                                                
                                               <?php if($viewParticulars === ""): ?>
                                                    <td class="bg-danger " style="color:#fff;">UNPAID</td>
                                               <?php else:?>
                                                @foreach($viewParticulars as $viewParticular)
                                                <?php if($viewParticular->status == "FOR APPROVAL" ): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewParticular->status == "FOR CONFIRMATION " ): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewParticular->status == "FULLY PAID AND RELEASED" ): ?>
                                                    <td class="bg-success" style="color:#fff;">PAID</td>
                                                <?php elseif($viewParticular->status == ""):?>
                                                    <t class="bg-danger" style="color:#fff;"d>UNPAID</td>
                                                <?php endif;?>
                                                
                                                @endforeach
                                                <?php endif;?>
                                               
                                                <td>{{ $meralcoDocument['created_by']}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                             </div> 
                         </div>
                     </div>
                </div><!-- end of row-->

                @endif
                @if(\Request::is('dno-personal/cebu-properties/view/'.$viewProperty['id']))
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
                                          
                                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addMCWD" ><i class="fa fa-plus" aria-hidden="true"></i> Add MCWD </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                <table class="table table-bordered display"  width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Account Id</th>
                                                <th>Account Name</th>
                                                <th >Meter No</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                             <tr>
                                                <th>Action</th>
                                                <th>Account Id</th>
                                                <th>Account Name</th>
                                                <th >Meter No</th>
                                                <th>Date</th>
                                                <th>Status</th>
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
                                                <?php
                                                    $viewParticulars  =  DB::table(
                                                                            'dno_personal_payment_vouchers')
                                                                        ->where('sub_category_account_id', $mcwdDocument['id'])
                                                                        ->get();
                                               ?>   
                                                
                                                @foreach($viewParticulars as $viewParticular)
                                                <?php if($viewParticular->status == "FOR APPROVAL" ): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewParticular->status == "FOR CONFIRMATION " ): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewParticular->status == "FULLY PAID AND RELEASED" ): ?>
                                                    <td class="bg-success" style="color:#fff;">PAID</td>
                                             
                                                <?php endif;?>
                                                
                                                @endforeach
                                              
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
                @elseif(\Request::is('dno-personal/manila-properties/view/'.$viewProperty['id']))
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
                                          
                                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addMCWD" ><i class="fa fa-plus" aria-hidden="true"></i> Add MCWD </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                <table class="table table-bordered display"  width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Account Id</th>
                                                <th>Account Name</th>
                                                <th >Meter No</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                             <tr>
                                                <th>Action</th>
                                                <th>Account Id</th>
                                                <th>Account Name</th>
                                                <th >Meter No</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody> 
                                            @foreach($mcwdDocuments as $mcwdDocument)
                                            <tr class="deletedId<?php echo $mcwdDocument['id'];?>">
                                                <td>
                                                    @if($user->role_type !== 3)
                                                        <!-- Button trigger modal -->
                                                        <a data-toggle="modal" data-target="#editMCWD<?php echo $mcwdDocument['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                    @if($user->role_type == 1)
                                                        <a id="delete" onClick="confirmDelete('{{ $mcwdDocument['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>                                                        
                                                    @endif
                                                </td>
                                             
                                                    <td><a href="{{ url('dno-personal/manila-properties/view-mcwd/'.$mcwdDocument['id']) }}">{{ $mcwdDocument['account_id']}}</a></td>
                                               
                                            
                                                <td>{{ $mcwdDocument['account_name']}}</td>
                                                <td>{{ $mcwdDocument['meter_no']}}</td>
                                                <td>{{ $mcwdDocument['date']}}</td>
                                                <?php
                                                    $viewParticulars  =  DB::table(
                                                                            'dno_personal_payment_vouchers')
                                                                        ->where('sub_category_account_id', $mcwdDocument['id'])
                                                                        ->get();
                                               ?>   
                                                
                                               <?php if($viewParticulars === ""): ?>
                                                    <td class="bg-danger " style="color:#fff;">UNPAID</td>
                                               <?php else:?>
                                                @foreach($viewParticulars as $viewParticular)
                                                <?php if($viewParticular->status == "FOR APPROVAL" ): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewParticular->status == "FOR CONFIRMATION " ): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewParticular->status == "FULLY PAID AND RELEASED" ): ?>
                                                    <td class="bg-success" style="color:#fff;">PAID</td>
                                              
                                                <?php endif;?>
                                                
                                                @endforeach
                                                <?php endif;?>
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


                @endif
                @if(\Request::is('dno-personal/cebu-properties/view/'.$viewProperty['id']))
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
                                          
                                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addPLDT" ><i class="fa fa-plus" aria-hidden="true"></i> Add PLDT </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                <table class="table table-bordered display"  width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Account Id</th>
                                                <th>Account Name</th>
                                                <th >Telephone No</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Action</th>
                                                <th>Account Id</th>
                                                <th>Account Name</th>
                                                <th >Telephone No</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody> 
                                            @foreach($PLDTDocuments as $PLDTDocument)
                                            <tr class="deletedId<?php echo $PLDTDocument['id']?>">
                                                <td>
                                                    @if($user->role_type !== 3)
                                                        <!-- Button trigger modal -->
                                                        <a data-toggle="modal" data-target="#editPLDT<?php echo $PLDTDocument['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                    @if($user->role_type == 1)
                                                        <a id="delete" onClick="confirmDelete('{{ $PLDTDocument['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>                                                        
                                                    @endif
                                                </td>
                                                @if(\Request::is('dno-personal/cebu-properties/view/'.$viewProperty['id']))
                                                    <td><a href="{{ url('dno-personal/cebu-properties/view-pldt/'.$PLDTDocument['id']) }}">{{ $PLDTDocument['account_id']}}</a></td>
                                                @else
                                                    <td><a href="{{ url('dno-personal/manila-properties/view-pldt/'.$PLDTDocument['id']) }}">{{ $PLDTDocument['account_id']}}</a></td>
                                              
                                                @endif
                                                <td>{{ $PLDTDocument['account_name']}}</td>
                                                <td>{{ $PLDTDocument['telephone_no']}}</td>
                                                <td>{{ $PLDTDocument['date']}}</td>
                                                <?php
                                                    $viewParticulars  =  DB::table(
                                                                            'dno_personal_payment_vouchers')
                                                                        ->where('sub_category_account_id', $PLDTDocument['id'])
                                                                        ->get();
                                               ?>   
                                                
                                               <?php if($viewParticulars === ""): ?>
                                                    <td class="bg-danger " style="color:#fff;">UNPAID</td>
                                               <?php else:?>
                                                @foreach($viewParticulars as $viewParticular)
                                                <?php if($viewParticular->status == "FOR APPROVAL" ): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewParticular->status == "FOR CONFIRMATION " ): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewParticular->status == "FULLY PAID AND RELEASED" ): ?>
                                                    <td class="bg-success" style="color:#fff;">PAID</td>
                                               
                                                <?php endif;?>
                                                
                                                @endforeach
                                                <?php endif;?>
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
                                <i class="fas fa-phone"></i>
                                GLOBE TELECOM
                             </div>
                             <div class="card-body">
                                 <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12 ">
                                            <!-- Button trigger modal -->
                                          
                                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addGlobe" ><i class="fa fa-plus" aria-hidden="true"></i> Add Globe Telecom </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                     <table class="table table-bordered display"  width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Account Id</th>
                                                <th>Account Name</th>
                                                <th >Telephone No</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Action</th>
                                                <th>Account Id</th>
                                                <th>Account Name</th>
                                                <th >Telephone No</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody> 
                                            @foreach($globeDocuments as $globeDocument)
                                            <tr class="deletedId<?php echo $globeDocument['id']?>">
                                                <td>
                                                    @if(Auth::user()['role_type'] !== 3)
                                                        <!-- Button trigger modal -->
                                                        <a data-toggle="modal" data-target="#editGlobe<?php echo $globeDocument['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                    @if(Auth::user()['role_type'] == 1)
                                                        <a id="delete" onClick="confirmDelete('{{ $globeDocument['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>                                                        
                                                    @endif
                                                </td>
                                                @if(\Request::is('dno-personal/manila-properties/view/'.$viewProperty['id']))
                                                    <td><a href="{{ url('dno-personal/manila-properties/view-globe/'.$globeDocument['id']) }}">{{ $globeDocument['account_id']}}</a></td>
                                                @else
                                                    <td><a href="{{ url('dno-personal/manila-properties/view-globe/'.$globeDocument['id']) }}">{{ $globeDocument['account_id']}}</a></td>
                                              
                                                @endif
                                                <td>{{ $globeDocument['account_name']}}</td>
                                                <td>{{ $globeDocument['telephone_no']}}</td>
                                                <td>{{ $globeDocument['date']}}</td>
                                                <?php
                                                    $viewParticulars  =  DB::table(
                                                                            'dno_personal_payment_vouchers')
                                                                        ->where('sub_category_account_id', $globeDocument['id'])
                                                                        ->get();
                                               ?>   
                                                
                                               <?php if($viewParticulars === ""): ?>
                                                    <td class="bg-danger " style="color:#fff;">UNPAID</td>
                                               <?php else:?>
                                                @foreach($viewParticulars as $viewParticular)
                                                <?php if($viewParticular->status == "FOR APPROVAL" ): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewParticular->status == "FOR CONFIRMATION " ): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewParticular->status == "FULLY PAID AND RELEASED" ): ?>
                                                    <td class="bg-success" style="color:#fff;">PAID</td>
                                               
                                                <?php endif;?>
                                                
                                                @endforeach
                                                <?php endif;?>
                                                <td>{{ $globeDocument['created_by']}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                             </div> 
                        </div>
                     </div>
                </div><!-- end of row -->
                <div class="row">
                     <div class="col-lg-12">
                        <div class="card mb-3">
                             <div class="card-header">
                                <i class="fas fa-phone"></i>
                                SMART COMMUNICATIONS INC
                             </div>
                             <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12 ">
                                            <!-- Button trigger modal -->
                                          
                                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addSmart" ><i class="fa fa-plus" aria-hidden="true"></i> Add Smart Communications </a>
                                        </div>

                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered display"  width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Account Id</th>
                                                <th>Account Name</th>
                                                <th >Telephone No</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Action</th>
                                                <th>Account Id</th>
                                                <th>Account Name</th>
                                                <th >Telephone No</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody> 
                                            @foreach($smartDocuments as $smartDocument)
                                            <tr class="deletedId<?php echo $smartDocument['id']?>">
                                                <td>
                                                    @if(Auth::user()['role_type'] !== 3)
                                                        <!-- Button trigger modal -->
                                                        <a data-toggle="modal" data-target="#editSmart<?php echo $smartDocument['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                    @if(Auth::user()['role_type'] == 1)
                                                        <a id="delete" onClick="confirmDelete('{{ $smartDocument['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>                                                        
                                                    @endif
                                                </td>
                                                @if(\Request::is('dno-personal/manila-properties/view/'.$viewProperty['id']))
                                                    <td><a href="{{ url('dno-personal/cebu-properties/view-globe/'.$smartDocument['id']) }}">{{ $smartDocument['account_id']}}</a></td>
                                                @else
                                                    <td><a href="{{ url('dno-personal/cebu-properties/view-globe/'.$globeDocument['id']) }}">{{ $smartDocument['account_id']}}</a></td>
                                              
                                                @endif
                                                <td>{{ $smartDocument['account_name']}}</td>
                                                <td>{{ $smartDocument['telephone_no']}}</td>
                                                <td>{{ $smartDocument['date']}}</td>
                                                <?php
                                                    $viewParticulars  =  DB::table(
                                                                            'dno_personal_payment_vouchers')
                                                                        ->where('sub_category_account_id', $smartDocument['id'])
                                                                        ->get();
                                               ?>   
                                                
                                               <?php if($viewParticulars === ""): ?>
                                                    <td class="bg-danger " style="color:#fff;">UNPAID</td>
                                               <?php else:?>
                                                @foreach($viewParticulars as $viewParticular)
                                                <?php if($viewParticular->status == "FOR APPROVAL" ): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewParticular->status == "FOR CONFIRMATION " ): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewParticular->status == "FULLY PAID AND RELEASED" ): ?>
                                                    <td class="bg-success" style="color:#fff;">PAID</td>
                                               
                                                <?php endif;?>
                                                
                                                @endforeach
                                                <?php endif;?>
                                                <td>{{ $smartDocument['created_by']}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                             </div>
                        </div>
                     </div>
                </div><!-- end of row-->
                @elseif(\Request::is('dno-personal/manila-properties/view/'.$viewProperty['id']))
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
                                          
                                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addPLDT" ><i class="fa fa-plus" aria-hidden="true"></i> Add PLDT </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                <table class="table table-bordered display"  width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Account Id</th>
                                                <th>Account Name</th>
                                                <th >Telephone No</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Action</th>
                                                <th>Account Id</th>
                                                <th>Account Name</th>
                                                <th >Telephone No</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody> 
                                            @foreach($PLDTDocuments as $PLDTDocument)
                                            <tr class="deletedId<?php echo $PLDTDocument['id']?>">
                                                <td>
                                                    @if($user->role_type !== 3)
                                                        <!-- Button trigger modal -->
                                                        <a data-toggle="modal" data-target="#editPLDT<?php echo $PLDTDocument['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                    @if($user->role_type == 1)
                                                        <a id="delete" onClick="confirmDelete('{{ $PLDTDocument['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>                                                        
                                                    @endif
                                                </td>
                                              
                                                <td><a href="{{ url('dno-personal/manila-properties/view-pldt/'.$PLDTDocument['id']) }}">{{ $PLDTDocument['account_id']}}</a></td>
                                              
                                          
                                                <td>{{ $PLDTDocument['account_name']}}</td>
                                                <td>{{ $PLDTDocument['telephone_no']}}</td>
                                                <td>{{ $PLDTDocument['date']}}</td>
                                                <?php
                                                    $viewParticulars  =  DB::table(
                                                                            'dno_personal_payment_vouchers')
                                                                        ->where('sub_category_account_id', $PLDTDocument['id'])
                                                                        ->get();
                                               ?>   
                                                
                                               <?php if($viewParticulars === ""): ?>
                                                    <td class="bg-danger " style="color:#fff;">UNPAID</td>
                                               <?php else:?>
                                                @foreach($viewParticulars as $viewParticular)
                                                <?php if($viewParticular->status == "FOR APPROVAL" ): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewParticular->status == "FOR CONFIRMATION " ): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewParticular->status == "FULLY PAID AND RELEASED" ): ?>
                                                    <td class="bg-success" style="color:#fff;">PAID</td>
                                              
                                                <?php endif;?>
                                                
                                                @endforeach
                                                <?php endif;?>
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
                                <i class="fas fa-phone"></i>
                                GLOBE TELECOM
                             </div>
                             <div class="card-body">
                                 <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12 ">
                                            <!-- Button trigger modal -->
                                          
                                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addGlobe" ><i class="fa fa-plus" aria-hidden="true"></i> Add Globe Telecom </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                     <table class="table table-bordered display"  width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Account Id</th>
                                                <th>Account Name</th>
                                                <th >Telephone No</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Action</th>
                                                <th>Account Id</th>
                                                <th>Account Name</th>
                                                <th >Telephone No</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody> 
                                            @foreach($globeDocuments as $globeDocument)
                                            <tr class="deletedId<?php echo $globeDocument['id']?>">
                                                <td>
                                                    @if($user->role_type !== 3)
                                                        <!-- Button trigger modal -->
                                                        <a data-toggle="modal" data-target="#editGlobe<?php echo $globeDocument['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                    @if($user->role_type == 1)
                                                        <a id="delete" onClick="confirmDelete('{{ $globeDocument['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>                                                        
                                                    @endif
                                                </td>
                                                @if(\Request::is('dno-personal/cebu-properties/view/'.$viewProperty['id']))
                                                    <td><a href="{{ url('dno-personal/cebu-properties/view-globe/'.$globeDocument['id']) }}">{{ $globeDocument['account_id']}}</a></td>
                                                @else
                                                    <td><a href="{{ url('dno-personal/manila-properties/view-globe/'.$globeDocument['id']) }}">{{ $globeDocument['account_id']}}</a></td>
                                              
                                                @endif
                                                <td>{{ $globeDocument['account_name']}}</td>
                                                <td>{{ $globeDocument['telephone_no']}}</td>
                                                <td>{{ $globeDocument['date']}}</td>
                                                <?php
                                                    $viewParticulars  =  DB::table(
                                                                            'dno_personal_payment_vouchers')
                                                                        ->where('sub_category_account_id', $globeDocument['id'])
                                                                        ->get();
                                               ?>   
                                                
                                               <?php if($viewParticulars === ""): ?>
                                                    <td class="bg-danger " style="color:#fff;">UNPAID</td>
                                               <?php else:?>
                                                @foreach($viewParticulars as $viewParticular)
                                                <?php if($viewParticular->status == "FOR APPROVAL" ): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewParticular->status == "FOR CONFIRMATION " ): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewParticular->status == "FULLY PAID AND RELEASED" ): ?>
                                                    <td class="bg-success" style="color:#fff;">PAID</td>
                                               
                                                <?php endif;?>
                                                
                                                @endforeach
                                                <?php endif;?>
                                                <td>{{ $globeDocument['created_by']}}</td>
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
                <div class="col-lg-12">
                        <div class="card mb-3">
                             <div class="card-header">
                                <i class="fas fa-phone"></i>
                                SMART COMMUNICATIONS INC
                             </div>
                             <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12 ">
                                            <!-- Button trigger modal -->
                                          
                                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addSmart" ><i class="fa fa-plus" aria-hidden="true"></i> Add Smart Communications </a>
                                        </div>

                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered display"  width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Account Id</th>
                                                <th>Account Name</th>
                                                <th >Telephone No</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Action</th>
                                                <th>Account Id</th>
                                                <th>Account Name</th>
                                                <th >Telephone No</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody> 
                                            @foreach($smartDocuments as $smartDocument)
                                            <tr class="deletedId<?php echo $smartDocument['id']?>">
                                                <td>
                                                    @if(Auth::user()['role_type'] !== 3)
                                                        <!-- Button trigger modal -->
                                                        <a data-toggle="modal" data-target="#editGlobe<?php echo $smartDocument['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                    @if(Auth::user()['role_type'] == 1)
                                                        <a id="delete" onClick="confirmDelete('{{ $smartDocument['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>                                                        
                                                    @endif
                                                </td>
                                                @if(\Request::is('dno-personal/manila-properties/view/'.$viewProperty['id']))
                                                    <td><a href="{{ url('dno-personal/cebu-properties/view-globe/'.$smartDocument['id']) }}">{{ $smartDocument['account_id']}}</a></td>
                                                @else
                                                    <td><a href="{{ url('dno-personal/cebu-properties/view-globe/'.$globeDocument['id']) }}">{{ $smartDocument['account_id']}}</a></td>
                                              
                                                @endif
                                                <td>{{ $smartDocument['account_name']}}</td>
                                                <td>{{ $smartDocument['telephone_no']}}</td>
                                                <td>{{ $smartDocument['date']}}</td>
                                                <?php
                                                    $viewParticulars  =  DB::table(
                                                                            'dno_personal_payment_vouchers')
                                                                        ->where('sub_category_account_id', $smartDocument['id'])
                                                                        ->get();
                                               ?>   
                                                
                                               <?php if($viewParticulars === ""): ?>
                                                    <td class="bg-danger " style="color:#fff;">UNPAID</td>
                                               <?php else:?>
                                                @foreach($viewParticulars as $viewParticular)
                                                <?php if($viewParticular->status == "FOR APPROVAL" ): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewParticular->status == "FOR CONFIRMATION " ): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewParticular->status == "FULLY PAID AND RELEASED" ): ?>
                                                    <td class="bg-success" style="color:#fff;">PAID</td>
                                               
                                                <?php endif;?>
                                                
                                                @endforeach
                                                <?php endif;?>
                                                <td>{{ $smartDocument['created_by']}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                             </div>
                        </div>
                     </div>
                </div><!-- end of row-->
                @endif
                @if(\Request::is('dno-personal/cebu-properties/view/'.$viewProperty['id']))
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
                                          
                                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addSky" ><i class="fa fa-plus" aria-hidden="true"></i> Add SkyCable </a>
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
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Action</th>
                                                <th>Account No</th>
                                                <th>Account Name</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody> 
                                            @foreach($skyDocuments as $skyDocument)
                                            <tr class="deletedId<?php echo $skyDocument['id']?>">
                                               
                                                <td>
                                                    @if($user->role_type !== 3)
                                                        <!-- Button trigger modal -->
                                                        <a data-toggle="modal" data-target="#editSky<?php echo $skyDocument['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                    @if($user->role_type == 1)
                                                        <a id="delete" onClick="confirmDelete('{{ $skyDocument['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>                                                        
                                                    @endif
                                                </td>
                                               
                                                <td><a href="{{ url('dno-personal/cebu-properties/view-skycable/'.$skyDocument['id']) }}">{{ $skyDocument['account_id']}}</a></td>
                                              
                                                <td>{{ $skyDocument['account_name']}}</td>
                                                <td>{{ $skyDocument['date']}}</td>
                                                <?php
                                                    $viewParticulars  =  DB::table(
                                                                            'dno_personal_payment_vouchers')
                                                                        ->where('sub_category_account_id', $skyDocument['id'])
                                                                        ->get();
                                               ?>   
                                                
                                              
                                                @foreach($viewParticulars as $viewParticular)
                                                <?php if($viewParticular->status == "FOR APPROVAL" ): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewParticular->status == "FOR CONFIRMATION " ): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewParticular->status == "FULLY PAID AND RELEASED" ): ?>
                                                    <td class="bg-success" style="color:#fff;">PAID</td>
                                              
                                                <?php endif;?>
                                                
                                                @endforeach
                                              
                                               
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
                @elseif(\Request::is('dno-personal/manila-properties/view/'.$viewProperty['id']))
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
                                          
                                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addSky" ><i class="fa fa-plus" aria-hidden="true"></i> Add SkyCable </a>
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
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Action</th>
                                                <th>Account No</th>
                                                <th>Account Name</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody> 
                                            @foreach($skyDocuments as $skyDocument)
                                            <tr class="deletedId<?php echo $skyDocument['id']?>">
                                               
                                                <td>
                                                    @if($user->role_type !== 3)
                                                        <!-- Button trigger modal -->
                                                        <a data-toggle="modal" data-target="#editSky<?php echo $skyDocument['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                    @if($user->role_type == 1)
                                                        <a id="delete" onClick="confirmDelete('{{ $skyDocument['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>                                                        
                                                    @endif
                                                </td>
                                            
                                                <td><a href="{{ url('dno-personal/manila-properties/view-skycable/'.$skyDocument['id']) }}">{{ $skyDocument['account_id']}}</a></td>
                                               
                                             
                                                <td>{{ $skyDocument['account_name']}}</td>
                                                <td>{{ $skyDocument['date']}}</td>
                                                <?php
                                                    $viewParticulars  =  DB::table(
                                                                            'dno_personal_payment_vouchers')
                                                                        ->where('sub_category_account_id', $skyDocument['id'])
                                                                        ->get();
                                               ?>   
                                                
                                               <?php if($viewParticulars === ""): ?>
                                                    <td class="bg-danger " style="color:#fff;">UNPAID</td>
                                               <?php else:?>
                                                @foreach($viewParticulars as $viewParticular)
                                                <?php if($viewParticular->status == "FOR APPROVAL" ): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewParticular->status == "FOR CONFIRMATION " ): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewParticular->status == "FULLY PAID AND RELEASED" ): ?>
                                                    <td class="bg-success" style="color:#fff;">PAID</td>
                                                <?php elseif($viewParticular->status == ""):?>
                                                    <t class="bg-danger" style="color:#fff;"d>UNPAID</td>
                                                <?php endif;?>
                                                
                                                @endforeach
                                                <?php endif;?>
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

                @endif
                @if(\Request::is('dno-personal/cebu-properties/view/'.$viewProperty['id']))
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                             <div class="card-header">
                                <i class="fa fa-industry" aria-hidden="true"></i>

                                Supplier/Service Provider
                             </div>
                             <div class="card-body">
                                
                                <div class="table-responsive">
                                <table class="table table-bordered display"  width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                               
                                                <th>Invoice #</th>
                                                <th>Paid To</th>
                                                <th>Issued Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                               
                                                <th>Invoice #</th>
                                                <th>Paid To</th>
                                                <th>Issued Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody> 
                                            @foreach($serviceProviders as $serviceProvider)
                                            <tr>
                                               
                                               
                                                <td><a href="{{ url('dno-personal/cebu-properties/view-service-provider/'.$serviceProvider['id']) }}">{{ $serviceProvider['invoice_number']}}</a></td>
                                               
                                                <td>{{ $serviceProvider['paid_to']}}</td>
                                                <td>{{ $serviceProvider['issued_date']}}</td>
                                                
                                                <?php if($serviceProvider['status'] === "FOR APPROVAL"): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($serviceProvider['status'] === "FOR CONFIRMATION"): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($serviceProvider['status'] === "FULLY PAID AND RELEASED"): ?>
                                                    <td class="bg-success" style="color:#fff;">PAID</td>
                                               
                                                <?php endif;?>
                                                <td>{{ $serviceProvider['created_by']}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                             </div>
                        </div>
                    </div>  
                </div><!-- end of row-->
                @elseif(\Request::is('dno-personal/manila-properties/view/'.$viewProperty['id']))
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                             <div class="card-header">
                                <i class="fa fa-industry" aria-hidden="true"></i>

                                Supplier/Service Provider
                             </div>
                             <div class="card-body">
                                
                                <div class="table-responsive">
                                <table class="table table-bordered display"  width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                               
                                                <th>Invoice #</th>
                                                <th>Paid To</th>
                                                <th>Issued Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                               
                                                <th>Invoice #</th>
                                                <th>Paid To</th>
                                                <th>Issued Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody> 
                                            @foreach($serviceProviders as $serviceProvider)
                                            <tr>
                                               
                                              
                                                <td><a href="{{ url('dno-personal/manila-properties/view-service-provider/'.$serviceProvider['id']) }}">{{ $serviceProvider['invoice_number']}}</a></td>
                                               
                                              
                                                <td>{{ $serviceProvider['paid_to']}}</td>
                                                <td>{{ $serviceProvider['issued_date']}}</td>
                                                
                                                <?php if($serviceProvider['status'] === "FOR APPROVAL"): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($serviceProvider['status'] === "FOR CONFIRMATION"): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($serviceProvider['status'] === "FULLY PAID AND RELEASED"): ?>
                                                    <td class="bg-success" style="color:#fff;">PAID</td>
                                                <?php else: ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php endif;?>
                                                <td>{{ $serviceProvider['created_by']}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                             </div>
                        </div>
                    </div>  
                </div><!-- end of row-->


                @endif
                
         </div>
     </div>
     @foreach($smartDocuments as $smartDocument)
      <div class="modal fade" id="editSmart<?php echo $smartDocument['id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Smart Communications Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="form-row">
                        <div id="succEditGlobe" class="col-lg-12"></div>
                        <div class="col-lg-12">
                           
                            <label>Account Name</label>
                            <input type="text" id="accountNameGlobeUpdate<?php echo $smartDocument['id']?>" name="accountNamePLDTUpdate" class="selcls form-control"  value="{{ $smartDocument['account_name']}}" />
                        </div>
                        <div class="col-lg-12">
                            <label>Account Id</label>
                            <input type="text" id="accountNoGlobeUpdate<?php echo $smartDocument['id']?>" name="accountNoPLDTUpdate" class="selcls form-control" value="{{ $smartDocument['account_id']}}"/>
                        </div>
                        <div class="col-lg-12">
                            <label>Telephone No</label>
                           
                            <input type="text" id="telephoneNOGlobeUpdate<?php echo $smartDocument['id']?>" name="telephoneNOUpdate" class="selcls form-control" value="{{ $smartDocument['telephone_no']}}" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button onclick="updateSmart(<?php echo $smartDocument['id']?>)" type="button" class="btn btn-success">Update Smart</button>
            </div>
            </div>
        </div>
    </div><!-- end of Modal -->
    @endforeach
    <!-- Modal -->
    <div class="modal fade" id="addSmart" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Smart Communications Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-row">
                            <div id="validateSmart" class="col-lg-12">
                                <p  class="alert alert-danger">Please Fill up the fields</p>
                            </div>
                            <div id="existsSmart" class="col-lg-12"></div>
                             <div id="succAddSmart" class="col-lg-12"></div>
                            <div class="col-lg-12">
                           
                            <label>Account Name</label>
                            <input type="text" id="accountNameSmart" name="accountNameSmart" class="selcls form-control" />
                            </div>
                            <div class="col-lg-12">
                                <label>Account Id</label>
                                <input type="text" id="accountIdSmart" name="accountIdSmart" class="selcls form-control" />
                            </div>
                            <div class="col-lg-12">
                                <label>Telephone No</label>
                                <input type="hidden" id="flagSmart" value="Smart" />
                                <input type="hidden" id="propIdSmart" value="{{ $viewProperty['id'] }}" />
                                <input type="text" id="telephoneNOSmart" name="telephoneNOSmart" class="selcls form-control" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="closeSmart()" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button onclick="saveSmart()" type="button" class="btn btn-success">Add Smart</button>
                </div>
                </div>
            </div>
        </div><!-- end of MOdal -->
      <!-- Modal -->

     @foreach($globeDocuments as $globeDocument)
      <div class="modal fade" id="editGlobe<?php echo $globeDocument['id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Globe Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="form-row">
                        <div id="succEditGlobe" class="col-lg-12"></div>
                        <div class="col-lg-12">
                           
                            <label>Account Name</label>
                            <input type="text" id="accountNameGlobeUpdate<?php echo $globeDocument['id']?>" name="accountNamePLDTUpdate" class="selcls form-control"  value="{{ $globeDocument['account_name']}}" />
                        </div>
                        <div class="col-lg-12">
                            <label>Account Id</label>
                            <input type="text" id="accountNoGlobeUpdate<?php echo $globeDocument['id']?>" name="accountNoPLDTUpdate" class="selcls form-control" value="{{ $globeDocument['account_id']}}"/>
                        </div>
                        <div class="col-lg-12">
                            <label>Telephone No</label>
                           
                            <input type="text" id="telephoneNOGlobeUpdate<?php echo $globeDocument['id']?>" name="telephoneNOUpdate" class="selcls form-control" value="{{ $globeDocument['telephone_no']}}" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button onclick="updateGlobe(<?php echo $globeDocument['id']?>)" type="button" class="btn btn-success">Update Globe</button>
            </div>
            </div>
        </div>
    </div><!-- end of Modal -->
    @endforeach
      <!-- Modal -->
    <div class="modal fade" id="addGlobe" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Globe Telecom Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-row">
                            <div id="validateGlobe" class="col-lg-12">
                                <p  class="alert alert-danger">Please Fill up the fields</p>
                            </div>
                            <div id="existsGlobe" class="col-lg-12"></div>
                             <div id="succAddGlobe" class="col-lg-12"></div>
                            <div class="col-lg-12">
                           
                            <label>Account Name</label>
                            <input type="text" id="accountNameGlobe" name="accountNameGlobe" class="selcls form-control" />
                            </div>
                            <div class="col-lg-12">
                                <label>Account Id</label>
                                <input type="text" id="accountNoGlobe" name="accountNoGlobe" class="selcls form-control" />
                            </div>
                            <div class="col-lg-12">
                                <label>Telephone No</label>
                                <input type="hidden" id="flagGlobe" value="Globe" />
                                <input type="hidden" id="propIdGlobe" value="{{ $viewProperty['id'] }}" />
                                <input type="text" id="telephoneNOGlobe" name="telephoneNO" class="selcls form-control" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="closeGlobe()" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button onclick="saveGlobe()" type="button" class="btn btn-success">Add Globe Telecom</button>
                </div>
                </div>
            </div>
        </div><!-- end of MOdal -->
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
                                <input type="text" id="skyAccountNoUpdate<?php echo $skyDocument['id']?>" name="skyAccountNoUpdate" class="selcls form-control" value="{{ $skyDocument['account_id']}}" />
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
                            <input type="text" id="accountNoPLDTUpdate<?php echo $PLDTDocument['id']?>" name="accountNoPLDTUpdate" class="selcls form-control" value="{{ $PLDTDocument['account_id']}}"/>
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
                            <input type="text" id="telephoneNOPLDT" name="telephoneNO" class="selcls form-control" />
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

     @foreach($meralcoDocuments as $meralcoDocument)
     <div class="modal fade" id="editMeralco<?php echo $meralcoDocument['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Meralco Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="form-row">
                       
                        <div id="succUpdateMeralco" class="col-lg-12"></div>
                        <div class="col-lg-12">
                           
                            <label>Account ID</label>
                            <input type="text" id="accountIdUpdateMeralco<?php echo $meralcoDocument['id']?>" name="accountIdUpdate" class="selcls form-control" value="{{ $meralcoDocument['account_id']}}" />
                        </div>
                        <div class="col-lg-12">
                            <label>Account Name</label>
                            <input type="text" id="accountNameUpdateMeralco<?php echo $meralcoDocument['id']?>" name="accountNameUpdate" class="selcls form-control" value="{{ $meralcoDocument['account_name']}}"  />
                        </div>
                        <div class="col-lg-12">
                            <label>Meter No</label>
                            <input type="text" id="meterNoUpdateMeralco<?php echo $meralcoDocument['id']?>" name="meterNoUpdate" class="selcls form-control"  value="{{ $meralcoDocument['meter_no']}}" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button onclick="updateMeralco(<?php echo $meralcoDocument['id']?>)" type="button" class="btn btn-success">Update Meralco</button>
            </div>
            </div>
        </div>
    </div><!-- end of Modal -->
    @endforeach
     <!-- Modal -->
     <div class="modal fade" id="addMeralco" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Meralco Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="form-row">
                        <div id="validateMeralco" class="col-lg-12">
                            <p  class="alert alert-danger">Please Fill up the fields</p>
                        </div>
                        <div id="existsMeralco" class="col-lg-12"></div>
                         <div id="succAddMeralco" class="col-lg-12"></div>
                        <div class="col-lg-12">
                           
                            <label>Account ID</label>
                            <input type="text" id="accountIdMeralco" name="accountId" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Account Name</label>
                            <input type="text" id="accountNameMeralco" name="accountName" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Meter No</label>
                            <input type="hidden" id="flagMeralco" value="Meralco" />
                            <input type="hidden" id="propIdMeralco" value="{{ $viewProperty['id'] }}" />
                            <input type="text" id="meterNoMeralco" name="meterNo" class="selcls form-control" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="closeMeralco()" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button onclick="saveMeralco()" type="button" class="btn btn-success">Add Meralco</button>
            </div>
            </div>
        </div>
    </div><!-- end of Modal -->
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
   $("#validateMeralco").hide();
   $("#validateMCWD").hide();
   $("#validatePLDT").hide();
   $("#validateGlobe").hide();
   $("#validateSky").hide();
   $("#validateSmart").hide();

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

    const updateGlobe = (id) =>{
        const accountNameGlobeUpdate = $("#accountNameGlobeUpdate"+id).val();
        const accountNoGlobeUpdate = $("#accountNoGlobeUpdate"+id).val();
        const telephoneNo = $("#telephoneNOGlobeUpdate"+id).val();
        //make ajax call
        $.ajax({
            type:"PATCH",
            url:'/dno-personal/properties/update-globe/' + id,
            data:{
                _method:'patch',
                "_token":"{{ csrf_token() }}",
                "id":id,
                "accountNameGlobeUpdate":accountNameGlobeUpdate,
                "accountNoGlobeUpdate":accountNoGlobeUpdate,
                "telephoneNo":telephoneNo,
            },
            success:function(data){
                console.log(data);
                const getData = data;
                const succData = getData.split(":");
                const succDataArr = succData[0];
                if(succDataArr == "Success"){
                    $("#succEditGlobe").fadeIn().delay(3000).fadeOut();
                    $("#succEditGlobe").html(`<p class="alert alert-success"> ${data}</p>`);
                    
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

    const updateMeralco = (id) =>{
        const accountIdUpdate = $("#accountIdUpdateMeralco"+id).val();
        const accountNameUpdate = $("#accountNameUpdateMeralco"+id).val();
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
                    $("#succUpdateMeralco").fadeIn().delay(3000).fadeOut();
                    $("#succUpdateMeralco").html(`<p class="alert alert-success"> ${data}</p>`);
                    
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
                $(".deletedId"+id).fadeOut('slow');
               
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
        
        if(skyAccountNo.length === 0 || skyAccountName.length === 0){
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

    const saveSmart = () =>{
        const accountName = $("#accountNameSmart").val();
        const accountIdSmart = $("#accountIdSmart").val();
        const telephone = $("#telephoneNOSmart").val();
        const flag = $("#flagSmart").val();
        const propId = $("#propIdSmart").val();

        if(accountName.length === 0 || accountIdSmart.length === 0 || telephone.length === 0){
            $("#validateSmart").fadeIn().delay(3000).fadeOut();
        }else{
            //make ajax call
            $.ajax({
                type: "POST",
                url: '/dno-personal/properties/add-smart',
                data:{
                    _method: 'post',
                    "_token": "{{ csrf_token() }}",
                    "accountName":accountName,
                    "accountId":accountIdSmart,
                    "telephoneNo":telephone,
                    "flag":flag,
                    "propId":propId
                },
                success:function(data){
                    console.log(data);
                    const getData = data;
                    const succData = getData.split(":");
                    const succDataArr = succData[0];
                    if(succDataArr == "Success"){
                       $("#succAddSmart").fadeIn().delay(3000).fadeOut();
                       $("#succAddSmart").html(`<p class="alert alert-success"> ${data}</p>`);
                      
                        setTimeout(function(){
                            document.location.reload();
                        }, 3000);
                    }else{
                        $("#existsSmart").fadeIn().delay(3000).fadeOut();
                        $("#existsSmart").html(`<p class="alert alert-danger">${data}</p>`);
                    }
                },
                error:function(data){
                    console.log('Error:', data);
                }
            });
        }


    }


    const saveGlobe = () =>{
        const accountNameGlobe = $("#accountNameGlobe").val();
        const accountNoGlobe = $("#accountNoGlobe").val();
        const telephoneNo = $("#telephoneNOGlobe").val();
        const flag = $("#flagGlobe").val();
        const propId = $("#propIdGlobe").val();

        if(accountNameGlobe.length === 0 || accountNoGlobe.length === 0 || telephoneNo.length === 0){
            $("#validateGlobe").fadeIn().delay(3000).fadeOut();
        }else{
            //make ajax call
            $.ajax({
                type: "POST",
                url: '/dno-personal/properties/add-globe',
                data:{
                    _method: 'post',
                    "_token": "{{ csrf_token() }}",
                    "accountName":accountNameGlobe,
                    "accountId":accountNoGlobe,
                    "telephoneNo":telephoneNo,
                    "flag":flag,
                    "propId":propId
                },
                success:function(data){
                    console.log(data);
                    const getData = data;
                    const succData = getData.split(":");
                    const succDataArr = succData[0];
                    if(succDataArr == "Success"){
                       $("#succAddGlobe").fadeIn().delay(3000).fadeOut();
                       $("#succAddGlobe").html(`<p class="alert alert-success"> ${data}</p>`);
                      
                        setTimeout(function(){
                            document.location.reload();
                        }, 3000);
                    }else{
                        $("#existsGlobe").fadeIn().delay(3000).fadeOut();
                        $("#existsGlobe").html(`<p class="alert alert-danger">${data}</p>`);
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
        $("#telephoneNOPLDT").val('');
    }

    const savePLDT = () => {
        const accountNamePLDT = $("#accountNamePLDT").val();
        const accountNoPLDT = $("#accountNoPLDT").val();
        const telephoneNO = $("#telephoneNOPLDT").val();
        const flagPLDT = $("#flagPLDT").val();
        const propIdPLDT = $("#propIdPLDT").val();

        if(accountNamePLDT.length === 0|| accountNoPLDT.lenght === 0 || telephoneNO.length === 0){
            $("#validatePLDT").fadeIn().delay(3000).fadeOut();
        }else{
            //make ajax call
            $.ajax({
                type: "POST",
                url: '/dno-personal/properties/add-pldt',
                data:{
                    _method: 'post',
                    "_token": "{{ csrf_token() }}",
                    "accountName":accountNamePLDT,
                    "accountId":accountNoPLDT,
                    "telephoneNo":telephoneNO,
                    "flag":flagPLDT,
                    "propId":propIdPLDT
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
        
        if(accountId.length === 0 || accountName.length === 0 || meterNo.length === 0){
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

    const saveMeralco = () =>{
        const accountId = $("#accountIdMeralco").val();
        const accountName = $("#accountNameMeralco").val();
        const meterNo = $("#meterNoMeralco").val();
        const flag = $("#flagMeralco").val();
        const propId = $("#propIdMeralco").val();

        if(accountId.length === 0 || accountName.length == 0 || meterNo.length === 0){
            $("#validateMeralco").fadeIn().delay(3000).fadeOut();
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
                       $("#succAddMeralco").fadeIn().delay(3000).fadeOut();
                       $("#succAddMeralco").html(`<p class="alert alert-success"> ${data}</p>`);
                      
                        setTimeout(function(){
                            document.location.reload();
                        }, 3000);
                    }else{
                        $("#existsMeralco").fadeIn().delay(3000).fadeOut();
                        $("#existsMeralco").html(`<p class="alert alert-danger">${data}</p>`);
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
       
        if(accountId.length === 0 || accountName.length === 0 || meterNo.length === 0){
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
