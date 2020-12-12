@extends('layouts.wimpys-food-express-app')
@section('title', 'Order Form Lists |')
@section('content')
<div id="wrapper">
	<!-- Sidebar -->

	 @include('sidebar.sidebar-wimpys-food-express')
     <div id="content-wrapper">
     	<div class="container-fluid">
     		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Wimpy's Food Express    </a>
              </li>
              <li class="breadcrumb-item active">Order Form Lists</li>
            </ol>
            <div class="row">
            	<div class="col-lg-12">
            		<div class="card mb-3">
            			<div class="card-header">
        					  <i class="fa fa-tasks" aria-hidden="true"></i>
        					  All Lists</div>
					  <div class="card-body">
					  		<div class="table-responsive">
				  				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				  					<thead>
				  						<tr>
				  							<th>Action</th>
			  								<th>Date</th>
			  								<th>Time</th>
                                            <th>No of people</th>
                                            <th class="bg-info" style="color:white">Order form #</th>
			  								<th>Created by</th>
				  						</tr>
				  					</thead>
				  					<tfoot>
				  						<tr>
				  							<th>Action</th>
			  								<th>Date</th>
			  								<th>Time</th>
                                            <th>No of people</th>
                                            <th class="bg-info" style="color:white">Order form #</th>
			  								<th>Created by</th>
				  						</tr>
				  					</tfoot>
				  					<tbody>
                      @foreach($orderForms as $orderForm)
                      <tr id="deletedId{{ $orderForm->id }}">
                          <td>
                          <a href="/wimpys-food-express/order-form/{{ $orderForm->id}}/transaction" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                            @if(Auth::user()['role_type'] == 1)
                              <a id="delete" onclick="confirmDelete('{{ $orderForm->id }}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                          @endif
                          <a href="/wimpys-food-express/{{ $orderForm->id}}/view/order-form" title="View"><i class="fas fa-low-vision"></i></a>

                          </td>
                          <td>{{ $orderForm->date }}</td>
                          <td>{{ $orderForm->time }}</td>
                          <td>{{ $orderForm->no_of_people }}</td>
                          <td class="bg-info" style="color:white">{{ $orderForm->module_code }}{{ $orderForm->wimpys_food_express_code}}</td>
                          <td>{{ $orderForm->created_by }}</td>
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

    const confirmDelete = (id) => {
        var x = confirm("Do you want to delete this?");
        if(x){
            $.ajax({
              type: "DELETE",
              url: '/wimpys-food-express/delete/order-form/' + id,
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