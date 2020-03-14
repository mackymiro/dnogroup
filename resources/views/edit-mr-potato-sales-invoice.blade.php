@extends('layouts.mr-potato-app')
@section('title', 'Edit Sales Invoice |')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
</script>
<div id="wrapper">
	@include('sidebar.sidebar-mr-potato')
	<div id="content-wrapper">
		<div class="container-fluid">
			<!-- Breadcrumbs-->
	         <ol class="breadcrumb">
	            <li class="breadcrumb-item">
	              <a href="#">Mr Potato</a>
	            </li>
	            <li class="breadcrumb-item active">Edit Sales Invoice</li>
	          </ol>
	          <a href="{{ url('mr-potato/') }}">Back to Lists</a>
	          <div class="col-lg-12">
	        		 <img src="{{ asset('images/mr-potato.png')}}" width="390" height="250" class="img-responsive mx-auto d-block" alt="Mr Potato">
        	 	
        	 		<h4 class="text-center"><u>SALES INVOICE</u></h4>
    		  </div>
    		  <div class="row">
	  				<div class="col-lg-12">
  						<div class="card mb-3">
							<div class="card-header">
                              <i class="fas fa-cash-register" aria-hidden="true"></i>
                            Edit Sales Invoice</div>
                            <form action="{{ action('MrPotatoController@updateSalesInvoice', $getSalesInvoice['id']) }}" method="post">
                            {{csrf_field()}}
                             <input name="_method" type="hidden" value="PATCH">
                            <div class="card-body">
                            	 @if(session('updateSuccessfull'))
	                             	<p class="alert alert-success">{{ Session::get('updateSuccessfull') }}</p>
	                             @endif 
                            	<div class="form-group">
	                    			<div class="form-row">
	                					<div class="col-md-2">
	                     					<label>Invoice #</label>
	                     					<input type="text" name="invoiceNum" class="form-control" value="{{ $getSalesInvoice['invoice_number']}}" />
	                     					

	                         			</div>
	                         			<div class="col-md-4">
	                         				<label>Ordered By</label>
	                         				<input type="text" name="orderedBy" class="form-control" value="{{ $getSalesInvoice['ordered_by']}}" />
	                         				
	                         			</div>
	                         			<div class="col-md-4">
	                         				<label>Address</label>
	                         				<input type="text" name="address" class="form-control" value="{{ $getSalesInvoice['address']}}" /> 
	                         			</div>
	                    			</div>
	                        	</div>	
	                        	<div class="form-group">
	                    			<div class="form-row">
	                					<div class="col-md-2">
	                     					<label>Qty</label>
	                     					<input type="text" name="qty" class="form-control" value="{{ $getSalesInvoice['qty']}}" />
	                         			</div>
	                         			<div class="col-md-2">
	                         				<label>Total KlS</label>
	                         				<input type="text" name="totalKls" class="form-control" value="{{ $getSalesInvoice['total_kls']}}" />
	                         			</div>
	                         			<div class="col-md-4">
	                         				<label>Item Description</label>
	                         				<input type="text" name="itemDescription" class="form-control" value="{{ $getSalesInvoice['item_description']}}" />
	                         			</div>
	                         			<div class="col-md-1">
	                         				<label>Unit Price</label>
	                         				<input type="text" name="unitPrice" class="form-control" disabled="disabled" value="500.00" />
	                         			</div>
                         				<div class="col-md-1">
	                         				<label>Amount</label>
	                         				<input type="text" name="amount" class="form-control" disabled="disabled" value="<?php echo number_format($getSalesInvoice['amount'], 2)?>" />
	                         			</div>
                    				</div>
                        		</div>
                        		<div class="form-group">
              					  	 		<div class="form-row">
              					  	 			<div class="float-right">
              					  	 				
        					  	 					  <button type="submit" class="btn btn-success">
        										      <i class="fa fa-refresh" aria-hidden="true"></i> Update Sales Invoice
        									      	 </button>
        			                            
              					  	 			</div>
              					  	 		</div>
        				  	 	        </div>
                            	</div>
                        		</form>
  						</div>
	  				</div>
    		  </div>
    		  <div class="row">
    		  		<div class="col-lg-12">
    		  			<div class="card mb-3">
    		  				<div class="card-header">
                              <i class="fas fa-cash-register" aria-hidden="true"></i>
                            Edit Sales Invoice</div>
                            <div class="card-body">
                            	 @if(session('SuccessEdit'))
		                             <p class="alert alert-success">{{ Session::get('SuccessEdit') }}</p>
		                          @endif 
                        		 @foreach($sInvoices as $sInvoice)
                        		 <form action="{{ action('MrPotatoController@updateSi', $sInvoice['id']) }}" method="post">
                        		 	{{csrf_field()}}
                          		 <input name="_method" type="hidden" value="PATCH">
                        		 <div class="form-group">
                    		 		<div id="deletedId{{ $sInvoice['id'] }}" class="form-row">
                		 				<div class="col-md-2">
	                     					<label>Qty</label>
	                     					<input type="text" name="qty" class="form-control" value="{{ $sInvoice['qty']}}" />
	                         			</div>
	                         			<div class="col-md-2">
	                         				<label>Total KlS</label>
	                         				<input type="text" name="totalKls" class="form-control" value="{{ $sInvoice['total_kls']}}" />
	                         			</div>
	                         			<div class="col-md-4">
	                         				<label>Item Description</label>
	                         				<input type="text" name="itemDescription" class="form-control" value="{{ $sInvoice['item_description']}}" />
	                         			</div>
	                         			<div class="col-md-1">
	                         				<label>Unit Price</label>
	                         				<input type="text" name="unitPrice" class="form-control" disabled="disabled" value="500.00" />
	                         			</div>
                         				<div class="col-md-1">
	                         				<label>Amount</label>
	                         				<input type="text" name="amount" class="form-control" disabled="disabled" value="<?php echo number_format($getSalesInvoice['amount'], 2)?>" />
	                         			</div>
	                         			<div class="col-lg-2">
		                                      <br>
		                                      <input type="hidden" name="siId" value="{{ $getSalesInvoice['id'] }}" />
		                                      <input type="submit" class="btn btn-success" value="Update" />
		                                      @if($user->role_type == 1)
		                                      <a id="delete" onClick="confirmDelete('{{ $sInvoice['id'] }}')" href="javascript:void" class="btn btn-danger">Remove</a>
		                                      @endif
	                                    </div>
                    		 		</div>
                        		 </div>
                        		 </form>
                        		 @endforeach
                            	 <div>
	                              @if($user->role_type == 1)
	                              <a href="{{ url('mr-potato/add-new-mr-potato-sales-invoice/'.$getSalesInvoice['id'] ) }}" class="btn btn-primary">Add New</a>
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
              url: '/mr-potato/delete-sales-invoice/' + id,
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