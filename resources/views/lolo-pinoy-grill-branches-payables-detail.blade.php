@extends('layouts.lolo-pinoy-grill-branches-app')
@section('title', 'Payables Form|')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
      
  });
</script>
<div id="wrapper">
	 @include('sidebar.sidebar-lolo-pinoy-grill-branches')
     <div id="content-wrapper">
		<div class="container-fluid">
			 <!-- Breadcrumbs-->
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">Lolo Pinoy Grill Branches</a>
                </li>
                <li class="breadcrumb-item active">Payables</li>
                <li class="breadcrumb-item ">Payable Form</li>
              </ol>
               <a href="{{ url('lolo-pinoy-grill-branches/payables/transaction-list')}}">Back to Transaction Lists</a>
               <br>
               <br>
               <div class="row">

               		<div class="col-lg-4">
       					<div class="card mb-3">
   							<div class="card-header">
	    					 <i class="fas fa-money-check"></i>
	    					  Payable Form</div>

	    					  <div class="card-body">
	    					  		<form action="{{ action('LoloPinoyGrillBranchesController@addPayment', $transactionList['id']) }}" method="post">
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
    					  		<form action="{{ action('LoloPinoyGrillBranchesController@accept', $transactionList['id'])}}" method="post">
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
		  									<input type="text" name="invoiceNumber" class="form-control" value="{{ $transactionList['invoice_number']}}" disabled="disabled" />
			  							</div>
			  							<div class="col-lg-2">
		  									<label>Amount Due</label>
		  									<input type="text" name="amountDue" style="color:white;" class="bg-danger form-control" value="<?php echo number_format($transactionList['amount_due'], 2)?>" />
			  							</div>
			  							<div class="col-lg-4">
		  									<label>Voucher Ref #</label>
		  									<input type="text" name="voucherRef" class="form-control" value="LPGC-{{ $transactionList['voucher_ref_number'] }}" disabled="disabled" />
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
				  							<td class="bg-success" style="color:white;"><?php echo number_format($tot, 2); ?></td>
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