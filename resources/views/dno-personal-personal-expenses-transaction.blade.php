@extends('layouts.dno-personal-app')
@section('title', 'View Personal Transaction|')
@section('content')
<style>
.selcls { 
    padding: 9px; 
    border: solid 1px #517B97; 
    min-height: 40px;
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
                  <li class="breadcrumb-item active">View Personal Transactions Details</li>
                  <li class="breadcrumb-item active">ALD Accounts</li>
                 
			</ol>
            <div class="row">
                 <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
							<i class="fa fa-file-invoice" aria-hidden="true"></i>
							View Transaction 
                            <div class="float-right">
                               <a href="{{ action('DnoPersonalController@printPersonalTransactions', $viewTransaction['id']) }}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                             </div>
						</div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="bg-info" style="color:#fff;" width="15%">PAID TO </th>
                                        <th class="bg-success" style="color:#fff;">{{ $viewTransaction['paid_to']}}</th>
                                    </tr>

                                </thead>
                            </table>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-2">
                                        <label>Invoice #</label>
                                        <input type="text" name="invoiceNumber" class="selcls form-control" value="{{ $viewTransaction['invoice_number']}}" disabled="disabled" />
                                    </div>
                                   <div class="col-lg-2">
                                        <label>Amount Due</label>
                                        <input type="text" name="amountDue" style="color:white;" class="bg-danger form-control" value="<?php echo number_format($sum, 2); ?>" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Voucher Ref #</label>
                                        <input type="text" name="voucherRef" class="selcls form-control" value="DP-{{ $viewTransaction['voucher_ref_number'] }}" disabled="disabled" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Account Name</label>
                                        <input type="text" name="accountName" class="selcls form-control" value="{{ $viewTransaction['account_name'] }}" disabled="disabled" />
                                    </div>
                                  
                                    <div class="col-lg-2">
                                        <label>Payment Method</label>
                                        <input type="text" name="paymentMethod" class="selcls form-control" value="{{ $viewTransaction['method_of_payment'] }}" disabled="disabled" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Status</label>
                                        <input type="text" name="status" class="selcls form-control" value="{{ $viewTransaction['status']}}" />
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                         <div class="card-header">
							<i class="fa fa-tasks" aria-hidden="true"></i>
							View Particulars 
                         
						</div>
                        <div class="card-body">
                             <table class="table table-striped">
                                 <thead>
                                    <tr>
                                        <th>PARTICULARS</th>
                                        <th>AMOUNT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>	
                                        <td>{{ $viewTransaction['particulars']}}</td>
                                        <td><?php echo number_format($viewTransaction['amount'], 2); ?></td>
                                    </tr>
                                    @foreach($getParticulars as $getParticular)
                                    <tr>
                                        <td>{{ $getParticular['particulars']}}</td>
                                        <td><?php echo number_format($getParticular['amount'], 2); ?></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                             </table>
                        </div>
                    </div>
                </div>
            </div><!-- end of div row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
							<i class="fas fa-credit-card"></i>
							Payment   
						</div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>PAYMENT CASH NUMBER</th>
                                        @if($viewTransaction['method_of_payment'] == "Cash")
                                            <th>CASH AMOUNT</th>
                                        @else
                                            <th>CHEQUE AMOUNT</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                     @foreach($getChequeNumbers as $getChequeNumber)
                                    <tr>
                                        <td>{{ $getChequeNumber['cheque_number']}}</td>
                                        <td><?php echo number_format($getChequeNumber['cheque_amount'], 2); ?></td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td class="bg-info" style="color:white;">Total</td>
                                        <td class="bg-success" style="color:white;"><?php echo number_format($sumCheque, 2);?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- end of div row -->
        </div>
    </div>
</div>

@endsection