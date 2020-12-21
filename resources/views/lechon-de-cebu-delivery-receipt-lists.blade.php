@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Delivery Receipt Lists| ')
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
                <li class="breadcrumb-item active">Delivery Receipt All Lists</li>
              </ol>
              <div class="row">
              		<div class="col-lg-12">
          				<div class="card mb-3">
          						<div class="card-header">
    		    					  <i class="fa fa-receipt" aria-hidden="true"></i>
    		    					  All Lists</div>
	    					  	<div class="card-body">
                       @if(session('duplicateSuccess'))
                       <p class="alert alert-success">{{ Session::get('duplicateSuccess') }}</p>
                      @endif 
	    					  		<div class="table-responsive">
	    					  			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					  					<thead>
					  						<th>Action</th>
					  						<th>Date</th>
                        <th>DR No</th>
	                      
					  						<th>Sold To</th>
					  						<th>Time</th>
                        <th>Date To Be Delivered</th>
					  						<th>Delivered To</th>
					  						<th>Qty</th>
					  						<th>Description</th>
					  						<th>Price</th>
					  						<th>Created By</th>
				  						</thead>
			  							<tfoot>
				  							<th>Action</th>
                        <th>Date</th>
                        <th>DR No</th>
	                     
					  						<th>Sold To</th>
					  						<th>Time</th>
                        <th>Date To Be Delivered</th>
					  						<th>Delivered To</th>
					  						<th>Qty</th>
					  						<th>Description</th>
					  						<th>Price</th>
					  						<th>Created By</th>

			  							</tfoot>
			  							<tbody>
			  								@foreach($getAllDeliveryReceipts as $getAllDeliveryReceipt)
			  								<tr id="deletedId{{ $getAllDeliveryReceipt->id }}">
			  									<td>
               					
			  									<a href="{{ url('lolo-pinoy-lechon-de-cebu/edit-delivery-receipt/'.$getAllDeliveryReceipt->id ) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
               					
              						@if(Auth::user()['role_type'] == 1)
				  								<a id="delete" onClick="confirmDelete('{{ $getAllDeliveryReceipt->id}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
              						@endif
				  								<a href="{{ url('lolo-pinoy-lechon-de-cebu/view-delivery-receipt/'.$getAllDeliveryReceipt->id)}}" title="View"><i class="fas fa-low-vision"></i></a>
                          @if(Auth::user()['role_type'] == 1)
                            @if($getAllDeliveryReceipt->duplicate_status != 1) 
                            <a href="{{ url('lolo-pinoy-lechon-de-cebu/duplicate-copy/'.$getAllDeliveryReceipt->id) }}" title="Duplicate Copy"><i class="fas fa-clone"></i></a>
                            @endif
                          @endif
			  									</td>
                          <td>{{ $getAllDeliveryReceipt->date}}</td>
			  									<td>{{ $getAllDeliveryReceipt->module_code}}{{ $getAllDeliveryReceipt->lechon_de_cebu_code}}</td>
			  									<td><p style="width: 170px;">{{ $getAllDeliveryReceipt->sold_to}}</p></td>
			  									<td><p style="width: 110px;">{{ $getAllDeliveryReceipt->time}}</p></td>
                          <td><p style="width: 140px;">{{ $getAllDeliveryReceipt->date_to_be_delivered}}</p></td>
			  									<td><p style="width: 200px;">{{ $getAllDeliveryReceipt->delivered_to}}</p></td>
			  									<td>{{ $getAllDeliveryReceipt->qty}}</td>
			  									<td><p style="width: 200px;">{{ $getAllDeliveryReceipt->description}}</p></td>
			  									<td><?php echo number_format($getAllDeliveryReceipt->total);?></td>
			  									<td><p style="width: 120px;">{{ $getAllDeliveryReceipt->created_by}}</p></td>
			  									
			  								</tr>
			  								@endforeach
			  							</tbody>
	    					  			</table>

	    					  		</div>
	    					  	</div>
          				</div>
              		</div>
              </div>
               <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
                              <i class="fa fa-receipt" aria-hidden="true"></i>
                              Duplicate Lists</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                              <th>Action</th>
                                              <th>DR No</th>
                                              <th>Date</th>
                                              <th>Sold To</th>
                                              <th>Time</th>
                                              <th>Date To Be Delivered</th>
                                              <th>Delivered To</th>
                                              <th>Qty</th>
                                              <th>Description</th>
                                              <th>Price</th>
                                              <th>Created By</th>
                                            </thead>
                                          <tfoot>
                                            <th>Action</th>
                                            <th>DR No</th>
                                            <th>Date</th>
                                            <th>Sold To</th>
                                            <th>Time</th>
                                            <th>Date To Be Delivered</th>
                                            <th>Delivered To</th>
                                            <th>Qty</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Created By</th>

                                          </tfoot>
                                          <tbody>
                                              @foreach($getDuplicateCopies as $getDuplicateCopy)
                                              <tr>
                                                  <td>
                                                      <a href="{{ url('lolo-pinoy-lechon-de-cebu/view-delivery-duplicate/'.$getDuplicateCopy['id'])}}" title="View"><i class="fas fa-low-vision"></i></a>
                                                  </td>
                                                  <td>{{ $getDuplicateCopy['dr_no']}}</td>
                                                  <td>{{ $getDuplicateCopy['date']}}</td>
                                                  <td>{{ $getDuplicateCopy['sold_to']}}</td>
                                                  <td>{{ $getDuplicateCopy['time']}}</td>
                                                  <td></td>
                                                  <td>{{ $getDuplicateCopy['delivered_to']}}</td>
                                                  <td>{{ $getDuplicateCopy['qty']}}</td>
                                                  <td>{{ $getDuplicateCopy['description']}}</td>
                                                  <td><?php echo number_format($getDuplicateCopy['price'], 2); ?></td>
                                                  <td>{{ $getDuplicateCopy['created_by']}}</td>
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
              url: '/lolo-pinoy-lechon-de-cebu/delete/dr/' + id,
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