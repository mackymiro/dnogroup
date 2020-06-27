@extends('layouts.wlg-corporation-app')
@section('title', 'Summary Reports |')
@section('content')
<style >
	.anchor{
		color:white;
	}

	.anchor:hover{
		color:black;
	}
</style>
<script>
  $(document).ready(function(){
      $('table.display').DataTable( {} );
  });  
  $(function() {
        $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd",
        });
      }); 
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div id="wrapper">
      @include('sidebar.sidebar-wlg-corporation')
      <div id="content-wrapper">
            <div class="container-fluid">
                  <!-- Breadcrumbs-->
                <h1 class="mt-4">Summary Report(s)</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="#">WLG Corporation </a>
                    </li>
                    <li class="breadcrumb-item active">Summary Report(s)</li>
                </ol>
                <div class="row">
                    <div class="col-lg-12">
                         <div class="card mb-3">
                             <div class="card-header">
                                <i class="fas fa-search"></i>
                                Search Date
                            </div>
                            <div class="card-body">
                                 <div class="form-group">
                                      <div class="form-row">
                                          
                                          <div class="col-lg-4">
                                              <form action="{{ action('DnoPersonalController@getSummaryReport') }}" method="get">
                                              {{ csrf_field() }}
                                              <h1>Search Date</h1>
                                              <input type="text" name="selectDate" class="datepicker form-control"  required/>
                                              <br>
                                              <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-search" aria-hidden="true"></i> Search Date</button>
                                              </form>
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
                                <i class="fas fa-flag"></i>
                                Summary Reports
                            </div>
                            <div class="card-body">
                                 <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-purchaseOrder" data-toggle="tab" href="#purchaseOrder" role="tab" aria-controls="purchaseOrder" aria-selected="false">Petty Cash</a>
                                        <a class="nav-item nav-link" id="nav-payables" data-toggle="tab" href="#payables" role="tab" aria-controls="payables" aria-selected="false">Payables</a>
                                        <a class="nav-item nav-link" id="nav-all" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="false">All</a>
                                   
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                     <div class="tab-pane fade show active" id="purchaseOrder" role="tabpanel" aria-labelledby="purchaseOrder-tab">
                                       <br>
                                       <div class="table-responsive">
                                             <table class="table table-bordered display" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Action</th>
                                                        <th>PO #</th>
                                                        <th>Paid to</th>
                                                        <th>Date</th>
                                                        <th>Created by</th>
                                                    </tr>
				  					            </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>Action</th>
                                                        <th>PO Number</th>
                                                        <th>Paid to</th>
                                                        <th>Date</th>
                                                        <th>Created by</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    @foreach($purchaseOrders as $purchaseOrder)
                                                        <tr>
                                                            <td>
                                                            @if(Auth::user()['role_type'] != 3)
                                                            <a href="{{ url('wlg-corporation/edit-wlg-corporation-purchase-order/'.$purchaseOrder->id) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                            @endif
                                                            @if(Auth::user()['role_type'] == 1)
                                                                <a id="delete" onClick="confirmDelete('{{ $purchaseOrder->id }}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                                                            @endif
                                                                <a href="{{ url('wlg-corporation/view-wlg-corporation-purchase-order/'.$purchaseOrder->id) }}" title="View"><i class="fas fa-low-vision"></i></a>
                                                            </td>
                                                            <td>{{ $purchaseOrder->module_code}}{{ $purchaseOrder->wlg_code}}</td>
                                                            <td>{{ $purchaseOrder->paid_to}}</td>
                                                            <td>{{ $purchaseOrder->date }}</td>
                                                            <td>{{ $purchaseOrder->created_by }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                             </table>
                                        </div>
                                     </div>
                                     <div class="tab-pane fade" id="payables" role="tabpanel" aria-labelledby="payables-tab">
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table table-bordered display" width="100%" cellspacing="0">
                                            <thead>
                                                    <tr>
                                                    <th>Action</th>
                                                    <th>Invoice #</th>
                                                    <th>PV No</th>
                                                    <th  class="bg-info" style="color:#fff;">Category</th>
                                                    <th>Issued Date</th>
                                                    <th>Paid To</th>
                                                    <th>Account Name</th>
                                                    <th  class="bg-danger" style="color:white;">Amount Due</th>
                                                    <th>Delivered Date</th>
                                                    <th style="width:230px;">Payment Method</th>
                                                    <th class="bg-success" style="color:white;">Status</th>
                                                    <th>Created By</th>
                                                    </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Invoice #</th>
                                                    <th>PV No</th>
                                                    <th class="bg-info" style="color:#fff;">Category</th>
                                                    <th>Issued Date</th>
                                                    <th>Paid To</th>
                                                    <th>Account Name</th>
                                                    <th  class="bg-danger" style="color:white;">Amount Due</th>
                                                    <th>Delivered Date</th>
                                                    <th style="width:230px;">Payment Method</th>
                                                    <th class="bg-success" style="color:white;">Status</th>
                                                    <th>Created By</th>
                                                </tr>
                                            </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      </div>
</div>

@endsection