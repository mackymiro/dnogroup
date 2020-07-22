@extends('layouts.dno-personal-app')
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
        @include('sidebar.sidebar-dno-personal')
        <div id="content-wrapper">
             <div class="container-fluid">
                  <!-- Breadcrumbs-->
                <h1 class="mt-4">Summary Report(s)</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="#">DNO Personal </a>
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
                                <form action="{{ action('DnoPersonalController@getSummaryReportMultiple')}}" method="get"> 
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
                                <div>
                                    <h1>Search Result For: {{ $startDate }} TO {{ $endDate}}</h1>
                                </div>
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-pettyCash" data-toggle="tab" href="#pettyCash" role="tab" aria-controls="pettyCash" aria-selected="false">Petty Cash</a>
                                        <a class="nav-item nav-link" id="nav-payables" data-toggle="tab" href="#payables" role="tab" aria-controls="payables" aria-selected="false">Payables</a>
                                        <a class="nav-item nav-link" id="nav-all" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="false">All</a>
                                   
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                     <div class="tab-pane fade show active" id="pettyCash" role="tabpanel" aria-labelledby="pettyCash-tab">
                                          <br>
                                        <div class="table-responsive">
                                             <table class="table table-bordered display" width="100%" cellspacing="0">
                                                 <thead>
                                                    <tr>
                                                      
                                                        <th>Date </th>
                                                        <th>Petty Cash No</th>
                                                        <th>Name</th>
                                                    
                                                        <th>Created By</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                       
                                                        <th>Date </th>
                                                        <th>Petty Cash No</th>
                                                        <th>Name</th>
                                                    
                                                        <th>Created By</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                @foreach($pettyCashLists as $pettyCashList)
                                                  <tr >    
                                                     
                                                      <td>{{ $pettyCashList->date}}</td>
                                                      <td>{{ $pettyCashList->module_code}}{{ $pettyCashList->dno_personal_code}}</td>
                                                      <td><a href="{{ url('dno-personal/petty-cash/view/'.$pettyCashList->id) }}">{{ $pettyCashList->petty_cash_name}}</a></td>
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
                                                    <tbody>
                                                    @foreach($getTransactionLists as $getTransactionList)
                                                          <?php $id = $getTransactionList->id; ?>
                                                          <?php
                                                            $amount1 = DB::table('dno_personal_payment_vouchers')
                                                                  ->select('*')
                                                                  ->where('id', $id)
                                                                  ->sum('amount');
                                                            
                                                            $amount2 = DB::table('dno_personal_payment_vouchers')
                                                                  ->select('*')
                                                                  ->where('id', $id)
                                                                  ->sum('amount');
                                                            $compute = $amount1 + $amount2;
                                                          ?>
                                                            <tr id="deletedId{{ $getTransactionList->id }}">
                                                             
                                                              <td>
                                                                @if($getTransactionList->status != "FULLY PAID AND RELEASED")
                                                                  <p style="width:250px;">
                                                                  <a href="{{ url('dno-personal/edit-dno-personal-payables-detail/'.$getTransactionList->id) }}" title="Edit">{{ $getTransactionList->invoice_number}}</a>

                                                                </p>
                                                                @else
                                                                  <p style="width:250px;">{{ $getTransactionList->invoice_number}}</p>
                                                                @endif
                                                              </td>
                                                              <td><p style="width:140px;">{{ $getTransactionList->module_code}}{{ $getTransactionList->dno_personal_code}}</p></td>
                                                            <td class="bg-info" style="color:#fff;"><p style="width:150px;">{{ $getTransactionList->category}}</p></td>
                                                            <td><p style="width:200px;">{{ $getTransactionList->paid_to}}</p></td>
                                                            <td><p style="width:200px;">{{ $getTransactionList->account_name}}</p></td>
                                                              <td><p style="width:130px;">{{ $getTransactionList->issued_date}}</p></td>
                                                              <td class="bg-danger" style="color:white;">
                                                              <p style="width:170px;"><?php echo number_format($compute, 2);?></p>
                                                            </td>
                                                              <td><p style="width:160px;">{{ $getTransactionList->delivered_date}}</p></td>
                                                            <td><p style="width:190px;">{{ $getTransactionList->method_of_payment }}</p></td>
                                                              
                                                              <td class="bg-success" style="color:white; "><p style="width:240px;"><a  class="anchor" href="{{ url('dno-personal/view-dno-personal-payables-details/'.$getTransactionList->id) }}">{{ $getTransactionList->status }}</a></p></td>
                                                              
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
                                             <a href="{{ action('DnoPersonalController@printMultipleSummary', $startDate.'TO'.$endDate) }}"><i class="fa fa-print fa-4x" aria-hidden="true"></i></a>
                                        </div>
                                        <br>
                                        <div class="table-responsive">
                                             <h1>Payment Cash Voucher </h1>
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
                                                @foreach($getTransactionListCashes as $getTransactionListCash)
                                                        <?php $id = $getTransactionListCash->id; ?>
                                                        <?php
                                                            $amount1 = DB::table('dno_personal_payment_vouchers')
                                                                        ->select('*')
                                                                        ->where('id', $id)
                                                                        ->sum('amount');
                                                            
                                                            $amount2 = DB::table('dno_personal_payment_vouchers')
                                                                        ->select('*')
                                                                        ->where('pv_id', $id)
                                                                        ->sum('amount');
                                                            $compute = $amount1 + $amount2;
                                                        ?>
                                                        <tr >
                                                          
                                                            <td>
                                                                @if($getTransactionListCash->status != "FULLY PAID AND RELEASED")
                                                                <p style="width:250px;">
                                                                    <a href="{{ url('dno-personal/edit-dno-personal-payables-detail/'.$getTransactionListCash->id) }}" title="Edit">{{ $getTransactionListCash->invoice_number}}</a>
                                                                </p>
                                                                @else
                                                                <p style="width:250px;">{{ $getTransactionListCash->invoice_number}}</p>
                                                                @endif
                                                            </td>
                                                            <td><p style="width:140px;">{{ $getTransactionListCash->module_code}}{{ $getTransactionListCash->dno_personal_code}}</p></td>
                                                           
                                                            <td><p style="width:130px;">{{ $getTransactionListCash->issued_date}}</p></td>
                                                            <td><p style="width:200px;">{{ $getTransactionListCash->paid_to}}</p></td>
                                                            <td><p style="width:200px;">{{ $getTransactionListCash->method_of_payment}}</p></td>
                                                           
                                                            <td class="bg-danger" style="color:white;"> <p style="width:170px;"><?php echo number_format($compute, 2);?></p></td>
                                                            
                                                            
                                                            <td class="bg-success" style="color:white; "><p style="width:240px;"><a class="anchor" href="{{ url('dno-personal/view-dno-personal-payables-details/'.$getTransactionListCash->id) }}">{{ $getTransactionListCash->status }}</a></p></td>
                                                            <td><p style="width:190px;">{{ $getTransactionListCash->created_by}}</p></td>
                                                            
                                                        </tr>
                                                        @endforeach
  
                                                </tbody>
                                             </table>
                                             <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="15%" class="bg-info" style="color:white;">Total:</th>
                                                        <th class="bg-success" style="color:white"><?php echo number_format($totalAmountCashes, 2);?></th>
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
                                                        <th>Currency</th>
                                                        <th  class="bg-success" style="color:white;">Paid Amount</th>
                                                        <th  class="bg-danger" style="color:white;">Balance</th>
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
                                                        <th>Currency</th>
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
                                                            $amount1 = DB::table('dno_personal_payment_vouchers')
                                                                        ->select('*')
                                                                        ->where('id', $id)
                                                                        ->sum('amount');
                                                            
                                                            $amount2 = DB::table('dno_personal_payment_vouchers')
                                                                        ->select('*')
                                                                        ->where('pv_id', $id)
                                                                        ->sum('amount');
                                                            $compute = $amount1 + $amount2;
                                                             //get the check account no
                                                             $getChecks = DB::table('dno_personal_payment_vouchers')
                                                                            ->select('*')
                                                                            ->where('pv_id', $id)
                                                                            ->get()->toArray();

                                                         
                                                          
                                                           
                                                        ?>
                                                        <tr >
                                                          
                                                            <td>
                                                                @if($getTransactionListCheck->status != "FULLY PAID AND RELEASED")
                                                                <p style="width:250px;">
                                                                    <a href="{{ url('dno-personal/edit-dno-personal-payables-detail/'.$getTransactionListCheck->id) }}" title="Edit">{{ $getTransactionListCheck->invoice_number}}</a>
                                                                </p>
                                                                @else
                                                                <p style="width:250px;">{{ $getTransactionListCheck->invoice_number}}</p>
                                                                @endif
                                                            </td>
                                                            <td><p style="width:140px;">{{ $getTransactionListCheck->module_code}}{{ $getTransactionListCheck->dno_personal_code}}</p></td>
                                                           
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
                                                            <td><p style="width:190px;">{{ $getTransactionListCheck->method_of_payment }}</p></td>
                                                            <td><p style="width:190px;">{{ $getTransactionListCheck->currency }}</p></td>
                                                           
                                                            <td class="bg-success" style="color:white"><p style="width:170px;"><?php echo number_format($getTransactionListCheck->cheque_total_amount, 2); ?></p></td>
                                                            @if($getTransactionListCheck->status === "FULLY PAID AND RELEASED")
                                                            <td class="bg-danger" style="color:white;"> <p style="width:170px;">0</p></td>
                                                            @else
                                                            <td class="bg-danger" style="color:white;"> <p style="width:170px;"><?php echo number_format($compute, 2);?></p></td>
                                                            
                                                            @endif
                                                            
                                                            <td class="bg-success" style="color:white; "><p style="width:240px;"><a class="anchor" href="{{ url('dno-personal/view-dno-personal-payables-details/'.$getTransactionListCheck->id) }}">{{ $getTransactionListCheck->status }}</a></p></td>
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
                                                <thead>
                                                    <tr>
                                                        <th width="15%" class="bg-info" style="color:white;">Total (USD):</th>
                                                        <th class="bg-success" style="color:white"><?php echo number_format($totalAmountCheckInUSD, 2);?></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                      </div>
                                </div>
                            </div><!-- end of card body-->
                      </div>  
                   </div>
                </div><!--end of row-->
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