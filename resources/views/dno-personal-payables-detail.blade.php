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

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css" >
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>


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
	    					  		<form action="{{ action('DnoPersonalController@addPayment', $transactionList[0]->id) }}" method="post">
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
				  								<label>Payment Cash Number</label>
				  								<input type="text" name="chequeNumber" class="form-control" />
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
  								<form action="{{ action('DnoPersonalController@addParticulars', $transactionList[0]->id) }}" method="post">
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
    					  		<form action="{{ action('DnoPersonalController@accept', $transactionList[0]->id)}}" method="post">
    					  			{{ csrf_field() }}
    					  			 <input name="_method" type="hidden" value="PATCH">
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
		  									<input type="text" name="voucherRef" class="form-control" value="{{ $transactionList[0]->module_code}}{{ $transactionList[0]->dno_personal_code}}" disabled="disabled" />
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
										@if($transactionList[0]->sub_category_name != "NULL")
										<div class="col-lg-4">
		  									<label>&nbsp;</label>
		  									<input type="text" name="subCateogry" class="form-control" value="{{ $transactionList[0]->sub_category_name }}" disabled="disabled" />
			  							</div>
										@endif
										@if($transactionList[0]->sub_category_bill_name != "NULL")
										<div class="col-lg-4">
		  									<label>&nbsp;</label>
		  									<input type="text" name="subCateogryBillBName" class="form-control" value="{{ $transactionList[0]->sub_category_bill_name }}" disabled="disabled" />
			  							</div>
										@endif
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
		  									<input type="text" name="voucherRef" class="form-control" value="{{ $transactionList[0]->module_code}}{{ $transactionList[0]->dno_personal_code}}" disabled="disabled" />
			  							</div>
  										
										@if($transactionList[0]->use_credit_card == "Use Card")
										<div class="col-lg-4">
											<label>Bank Name</label>
											<?php
												$bankCard = explode("-", $transactionList[0]->bank_card);
												$bank = $bankCard;
											?>
											<input type="text" name="bankName" class="form-control" value="{{ $bank[1] }}" disabled="disabled" />
										</div>
  										@endif

										@if($transactionList[0]->use_credit_card != "No")
										<div class="col-lg-4">
		  									<label>Account #</label>
		  									<input type="text" name="accountNum" class="form-control" value="{{ $transactionList[0]->account_no }}" disabled="disabled" />
			  							</div>
										@endif
										<div class="col-lg-6">
		  									<label>Account Name</label>
		  									<input type="text" name="accountName" class="form-control" value="{{ $transactionList[0]->account_name }}" disabled="disabled" />
			  							</div>
										@if($transactionList[0]->use_credit_card != "No")
										<div class="col-lg-4">
		  									<label>Type Of Card</label>
		  									<input type="text" name="typeOfCard" class="form-control" value="{{ $transactionList[0]->type_of_card }}" disabled="disabled" />
			  							</div>
										@endif
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
											<td><?php echo number_format($transactionList[0]->amount, 2); ?></td>
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
											<th>PAYMENT CASH NUMBER</th>
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
				  							<td><?php echo number_format($getChequeNumber['cheque_amount'], 2); ?></td>
				  						</tr>
				  						@endforeach
				  						<tr>
				  							<td class="bg-info" style="color:white;">Total</td>
											<td class="bg-info" style="color:white;"></td>
											<td class="bg-info" style="color:white;"></td>
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
						@if($transactionList[0]->use_credit_card === "No")
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
								<label>Bank Name </label>
								<?php
									$bankCard = explode("-", $transactionList[0]->bank_card);
									$bank = $bankCard;
								?>
								<select  data-live-search="true" id="bankName" name="bankName" class="change selectpicker form-control">
								<option value="0">--Please Select--</option>
								@foreach($getCreditCards as $getCreditCard)
								<option value="{{ $getCreditCard['id'] }}-{{ $getCreditCard['bank_name']}}" {{ ( $getCreditCard['bank_name'] == $bank[1]) ? 'selected' : '' }}>{{ $getCreditCard['bank_name'] }}</option>
								@endforeach
							</select>
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
							<div class="col-lg-4">
								<label>Type Of Card </label>
								<div id="typeOfCardHide">
									<input type="text" id="typeOfCard" name="typeOfCard" class="form-control" disabled value="{{ $transactionList[0]->type_of_card}}" />
								</div>
								<div id="typeOfCard1"></div>
							</div>
							
						</div>

						@endif

					@endif
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				@if($transactionList[0]->use_credit_card === "No")
					<button type="button" onclick="updateDetailsPayable(<?php echo $transactionList[0]->id; ?>)" class="btn btn-success">Update changes</button>
			
				@else
					<button type="button" onclick="updateDetailsPayableCard(<?php echo $transactionList[0]->id; ?>)" class="btn btn-success">Update changes</button>
			
				@endif
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
							<input type="text" id="dateP<?php echo $getParticular['id']?>" name="date" class="datepicker form-control"  value="{{ $getParticular['date']}}" />
						</div>
						<div class="col-lg-4">
							<label>Particulars</label>
							<textarea id="particularsP<?php echo $getParticular['id']?>" name="particulars" class="form-control">{{ $getParticular['particulars'] }}</textarea>
						</div>
						<div class="col-lg-4">
							<label>Amount</label>
							<input type="text" id="amountP<?php echo $getParticular['id']?>" name="amount" class="form-control" value="{{ $getParticular['amount'] }}" />
						</div>
						
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				<input type="hidden" id="transId<?php echo $getParticular['id']?>" value="{{ $transactionList[0]->id }}" />
				<button type="button" onclick="updateP(<?php echo $getParticular['id'];?>)" class="btn btn-success">Update changes</button>
			</div>
			</div>
		</div>
	</div>
	@endforeach
	<!-- Modal -->
	@foreach($getChequeNumbers as $getChequeNumber)
	<div class="modal fade" id="editCheck<?php echo $getChequeNumber['id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
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
							<input type="text" id="accountNameNo<?php echo $getChequeNumber['id']?>" name="accountNameNo" class="form-control"  value="{{ $getChequeNumber['account_name_no']}}" />
						</div>
						<div class="col-lg-4">
							<label>Payment Check Number</label>
							<input type="text" id="checkNumber<?php echo $getChequeNumber['id']?>" name="checkNumber" class="form-control"  value="{{ $getChequeNumber['cheque_number']}}" />
						
						</div>
						<div class="col-lg-4">
							<label>Check Amount</label>
							<input type="text" id="checkAmount<?php echo $getChequeNumber['id']?>" name="amount" class="form-control" value="{{ $getChequeNumber['cheque_amount']}}" />
						</div>
						
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				<button type="button" onclick="updateCheck(<?php echo $getChequeNumber['id']; ?>)" class="btn btn-success">Update check</button>
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

