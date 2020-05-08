@extends('layouts.dno-personal-app')
@section('title', 'View Bill|')
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
<div id="wrapper">
     @include('sidebar.sidebar-dno-personal')
     <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">DNO Personal</a>
                </li>
                @if(\Request::is('dno-personal/cebu-properties/view-veco/'.$viewBill['id']))
                    <li class="breadcrumb-item active">Properties</li>    
                    <li class="breadcrumb-item active">Cebu Properties</li>
                    <li class="breadcrumb-item active">Veco </li>  
                    <li class="breadcrumb-item ">View Veco Details </li>  
                @elseif(\Request::is('dno-personal/cebu-properties/view-mcwd/'.$viewBill['id']))
                    <li class="breadcrumb-item active">Properties</li>
                    <li class="breadcrumb-item active">Cebu Properties</li>
                    <li class="breadcrumb-item active">MCWD </li>      
                    <li class="breadcrumb-item ">View MCWD Details</li>  
                @elseif(\Request::is('dno-personal/cebu-properties/view-pldt/'.$viewBill['id']))
                     <li class="breadcrumb-item active">Properties</li>
                    <li class="breadcrumb-item active">Cebu Properties</li>
                    <li class="breadcrumb-item active">PLDT </li>     
                    <li class="breadcrumb-item active">View PLDT Details</li>  
                @elseif(\Request::is('dno-personal/cebu-properties/view-skycable/'.$viewBill['id']))
                    <li class="breadcrumb-item active">Properties</li>
                    <li class="breadcrumb-item active">Cebu Properties</li>
                    <li class="breadcrumb-item active">SkyCable </li>     
                    <li class="breadcrumb-item active">View SkyCable Details</li>  
                @elseif(\Request::is('dno-personal/cebu-properties/view-service-provider/'.$viewBill['id']))
                    <li class="breadcrumb-item active">Properties</li>
                    <li class="breadcrumb-item active">Cebu Properties</li>
                    <li class="breadcrumb-item active">Service Provider</li>     
                    <li class="breadcrumb-item active">View Service Provider</li>  
                @elseif(\Request::is('dno-personal/manila-properties/view-veco/'.$viewBill['id']))
                     <li class="breadcrumb-item active">Manila Properties</li>
                    <li class="breadcrumb-item active">Veco </li>  
                    <li class="breadcrumb-item ">View Veco Details </li>  
                 @elseif(\Request::is('dno-personal/manila-properties/view-mcwd/'.$viewBill['id']))
                    <li class="breadcrumb-item active">Properties</li>
                    <li class="breadcrumb-item active">Manila Properties</li>
                    <li class="breadcrumb-item active">MCWD </li>      
                    <li class="breadcrumb-item ">View MCWD Details</li>  
                 @elseif(\Request::is('dno-personal/manila-properties/view-pldt/'.$viewBill['id']))
                     <li class="breadcrumb-item active">Properties</li>
                    <li class="breadcrumb-item active">Manila Properties</li>
                    <li class="breadcrumb-item active">PLDT </li>     
                    <li class="breadcrumb-item active">View PLDT Details</li> 
                @elseif(\Request::is('dno-personal/manila-properties/view-skycable/'.$viewBill['id']))
                    <li class="breadcrumb-item active">Properties</li>
                    <li class="breadcrumb-item active">Cebu Properties</li>
                    <li class="breadcrumb-item active">SkyCable </li>     
                    <li class="breadcrumb-item active">View SkyCable Details</li>
                 @elseif(\Request::is('dno-personal/manila-properties/view-service-provider/'.$viewBill['id']))
                    <li class="breadcrumb-item active">Properties</li>
                    <li class="breadcrumb-item active">Manila Properties</li>
                    <li class="breadcrumb-item active">Service Provider</li>     
                    <li class="breadcrumb-item active">View Service Provider</li>  
                @endif
                
            </ol>
            @if(\Request::is('dno-personal/cebu-properties/view-veco/'.$viewBill['id']))
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                         <div class="card-header">
                                <i class="fas fa-bolt" aria-hidden="true"></i>
                                View Veco                   
                         </div>
                         <div class="card-body">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-2">
                                        <label>Account ID</label>
                                        <input type="text" name="accountId" class="selcls form-control" value="{{ $viewBill['account_id'] }}" disabled="disabled" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Account Name</label>
                                        <input type="text" name="accountName" class="selcls form-control" value="{{ $viewBill['account_name'] }}" disabled="disabled" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Meter No</label>
                                        <input type="text" name="meterNo" class="selcls form-control" value="{{ $viewBill['meter_no'] }}" disabled="disabled" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Date</label>
                                        <input type="text" name="date" class="selcls form-control" value="{{ $viewBill['date'] }}" disabled="disabled" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Status</label>
                                        <?php if($viewBill['status'] == "FOR APPROVAL"): ?>
                                        <input type="text" name="status" style="color:#fff" class="bg-danger form-control" value="UNPAID" />

                                        <?php elseif($viewBill['status'] == "FOR CONFIRMATION"): ?>
                                        <input type="text" name="status" style="color:#fff" class="bg-danger form-control" value="UNPAID" />

                                        <?php elseif($viewBill['status'] == "FULLY PAID AND RELEASED"): ?>
                                        <input type="text" name="status" style="color:#fff" class="bg-success form-control" value="PAID" />

                                        <?php else: ?>
                                        <input type="text" name="status" style="color:#fff" class="bg-danger form-control" value="UNPAID" />


                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                         </div>
                    </div>
                </div> 
            </div><!-- end of row -->
            <div class="row">
                 <div class="col-lg-12">
                     <div class="card mb-3">
                         <div class="card-header">
                            <i class="fas fa-receipt" aria-hidden="true"></i>
                            Particulars
                         </div>
                         <div class="card-body">
                            <div class="table-responsive">
                                 <table class="table table-striped"  width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="300px;">PARTICULARS</th>
                                            <th>AMOUNT</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($viewParticulars as $viewParticular)
                                        <tr>
                                            <td>{{ $viewParticular['particulars']}}</td>
                                            <td><?php echo number_format($viewParticular['amount'], 2); ?></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                 </table>   
                            </div>
                         </div>
                    </div>
                 </div>
            </div><!-- end of row -->
            @elseif(\Request::is('dno-personal/manila-properties/view-veco/'.$viewBill['id']))
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                         <div class="card-header">
                                <i class="fas fa-bolt" aria-hidden="true"></i>
                                View Veco                   
                         </div>
                         <div class="card-body">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-2">
                                        <label>Account ID</label>
                                        <input type="text" name="accountId" class="selcls form-control" value="{{ $viewBill['account_id'] }}" disabled="disabled" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Account Name</label>
                                        <input type="text" name="accountName" class="selcls form-control" value="{{ $viewBill['account_name'] }}" disabled="disabled" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Meter No</label>
                                        <input type="text" name="meterNo" class="selcls form-control" value="{{ $viewBill['meter_no'] }}" disabled="disabled" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Date</label>
                                        <input type="text" name="date" class="selcls form-control" value="{{ $viewBill['date'] }}" disabled="disabled" />
                                    </div>
                            
                                    @foreach($viewParticulars as $viewParticular)
                                    <div class="col-lg-2">
                                        <label>Status</label>
                                        <?php if($viewParticular['status'] == "FOR APPROVAL" ): ?>
                                            <input type="text" name="date" class="bg-danger form-control" style="color:#ffff;" value="UNPAID" disabled="disabled" />
                                        <?php elseif($viewParticular['status'] == "FOR CONFIRMATION " ): ?>
                                            <input type="text" name="date" class="bg-danger form-control" style="color:#ffff;" value="UNPAID" disabled="disabled" />
                                        <?php elseif($viewParticular['status'] == "FULLY PAID AND RELEASED" ): ?>
                                            <input type="text" name="date" class="bg-success form-control" style="color:#ffff;" value="PAID" disabled="disabled" />
                                        <?php elseif($viewParticular['status'] == ""):?>
                                            <input type="text" name="date" class="bg-danger form-control" style="color:#ffff;" value="UNPAID" disabled="disabled" />
                                       
                                        <?php endif;?>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                         </div>
                    </div>
                </div> 
            </div><!-- end of row -->
            <div class="row">
                 <div class="col-lg-12">
                     <div class="card mb-3">
                         <div class="card-header">
                            <i class="fas fa-receipt" aria-hidden="true"></i>
                            Particulars
                         </div>
                         <div class="card-body">
                            <div class="table-responsive">
                                 <table class="table table-striped"  width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="300px;">PARTICULARS</th>
                                            <th>AMOUNT</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($viewParticulars as $viewParticular)
                                        <tr>
                                            <td>{{ $viewParticular['particulars']}}</td>    
                                            <td><?php echo number_format($viewParticular['amount'], 2); ?></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                 </table>   
                            </div>
                         </div>
                    </div>
                 </div>
            </div><!-- end of row -->
            @elseif(\Request::is('dno-personal/cebu-properties/view-mcwd/'.$viewBill['id']))
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                         <div class="card-header">
                                <i class="fas fa-water" aria-hidden="true"></i>
                                View MCWD                   
                         </div>
                         <div class="card-body">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-2">
                                        <label>Account ID</label>
                                        <input type="text" name="accountId" class="selcls form-control" value="{{ $viewBill['account_id'] }}" disabled="disabled" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Account Name</label>
                                        <input type="text" name="accountName" class="selcls form-control" value="{{ $viewBill['account_name'] }}" disabled="disabled" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Meter No</label>
                                        <input type="text" name="meterNo" class="selcls form-control" value="{{ $viewBill['meter_no'] }}" disabled="disabled" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Date</label>
                                        <input type="text" name="date" class="selcls form-control" value="{{ $viewBill['date'] }}" disabled="disabled" />
                                    </div>
                                    @foreach($viewParticulars as $viewParticular)
                                    <div class="col-lg-2">
                                        <label>Status</label>
                                        <?php if($viewParticular['status'] == "FOR APPROVAL" ): ?>
                                            <input type="text" name="date" class="bg-danger form-control" style="color:#ffff;" value="UNPAID" disabled="disabled" />
                                        <?php elseif($viewParticular['status'] == "FOR CONFIRMATION " ): ?>
                                            <input type="text" name="date" class="bg-danger form-control" style="color:#ffff;" value="UNPAID" disabled="disabled" />
                                        <?php elseif($viewParticular['status'] == "FULLY PAID AND RELEASED" ): ?>
                                            <input type="text" name="date" class="bg-success form-control" style="color:#ffff;" value="PAID" disabled="disabled" />
                                       
                                        <?php endif;?>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                         </div>
                    </div>
                </div> 
            </div><!-- end of row -->
            <div class="row">
                 <div class="col-lg-12">
                     <div class="card mb-3">
                         <div class="card-header">
                            <i class="fas fa-receipt" aria-hidden="true"></i>
                            Particulars
                         </div>
                         <div class="card-body">
                            <div class="table-responsive">
                                 <table class="table table-striped"  width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="300px;">PARTICULARS</th>
                                            <th>AMOUNT</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($viewParticulars as $viewParticular)
                                        <tr>
                                            <td>{{ $viewParticular['particulars']}}</td>
                                            <td><?php echo number_format($viewParticular['amount'], 2); ?></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                 </table>   
                            </div>
                         </div>
                    </div>
                 </div>
            </div><!-- end of row -->
            @elseif(\Request::is('dno-personal/manila-properties/view-mcwd/'.$viewBill['id']))
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                         <div class="card-header">
                                <i class="fas fa-water" aria-hidden="true"></i>
                                View MCWD                   
                         </div>
                         <div class="card-body">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-2">
                                        <label>Account ID</label>
                                        <input type="text" name="accountId" class="selcls form-control" value="{{ $viewBill['account_id'] }}" disabled="disabled" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Account Name</label>
                                        <input type="text" name="accountName" class="selcls form-control" value="{{ $viewBill['account_name'] }}" disabled="disabled" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Meter No</label>
                                        <input type="text" name="meterNo" class="selcls form-control" value="{{ $viewBill['meter_no'] }}" disabled="disabled" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Date</label>
                                        <input type="text" name="date" class="selcls form-control" value="{{ $viewBill['date'] }}" disabled="disabled" />
                                    </div>
                                    @foreach($viewParticulars as $viewParticular)
                                    <div class="col-lg-2">
                                        <label>Status</label>
                                        <?php if($viewParticular['status'] == "FOR APPROVAL" ): ?>
                                            <input type="text" name="date" class="bg-danger form-control" style="color:#ffff;" value="UNPAID" disabled="disabled" />
                                        <?php elseif($viewParticular['status'] == "FOR CONFIRMATION " ): ?>
                                            <input type="text" name="date" class="bg-danger form-control" style="color:#ffff;" value="UNPAID" disabled="disabled" />
                                        <?php elseif($viewParticular['status'] == "FULLY PAID AND RELEASED" ): ?>
                                            <input type="text" name="date" class="bg-success form-control" style="color:#ffff;" value="PAID" disabled="disabled" />
                                        <?php elseif($viewParticular['status'] == ""):?>
                                            <input type="text" name="date" class="bg-danger form-control" style="color:#ffff;" value="UNPAID" disabled="disabled" />
                                       
                                        <?php endif;?>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                         </div>
                    </div>
                </div> 
            </div><!-- end of row -->
            <div class="row">
                 <div class="col-lg-12">
                     <div class="card mb-3">
                         <div class="card-header">
                            <i class="fas fa-receipt" aria-hidden="true"></i>
                            Particulars
                         </div>
                         <div class="card-body">
                            <div class="table-responsive">
                                 <table class="table table-striped"  width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="300px;">PARTICULARS</th>
                                            <th>AMOUNT</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($viewParticulars as $viewParticular)
                                        <tr>
                                            <td>{{ $viewParticular['particulars']}}</td>
                                            <td><?php echo number_format($viewParticular['amount'], 2); ?></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                 </table>   
                            </div>
                         </div>
                    </div>
                 </div>
            </div><!-- end of row -->

            @elseif(\Request::is('dno-personal/cebu-properties/view-pldt/'.$viewBill['id']))
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                         <div class="card-header">
                                <i class="fas fa-phone" aria-hidden="true"></i>
                                View PLDT                   
                         </div>
                         <div class="card-body">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-2">
                                        <label>Account No</label>
                                        <input type="text" name="accountNo" class="selcls form-control" value="{{ $viewBill['account_id'] }}" disabled="disabled" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Account Name</label>
                                        <input type="text" name="accountName" class="selcls form-control" value="{{ $viewBill['account_name'] }}" disabled="disabled" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Telephone No</label>
                                        <input type="text" name="meterNo" class="selcls form-control" value="{{ $viewBill['telephone_no'] }}" disabled="disabled" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Date</label>
                                        <input type="text" name="date" class="selcls form-control" value="{{ $viewBill['date'] }}" disabled="disabled" />
                                    </div>
                                    @foreach($viewParticulars as $viewParticular)
                                    <div class="col-lg-2">
                                        <label>Status</label>
                                        <?php if($viewParticular['status'] == "FOR APPROVAL" ): ?>
                                            <input type="text" name="date" class="bg-danger form-control" style="color:#ffff;" value="UNPAID" disabled="disabled" />
                                        <?php elseif($viewParticular['status'] == "FOR CONFIRMATION " ): ?>
                                            <input type="text" name="date" class="bg-danger form-control" style="color:#ffff;" value="UNPAID" disabled="disabled" />
                                        <?php elseif($viewParticular['status'] == "FULLY PAID AND RELEASED" ): ?>
                                            <input type="text" name="date" class="bg-success form-control" style="color:#ffff;" value="PAID" disabled="disabled" />
                                        <?php elseif($viewParticular['status'] == ""):?>
                                            <input type="text" name="date" class="bg-danger form-control" style="color:#ffff;" value="UNPAID" disabled="disabled" />
                                       
                                        <?php endif;?>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                         </div>
                    </div>
                </div> 
            </div><!-- end of row -->
            <div class="row">
                 <div class="col-lg-12">
                     <div class="card mb-3">
                         <div class="card-header">
                            <i class="fas fa-receipt" aria-hidden="true"></i>
                            Particulars
                         </div>
                         <div class="card-body">
                            <div class="table-responsive">
                                 <table class="table table-striped"  width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="300px;">PARTICULARS</th>
                                            <th>AMOUNT</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($viewParticulars as $viewParticular)
                                        <tr>
                                            <td>{{ $viewParticular['particulars']}}</td>
                                            <td><?php echo number_format($viewParticular['amount'], 2); ?></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                 </table>   
                            </div>
                         </div>
                    </div>
                 </div>
            </div><!-- end of row -->
            @elseif(\Request::is('dno-personal/manila-properties/view-pldt/'.$viewBill['id']))
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                         <div class="card-header">
                                <i class="fas fa-phone" aria-hidden="true"></i>
                                View PLDT                   
                         </div>
                         <div class="card-body">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-2">
                                        <label>Account No</label>
                                        <input type="text" name="accountNo" class="selcls form-control" value="{{ $viewBill['account_id'] }}" disabled="disabled" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Account Name</label>
                                        <input type="text" name="accountName" class="selcls form-control" value="{{ $viewBill['account_name'] }}" disabled="disabled" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Telephone No</label>
                                        <input type="text" name="meterNo" class="selcls form-control" value="{{ $viewBill['telephone_no'] }}" disabled="disabled" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Date</label>
                                        <input type="text" name="date" class="selcls form-control" value="{{ $viewBill['date'] }}" disabled="disabled" />
                                    </div>
                                    @foreach($viewParticulars as $viewParticular)
                                    <div class="col-lg-2">
                                        <label>Status</label>
                                        <?php if($viewParticular['status'] == "FOR APPROVAL" ): ?>
                                            <input type="text" name="date" class="bg-danger form-control" style="color:#ffff;" value="UNPAID" disabled="disabled" />
                                        <?php elseif($viewParticular['status'] == "FOR CONFIRMATION " ): ?>
                                            <input type="text" name="date" class="bg-danger form-control" style="color:#ffff;" value="UNPAID" disabled="disabled" />
                                        <?php elseif($viewParticular['status'] == "FULLY PAID AND RELEASED" ): ?>
                                            <input type="text" name="date" class="bg-success form-control" style="color:#ffff;" value="PAID" disabled="disabled" />
                                        <?php elseif($viewParticular['status'] == ""):?>
                                            <input type="text" name="date" class="bg-danger form-control" style="color:#ffff;" value="UNPAID" disabled="disabled" />
                                       
                                        <?php endif;?>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                         </div>
                    </div>
                </div> 
            </div><!-- end of row -->
            <div class="row">
                 <div class="col-lg-12">
                     <div class="card mb-3">
                         <div class="card-header">
                            <i class="fas fa-receipt" aria-hidden="true"></i>
                            Particulars
                         </div>
                         <div class="card-body">
                            <div class="table-responsive">
                                 <table class="table table-striped"  width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="300px;">PARTICULARS</th>
                                            <th>AMOUNT</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($viewParticulars as $viewParticular)
                                        <tr>
                                            <td>{{ $viewParticular['particulars']}}</td>
                                            <td><?php echo number_format($viewParticular['amount'], 2); ?></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                 </table>   
                            </div>
                         </div>
                    </div>
                 </div>
            </div><!-- end of row -->
            @elseif(\Request::is('dno-personal/cebu-properties/view-skycable/'.$viewBill['id']))
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                         <div class="card-header">
                                <i class="fab fa-skyatlas" aria-hidden="true"></i>
                                View SkyCable                   
                         </div>
                         <div class="card-body">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-2">
                                        <label>Account No</label>
                                        <input type="text" name="accountNo" class="selcls form-control" value="{{ $viewBill['account_id'] }}" disabled="disabled" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Account Name</label>
                                        <input type="text" name="accountName" class="selcls form-control" value="{{ $viewBill['account_name'] }}" disabled="disabled" />
                                    </div>
                                  
                                    <div class="col-lg-2">
                                        <label>Date</label>
                                        <input type="text" name="date" class="selcls form-control" value="{{ $viewBill['date'] }}" disabled="disabled" />
                                    </div>
                                    @foreach($viewParticulars as $viewParticular)
                                    <div class="col-lg-2">
                                        <label>Status</label>
                                        <?php if($viewParticular['status'] == "FOR APPROVAL" ): ?>
                                            <input type="text" name="date" class="bg-danger form-control" style="color:#ffff;" value="UNPAID" disabled="disabled" />
                                        <?php elseif($viewParticular['status'] == "FOR CONFIRMATION " ): ?>
                                            <input type="text" name="date" class="bg-danger form-control" style="color:#ffff;" value="UNPAID" disabled="disabled" />
                                        <?php elseif($viewParticular['status'] == "FULLY PAID AND RELEASED" ): ?>
                                            <input type="text" name="date" class="bg-success form-control" style="color:#ffff;" value="PAID" disabled="disabled" />
                                        <?php elseif($viewParticular['status'] == ""):?>
                                            <input type="text" name="date" class="bg-danger form-control" style="color:#ffff;" value="UNPAID" disabled="disabled" />
                                       
                                        <?php endif;?>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                         </div>
                    </div>
                </div> 
            </div><!-- end of row -->
            <div class="row">
                 <div class="col-lg-12">
                     <div class="card mb-3">
                         <div class="card-header">
                            <i class="fas fa-receipt" aria-hidden="true"></i>
                            Particulars
                         </div>
                         <div class="card-body">
                            <div class="table-responsive">
                                 <table class="table table-striped"  width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="300px;">PARTICULARS</th>
                                            <th>AMOUNT</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($viewParticulars as $viewParticular)
                                        <tr>
                                            <td>{{ $viewParticular['particulars']}}</td>
                                            <td><?php echo number_format($viewParticular['amount'], 2); ?></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                 </table>   
                            </div>
                         </div>
                    </div>
                 </div>
            </div><!-- end of row -->
            @elseif(\Request::is('dno-personal/manila-properties/view-skycable/'.$viewBill['id']))
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                         <div class="card-header">
                                <i class="fab fa-skyatlas" aria-hidden="true"></i>
                                View SkyCable                   
                         </div>
                         <div class="card-body">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-2">
                                        <label>Account No</label>
                                        <input type="text" name="accountNo" class="selcls form-control" value="{{ $viewBill['account_id'] }}" disabled="disabled" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Account Name</label>
                                        <input type="text" name="accountName" class="selcls form-control" value="{{ $viewBill['account_name'] }}" disabled="disabled" />
                                    </div>
                                  
                                    <div class="col-lg-2">
                                        <label>Date</label>
                                        <input type="text" name="date" class="selcls form-control" value="{{ $viewBill['date'] }}" disabled="disabled" />
                                    </div>
                                    @foreach($viewParticulars as $viewParticular)
                                    <div class="col-lg-2">
                                        <label>Status</label>
                                        <?php if($viewParticular['status'] == "FOR APPROVAL" ): ?>
                                            <input type="text" name="date" class="bg-danger form-control" style="color:#ffff;" value="UNPAID" disabled="disabled" />
                                        <?php elseif($viewParticular['status'] == "FOR CONFIRMATION " ): ?>
                                            <input type="text" name="date" class="bg-danger form-control" style="color:#ffff;" value="UNPAID" disabled="disabled" />
                                        <?php elseif($viewParticular['status'] == "FULLY PAID AND RELEASED" ): ?>
                                            <input type="text" name="date" class="bg-success form-control" style="color:#ffff;" value="PAID" disabled="disabled" />
                                        <?php elseif($viewParticular['status'] == ""):?>
                                            <input type="text" name="date" class="bg-danger form-control" style="color:#ffff;" value="UNPAID" disabled="disabled" />
                                       
                                        <?php endif;?>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                         </div>
                    </div>
                </div> 
            </div><!-- end of row -->
            <div class="row">
                 <div class="col-lg-12">
                     <div class="card mb-3">
                         <div class="card-header">
                            <i class="fas fa-receipt" aria-hidden="true"></i>
                            Particulars
                         </div>
                         <div class="card-body">
                            <div class="table-responsive">
                                 <table class="table table-striped"  width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="300px;">PARTICULARS</th>
                                            <th>AMOUNT</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($viewParticulars as $viewParticular)
                                        <tr>
                                            <td>{{ $viewParticular['particulars']}}</td>
                                            <td><?php echo number_format($viewParticular['amount'], 2); ?></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                 </table>   
                            </div>
                         </div>
                    </div>
                 </div>
            </div><!-- end of row -->
            @elseif(\Request::is('dno-personal/cebu-properties/view-service-provider/'.$viewBill['id']))
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                         <div class="card-header">
                                <i class="fas fa-industry" aria-hidden="true"></i>
                                View Supplier/Service Provider                   
                         </div>
                         <div class="card-body">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-2">
                                        <label>Invoice #</label>
                                        <input type="text" name="invoiceNo" class="selcls form-control" value="{{ $viewBill['invoice_number'] }}" disabled="disabled" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Voucher Ref #</label>
                                        <input type="text" name="voucherRef" class="selcls form-control" value="{{ $viewBill['voucher_ref_number'] }}" disabled="disabled" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Paid To</label>
                                        <input type="text" name="paidTo" class="selcls form-control" value="{{ $viewBill['paid_to'] }}" disabled="disabled" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Account Name</label>
                                        <input type="text" name="accountName" class="selcls form-control" value="{{ $viewBill['account_name'] }}" disabled="disabled" />
                                    </div>
                                  
                                    <div class="col-lg-2">
                                        <label>Issued Date</label>
                                        <input type="text" name="issuedDate" class="selcls form-control" value="{{ $viewBill['issued_date'] }}" disabled="disabled" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Status</label>
                                        <?php if($viewBill['status'] === "FOR APPROVAL"): ?>
                                            <input type="text" name="issuedDate" class="bg-danger form-control" style="color:#fff;" value="UNPAID" disabled="disabled" />
                                
                                        <?php elseif($viewBill['status'] === "FOR CONFIRMATION"): ?>
                                            <input type="text" name="issuedDate" class="bg-danger form-control" style="color:#fff;" value="UNPAID" disabled="disabled" />
                                
                                        <?php elseif($viewBill['status'] === "FULLY PAID AND RELEASED"): ?>
                                            <input type="text" name="issuedDate" class="bg-success form-control" style="color:#fff;" value="PAID" disabled="disabled" />
                                
                                        <?php else: ?>
                                            
                                            <input type="text" name="issuedDate" class="bg-danger form-control" style="color:#fff;" value="UNPAID" disabled="disabled" />
                                
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                         </div>
                    </div>
                </div> 
            </div><!-- end of row -->
            <div class="row">
                 <div class="col-lg-12">
                     <div class="card mb-3">
                         <div class="card-header">
                            <i class="fas fa-receipt" aria-hidden="true"></i>
                            Particulars
                         </div>
                         <div class="card-body">
                            <div class="table-responsive">
                                 <table class="table table-striped"  width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="440px;">PARTICULARS</th>
                                            <th>AMOUNT</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>	
  											<td>{{ $viewBill['particulars']}}</td>
											<td><?php echo number_format($viewBill['amount'], 2); ?></td>
										</tr>
                                        @foreach($getParticulars as $getParticular)
										<tr>
  											<td>{{ $getParticular['particulars']}}</td>
											<td><?php echo number_format($getParticular['amount'], 2); ?></td>
										</tr>
										@endforeach
                                    <tbody>
                                 </table>   
                            </div>
                         </div>
                    </div>
                 </div>
            </div><!-- end of row -->

            @endif
        </div>
     </div>
</div>
@endsection