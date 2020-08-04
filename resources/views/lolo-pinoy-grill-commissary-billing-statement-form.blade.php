@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'Billing Statement Form |')
@section('content')
<script>
    $(function() {
        $( ".datepicker" ).datepicker();
    });
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div id="wrapper">
	<!-- Sidebar -->
    @include('sidebar.sidebar-lolo-pinoy-grill')
    <div id="content-wrapper">
    	<form action="{{ action('LoloPinoyGrillCommissaryController@storeBillingStatement') }}" method="post">
    		 {{csrf_field()}}
    	<div class="container-fluid">
    		 	<!-- Breadcrumbs-->
	            <ol class="breadcrumb">
	              <li class="breadcrumb-item">
	                <a href="#">Lolo Pinoy Grill Commissary</a>
	              </li>
	              <li class="breadcrumb-item active">Billing Statement Form</li>
	            </ol>
	            <div class="col-lg-12">
            	  <img src="{{ asset('images/digitized-logos/lolo-pinoy-grill.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lolo Pinoy Grill ">
            	 
            	 <h4 class="text-center"><u>BILLING STATEMENT</u></h4>
            	</div>
            	 <div class="row">
            	 	<div class="col-lg-12">
            	 		<div class="card mb-3">
        	 				<div class="card-header">
                              	<i class="fas fa-receipt" aria-hidden="true"></i>
                            	Billing Statement</div>
                        	 <div class="card-body">
                    	 		<div class="form-group">
                	 				<div class="form-row">
            	 						<div class="col-lg-2">
        	 								<label>Bill To</label>
        	 								<input type="text" name="billTo" class="form-control" required="required" />
        	 								 @if ($errors->has('billTo'))
			                                    <span class="alert alert-danger">
			                                      <strong>{{ $errors->first('billTo') }}</strong>
			                                    </span>
			                                @endif
            	 						</div>	
            	 						<div class="col-lg-2">
        	 								<label>Date</label>
        	 								<input type="text" name="date" class="datepicker form-control" required="required" />
    	 								 	@if ($errors->has('date'))
			                                    <span class="alert alert-danger">
			                                      <strong>{{ $errors->first('date') }}</strong>
			                                    </span>
		                                  	@endif
            	 						</div>
										
            	 						<div class="col-lg-4">
        	 								<label>Address</label>
        	 								<input type="text" name="address" class="form-control" required="required" />
        	 								 @if ($errors->has('address'))
			                                    <span class="alert alert-danger">
			                                      <strong>{{ $errors->first('address') }}</strong>
			                                    </span>
			                                  @endif
            	 						</div>
            	 						<div class="col-lg-4">
            	 							<label>Period Covered</label>
            	 							<input type="text" name="periodCovered" class="form-control" required="required" />
        	 							 	 @if ($errors->has('periodCovered'))
		                                    <span class="alert alert-danger">
		                                      <strong>{{ $errors->first('periodCovered') }}</strong>
		                                    </span>
		                                  @endif
            	 						</div>
                	 				</div>
                    	 		</div>
                    	 		<div class="form-group">
                	 				<div class="form-row">
            	 						<div class="col-lg-2">
            	 							<label>Terms</label>
            	 							<input type="text" name="terms" class="form-control" required="required" />
            	 							 @if ($errors->has('terms'))
			                                    <span class="alert alert-danger">
			                                      <strong>{{ $errors->first('terms') }}</strong>
			                                    </span>
			                                  @endif
            	 						</div>
                	 				</div>
                    	 		</div>
                    	 		<div class="form-group">
                	 				<div class="form-row">
            	 						<div class="col-lg-2">
        	 								<label>Date</label>
        	 								<input type="text" name="transactionDate" class="datepicker form-control" required="required" />
        	 								@if ($errors->has('transactionDate'))
	                                            <span class="alert alert-danger">
	                                              <strong>{{ $errors->first('transactionDate') }}</strong>
	                                            </span>
	                                          @endif
            	 						</div>
										
            	 						<div  class="col-lg-2">
        	 								<label>Invoice #</label>
        	 								<input type="text" name="invoiceNumber" class="form-control" required="required" />
            	 						</div>
										 <div  class="col-lg-4">
        	 								<label>Description</label>
        	 								<input type="text" name="description" class="form-control"  />
        	 							
            	 						</div>
            	 						<div  class="col-lg-2">
            	 							<label>Amount</label>
            	 							<input type="text" name="amount" class="form-control"  />
            	 							
            	 						</div>
									
                	 				</div>
                	 				 <br>
		                            <div>
									<button type="submit" class="btn btn-success btn-lg float-right"><i class="fas fa-save"></i> Save Billing</button>
		                            </div>
                    	 		</div>
                        	 </div>
            	 		</div>
            	 	</div>
            	 </div>
    	</div>
    	</form>
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
	
</script>
@endsection