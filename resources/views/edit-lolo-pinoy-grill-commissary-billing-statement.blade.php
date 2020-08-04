@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'Edit Billing Statement |')
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
		@include('sidebar.sidebar-lolo-pinoy-grill')
		<div id="content-wrapper"> 
			<div class="container-fluid">
					<!-- Breadcrumbs-->
		            <ol class="breadcrumb">
		              <li class="breadcrumb-item">
		                <a href="#">Lolo Pinoy Grill Commissary</a>
		              </li>
		              <li class="breadcrumb-item active">Update Billing Statement Form</li>
		            </ol>
		             <a href="{{ url('lolo-pinoy-grill-commissary/billing-statement-lists') }}">Back to Lists</a>
		             <div class="col-lg-12">
		            	 <img src="{{ asset('images/digitized-logos/lolo-pinoy-grill.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lolo Pinoy Grill ">
		            	 
		            	 <h4 class="text-center"><u>BILLING STATEMENT/COLLECTION STATEMENT</u></h4>
		            </div>
		            <div class="row">
		            	 <div class="col-lg-12">
		            	 	<div class="card mb-3">
		            	 		 <div class="card-header">
	                              <i class="fas fa-receipt" aria-hidden="true"></i>
	                            Edit Billing Statement</div>
	                            <div class="card-body">
	                            	@if(session('SuccessE'))
                                    	 <p class="alert alert-success">{{ Session::get('SuccessE') }}</p>
                                    @endif 
	                            	<form action="{{ action('LoloPinoyGrillCommissaryController@updateBillingInfo', $billingStatement['id']) }}" method="post">
	                            		{{csrf_field()}}
                                   	<input name="_method" type="hidden" value="PATCH">
	                            	<div class="form-group">
                            			<div class="form-row">
                        					<div class="col-lg-2">
	        	 								<label>Bill To</label>
	        	 								<input type="text" name="billTo" class="form-control" value="{{ $billingStatement['bill_to']}}" />
	        	 					
	            	 						</div>
	            	 						<div class="col-lg-2">
	        	 								<label>Date</label>
	        	 								<input type="text" name="date" class="datepicker form-control" value="{{ $billingStatement['date']}}" />
	    	 								 	
	            	 						</div>
	            	 						<div class="col-lg-4">
	        	 								<label>Address</label>
	        	 								<input type="text" name="address" class="form-control" value="{{ $billingStatement['address']}}" />
	        	 								
	            	 						</div>	
	            	 						<div class="col-lg-4">
	            	 							<label>Period Covered</label>
	            	 							<input type="text" name="periodCovered" class="form-control" value="{{ $billingStatement['period_cover']}}" />
	        	 							 	
	            	 						</div>
                            			</div>
	                            	</div>
	                            	<div class="form-group">	
                            			<div class="form-row">
	            	 						<div class="col-lg-2">
	            	 							<label>Terms</label>
	            	 							<input type="text" name="terms" class="form-control" value="{{ $billingStatement['terms']}}" />
	            	 						</div>
                            			</div>
	                            	</div>
	                            	<div class="form-group">
	                            		<div class="form-row">	
                            				<div class="col-lg-2">
	        	 								<label>Date</label>
	        	 								<input type="text" name="transactionDate" class="datepicker form-control" value="{{ $billingStatement['date_of_transaction']}}" />
	        	 								
	            	 						</div>
	            	 						<div class="col-lg-2">
	        	 								<label>Invoice #</label>
	        	 								<input type="text" name="invoiceNumber" class="form-control" value="{{ $billingStatement['invoice_number']}}" />
	            	 						</div>
	            	 					
	            	 						<div class="col-lg-4">
	        	 								<label>Description</label>
	        	 								<input type="text" name="description" class="form-control" value="{{ $billingStatement['description']}}" />
	        	 								
	            	 						</div>
	            	 						<div class="col-lg-1">
	        	 								<label>Amount</label>
	        	 								<input type="text" name="amount" class="form-control" value="<?php echo number_format($billingStatement['amount'], 2); ?>" disabled="disabled" />
	        	 								
	            	 						</div>
											 <div class="col-lg-12 float-right">
												<br>
												<br>
												<input type="submit" class="btn btn-success float-right btn-lg"  value="Update Billing Statement" />
                                      		</div>
	                            		</div>                            		
	                            	</div>
	                            	</form>
	                            </div>
		            	 	</div>
		            	 </div>
		            </div>
		            <div class="row">
	            		 <div class="col-lg-4">
            				<div class="card mb-3">
            					<div class="card-header">
	                              <i class="fas fa-plus" aria-hidden="true"></i>
	                              Add </div>
	                            <div class="card-body">
									<form action="{{ action('LoloPinoyGrillCommissaryController@addNewBillingData', $id) }}" method="post">
									{{csrf_field()}}
									<div class="form-group">
	                            		<div class="form-row">	
                            				<div class="col-lg-12">
	        	 								<label>Date</label>
	        	 								<input type="text" name="transactionDate" class="datepicker form-control" required />
	        	 								
	            	 						</div>
	            	 						<div class="col-lg-12">
	        	 								<label>Invoice #</label>
	        	 								<input type="text" name="invoiceNumber" class="form-control"  />
	            	 						</div>
	            	 					
	            	 						<div class="col-lg-12">
	        	 								<label>Description</label>
	        	 								<input type="text" name="description" class="form-control"/>
	        	 								
	            	 						</div>
	            	 						<div class="col-lg-12">
	        	 								<label>Amount</label>
	        	 								<input type="text" name="amount" class="form-control" value="" />
	        	 								
	            	 						</div>
	            	 					
	                            		</div>                            		
	                            	</div>
									<div>
  										<button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-plus"></i>Add</button>
									</div>
									</form>
	                            </div>
								
            				</div>
	            		</div>
						<div class="col-lg-8">
  							<div class="card mb-3">
								<div class="card-header">
	                              <i class="fas fa-receipt" aria-hidden="true"></i>
	                            	Edit Billing Statement
								</div>
								<div class="card-body">
								@if(session('SuccessEdit'))
	                                   <p class="alert alert-success">{{ Session::get('SuccessEdit') }}</p>
	                                  @endif 
	                            	 @foreach($bStatements as $bStatement)
	                            	 <form action="{{ action('LoloPinoyGrillCommissaryController@updateBillingStatement', $bStatement['id']) }}" method="post">
	                            	 	 {{csrf_field()}}
                                    <input name="_method" type="hidden" value="PATCH">
	                            	<div class="form-group">
	                            		<div id="deletedId{{ $bStatement['id'] }}" class="form-row">
	                            			<div class="col-lg-2">
	                                            <label>Date</label>
	                                            <input type="text" name="transactionDate" class="form-control" value="{{ $bStatement['date_of_transaction']}}" />
		                                    </div>
		                                    <div class="col-lg-2">
	        	 								<label>Invoice #</label>
	        	 								<input type="text" name="invoiceNumber" class="form-control" value="{{ $bStatement['invoice_number']}}" />
	            	 						</div>
	            	 					
	            	 						<div class="col-lg-4">
	        	 								<label>Description</label>
	        	 								<input type="text" name="description" class="form-control" value="{{ $bStatement['description']}}" />
	        	 								
	            	 						</div>
	            	 						<div class="col-lg-2">
	        	 								<label>Amount</label>
	        	 								<input type="text" name="amount" class="form-control" value="<?php echo number_format($bStatement['amount'], 2); ?>" disabled="disabled" />
	        	 								
	            	 						</div>
	            	 						<div class="col-lg-4">
	                                          <br>
	                                          <input type="hidden" name="billingStatementId" value="{{ $billingStatement['id'] }}" />
	                                          <input type="submit" class="btn btn-success" value="Update" />
	                                          @if(Auth::user()['role_type'] == 1)
	                                          <a id="delete" onClick="confirmDelete('{{ $bStatement['id'] }}')" href="javascript:void" class="btn btn-danger">Remove</a>
	                                          @endif
	                                        </div>
			
	                            		</div>
	                            	</div>
	                            	 </form>
	                            	@endforeach
	                            	 
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
<script type="text/javascript">
	 const confirmDelete = (id) =>{
		const billingStatementId =  $("#billingStatementId").val();		
		var x = confirm("Do you want to delete this?");
			if(x){
				$.ajax({
				type: "DELETE",
				url: '/lolo-pinoy-grill-commissary/delete-data-billing-statement/' + id,
				data:{
					_method: 'delete', 
					"_token": "{{ csrf_token() }}",
					"id": id,
					"billingStatementId":billingStatementId
				},
				success: function(data){
					console.log(data);
					$("#deletedId"+id).fadeOut('slow');
				},
				error: function(data){
					console.log('Error:', data);
				}

				});

			}else{
				return false;
			}
   }
</script>
@endsection