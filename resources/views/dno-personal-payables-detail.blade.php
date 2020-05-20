@extends('layouts.dno-personal-app')
@section('title', 'Payables Form|')
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
	 @include('sidebar.sidebar-dno-personal')
     <div id="content-wrapper">
		<div class="container-fluid">
			 <!-- Breadcrumbs-->
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">DNO Personal</a>
                </li>
                <li class="breadcrumb-item active">Payables</li>
                <li class="breadcrumb-item ">Payable Form</li>
              </ol>
               <a href="{{ url('dno-personal/payables/transaction-list')}}">Back to Transaction Lists</a>
               <br>
               <br>
               <div class="row">

               		<div class="col-lg-4">
       					<div class="card mb-3">
   							<div class="card-header">
	    					 <i class="fas fa-money-check"></i>
	    					  Payable Form</div>

	    					  <div class="card-body">
	    					  		<form action="{{ action('DnoPersonalController@addPayment', $transactionList['id']) }}" method="post">
	    					  			{{ csrf_field() }}
				  			 	 	@if(session('paymentAdded'))
		                                <p class="alert alert-success">{{ Session::get('paymentAdded') }}</p>
		                            @endif 
									@if($transactionList['method_of_payment'] == "Cash")
									<div class="form-group">
    					  				<div class="form-row">
					  						<div class="col-lg-12">
				  								<label>Date</label>
				  								<input type="text" name="date" class="datepicker form-control" required="required" />
					  						</div> 

    					  				</div>
	    					  		</div>
									<div class="form-group">
    					  				<div class="form-row">
					  						<div class="col-lg-12">
				  								<label>Payment Cash Number</label>
				  								<input type="text" name="chequeNumber" class="form-control" required="required" />
					  						</div> 

    					  				</div>
	    					  		</div>
	    					  		<div class="form-group">
    					  				<div class="form-row">
					  						<div class="col-lg-12">
				  								<label>Cash Amount</label>
				  								<input type="text" name="chequeAmount" class="form-control" required="required" />
					  						</div> 
					  					
    					  				</div>
	    					  		</div>
									@if($transactionList['status'] != "FULLY PAID AND RELEASED")
									<div class="form-group">
										<div class="form-row">
											<div class="col-lg-4">
												<input type="submit" class="btn btn-primary" value="Add" />
											</div> 
										
										</div>
									</div>
  									@else
  									<div class="form-group">
										<div class="form-row">
											<div class="col-lg-4">
												<input type="submit" class="btn btn-primary" value="Add" disabled/>
											</div> 
										
										</div>
									</div>
									@endif
									@elseif($transactionList['method_of_payment'] == "Cheque")
									<div class="form-group">
    					  				<div class="form-row">
					  						<div class="col-lg-12">
				  								<label>Date</label>
				  								<input type="text" name="date" class="datepicker form-control" required="required" />
					  						</div> 

    					  				</div>
	    					  		</div>
									<div class="form-group">
    					  				<div class="form-row">
					  						<div class="col-lg-12">
				  								<label>Payment Cheque Number</label>
				  								<input type="text" name="chequeNumber" class="form-control" required="required" />
					  						</div> 

    					  				</div>
	    					  		</div>
	    					  		<div class="form-group">
    					  				<div class="form-row">
					  						<div class="col-lg-12">
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
									@endif
	    					  		
	    					  		</form>
	    					  </div>
       					</div>
						
						<div class="card mb-3">
							<div class="card-header">
								<i class="fas fa-tasks"></i>
								Particulars
							</div>
							<div class="card-body">
  								<form action="{{ action('DnoPersonalController@addParticulars', $transactionList['id']) }}" method="post">
								  {{ csrf_field() }}
								  @if(session('particularsAdded'))
		                                <p class="alert alert-success">{{ Session::get('particularsAdded') }}</p>
		                            @endif 
  								<div class="form-group">
  									<div class="form-row">
										<div class="col-lg-12">
											<label>Date</label>
											<input type="text"  name="date" class="datepicker form-control" required="required" />
										
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
								@if($transactionList['status'] != "FOR APPROVAL" && $transactionList['status'] != "FOR CONFIRMATION"
								&& $transactionList['status'] != "FULLY PAID AND RELEASED")
								<div class="form-group">
									<div class="form-row">
										<div class="col-lg-4">
											<input type="submit" class="btn btn-primary" value="Add" />
										</div> 
									
									</div>
								</div>
								@else	
								<div class="form-group">
									<div class="form-row">
										<div class="col-lg-4">
											<input type="submit" class="btn btn-primary" value="Add" disabled />
										</div> 
									
									</div>
								</div>
								@endif
								</form>
							</div>
						</div>
               		</div>
				
               		<div class="col-lg-8">
               			<div class="card mb-3">
               				<div class="card-header">
	    					 <i class="fas fa-money-check"></i>
	    					  Payable Form</div>
    					  	<div class="card-body">
    					  		@if(session('payablesSuccess'))
		                                <p class="alert alert-success">{{ Session::get('payablesSuccess') }}</p>
		                         @endif
		                         @if(session('errorPaid'))
		                                <p class="alert alert-danger">{{ Session::get('errorPaid') }}</p>
		                         @endif
    					  		<form action="{{ action('DnoPersonalController@accept', $transactionList['id'])}}" method="post">
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
								@if($transactionList['method_of_payment'] == "Cash")
								<div class="form-group">
			  						<div class="form-row">
			  							<div class="col-lg-2">
		  									<label>Invoice #</label>
		  									<input type="text" name="invoiceNumber" class="selcls form-control" value="{{ $transactionList['invoice_number']}}" disabled="disabled" />
			  							</div>
			  							<div class="col-lg-2">
		  									<label>Amount Due</label>
		  									<input type="text" name="amountDue" style="color:white;" class="bg-danger form-control" value="<?php echo number_format($sum, 2); ?>" />
			  							</div>
			  							<div class="col-lg-4">
		  									<label>Voucher Ref #</label>
		  									<input type="text" name="voucherRef" class="selcls form-control" value="DP-{{ $transactionList['voucher_ref_number'] }}" disabled="disabled" />
			  							</div>
										<div class="col-lg-4">
											<label>Account Name</label>
											<input type="text" name="accountName" class="selcls form-control" value="{{ $transactionList['account_name'] }}" disabled="disabled" />
										</div>
										
									
										<div class="col-lg-4">
		  									<label>Payment Method</label>
		  									<input type="text" name="paymentMethod" class="selcls form-control" value="{{ $transactionList['method_of_payment'] }}" disabled="disabled" />
			  							</div>
										<div class="col-lg-4">
		  									<label>Category</label>
		  									<input type="text" name="category" class="selcls form-control" value="{{ $transactionList['category'] }}" disabled="disabled" />
			  							</div>
										@if($transactionList['sub_category_name'] != "NULL")
										<div class="col-lg-4">
		  									<label>&nbsp;</label>
		  									<input type="text" name="subCateogry" class="selcls form-control" value="{{ $transactionList['sub_category_name'] }}" disabled="disabled" />
			  							</div>
										@endif
										@if($transactionList['sub_category_bill_name'] != "NULL")
										<div class="col-lg-4">
		  									<label>&nbsp;</label>
		  									<input type="text" name="subCateogryBillBName" class="selcls form-control" value="{{ $transactionList['sub_category_bill_name'] }}" disabled="disabled" />
			  							</div>
										@endif
			  							<div class="col-lg-4">
		  									<label>Status</label>
		  									<div id="app-status">
	  											<select name="status" class="selcls form-control">
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

								@elseif($transactionList['method_of_payment'] == "Cheque")
								<div class="form-group">
			  						<div class="form-row">
			  							<div class="col-lg-2">
		  									<label>Invoice #</label>
		  									<input type="text" name="invoiceNumber" class="selcls form-control" value="{{ $transactionList['invoice_number']}}" disabled="disabled" />
			  							</div>
			  							<div class="col-lg-2">
		  									<label>Amount Due</label>
		  									<input type="text" name="amountDue" style="color:white;" class="bg-danger form-control" value="<?php echo number_format($sum, 2); ?>" />
			  							</div>
			  							<div class="col-lg-4">
		  									<label>Voucher Ref #</label>
		  									<input type="text" name="voucherRef" class="selcls form-control" value="DP-{{ $transactionList['voucher_ref_number'] }}" disabled="disabled" />
			  							</div>
										<div class="col-lg-4">
											<label>Bank Name</label>
											<?php
												$bankCard = explode("-", $transactionList['bank_card']);

											?>
											<input type="text" name="bankName" class="selcls form-control" value="{{ $bankCard[1] }}" disabled="disabled" />
										</div>
										@if($transactionList['use_credit_card'] != "No")
										<div class="col-lg-4">
		  									<label>Account #</label>
		  									<input type="text" name="accountNum" class="selcls form-control" value="{{ $transactionList['account_no'] }}" disabled="disabled" />
			  							</div>
										@endif
										<div class="col-lg-4">
		  									<label>Account Name</label>
		  									<input type="text" name="accountName" class="selcls form-control" value="{{ $transactionList['account_name'] }}" disabled="disabled" />
			  							</div>
										@if($transactionList['use_credit_card'] != "No")
										<div class="col-lg-4">
		  									<label>Type Of Card</label>
		  									<input type="text" name="typeOfCard" class="selcls form-control" value="{{ $transactionList['type_of_card'] }}" disabled="disabled" />
			  							</div>
										@endif
										<div class="col-lg-4">
		  									<label>Payment Method</label>
		  									<input type="text" name="paymentMethod" class="selcls form-control" value="{{ $transactionList['method_of_payment'] }}" disabled="disabled" />
			  							</div>
			  							<div class="col-lg-4">
		  									<label>Status</label>
		  									<div id="app-status">
	  											<select name="status" class="selcls form-control">
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

								@endif
				  				
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
											@if($transactionList['method_of_payment'] == "Cash")
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
				  				<br>
				  				<br>
				  				<br>
				  				<div class="form-group">
				  					<div class="form-row">
			  							<div class="col-lg-4">
			  								<input type="submit" class="btn btn-success" name="action" value="PAID AND RELEASE" value="PAID AND RELEASE" />
			  							</div>
										<?php if($transactionList['status'] != "FULLY PAID AND RELEASED"):?>
			  							<div class="col-lg-4">
			  								<input type="submit" class="btn btn-primary" name="action" value="PAID & HOLD" value="PAID & HOLD" />
			  							</div>
										<?php endif; ?>
				  					</div>
				  				</div>
				  			</form>
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
<script>
	new Vue({
	el: '#app-status',
		data: {
			statuses:[
				{ text:'FULLY PAID AND RELEASED', value: 'FULLY PAID AND RELEASED' },
				{ text:'FOR APPROVAL', value: 'FOR APPROVAL'},
				{ text: 'FOR CONFIRMATION', value: 'FOR CONFIRMATION'}
			]
		}
	})
</script>
@endsection