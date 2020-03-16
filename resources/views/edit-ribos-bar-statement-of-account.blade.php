@extends('layouts.ribos-bar-app')
@section('title', 'Edit Statment Of Account|')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
</script>
<div id="wrapper">
	 @include('sidebar.sidebar-ribos-bar')
	 <div id="content-wrapper">
	 	<div class="container-fluid">
	 		<!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Ribo's Bar</a>
              </li>
              <li class="breadcrumb-item active">Update Statement Of Account Form</li>
            </ol>
            <a href="{{ url('ribos-bar/statement-of-account-lists') }}">Back to Lists</a>
             <div class="col-lg-12">
            	<img src="{{ asset('images/ribos.jpg')}}" width="390" height="250" class="img-responsive mx-auto d-block" alt="Rib's Bar">
            	 
            	 <h4 class="text-center"><u>STATEMENT OF ACCOUNT</u></h4>
            </div>
            <div class="row">
            	 <div class="col-lg-12">
            	 	<div class="card mb-3">
            	 		<div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            Edit Statement Of Account</div>
                        <div class="card-body">
                    		 @if(session('SuccessE'))
                                 <p class="alert alert-success">{{ Session::get('SuccessE') }}</p>
                            @endif 
                        	<form action="{{ action('RibosBarController@updateStatementInfo', $getStatementOfAccount['id'])}}" method="post">
                        		 {{csrf_field()}}
                              <input name="_method" type="hidden" value="PATCH">
                        	<div class="form-group">
                    			<div class="form-row">
                					<div class="col-lg-2">
        		 						<label>Date</label>
        		 						<input type="text" name="date" class="form-control" value="{{ $getStatementOfAccount['date']}}" />
        		 						
        		 					</div>
        		 					<div class="col-lg-2">
			 							 <label>Branch</label>
				                          
			                           <select name="branch" class="form-control">
		                             	 <option value="0">--Please Select--</option>
	                                      <option value="Terminal 1" <?php echo ("Terminal 1" == $getStatementOfAccount['branch']) ? 'selected="selected"' : '' ?> >Terminal 1</option>
	                                      <option value="Terminal 2" <?php echo ("Terminal 2" == $getStatementOfAccount['branch']) ? 'selected="selected"' : '' ?> >Terminal 2</option>
		                                    </option>
			                            </select>
				                          
	    		 					</div>
	    		 					<div class="col-lg-2">
    		 							 <label>Invoice #</label>
                  						<input type="text" name="invoiceNumber" class="form-control" disabled="disabled"  value="{{ $getStatementOfAccount['invoice_number']}}" />
        		 					</div>
        		 					<div class="col-lg-2">
    		 							<label>Kilos</label>
    		 							<input type="text" name="kilos" class="form-control" value="{{ $getStatementOfAccount['kilos']}}" />
    		 							 
        		 					</div>
        		 					<div class="col-lg-2">
    		 							<label>Unit Price</label>
    		 							<input type="text" name="unitPrice" class="form-control" value="{{ $getStatementOfAccount['unit_price']}}" />
        		 					</div>
        		 					<div class="col-lg-2">
        		 						<label>Payment Method</label>
        		 						<select name="paymentMethod" class="form-control">
		                                    <option value="0">--Please Select--</option>
		                                    <option value="CHEQUE" <?php echo ("CHEQUE" == $getStatementOfAccount['payment_method']) ? 'selected="selected"' : '' ?>>CHEQUE</option>
		                                    <option value="ACCOUNT"  <?php echo ("ACCOUNT" == $getStatementOfAccount['payment_method']) ? 'selected="selected"' : '' ?>>ACCOUNT</option>
		                                  </option>
	                                  	</select>
        		 					</div>
                    			</div>
                        	</div>
                        	<div class="form-group">
                				<div class="form-row">
            						<div class="col-lg-2">
    		 							<label>Amount</label>
    		 							<input type="text" name="amount" class="form-control" value="" />
    		 							
    		 						</div>
    		 						<div class="col-lg-2">
		 								<label>Status</label>
				                            <select name="status" class="form-control">
				                             	 <option value="0">--Please Select--</option>
			                                    <option value="Unpaid"  <?php echo ("Unpaid" == $getStatementOfAccount['status']) ? 'selected="selected"' : '' ?>>Unpaid</option>
			                                    <option value="Paid"  <?php echo ("Paid" == $getStatementOfAccount['status']) ? 'selected="selected"' : '' ?>>Paid</option>
				                            </select>
				                          
			 						</div>
			 						<div class="col-lg-2">
        		 							<label>Paid Amount</label>
        		 							<input type="text" name="paidAmount" class="form-control" value="{{ $getStatementOfAccount['paid_amount']}}" />
        		 						</div>
        		 						<div class="col-lg-2">
        		 							<label>Collection Date</label>
        		 							<input type="text" name="collectionDate" class="form-control"  value="{{ $getStatementOfAccount['collection_date']}}" />
        		 						</div>
        		 						<div class="col-lg-2">
        		 							<label>Check Number</label>
        		 							<input type="text" name="checkNumber" class="form-control" value="{{ $getStatementOfAccount['check_number']}}" />
        		 						</div>
        		 						<div class="col-lg-2">
        		 							<label>Check Amount</label>
        		 							<input type="text" name="checkAmount" class="form-control" value="{{ $getStatementOfAccount['check_amount']}}" />
        		 							
        		 						</div>
                				</div>
                        	</div>
                        	<div class="form-group">
                    			<div class="form-row">
                					<div class="col-lg-2">
        		 						<label>OR Number</label>
        		 						<input type="text" name="orNumber" class="form-control" value="{{ $getStatementOfAccount['or_number']}}" />
        		 					</div>
        		 					<br>
			                         <div class="col-lg-12 float-right">
	                                    <br>
	                                    <br>
	                                    <input type="submit" class="btn btn-success"  value="Update Statement Of Account" />
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
                            Edit Statement Of Account</div>
                         <div class="card-body">
                         		<div class="form-group">
                     				<div class="form-row">
                 						
                     				</div>
                         		</div>
                         </div>
        		 	</div>
        		 </div>
            </div>
	 	</div>
	 </div>
</div>
@endsection