@extends('layouts.wlg-corporation-app')
@section('title', 'Payables Form|')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
      
  });
  $(function() {
    $( ".datepicker" ).datepicker();
  });
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div id="wrapper">
   @include('sidebar.sidebar-wlg-corporation')
   <div id="content-wrapper" >
         <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">WLG Corporation</a>
                </li>
                <li class="breadcrumb-item active">Payables</li>
                <li class="breadcrumb-item ">Payable Form</li>
            </ol>
            <a href="{{ url('wlg-corporation/payables/transaction-list')}}">Back to Transaction Lists</a>
            <br>
            <br>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-3">
                         <div class="card-header">
	    					 <i class="fas fa-money-check"></i>
	    					  Payable Form
                        </div>
                        <div class="card-body">
                            <form action="{{ action('WlgCorporationController@addPayment', $transactionList['id']) }}" method="post">
                             {{ csrf_field() }}
                            @if(session('paymentAdded'))
                                <p class="alert alert-success">{{ Session::get('paymentAdded') }}</p>
                            @endif 
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-8">
                                        <label>Payment Cheque Number</label>
                                        <input type="text" name="chequeNumber" class="form-control" required="required" />
                                    </div> 

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-8">
                                        <label>Cheque Amount</label>
                                        <input type="text" name="chequeAmount" class="form-control" required="required" />
                                    </div> 
                                
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-4">
                                        <input type="submit" class="btn btn-primary" value="Add" />
                                    </div> 
                                
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <div class="card mb-3">
                         <div class="card-header">
                            <i class="fas fa-tasks"></i>
                            Particulars
						</div>
                        <div class="card-body">
                            <form action="{{ action('WlgCorporationController@addParticulars', $transactionList['id']) }}" method="post">
                            {{ csrf_field() }}
                            @if(session('particularsAdded'))
                                <p class="alert alert-success">{{ Session::get('particularsAdded') }}</p>
                            @endif 
                             <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-12">
                                        <label>Date</label>
                                        <input type="text" name="date" class="datepicker form-control" required="required" />
                                    
                                    </div>
                                    <div class="col-lg-12">
                                        <label>Particulars</label>
                                        <input type="text" name="particulars" class="form-control" required="required" />
                                    
                                    </div>
                                    <div class="col-lg-12">
                                        <label>Amount</label>
                                        <input type="text" name="amount" class="form-control" required="required" />
                                    
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-4">
                                        <input type="submit" class="btn btn-primary" value="Add" />
                                    </div> 
                                
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-3">
                         <div class="card-header">
                            <i class="fas fa-money-check"></i>
                            Payable Form
                        </div>
                        <div class="card-body">
                             @if(session('payablesSuccess'))
                                <p class="alert alert-success">{{ Session::get('payablesSuccess') }}</p>
                            @endif
                            <form action="{{ action('WlgCorporationController@accept', $transactionList['id']) }}" method="post">
                            {{ csrf_field() }}
                            <input name="_method" type="hidden" value="PATCH">
                             <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="15%">Paid To</th>
                                        <th>{{ $transactionList['paid_to']}}</th>
                                    </tr>

                                </thead>
                            </table>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-2">
                                        <label>Invoice #</label>
                                        <input type="text" name="invoiceNumber" class="form-control" value="{{ $transactionList['invoice_number']}}"  disabled="disabled" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Amount Due</label>
                                        <input type="text" name="amountDue" style="color:white;" class="bg-danger form-control" value="<?php echo number_format($sum, 2); ?>" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Voucher Ref #</label>
                                        <input type="text" name="voucherRef" class="form-control" value="WLG-{{ $transactionList['voucher_ref_number'] }}" disabled="disabled" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Status</label>
                                        <div id="app-status">
                                            <select name="status" class="form-control">
                                                <option value="0">--Please Select--</option>
                                                <option v-for="status in statuses" v-bind:value="status.value"
                                                :selected="status.value=={{json_encode($transactionList['status'])}}?true : false">
                                                @{{ status.text }}
                                            </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>DATE</th>
                                        <th>PARTICULARS</th>
                                        <th>AMOUNT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $transactionList['issued_date']}}</td>
                                        <td>{{ $transactionList['particulars']}}</td>
                                        <td><?php echo number_format($transactionList['amount'], 2); ?></td>
                                    </tr>
                                    @foreach($getParticulars as $getParticular)
                                    <tr>
                                        <td>{{ $getParticular['date']}}</td>
                                        <td>{{ $getParticular['particulars']}}</td>
                                        <td><?php echo number_format($getParticular['amount'], 2); ?></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>PAYMENT CHEQUE NUMBER</th>
                                        <th>CHEQUE AMOUNT</th>
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
                            <br>
                            <br>
                            <br>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-4">
                                        <input type="submit" class="btn btn-success" name="action" value="PAID AND RELEASE" value="PAID AND RELEASE" />
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="submit" class="btn btn-primary" name="action" value="PAID & HOLD" value="PAID & HOLD" />
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>  
                    </div>  
                </div>
            </div><!-- end of row -->
         </div>
   </div>   
</div>
@endsection