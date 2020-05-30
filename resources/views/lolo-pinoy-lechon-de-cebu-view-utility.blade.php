@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
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
      @include('sidebar.sidebar')
      <div id="content-wrapper">
        <div class="container-fluid">
              <!-- Breadcrumbs-->
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Lechon de Cebu</a>
                </li>
                
                @if(\Request::is('lolo-pinoy-lechon-de-cebu/utilities/view-veco/'.$viewBill['id']))
                    <li class="breadcrumb-item active">Utilities</li>    
                    <li class="breadcrumb-item active">Veco </li>  
                    <li class="breadcrumb-item ">View Veco Details </li>  
             
                @elseif(\Request::is('lolo-pinoy-lechon-de-cebu/utilities/view-internet/'.$viewBill['id']))
                    <li class="breadcrumb-item active">Utilities</li>    
                    <li class="breadcrumb-item active">Internet </li>  
                    <li class="breadcrumb-item ">View Internet Details </li> 
                @endif
              </ol>
              @if(\Request::is('lolo-pinoy-lechon-de-cebu/utilities/view-veco/'.$viewBill['id']))
              <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-bolt" aria-hidden="true"></i>
                            View Veco                   
                        </div><!-- end of card header -->
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
          
            @elseif(\Request::is('lolo-pinoy-lechon-de-cebu/utilities/view-internet/'.$viewBill['id']))
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                         <div class="card-header">
                             <i class="fas fa-globe"></i>
                            View Internet                   
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
                                        <label>Date</label>
                                        <input type="text" name="date" class="selcls form-control" value="{{ $viewBill['date'] }}" disabled="disabled" />
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
                                 </table>
                            </div>
                         </div>
                     </div> 
                 </div>
            </div><!-- end of row -->
            @endif
        </div>
      </div><!-- end of content wrapper -->
</div><!-- end of wrapper-->
@endsection