@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'Add New Payment Voucher |')
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
              <li class="breadcrumb-item active">Add New Payment Voucher</li>
            </ol>
             <div class="row">
             	<div class="col-lg-12">
             		<div class="card mb-3">
             			<div class="card-header">
						  <i class="fa fa-plus" aria-hidden="true"></i>
						  Add New</div>
						  <div class="card-body">
						  		<form action="{{ action('LoloPinoyGrillCommissaryController@addNewPaymentVoucherData', $id) }}" method="post">
						  			{{csrf_field()}}
				  				 @if(session('addPaymentVoucherSuccess'))
			                       <p class="alert alert-success">{{ Session::get('addPaymentVoucherSuccess') }}</p>
			                     @endif 
					  			<div class="form-group">
					  	 			<div class="form-row">
				  	 					<div class="col-md-4">
					  	 					<label>Particulars</label>
					  	 					<input type="text" name="particulars" class="form-control" required="required" />
					  	 			    </div>
					  	 			    <div class="col-md-2">
					  	 					<label>Amount</label>
					  	 					<input type="text" name="amount" class="form-control" />
						  	 			</div>
					  	 			</div>
						  	 	</div>
						  	 	<div class="form-group">
						   			<div class="form-row">
						   				<div class="col-lg-12 float-right">
				  							<input type="submit" class="btn btn-success" value="Add" />
				  							<br>
				  							<br>
				  							<br>
				  							<a href="{{ url('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-payment-voucher/'.$id) }}">Back</a>
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
@endsection