@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Edit Sales Invoice |')
@section('content')
<style>
.selcls { 
    padding: 9px; 
    border: solid 1px #517B97; 
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
</script>
<div id="wrapper">
	 @include('sidebar.sidebar')
	 <div id="content-wrapper">
 		<div class="container-fluid">
 			<!-- Breadcrumbs-->
	         <ol class="breadcrumb">
	            <li class="breadcrumb-item">
	              <a href="#">Lechon de Cebu</a>
	            </li>
	            <li class="breadcrumb-item active">Edit Sales Invoice</li>
	          </ol>
	          <a href="{{ url('lolo-pinoy-lechon-de-cebu/') }}">Back to Lists</a>
	          <div class="col-lg-12">
  					<img src="{{ asset('images/digitized-logos/lolo-pinoy-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">

        	 		<h4 class="text-center"><u>SALES INVOICE</u></h4>
    		  </div>
    		  <div class="row">
    		  		<div class="col-lg-12">
		  				<div class="card mb-3">
		  					<div class="card-header">
                              <i class="fas fa-cash-register" aria-hidden="true"></i>
                            Edit Sales Invoice</div>

                            <form action="{{ action('LoloPinoyLechonDeCebuController@updateSalesInvoice', $getSalesInvoice['id'])}}" method="post">
                            	{{csrf_field()}}
                             <input name="_method" type="hidden" value="PATCH">
                             <div class="card-body">

                             @if(session('updateSuccessfull'))
                             	<p class="alert alert-success">{{ Session::get('updateSuccessfull') }}</p>
                             @endif 
	                             	<div class="form-group">
	                             		<div class="form-row">
	                             			<div class="col-md-2">
			                 					<label>Date</label>
			                 					<input type="text" name="date" class="selcls form-control" value="{{ $getSalesInvoice['date'] }}" />
			                 					
			                     			</div>
	                         				<div class="col-md-2">
			                 					<label>Invoice #</label>
			                 					<input type="text" name="invoiceNum" class="selcls form-control" value="{{ $getSalesInvoice['invoice_number']}}" />
			                 					
			                     			</div>
			                     			<div class="col-md-4">
			                     				<label>Ordered By</label>
			                     				<input type="text" name="orderedBy" class="selcls form-control" value="{{ $getSalesInvoice['ordered_by']}}" />
			                     				
			                     			</div>
			                     			<div class="col-md-4">
		                         				<label>Address</label>
		                         				<input type="text" name="address" class="selcls form-control" value="{{ $getSalesInvoice['address']}}" /> 
		                         			</div>
	                             		</div>
	                             	</div>
                             		<div class="form-group">
                         				<div class="form-row">
                         					<div class="col-md-1">
		                     					<label>Qty</label>
		                     					<input type="text" name="qty" class="selcls form-control" value="{{ $getSalesInvoice['qty']}}" />
		                         			</div>
		                         			 <div class="col-md-2">
		                                        <label>Body 400/KLS</label>
		                                        <input type="text" name="body" class="selcls form-control" value="{{ $getSalesInvoice['body']}}" />
		                                    </div>
		                                    <div class="col-md-2">
		                                        <label>Head & Feet 200/KLS</label>
		                                        <input type="text" name="headFeet" class="selcls form-control" value="{{ $getSalesInvoice['head_and_feet']}}" />
		                                    </div>
		                         			<div class="col-md-4">
		                         				<label>Item Description</label>
		                         				<input type="text" name="itemDescription" class="selcls form-control" value="{{ $getSalesInvoice['item_description']}}" />
		                         			</div>
		                         		
		                         			<div class="col-md-4">
		                         				<label>Amount</label>
		                         				<input type="text" name="amount" class="selcls form-control" disabled="disabled" value="<?php echo number_format($getSalesInvoice['amount'], 2)?>" />
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
    		  		<div class="col-lg-4">
		  				<div class="card mb-3">
		  					<div class="card-header">
							  <i class="fas fa-plus" aria-hidden="true"></i>
                            Add</div>
                             <div class="card-body">
                             	 @if(session('addSalesInvoiceSuccess'))
		                       <p class="alert alert-success">{{ Session::get('addSalesInvoiceSuccess') }}</p>
		                      @endif 
								<form action="{{ action('LoloPinoyLechonDeCebuController@addNewSalesInvoiceData', $id)}}" method="post">
									{{csrf_field()}}
								<div class="form-group">
									<div class="form-row">
										<div class="col-md-12">
											<label>Qty</label>
											<input type="text" name="qty" class="form-control" required="required"  />
										</div>
										<div class="col-md-12">
											<label>Body 400/KLS</label>
											<input type="text" name="body" class="form-control" />
										</div>
										<div class="col-md-12">
											<label>Head & Feet 200/KLS</label>
											<input type="text" name="headFeet" class="form-control" />
										</div>
										<div class="col-md-12">
											<label>Item Description</label>
											<input type="text" name="itemDescription" class="form-control"/>
										</div>
										
									</div>
								</div>
                             	 <div>
	                              <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-plus"></i> Add</button>
                     
	                            </div>
								</form>
                             </div>
		  				</div>
    		  		</div>
					<div class="col-lg-8">
						<div class="card mb-3">
							<div class="card-header">
							  <i class="fa fa-pencil" aria-hidden="true"></i>
                            Edit Sales Invoices</div>
  							<div class="card-body">
  								 @if(session('SuccessEdit'))
                                     <p class="alert alert-success">{{ Session::get('SuccessEdit') }}</p>
                                  @endif 
                             	@foreach($sInvoices as $sInvoice)
                             	<form action="{{ action('LoloPinoyLechonDeCebuController@updateSi', $sInvoice['id']) }}" method="post">
                             	 {{csrf_field()}}
                                 <input name="_method" type="hidden" value="PATCH">
                             	<div class="form-group">
                             		<div id="deletedId{{ $sInvoice['id'] }}" class="form-row">
                         				<div class="col-md-1">
	                     					<label>Qty</label>
	                     					<input type="text" name="qty" class="selcls form-control" value="{{ $sInvoice['qty']}}" />
	                         			</div>
	                         				 <div class="col-md-2">
		                                        <label>Body 400/KLS</label>
		                                        <input type="text" name="body" class="selcls form-control" value="{{ $sInvoice['body']}}" />
		                                    </div>
		                                    <div class="col-md-4">
		                                        <label>Head & Feet 200/KLS</label>
		                                        <input type="text" name="headFeet" class="selcls form-control" value="{{ $sInvoice['head_and_feet']}}" />
		                                    </div>
		                         			<div class="col-md-6">
		                         				<label>Item Description</label>
		                         				<input type="text" name="itemDescription" class="selcls form-control" value="{{ $sInvoice['item_description'] }}" />
		                         			</div>
		                         			
		                         			<div class="col-md-4">
		                         				<label>Amount</label>
		                         				<input type="text" name="ampunt" class="selcls form-control" disabled="disabled" value="<?php echo number_format(
		                         				$sInvoice['amount'], 2)?>" />
		                         			</div>
	                         				 <div class="col-lg-4">
	                                          <br>
	                                          <input type="hidden" id="siId" name="siId" value="{{ $getSalesInvoice['id'] }}" />
	                                          <input type="submit" class="btn btn-success" value="Update" />
	                                         
	                                          <a id="delete" onclick="confirmDelete('{{ $sInvoice['id'] }}')" href="javascript:void" class="btn btn-danger">Remove</a>
	                                         
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
	const confirmDelete = (id) => {
		const x = confirm("Do you want to delete this?");
		const siId = $("#siId").val();
			if(x){
				$.ajax({
				type: "DELETE",
				url: '/lolo-pinoy-lechon-de-cebu/delete-sales-invoice/' + id,
				data:{
					_method: 'delete', 
					"_token": "{{ csrf_token() }}",
					"id": id,
					"siId":siId,
				},
				success: function(data){
				
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