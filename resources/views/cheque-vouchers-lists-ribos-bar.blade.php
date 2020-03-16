@extends('layouts.ribos-bar-app')
@section('title', 'Cheque Vouchers Lists |')
@section('content')
<div id="wrapper">
	 @include('sidebar.sidebar-ribos-bar')
     <div id="content-wrapper">
		<div class="container-fluid">
			 <!-- Breadcrumbs-->
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">Ribo's Bar</a>
                </li>
                <li class="breadcrumb-item active">Cheque Vouchers All Lists</li>
              </ol>
               <div class="row">
               		<div class="col-lg-12">
               			<div class="card mb-3">
               				<div class="card-header">
	    					  <i class="fa fa-file-invoice" aria-hidden="true"></i>
	    					  All Lists</div>
    					  	<div class="card-body">
    					  		<div class="table-responsive">
    					  			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    					  				<thead>
						  						<th>Action</th>
						  						<th>Reference #</th>
							                    <th>Paid To</th>
						  						<th>Account No</th>
						  						<th>Date</th>
						  						<th>Method Of Payment</th>
						  						<th>Particulars</th>
						  						<th>Amount</th>
						  						<th>Created By</th>
					  						</thead>
					  						<tfoot>
					  							<th>Action</th>
						  						<th>Reference #</th>
							                    <th>Paid To</th>
						  						<th>Account No</th>
						  						<th>Date</th>
						  						<th>Method Of Payment</th>
						  						<th>Particulars</th>
						  						<th>Amount</th>
						  						<th>Created By</th>
					  						</tfoot>
					  						<tbody>
					  							@foreach($getAllChequeVouchers as $getAllChequeVoucher)
					  							<tr id="deletedId{{ $getAllChequeVoucher['id']}}">
					  								<td>
					  									<a href="{{ url('ribos-bar/edit-ribos-bar-payment-voucher/'.$getAllChequeVoucher['id']) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
	      		  										<a id="delete" href="javascript:void" onClick="confirmDelete('{{ $getAllChequeVoucher['id']}}')" title="Delete"><i class="fas fa-trash"></i></a>
	      		  										<a href="{{ url('ribos-bar/view-ribos-bar-payment-voucher/'.$getAllChequeVoucher['id'])}}" title="View"><i class="fas fa-low-vision"></i></a>
					  								</td>
					  								<td>{{ $getAllChequeVoucher['reference_number'] }}</td>
					  								<td>{{ $getAllChequeVoucher['paid_to']}}</td>
					  								<td>{{ $getAllChequeVoucher['account_no']}}</td>
					  								<td>{{ $getAllChequeVoucher['date']}}</td>
					  								<td class="bg-danger" style="color:white">{{ $getAllChequeVoucher['method_of_payment']}}</td>
					  								<td>{{ $getAllChequeVoucher['particulars']}}</td>
					  								<td><?php echo number_format($getAllChequeVoucher['amount'], 2); ?></td>
					  								<td>{{ $getAllChequeVoucher['created_by'] }}</td>
					  							</tr>
					  							@endforeach
					  						</tbody>
    					  			</table>
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
	              url: '/ribos-bar/delete-payment-voucher/' + id,
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