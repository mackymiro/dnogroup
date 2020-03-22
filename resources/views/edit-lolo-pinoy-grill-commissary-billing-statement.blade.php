@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'Edit Billing Statement |')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
</script>
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
		            	 <img src="{{ asset('images/lolo-pinoy-grill.jpeg')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lolo Pinoy Grill ">
		            	 
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
	        	 								<input type="text" name="date" class="form-control" value="{{ $billingStatement['date']}}" />
	    	 								 	
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
	            	 							<label>PO Number</label>
	            	 							<select name="poNumber" class="form-control">
	    	 									  	 @foreach($getPurchaseOrders as $getPurchaseOrder)
			                                            <option value="{{ $getPurchaseOrder['p_o_number'] }}" {{ ( $billingStatement['p_o_number'] == $getPurchaseOrder['p_o_number']) ? 'selected' : '' }}>{{ $getPurchaseOrder['p_o_number'] }}</option>
		                                            @endforeach
	            	 							</select>
	            	 						</div>
	            	 						<div class="col-lg-2">
	            	 							<label>Terms</label>
	            	 							<input type="text" name="terms" class="form-control" value="{{ $billingStatement['terms']}}" />
	            	 							
	            	 						</div>
                            			</div>
	                            	</div>
	                            	<div class="form-group">
	                            		<div class="form-row">	
                            				<div class="col-lg-1">
	        	 								<label>Date</label>
	        	 								<input type="text" name="transactionDate" class="form-control" value="{{ $billingStatement['date_of_transaction']}}" />
	        	 								
	            	 						</div>
	            	 						<div class="col-lg-1">
	        	 								<label>Invoice #</label>
	        	 								<input type="text" name="invoiceNumber" class="form-control" value="{{ $billingStatement['invoice_number']}}" />
	            	 						</div>
	            	 						<div class="col-lg-4">
	            	 							<label>Whole Lechon 500/KL</label>
	            	 							<input type="text" name="wholeLechon" class="form-control" value="{{ $billingStatement['whole_lechon'] }}" />
	            	 							
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
		                                        <input type="submit" class="btn btn-success"  value="Update Billing Statement" />
		                                      </div>
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
	                              <i class="fas fa-receipt" aria-hidden="true"></i>
	                            Edit Billing Statement</div>
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
	                            			<div class="col-lg-1">
	                                            <label>Date</label>
	                                            <input type="text" name="transactionDate" class="form-control" value="{{ $bStatement['date_of_transaction']}}" />
		                                    </div>
		                                    <div class="col-lg-1">
	        	 								<label>Invoice #</label>
	        	 								<input type="text" name="invoiceNumber" class="form-control" value="{{ $bStatement['invoice_number']}}" />
	            	 						</div>
	            	 						<div class="col-lg-2">
	            	 							<label>Whole Lechon 500/KL</label>
	            	 							<input type="text" name="wholeLechon" class="form-control" value="{{ $bStatement['whole_lechon']}}" />
	            	 							
	            	 						</div>
	            	 						<div class="col-lg-4">
	        	 								<label>Description</label>
	        	 								<input type="text" name="description" class="form-control" value="{{ $bStatement['description']}}" />
	        	 								
	            	 						</div>
	            	 						<div class="col-lg-1">
	        	 								<label>Amount</label>
	        	 								<input type="text" name="amount" class="form-control" value="<?php echo number_format($bStatement['amount'], 2); ?>" disabled="disabled" />
	        	 								
	            	 						</div>
	            	 						<div class="col-lg-2">
	                                          <br>
	                                          <input type="hidden" name="billingStatementId" value="{{ $billingStatement['id'] }}" />
	                                          <input type="submit" class="btn btn-success" value="Update" />
	                                          @if($user->role_type == 1)
	                                          <a id="delete" onClick="confirmDelete('{{ $bStatement['id'] }}')" href="javascript:void" class="btn btn-danger">Remove</a>
	                                          @endif
	                                        </div>
			
	                            		</div>
	                            	</div>
	                            	 </form>
	                            	@endforeach
	                            	 <div>
	                                  @if($user->role_type == 1)
	                                  <a href="{{ url('lolo-pinoy-grill-commissary/add-new-lolo-pinoy-grill-billing-statement/'.$billingStatement['id'] ) }}" class="btn btn-primary">Add New</a>
	                                  @endif
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
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript">
	 function confirmDelete(id){
      var x = confirm("Do you want to delete this?");
        if(x){
            $.ajax({
              type: "DELETE",
              url: '/lolo-pinoy-grill-commissary/delete-billing-statement/' + id,
              data:{
                _method: 'delete', 
                "_token": "{{ csrf_token() }}",
                "id": id
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