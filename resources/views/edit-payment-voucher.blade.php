@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Edit Payment Voucher |')
@section('content')
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
              <li class="breadcrumb-item active">Update Payment Voucher</li>
            </ol>
             <a href="{{ url('lolo-pinoy-lechon-de-cebu/payment-voucher-form') }}">Back to Form</a>
             <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
            	 <h4 class="text-center"><u>PAYMENT VOUCHER</u></h4>
            </div>
            <div class="row">
            	 <div class="col-lg-12">
					<div class="card mb-3">
						 <div class="card-header">
                       <i class="fa fa-file-invoice" aria-hidden="true"></i>
                         Edit Payment Voucher</div>
                         <form action="{{ action('LoloPinoyLechonDeCebuController@updatePaymentVoucher', $getPaymentVoucher['id']) }}" method="post">
                         	{{ csrf_field() }}
                         	 <input name="_method" type="hidden" value="PATCH">
                         <div class="card-body">
                         	 @if(session('updateSuccessfull'))
                                 <p class="alert alert-success">{{ Session::get('updateSuccessfull') }}</p>
                                @endif 
                     		<div class="form-group">
                 				 <div class="form-row">
         				 			<div class="col-md-4">
				  	 					<label>Paid To </label>
				  	 					<input type="text" name="paidTo" class="form-control" value="{{ $getPaymentVoucher['paid_to']}}" />                           
				  	 				</div>
				  	 				<div class="col-md-4">
				  	 					<label>Account No</label>
				  	 					<input type="text" name="accountNo" class="form-control"  value="{{ $getPaymentVoucher['account_no']}}" />
					  	 			</div>
					  	 			<div class="col-md-2">
				  	 					<label>Date </label>
				  	 					<input type="text" name="date" class="form-control" value="{{ $getPaymentVoucher['date']}}"  />
					  	 			</div>
                 				 </div>
                     		</div>
                     		<div class="form-group">
                 				<div class="form-row">
             						<div class="col-md-4">
				  	 					<label>Particulars</label>
				  	 					<input type="text" name="particulars" class="form-control" value="{{ $getPaymentVoucher['particulars']}}" />
				  	 			    </div>
				  	 			   	<div class="col-md-2">
				  	 					<label>Amount</label>
				  	 					<input type="text" name="amount" class="form-control" value="{{ $getPaymentVoucher['amount']}}" />
					  	 			</div>
					  	 			<div class="col-md-2">
			  	 						<label>Method Of Payment</label>
				  	 					<select name="methodOfPayment" class="form-control">
				  	 						<option value="Cheque"  {{ ( $getPaymentVoucher['method_of_payment'] == "Cheque") ? 'selected' : '' }}>Cheque</option>
				  	 						<option value="Cash"  {{ ( $getPaymentVoucher['method_of_payment'] == "Cash") ? 'selected' : '' }}>Cash</option>
				  	 					</select>
			  	 			        </div>
                     			</div>
                     		</div>
                     		<div>
      		  	 				    <input type="submit" class="btn btn-success float-right" value="Update Payment Voucher" />
      			  	 			 </div>
			  	 			 <br>
                         </div>
                     	</form>
					</div>
            	 </div>
            </div>	
            <div class="row">
        		 <div class="col-lg-12">
        		 	<div class="card mb-3">
        		 		<div class="card-header">
                       <i class="fa fa-file-invoice" aria-hidden="true"></i>
                          Edit Payment Voucher</div>
                      	<div class="card-body">
                      		 @if(session('SuccessEdit'))
                               <p class="alert alert-success">{{ Session::get('SuccessEdit') }}</p>
                              @endif 
                      		@foreach($pVouchers as $pVoucher)
                      		<form action="{{ action('LoloPinoyLechonDeCebuController@updatePV', $pVoucher['id']) }}" method="post">
                      		 <div class="form-group">
                      		 	 {{csrf_field()}}
                                 <input name="_method" type="hidden" value="PATCH">
                      		 	<div id="deletedId{{ $pVoucher['id']}}" class="form-row">
                      		 		<div class="col-md-4">
              			  	 					<label>Particulars</label>
              			  	 					<input type="text" name="particulars" class="form-control" value="{{ $pVoucher['particulars']}}" />
        				  	 			     </div>
          			  	 			    	<div class="col-md-2">
            				  	 					<label>Amount</label>
            				  	 					<input type="text" name="amount" class="form-control"  value="{{ $pVoucher['amount']}}" />
            					  	 			</div>
					  	 			        <div class="col-lg-2">
                              <br>
                              <input type="hidden" name="pvId" value="{{ $getPaymentVoucher['id'] }}" />
                              <input type="submit" class="btn btn-success" value="Update" />
                              @if($user->role_type == 1)
                              <a id="delete" onClick="confirmDelete('{{ $pVoucher['id']}}')" href="javascript:void" class="btn btn-danger">Remove</a>
                              @endif
                            </div>
              		 	</div>
                      		 	
                		 </div>
                		</form>
                		 @endforeach
                		<div>
                        @if($user->role_type == 1)
                        <a href="{{ url('lolo-pinoy-lechon-de-cebu/add-new-payment-voucher/'.$getPaymentVoucher['id']) }}" class="btn btn-primary">Add New </a>
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
              url: '/lolo-pinoy-lechon-de-cebu/delete-payment-voucher/' + id,
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