$(".change").change(function(){
             
             const bankName =   $(this).children("option:selected").val();
             const bankNameSplit  = bankName.split("-");
             const bankNameSplitArr = bankNameSplit[0];
			
             if(bankNameSplitArr != 0 ){
                  <?php
                    $getCreditCards = DB::table(
                                      'dno_personal_credit_cards')
                                      ->get();  ?>

                  <?php foreach($getCreditCards as $getCreditCard): ?>
                        var paidTo =  $(this).children("option:selected").val();
						var paidToSplit = paidTo.split("-");
                        var paidToSplitArr = paidToSplit[0];
						
                        if(paidToSplitArr === "<?php echo $getCreditCard->id ?>"){
                          <?php
                                $getId = DB::table(
                                              'dno_personal_credit_cards')
                                            ->where('id', $getCreditCard->id)
                                            ->get();
                            ?>
                          
                            $("#accountNo").html('<input type="text" id="acct" name="accountNo" class=" form-control" value="<?php echo $getId[0]->account_no?>" readonly="readonly">');
                            $("#accountNoHide").hide();

            
                            $("#accountName1").html('<input type="text" id="actName" name="accountName" class="form-control" value="<?php echo $getId[0]->account_name; ?>" readonly="readonly"> ');
                            $("#accountNameHide").hide();

                            $("#typeOfCard1").html('<input type="text" id="typeCC" name="typeOfCard" class="form-control" value="<?php echo $getId[0]->type_of_card?>" readonly="readonly">');
                            $("#typeOfCardHide").hide();
                        }

                  <?php endforeach; ?>

             }else{
                  $("#acct").val('');
                  $("#actName").val('');
                  $("#typeCC").val('');
             }
             
             
        });

	const updateDetailsPayableCard = (id) =>{
		const paidTo = $("#paidTo").val();
		const invoiceNo = $("#invoiceNo").val();

		const bankName = $("#bankName").val();

		const acctNum  = $("#acct").val();
		const actName = $("#actName").val();
		const typeCC = $("#typeCC").val();

		//make ajax call
		$.ajax({
			type:"PATCH",
            url:'/dno-personal/payables/update-details-cc/' + id,
			data:{
                _method:'patch',
                "_token":"{{ csrf_token() }}",
                "id":id,
                "paidTo":paidTo,
                "invoiceNo":invoiceNo,
				"bankName":bankName,
				"acctNum":acctNum,
				"actName":actName,
				"typeCC":typeCC,
            },
			success:function(data){
				console.log(data);

				const getData = data;
                const succData = getData.split(":");
                const succDataArr = succData[0];

				if(succDataArr == "Success"){
					$("#editCC").fadeIn().delay(3000).fadeOut();
                    $("#editCC").html(`<p class="alert alert-success"> ${data}</p>`);
                    
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

	const updateDetailsPayable = (id) =>{
		const paidTo = $("#paidTo").val();
		const invoiceNo = $("#invoiceNo").val();
		const accountName = $("#accountName").val();

		//make ajax call
		$.ajax({
			type:"PATCH",
            url:'/dno-personal/payables/update-details/' + id,
			data:{
                _method:'patch',
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

	const updateCheck = (id) => {
		const accountNameNo = $("#accountNameNo"+id).val();
		const checkNumber = $("#checkNumber"+id).val();
		const checkAmount = $("#checkAmount"+id).val();

		//make ajax call
		$.ajax({
			type:"PATCH",
            url:'/dno-personal/payables/update-check/' + id,
			data:{
                _method:'patch',
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
			type:"PATCH",
            url:'/dno-personal/payables/updateP/' + id,
			data:{
                _method:'patch',
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
			type:"PATCH",
            url:'/dno-personal/payables/update-particulars/' + id,
			data:{
                _method:'patch',
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