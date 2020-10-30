@extends('layouts.wimpys-food-express-app')
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

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css" >
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>


<div id="wrapper">
	 @include('sidebar.sidebar-wimpys-food-express')
     <div id="content-wrapper">
		<div class="container-fluid">
			 <!-- Breadcrumbs-->
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">Wimpy's Food Express</a>
                </li>
                <li class="breadcrumb-item active">Payables</li>
                <li class="breadcrumb-item ">Payable Form</li>
              </ol>
               <a href="{{ url('wimpys-food-express/payables/transaction-list')}}">Back to Transaction Lists</a>
               <br>
               <br>
               <div class="row">

               		<div class="col-lg-4">
       					<div class="card mb-3">
   							<div class="card-header">
	    					 <i class="fas fa-money-check"></i>
	    					  Payable Form</div>

	    					  <div class="card-body">
	    					  		<form action="{{ action('WimpysFoodExpressController@addPayment', $transactionList[0]->id) }}" method="post">
	    					  			{{ csrf_field() }}
				  			 	 	@if(session('paymentAdded'))
		                                <p class="alert alert-success">{{ Session::get('paymentAdded') }}</p>
		                            @endif 
									@if($transactionList[0]->method_of_payment === "CASH")
									<div class="form-group">
    					  				<div class="form-row">
					  						<div class="col-lg-12">
				  								<label>Date</label>
				  								<input type="text" name="date" class="datepicker form-control" />
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
									@if($transactionList[0]->status != "FULLY PAID AND RELEASED")
									<div class="form-group">
										<div class="form-row">
											<div class="col-lg-4">
											<button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-plus"></i> Add</button>
					  					
											</div> 
						
										</div>
									</div>
  									@else
  									<div class="form-group">
										<div class="form-row">
											<div class="col-lg-4">
												<button type="submit" class="btn btn-primary btn-lg" disabled><i class="fas fa-plus"></i> Add</button>
					  					
											</div> 
										
										</div>
									</div>
									@endif
									@elseif($transactionList[0]->method_of_payment == "CHECK")
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
				  								<label>Account Name/No</label>
				  								<input type="text" name="accountNameNo" class="form-control"  />
					  						</div> 

    					  				</div>
	    					  		</div>
									<div class="form-group">
    					  				<div class="form-row">
					  						<div class="col-lg-12">
				  								<label>Payment Check Number</label>
				  								<input type="text" name="chequeNumber" class="form-control" required="required" />
					  						</div> 

    					  				</div>
	    					  		</div>
	    					  		<div class="form-group">
    					  				<div class="form-row">
					  						<div class="col-lg-12">
				  								<label>Check Amount</label>
				  								<input type="text" name="chequeAmount" class="form-control" required="required" />
					  						</div> 
					  					
    					  				</div>
	    					  		</div>
									  @if($transactionList[0]->status != "FULLY PAID AND RELEASED")
									<div class="form-group">
										<div class="form-row">
											<div class="col-lg-4">
											<button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-plus"></i> Add</button>
					  					
											</div> 
						
										</div>
									</div>
  									@else
  									<div class="form-group">
										<div class="form-row">
											<div class="col-lg-4">
												<button type="submit" class="btn btn-primary btn-lg" disabled><i class="fas fa-plus"></i> Add</button>
					  					
											</div> 
										
										</div>
									</div>
									@endif
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
  								<form action="{{ action('WimpysFoodExpressController@addParticulars', $transactionList[0]->id) }}" method="post">
								  {{ csrf_field() }}
								  @if(session('particularsAdded'))
		                                <p class="alert alert-success">{{ Session::get('particularsAdded') }}</p>
		                            @endif 
  								<div class="form-group">
  									<div class="form-row">
										<div class="col-lg-12">
											<label>Date</label>
											<input type="text"  name="date" class="datepicker form-control"  />
										
										</div>
  										<div class="col-lg-12">
  											<label>Particulars</label>
										
  											<textarea name="particulars" class="form-control"></textarea>
										</div>
										<div class="col-lg-12">
  											<label>Amount</label>
											<input type="text" name="amount" class="form-control" required="required" autocomplete="off" />
										
										</div>
										
									</div>
								</div>
								@if($transactionList[0]->status != "FOR APPROVAL" && $transactionList[0]->status != "FOR CONFIRMATION"
								&& $transactionList[0]->status != "FULLY PAID AND RELEASED")
								<div class="form-group">
									<div class="form-row">
										<div class="col-lg-4">
											<button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-plus"></i> Add</button>
					  					
										</div> 
									
									</div>
								</div>
								@else	
								<div class="form-group">
									<div class="form-row">
										<div class="col-lg-4">
										<button type="submit" class="btn btn-primary btn-lg" disabled><i class="fas fa-plus"></i> Add</button>
					  					
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
    					  		<form action="{{ action('WimpysFoodExpressController@accept', $transactionList[0]->id)}}" method="post">
    					  			{{ csrf_field() }}
    					  			 <input name="_method" type="hidden" value="PUT">
									@if($transactionList[0]->status != "FULLY PAID AND RELEASED")
										<!-- Button trigger modal -->
										<a  data-toggle="modal" data-target="#payableFormModal" href="#" title="Edit"><i class="fas fa-edit" style="font-size:24px"></i></a>
									@else
									<i class="fas fa-edit" style="font-size:24px"></i>
									@endif
									<br>
									<br>
					  			 <table class="table table-bordered">
				  			 		<thead>

				  			 			<tr>
				  			 				<th width="15%">Paid To</th>
										
  												<th>{{ $transactionList[0]->paid_to}}</th>
											
				  			 			</tr>

				  			 		</thead>
					  			 </table>
								@if($transactionList[0]->method_of_payment === "CASH")
								<div class="form-group">
			  						<div class="form-row">
			  							<div class="col-lg-4">
		  									<label>Invoice #</label>
		  									<input type="text" name="invoiceNumber" class=" form-control" value="{{ $transactionList[0]->invoice_number}}" disabled="disabled" />
			  							</div>
			  							<div class="col-lg-2">
		  									<label>Amount Due</label>
		  									<input type="text" name="amountDue" style="color:white;" class="bg-danger form-control" value="<?php echo number_format($sum, 2); ?>" />
			  							</div>
			  							<div class="col-lg-2">
		  									<label>PV No</label>
                                             @foreach($transactionList[0]->payment_vouchers as $voucher)
                                                @if($voucher->module_name === "Payment Voucher")
                                                <input type="text" name="voucherRef" class="form-control" value="{{ $voucher->module_code}} {{ $voucher->wimpys_food_express_code }}" disabled="disabled" />
			  						
                                                @endif
                                             @endforeach 
		  									</div>
										
									
										<div class="col-lg-6">
											<label>Account Name</label>
											<input type="text" name="accountName" class="form-control" value="{{ $transactionList[0]->account_name }}" disabled="disabled" />
										</div>
										
										<div class="col-lg-2">
		  									<label>Payment Method</label>
		  									<input type="text" name="paymentMethod" class="form-control" value="{{ $transactionList[0]->method_of_payment}}" disabled="disabled" />
			  							</div>
										<div class="col-lg-4">
		  									<label>Category</label>
		  									<input type="text" name="category" class="form-control" value="{{ $transactionList[0]->category }}" disabled="disabled" />
			  							</div>
										
									
			  							<div class="col-lg-4">
		  									<label>Status</label>
		  									<div id="app-status">
	  											<select name="status" class="form-control">
	  												<option value="0">--Please Select--</option>
													<option v-for="status in statuses" v-bind:value="status.value"
													:selected="status.value=={{json_encode($transactionList[0]->status)}}?true : false">
													@{{ status.text }}
												</option>
	  											</select>
		  									</div>
			  							</div>
			  						</div>
				  				</div>

								@elseif($transactionList[0]->method_of_payment === "CHECK")
								<div class="form-group">
			  						<div class="form-row">
			  							<div class="col-lg-4">
		  									<label>Invoice #</label>
		  									<input type="text" name="invoiceNumber" class="form-control" value="{{ $transactionList[0]->invoice_number}}" disabled="disabled" />
			  							</div>
			  							<div class="col-lg-2">
		  									<label>Amount Due</label>
		  									<input type="text" name="amountDue" style="color:white;" class="bg-danger form-control" value="<?php echo number_format($sum, 2); ?>" />
			  							</div>
			  							<div class="col-lg-2">
		  									<label>PV No</label>
											  @foreach($transactionList[0]->payment_vouchers as $voucher)
                                                @if($voucher->module_name === "Payment Voucher")
                                                <input type="text" name="voucherRef" class="form-control" value="{{ $voucher->module_code}} {{ $voucher->wimpys_food_express_code }}" disabled="disabled" />
			  						
                                                @endif
                                             @endforeach 
										</div>
  										<div class="col-lg-6">
		  									<label>Account Name</label>
		  									<input type="text" name="accountName" class="form-control" value="{{ $transactionList[0]->account_name }}" disabled="disabled" />
			  							</div>
									
										<div class="col-lg-2">
		  									<label>Payment Method</label>
		  									<input type="text" name="paymentMethod" class="form-control" value="{{ $transactionList[0]->method_of_payment }}" disabled="disabled" />
			  							</div>
										<div class="col-lg-4">
		  									<label>Category</label>
		  									<input type="text" name="category" class="form-control" value="{{ $transactionList[0]->category }}" disabled="disabled" />
			  							</div>
									
			  							<div class="col-lg-4">
		  									<label>Status</label>
		  									<div id="app-status">
	  											<select name="status" class="form-control">
	  												<option value="0">--Please Select--</option>
													<option v-for="status in statuses" v-bind:value="status.value"
													:selected="status.value=={{json_encode($transactionList[0]->status)}}?true : false">
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
  											<th>ACTION</th>
  											<th>DATE</th>
  											<th>PARTICULARS</th>
											<th>AMOUNT</th>
										</tr>
									</thead>
									<tbody>
  										
										<tr>	
  											<td>
											  @if($transactionList[0]->status != "FULLY PAID AND RELEASED")
											   <!-- Button trigger modal -->
											   <a  data-toggle="modal" data-target="#editParticulars<?php echo $transactionList[0]->id ?>" href="#" title="Edit"><i class="fas fa-edit" style="font-size:24px"></i></a>
  											  @else
  												  <!-- Button trigger modal -->
												<i class="fas fa-edit" style="font-size:24px"></i>
  											 

											  @endif
											</td>
  											<td>{{ $transactionList[0]->issued_date}}</td>
  											<td>{{ $transactionList[0]->particulars}}</td>
											<td>
												@if($transactionList[0]->currency === "PHP")
												 ₱ 
												@elseif($transactionList[0]->currency === "USD")
												$

												@endif
												<?php echo number_format($transactionList[0]->amount, 2); ?></td>
										</tr>
										@foreach($getParticulars as $getParticular)
										<tr>
											<td>
											 @if($transactionList[0]->status != "FULLY PAID AND RELEASED")
											  <!-- Button trigger modal -->
											  <a data-toggle="modal" data-target="#editP<?php echo $getParticular['id'] ?>" href="#" title="Edit"><i class="fas fa-edit" style="font-size:24px"></i></a>
											 @else
											   
												<i class="fas fa-edit" style="font-size:24px"></i>
  											 
											 @endif
											</td>
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
										    @if($transactionList[0]->method_of_payment === "CASH")
											<th>ACTON</th>
											@else
											<th>ACTON</th>
											<th>ACCOUNT NAME/NO</th>
											<th>PAYMENT CHECK NUMBER</th>
											@endif
											@if($transactionList[0]->method_of_payment === "CASH")
				  								<th>CASH AMOUNT</th>
											@else
												<th>CHECK AMOUNT</th>
											@endif
				  						</tr>
				  					</thead>
				  					<tbody>
										@if($transactionList[0]->method_of_payment === "CASH")
  											@foreach($getCashAmounts as $getCashAmount)
  											<tr>
  												<td>
												@if($transactionList[0]->status != "FULLY PAID AND RELEASED")
													<!-- Button trigger modal -->
													<a  data-toggle="modal" data-target="#editCash<?php echo $getCashAmount['id'] ?>" href="#" title="Edit"><i class="fas fa-edit" style="font-size:24px"></i></a>
												@else
													
													<i class="fas fa-edit" style="font-size:24px"></i>
												@endif	
												</td>
												<td><?php echo number_format($getCashAmount['cheque_amount'], 2); ?></td>
											</tr>
											@endforeach
											<tr>
												<td class="bg-info" style="color:white;">Total</td>
											
												
												<td class="bg-success" style="color:white;">
  													@if($sumCheque != 0.00)
													<?= number_format($sumCheque, 2);?>
													@else
													<?= number_format($sum, 2); ?>
													@endif
												</td>
											</tr>
										@else
											@foreach($getChequeNumbers as $getChequeNumber)
											<tr>
												<td>
												@if($transactionList[0]->status != "FULLY PAID AND RELEASED")
													<!-- Button trigger modal -->
													<a  data-toggle="modal" data-target="#editCheck<?php echo $getChequeNumber['id'] ?>" href="#" title="Edit"><i class="fas fa-edit" style="font-size:24px"></i></a>
												@else
													
													<i class="fas fa-edit" style="font-size:24px"></i>
												@endif	
												</td>
											
												<td>{{ $getChequeNumber['account_name_no']}}</td>
												<td>{{ $getChequeNumber['cheque_number']}}</td>
											
												<td>
												@if($transactionList[0]->currency === "PHP")
												 ₱ 
												@elseif($transactionList[0]->currency === "USD")
												$

												@endif 	
													<?php echo number_format($getChequeNumber['cheque_amount'], 2); ?></td>
											</tr>
											@endforeach
											<tr>
												<td class="bg-info" style="color:white;">Total</td>
												
												<td class="bg-info" style="color:white;"></td>
												<td class="bg-info" style="color:white;"></td>
												
												<td class="bg-success" style="color:white;">
													
													@if($sumCheque != 0.00)
													<?php echo number_format($sumCheque, 2);?>
													@else
													<?php echo number_format($sum, 2); ?>
													@endif
												</td>
											</tr>
										@endif
				  					</tbody>
				  				</table>
				  				<br>
				  				<br>
				  				<br>
				  				<div class="form-group">
				  					<div class="form-row">
			  							<div class="col-lg-4">
			  								<input type="submit" class="btn btn-success btn-lg" name="action" value="PAID AND RELEASE" value="PAID AND RELEASE" />
			  							</div>
										<?php if($transactionList[0]->status != "FULLY PAID AND RELEASED"):?>
			  							<div class="col-lg-4">
			  								<input type="submit" class="btn btn-primary btn-lg" name="action" value="PAID & HOLD" value="PAID & HOLD" />
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
	 <!-- Modal -->
	 
	<div class="modal fade" id="payableFormModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" aria-hidden="true" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Edit Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
			<div class="form-group">
					<div id="editDetails" class="col-lg-12"></div>
					<div id="editCC" class="col-lg-12"></div>
					@if($transactionList[0]->method_of_payment === "CASH")
                                            
					<div class="form-row">
						<div class="col-lg-4">
							<label>Paid To </label>
							<input type="text" id="paidTo" name="paidTo" class="form-control" value="{{ $transactionList[0]->paid_to }}" />
						</div>
						<div class="col-lg-4">
							<label>Invoice # </label>
							<input type="text" id="invoiceNo" name="invoiceNo" class="form-control" value="{{ $transactionList[0]->invoice_number }}" />
						</div>
						<div class="col-lg-4">
							<label>Account Name </label>
							<input type="text" id="accountName" name="accountName" class="form-control" value="{{ $transactionList[0]->account_name}}" />
						</div>
						
						
					</div>
					@else
					
						<div class="form-row">
							<div class="col-lg-4">
								<label>Paid To </label>
								<input type="text" id="paidTo" name="paidTo" class="form-control" value="{{ $transactionList[0]->paid_to }}" />
							</div>
							<div class="col-lg-4">
								<label>Invoice # </label>
								<input type="text" id="invoiceNo" name="invoiceNo" class="form-control" value="{{ $transactionList[0]->invoice_number }}" />
							</div>
						
							<div class="col-lg-4">
								<label>Account # </label>
								<div id="accountNoHide">
									<input type="text" id="accountNum" name="accountNum" class="form-control" disabled value="{{ $transactionList[0]->account_no}}" />
								</div>
								<div id="accountNo"></div> 
							</div>
							<div class="col-lg-4">
								<label>Account Name </label>
								<div id="accountNameHide">
									<input type="text" id="accountName" name="accountName" class="form-control" disabled value="{{ $transactionList[0]->account_name }}" />
								</div>
								<div id="accountName1"></div>
							</div>
						
							
						</div>

					

					@endif
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			
					<button type="button" onclick="updateDetailsPayable(<?= $transactionList[0]->id; ?>)" class="btn btn-success">Update changes</button>
			
			
			</div>
			</div>
		</div>
		</div>
	 <!-- Modal -->
		<div class="modal fade" id="editParticulars<?php echo $transactionList[0]->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Edit Particulars</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<div class="form-row">
						<div id="succEditParticular" class="col-lg-12"></div>
						<div class="col-lg-4">
							<label>Date</label>
							<input type="text" id="date" name="date" class="datepicker form-control"  value="{{ $transactionList[0]->issued_date}}" />
						</div>
						<div class="col-lg-4">
							<label>Particulars</label>
							<textarea id="particulars" name="particulars" class="form-control">{{ $transactionList[0]->particulars}}</textarea>
						</div>
						<div class="col-lg-4">
							<label>Amount</label>
							<input type="text" id="amount" name="amount" class="form-control" value="{{ $transactionList[0]->amount }}" />
						</div>
						
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				<button type="button" onclick="updateParticular(<?php echo $transactionList[0]->id; ?>)" class="btn btn-success">Update changes</button>
			</div>
			</div>
		</div>
	</div>
	 <!-- Modal -->
	 @foreach($getParticulars as $getParticular)
	 <div class="modal fade" id="editP<?php echo $getParticular['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Edit Particulars</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<div class="form-row">
						<div id="editParticularP" class="col-lg-12"></div>
						<div class="col-lg-4">
							<label>Date</label>
							<input type="text" id="dateP<?= $getParticular['id']?>" name="date" class="datepicker form-control"  value="{{ $getParticular['date']}}" />
						</div>
						<div class="col-lg-4">
							<label>Particulars</label>
							<textarea id="particularsP<?= $getParticular['id']?>" name="particulars" class="form-control">{{ $getParticular['particulars'] }}</textarea>
						</div>
						<div class="col-lg-4">
							<label>Amount</label>
							<input type="text" id="amountP<?= $getParticular['id']?>" name="amount" class="form-control" value="{{ $getParticular['amount'] }}" />
						</div>
						
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				<input type="hidden" id="transId<?= $getParticular['id']?>" value="{{ $transactionList[0]->id }}" />
				<button type="button" onclick="updateP(<?= $getParticular['id'];?>)" class="btn btn-success">Update changes</button>
			</div>
			</div>
		</div>
	</div>
	@endforeach
	<!-- Modal -->
	@foreach($getCashAmounts as $getCashAmount)
	<div class="modal fade" id="editCash<?= $getCashAmount['id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog modal-dialog-centered " role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Edit Cash Amount</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<div class="form-row">
						<div id="editCashSucc<?= $getCashAmount['id']?>" class="col-lg-12"></div>
						
						<div class="col-lg-4">
							<label>Cash Amount</label>
							<input type="text" id="cashAmount<?= $getCashAmount['id']?>" name="cashAmount" class="form-control" value="{{ $getCashAmount['cheque_amount']}}" />
						</div>
						
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				<button type="button" onclick="updateCash(<?= $getCashAmount['id']; ?>)" class="btn btn-success">Update cash</button>
			</div>
			</div>
		</div>
	</div>
	@endforeach
	<!-- Modal -->
	@foreach($getChequeNumbers as $getChequeNumber)
	<div class="modal fade" id="editCheck<?= $getChequeNumber['id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Edit Check Number</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<div class="form-row">
						<div id="editCheck" class="col-lg-12"></div>
						<div class="col-lg-4">
							<label>Account Name/No</label>
							<input type="text" id="accountNameNo<?= $getChequeNumber['id']?>" name="accountNameNo" class="form-control"  value="{{ $getChequeNumber['account_name_no']}}" />
						</div>
						<div class="col-lg-4">
							<label>Payment Check Number</label>
							<input type="text" id="checkNumber<?= $getChequeNumber['id']?>" name="checkNumber" class="form-control"  value="{{ $getChequeNumber['cheque_number']}}" />
						
						</div>
						<div class="col-lg-4">
							<label>Check Amount</label>
							<input type="text" id="checkAmount<?= $getChequeNumber['id']?>" name="amount" class="form-control" value="{{ $getChequeNumber['cheque_amount']}}" />
						</div>
						
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				<button type="button" onclick="updateCheck(<?= $getChequeNumber['id']; ?>)" class="btn btn-success">Update check</button>
			</div>
			</div>
		</div>
	</div>
	@endforeach
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
<script type="text/javascript">

	const updateDetailsPayable = (id) =>{
		const paidTo = $("#paidTo").val();
		const invoiceNo = $("#invoiceNo").val();
		const accountName = $("#accountName").val();

		//make ajax call
		$.ajax({
			type:"PUT",
            url:'/wimpys-food-express/payables/update-details/' + id,
			data:{
                _method:'put',
                "_token":"{{ csrf_token() }}",
                "id":id,
                "paidTo":paidTo,
                "invoiceNo":invoiceNo,
				"accountName":accountName,
            },
			success:function(data){
				console.log(data);

				const getData = data;
                const succData = getData.split(":");
                const succDataArr = succData[0];

				if(succDataArr == "Success"){
					$("#editDetails").fadeIn().delay(3000).fadeOut();
                    $("#editDetails").html(`<p class="alert alert-success"> ${data}</p>`);
                    
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

	const updateCash = (id) => {
		const cashAmount = $("#cashAmount"+id).val();

		//make ajax call
		$.ajax({
			type:"PUT",
            url:'/wimpys-food-express/payables/update-cash/' + id,
			data:{
                _method:'put',
                "_token":"{{ csrf_token() }}",
                "id":id,
                "cashAmount":cashAmount,
               
            },
			success:function(data){
				console.log(data);

				const getData = data;
                const succData = getData.split(":");
                const succDataArr = succData[0];
				if(succDataArr == "Success"){
					$("#editCashSucc"+id).fadeIn().delay(3000).fadeOut();
                    $("#editCashSucc"+id).html(`<p class="alert alert-success"> ${data}</p>`);
                    
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

	const updateCheck = (id) => {
		const accountNameNo = $("#accountNameNo"+id).val();
		const checkNumber = $("#checkNumber"+id).val();
		const checkAmount = $("#checkAmount"+id).val();

		//make ajax call
		$.ajax({
			type:"PUT",
            url:'/wimpys-food-express/payables/update-check/' + id,
			data:{
                _method:'put',
                "_token":"{{ csrf_token() }}",
                "id":id,
                "accountNameNo":accountNameNo,
                "checkNumber":checkNumber,
				"checkAmount":checkAmount,
            },
			success:function(data){
				console.log(data);

				const getData = data;
                const succData = getData.split(":");
                const succDataArr = succData[0];
				if(succDataArr == "Success"){
					$("#editCheck").fadeIn().delay(3000).fadeOut();
                    $("#editCheck").html(`<p class="alert alert-success"> ${data}</p>`);
                    
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
	
	const updateP = (id) => {
		const dateP = $("#dateP"+id).val();
		const particularsP = $("#particularsP"+id).val();
		const amountP = $("#amountP"+id).val();
		const transId = $("#transId"+id).val();

		 //make ajax call
		 $.ajax({
			type:"PUT",
            url:'/wimpys-food-express/payables/updateP/' + id,
			data:{
                _method:'put',
                "_token":"{{ csrf_token() }}",
                "id":id,
                "date":dateP,
                "particulars":particularsP,
				"amount":amountP,
				"transId":transId,
            },
			success:function(data){
				console.log(data);
				const getData = data;
                const succData = getData.split(":");
                const succDataArr = succData[0];
				if(succDataArr == "Success"){
					$("#editParticularP").fadeIn().delay(3000).fadeOut();
                    $("#editParticularP").html(`<p class="alert alert-success"> ${data}</p>`);
                    
                    setTimeout(function(){
                        document.location.reload();
                    }, 3000);
				}
			},
			error:function(data){
				console.log('Error:', data)
			}
		});
	}

	const updateParticular = (id) =>{
		const date = $("#date").val();
		const particulars = $("#particulars").val();
		const amount = $("#amount").val();
		
		 //make ajax call
		 $.ajax({
			type:"PUT",
            url:'/wimpys-food-express/payables/update-particulars/' + id,
			data:{
                _method:'put',
                "_token":"{{ csrf_token() }}",
                "id":id,
                "date":date,
                "particulars":particulars,
				"amount":amount,
            },
			success:function(data){
				console.log(data);
				const getData = data;
                const succData = getData.split(":");
                const succDataArr = succData[0];
				if(succDataArr == "Success"){
					$("#succEditParticular").fadeIn().delay(3000).fadeOut();
                    $("#succEditParticular").html(`<p class="alert alert-success"> ${data}</p>`);
                    
                    setTimeout(function(){
                        document.location.reload();
                    }, 3000);
				}
			},
			error:function(data){
				console.log('Error:', data)
			}
		});
	}
</script>
@endsection