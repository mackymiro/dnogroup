@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Cash Voucher Lists |')
@section('content')
<div id="wrapper">
	 @include('sidebar.sidebar')
    <div id="content-wrapper">
    	<div class="container-fluid">
    		 <!-- Breadcrumbs-->
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">Lechon de Cebu</a>
                </li>
                <li class="breadcrumb-item active">Cash Vouchers All Lists</li>
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
					  							@foreach($getAllCashVouchers as $getAllCashVoucher)
					  							<tr id="deletedId{{ $getAllCashVoucher['id']}}">
					  								<td>
					  									<a href="{{ url('lolo-pinoy-lechon-de-cebu/edit-payment-voucher/'.$getAllCashVoucher['id']) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
	      		  										<a id="delete" href="javascript:void" onClick="confirmDelete('{{ $getAllCashVoucher['id']}}')" title="Delete"><i class="fas fa-trash"></i></a>
	      		  										<a href="{{ url('lolo-pinoy-lechon-de-cebu/view-payment-voucher/'.$getAllCashVoucher['id']) }}" title="View"><i class="fas fa-low-vision"></i></a>
					  								</td>
					  								<td>{{ $getAllCashVoucher['reference_number'] }}</td>
					  								<td>{{ $getAllCashVoucher['paid_to'] }}</td>
					  								<td>{{ $getAllCashVoucher['account_no']}}</td>
					  								<td>{{ $getAllCashVoucher['date'] }}</td>
					  								<td class="bg-success" style="color:white;">{{ $getAllCashVoucher['method_of_payment'] }}</td>
					  								<td>{{ $getAllCashVoucher['particulars']}}</td>
					  								<td><?php echo number_format($getAllCashVoucher['amount'], 2); ?></td>
					  								<td>{{ $getAllCashVoucher['created_by'] }}</td>
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