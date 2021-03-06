@extends('layouts.lolo-pinoy-grill-branches-app')
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

    $(function() {
        $('a[data-toggle="tab"]').on('click', function(e) {
            window.localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = window.localStorage.getItem('activeTab');
        if (activeTab) {
            $('#nav-tab a[href="' + activeTab + '"]').tab('show');
            window.localStorage.removeItem("activeTab");
        }
    });
</script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div id="wrapper">
       @include('sidebar.sidebar-lolo-pinoy-grill-branches')
       <div id="content-wrapper">
             <div class="container-fluid">
                <!-- Breadcrumbs-->
                <h1 class="mt-4">Summary Report(s)</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="#">Lolo Pinoy Grill Branches </a>
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
                                            <form action="{{ action('LoloPinoyGrillBranchesController@getSummaryReport') }}" method="get">
                                            {{ csrf_field() }}
                                                <h1>Search Date</h1>
                                                <input type="text" name="selectDate" class="datepicker form-control"  required/>
                                                <br>
                                                <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-search" aria-hidden="true"></i> Search Date</button>
                                            </form>
                                        </div>
                                        
                                    </div>
                                </div>
                                <form action="{{ action('LoloPinoyGrillBranchesController@getSummaryReportMultiple')}}" method="get"> 
                                     {{ csrf_field() }}
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="col-lg-4">
                                            <h1>Search Start Date</h1>
                                            <input type="text" name="startDate" class="datepicker form-control"  required/>
                                                
                                            </div>
                                            <div class="col-lg-4">
                                            <h1>Search End Date</h1>
                                            <input type="text" name="endDate" class="datepicker form-control"  required/>
                                            
                                            </div>
                                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <br>
                                            <button type="submit" class="btn btn-success  btn-lg"><i class="fa fa-search" aria-hidden="true"></i> Search Date</button>
                                            
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                   </div>
              </div>
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
                                        <a class="nav-item nav-link active" id="nav-reqSlip" data-toggle="tab" href="#reqSlip" role="tab" aria-controls="reqSlip" aria-selected="true">Requisition Slip</a>
                                        <a class="nav-item nav-link " id="nav-transactionSlip" data-toggle="tab" href="#transactionSlip" role="tab" aria-controls="transactionSlip" aria-selected="true">Transaction Slip</a>
                                        <a class="nav-item nav-link" id="nav-pettyCash" data-toggle="tab" href="#pettyCash" role="tab" aria-controls="pettyCash" aria-selected="false">Petty Cash</a>
                                        <a class="nav-item nav-link" id="nav-payables" data-toggle="tab" href="#payables" role="tab" aria-controls="payables" aria-selected="false">Payables</a>
                                        <a class="nav-item nav-link" id="nav-all" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="false">All</a>
                                   
                                    </div>
                                 </nav>
                                 <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="reqSlip" role="tabpanel" aria-labelledby="reqSlip-tab">
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>RS No</th>
                                                    <th>Requesting Department</th>
                                                    <th>Request Date</th>
                                                    <th>Date Released</th>
                                                    <th>Created by</th>
                                                </tr>
				  					            </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>Action</th>
                                                        <th>RS No</th>
                                                        <th>Requesting Department</th>
                                                        <th>Request Date</th>
                                                        <th>Date Released</th>
                                                        <th>Created by</th>
                                                    </tr>
				  					            </tfoot>
                                                <tbody>
                                                @foreach($requisitionLists as $requisitionList)
                                                    <tr>
                                                    <td>
                                
                                
                                                        <a href="{{ url('lolo-pinoy-grill-branches/view/'.$requisitionList->id) }}" title="View"><i class="fas fa-low-vision"></i></a>
                                                    </td>
                                                    <td>{{ $requisitionList->module_code}}{{ $requisitionList->lolo_pinoy_branches_code}}</td>
                                                    <td>{{ $requisitionList->requesting_department }}</td>
                                                    <td>{{ $requisitionList->request_date }}</td>
                                                    <td>{{ $requisitionList->date_released }}</td>
                                                    <td>{{ $requisitionList->created_by}}</td>
                                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="transactionSlip" role="tabpanel" aria-labelledby="transactionSlip-tab">
                                          <br>
                                        <div class="table-responsive">
                                             <table class="table table-bordered display"  width="100%" cellspacing="0">
                                                 <thead>
                                                    <tr>
                                                        <th>RS No</th>
                                                        <th>Requesting Department</th>
                                                        <th>Request Date</th>
                                                        <th>Date Released</th>
                                                        <th>Created by</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th>RS No</th>
                                                    <th>Requesting Department</th>
                                                    <th>Request Date</th>
                                                    <th>Date Released</th>
                                                    <th>Created by</th>
                                                </tr>
                                                </tfoot>
                                                <tbody>
                                                @foreach($transactionLists as $transactionList)
                                                <tr>
                                                
                                                    <td>{{ $transactionList->module_code}}{{ $transactionList->lolo_pinoy_branches_code }}</td>
                                                    <td>{{ $transactionList->requesting_department }}</td>
                                                    <td>{{ $transactionList->request_date }}</td>
                                                    <td>{{ $transactionList->date_released }}</td>
                                                    <td>{{ $transactionList->created_by }}</td>
                                                </tr>
                                                @endforeach
                                                </tbody>
                                             </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pettyCash" role="tabpanel" aria-labelledby="pettyCash-tab">
                                         <br>
                                        <div class="table-responsive">
                                             <table class="table table-bordered display"  width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Action</th>
                                                        <th>Date</th>
                                                        <th>Petty Cash No</th>
                                                        <th>Name</th>
                                                            
                                                        <th>Created By</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>Action</th>
                                                        <th>Date</th>
                                                        <th>Petty Cash No</th>
                                                        <th>Name</th>
                                                            
                                                        <th>Created By</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                @foreach($pettyCashLists as $pettyCashList)
                                                <tr >    
                                                    <td>
                                                    @if(Auth::user()['role_type'] != 3)
                                                        <a href="{{ url('lolo-pinoy-grill-branches/edit-petty-cash/'.$pettyCashList->id) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                        @endif
                                                    @if(Auth::user()['role_type'] == 1)
                                                        <a id="delete" onClick="confirmDelete('{{ $pettyCashList->id}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                                                    @endif
                                                    </td>
                                                    <td>{{ $pettyCashList->date}}</td>
                                                    <td>{{ $pettyCashList->module_code}}{{ $pettyCashList->lolo_pinoy_branches_code}}</td>
                                                    <td><a href="{{ url('lolo-pinoy-grill-branches/petty-cash/view/'.$pettyCashList->id) }}">{{ $pettyCashList->petty_cash_name}}</a></td>
                                                    <td>{{ $pettyCashList->created_by}}</td>
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
                                                </tfoot>
                                                <tbody>
                                                @foreach($getTransactionLists as $getTransactionList)
                                                    <?php $id = $getTransactionList->id; ?>
                                                    <?php
                                                        $amount1 = DB::table('lolo_pinoy_grill_branches_payment_vouchers')
                                                                    ->select('*')
                                                                    ->where('id', $id)
                                                                    ->sum('amount');
                                                        
                                                        $amount2 = DB::table('lolo_pinoy_grill_branches_payment_vouchers')
                                                                    ->select('*')
                                                                    ->where('pv_id', $id)
                                                                    ->sum('amount');
                                                        $compute = $amount1 + $amount2;
                                                    ?>
                                                    <tr >
                                                       
                                                        <td>
                                                            @if($getTransactionList->status != "FULLY PAID AND RELEASED")
                                                            <p style="width:250px;">  
                                                                    <a href="{{ url('lolo-pinoy-grill-branches/edit-lolo-pinoy-grill-branches-payables-detail/'.$getTransactionList->id) }}" title="Edit">{{ $getTransactionList->invoice_number}}</a>
                                                            </p>
                                                            @else
                                                                {{ $getTransactionList->invoice_number}}
                                                            @endif
                                                        </td>
                                                        <td><p style="width:140px;">{{ $getTransactionList->module_code}}{{ $getTransactionList->lolo_pinoy_branches_code}}</p></td>
                                                        <td class="bg-info" style="color:#fff;"><p style="width:150px;">{{ $getTransactionList->category}}</p></td>
                                                        <td><p style="width:130px;">{{ $getTransactionList->issued_date}}</p></td>
                                                        <td><p style="width:200px;">{{ $getTransactionList->paid_to}}</p></td>
                                                        <td><p style="width:200px;">{{ $getTransactionList->account_name}}</p></td>
                                                        <td class="bg-danger" style="color:white;">
                                                            <?php echo number_format($compute, 2); ?>
                                                        </td>
                                                        <td><p style="width:160px;">{{ $getTransactionList->delivered_date}}</p></td>
                                                        <td><p style="width:190px;">{{ $getTransactionList->method_of_payment }}</p></td>
                                                        
                                                        <td class="bg-success" style="color:white; "><p style="width:240px;"><a class="anchor" href="{{ url('lolo-pinoy-grill-branches/view-lolo-pinoy-grill-branches-payables-details/'.$getTransactionList->id) }}">{{ $getTransactionList->status }}</a></p></td>
                                                        <td><p style="width:190px;">{{ $getTransactionList->created_by}}</p></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="all" role="tabpanel" aria-labelledby="all-tab">
                                    <br>
                                         <div class="float-right">
                                             <a href=""><i class="fa fa-print fa-4x" aria-hidden="true"></i></a>
                                        </div>
                                       
                                        <br>
                                        <div class="table-responsive">
                                             <h1>Payment Cash Voucher</h1>
                                             <table class="table table-bordered display" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Invoice #</th>
                                                        <th>PV No</th>
                                                        <th>Issued Date</th>
                                                        <th>Paid To</th>
                                                        <th>Payment Method</th>
                                                        <th  class="bg-danger" style="color:white;">Amount Due</th>
                                                        <th class="bg-success" style="color:white;">Status</th>
                                                        <th>Created By</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                     <tr>
                                                        <th>Invoice #</th>
                                                        <th>PV No</th>
                                                        <th>Issued Date</th>
                                                        <th>Paid To</th>
                                                        <th>Payment Method</th>
                                                        <th  class="bg-danger" style="color:white;">Amount Due</th>
                                                        <th class="bg-success" style="color:white;">Status</th>
                                                        <th>Created By</th>
                                                    </tr>
                                                </tfoot>
                                                    <tbody>
                                                    <?php $sum = 0; ?>
                                                    @foreach($getTransactionListCashes as $getTransactionListCash)
                                                    <?php $id = $getTransactionListCash->id; ?>
                                                    <?php
                                                        $amount1 = DB::table('lolo_pinoy_grill_branches_payment_vouchers')
                                                                    ->select('*')
                                                                    ->where('id', $id)
                                                                    ->sum('amount');
                                                        
                                                        $amount2 = DB::table('lolo_pinoy_grill_branches_payment_vouchers')
                                                                    ->select('*')
                                                                    ->where('pv_id', $id)
                                                                    ->sum('amount');
                                                        $compute = $amount1 + $amount2;
                                                    ?>
                                            
                                                    
                                                    <tr >
                                                      
                                                        <td>
                                                        <p style="width:250px;">{{ $getTransactionListCash->invoice_number}}</p>
                                                       
                                                        </td>
                                                        <td><p style="width:140px;">{{ $getTransactionListCash->module_code}}{{ $getTransactionListCash->lolo_pinoy_branches_code}}</p></td>
                                                        <td><p style="width:130px;">{{ $getTransactionListCash->issued_date}}</p></td>
                
                                                        <td><p style="width:200px;">{{ $getTransactionListCash->paid_to}}</p></td>
                                                        
                                                        <td><p style="width:200px;">{{ $getTransactionListCash->method_of_payment}}</p></td>
                                                       
                                                        <td class="bg-danger" style="color:white;">												  
                                                        <p style="width:170px;"><?php echo number_format($compute, 2); ?></p></td>
                                                        
                                                        <td class="bg-success" style="color:white; "><p style="width:240px;"><a class="anchor" href="{{ url('lolo-pinoy-grill-branches/view-payables-details/'.$getTransactionList->id) }}">{{ $getTransactionList->status }}</a></p></td>
                                                        <td><p style="width:190px;">{{ $getTransactionListCash->created_by}}</p></td>
                                                        </tr>
                                                    
                                                        @endforeach
                                                    </tbody>
                                             </table>
                                             <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="15%" class="bg-info" style="color:white;">Total:</th>
                                                        <th class="bg-success" style="color:white"><?php echo number_format($totalAmountCash, 2);?></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <br>
                                        <div class="table-responsive">
                                            <h1>Payment Check Voucher </h1>
                                            <table class="table table-bordered display" width="100%" cellspacing="0">
                                                 <thead>
                                                    <tr>
                                                        <th>Invoice #</th>
                                                        <th>PV No</th>
                                                        <th>Issued Date</th>
                                                        <th>Paid To</th>
                                                        <th>Account Name/No</th>
                                                        <th>Bank Name/Check No</th>
                                                        <th>Payment Method</th>
                                                        <th class="bg-success" style="color:white;">Paid Amount</th>
                                                        <th class="bg-danger" style="color:white;">Balance</th>
                                                        <th class="bg-success" style="color:white;">Status</th>
                                                        <th>Created By</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                     <tr>
                                                        <th>Invoice #</th>
                                                        <th>PV No</th>
                                                        <th>Issued Date</th>
                                                        <th>Paid To</th>
                                                        <th>Account Name/No</th>
                                                        <th>Bank Name/Check No</th>
                                                        <th>Payment Method</th>
                                                        <th class="bg-success" style="color:white;">Paid Amount</th>
                                                        <th class="bg-danger" style="color:white;">Balance</th>
                                                        <th class="bg-success" style="color:white;">Status</th>
                                                        <th>Created By</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                @foreach($getTransactionListChecks as $getTransactionListCheck)
                                                    <?php $id = $getTransactionListCheck->id; ?>
                                                    <?php
                                                        $amount1 = DB::table('lolo_pinoy_grill_branches_payment_vouchers')
                                                                    ->select('*')
                                                                    ->where('id', $id)
                                                                    ->sum('amount');
                                                        
                                                        $amount2 = DB::table('lolo_pinoy_grill_branches_payment_vouchers')
                                                                    ->select('*')
                                                                    ->where('pv_id', $id)
                                                                    ->sum('amount');
                                                        $compute = $amount1 + $amount2;

                                                         //get the check account no
                                                         $getChecks = DB::table('lolo_pinoy_grill_branches_payment_vouchers')
                                                                        ->select('*')
                                                                        ->where('pv_id', $id)
                                                                        ->get()->toArray();
                                                    ?>
                                            
                                                    
                                                    <tr >
                                                      
                                                        <td>
                                                        <p style="width:250px;">{{ $getTransactionListCheck->invoice_number}}</p>
                                                       
                                                        </td>
                                                        <td><p style="width:140px;">{{ $getTransactionListCheck->module_code}}{{ $getTransactionListCheck->lolo_pinoy_branches_code}}</p></td>
                                                        <td><p style="width:130px;">{{ $getTransactionListCheck->issued_date}}</p></td>
                
                                                        <td><p style="width:200px;">{{ $getTransactionListCheck->paid_to}}</p></td>
                                                        <td>
                                                            <?php foreach($getChecks as $getCheck): ?>
                                                                <?php echo $getCheck->account_name_no; ?>
                                                            <?php endforeach; ?>
                                                        </td>
                                                        <td>
                                                            <p style="width:190px;">
                                                            <?php foreach($getChecks as $getCheck): ?>
                                                                    <?php echo $getCheck->cheque_number; ?>
                                                                <?php endforeach; ?>
                                                            </p>
                                                        </td>
                                                        <td><p style="width:200px;">{{ $getTransactionListCheck->method_of_payment}}</p></td>
                                                        <td class="bg-success" style="color:white"><p style="width:170px;"><?php echo number_format($getTransactionListCheck->cheque_total_amount, 2); ?></p></td>
                                                        @if($getTransactionListCheck->status === "FULLY PAID AND RELEASED")
                                                            <td class="bg-danger" style="color:white;"> <p style="width:170px;">0</p></td>
                                                        @else
                                                        <td class="bg-danger" style="color:white;">												  
                                                        <p style="width:170px;"><?php echo number_format($compute, 2); ?></p></td>
                                                        @endif
                                                        <td class="bg-success" style="color:white; "><p style="width:240px;"><a class="anchor" href="{{ url('lolo-pinoy-grill-branches/view-payables-details/'.$getTransactionListCheck->id) }}">{{ $getTransactionListCheck->status }}</a></p></td>
                                                        <td><p style="width:190px;">{{ $getTransactionListCheck->created_by}}</p></td>
                                                        </tr>
                                                    
                                                        @endforeach
                                                </tbody>
                                            </table>  
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="15%" class="bg-info" style="color:white;">Total:</th>
                                                        <th class="bg-success" style="color:white"><?php echo number_format($totalAmountCheck, 2);?></th>
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
@endsection