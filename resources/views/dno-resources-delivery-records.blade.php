@extends('layouts.dno-resources-development-corp-app')
@section('title', 'Delivery Transaction Records |')
@section('content')
<div id="wrapper">
    <!-- Sidebar -->

	 @include('sidebar.sidebar-dno-resources-development-corp')
     <div id="content-wrapper">
        <div class="container-fluid">
             <!-- Breadcrumbs-->
             <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">DNO Resources and Development Corp</a>
              </li>
              <li class="breadcrumb-item active">Delivery Transaction Records</li>
            </ol>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                    	<div class="card-header">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            All Lists
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                     <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>Delivery Date</th>
                                            <th>Supplier Name</th>
                                            <th>DR NO</th>
                                            <th>Created by</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>Action</th>
                                            <th>Delivery Date</th>
                                            <th>Supplier Name</th>
                                            <th>DR NO</th>
                                            <th>Created by</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach($deliveryTransactions as $deliveryTransaction)
                                            <tr id="deletedId{{ $deliveryTransaction['id']}}">
                                                <td>
                                                    @if(Auth::user()['role_type'] != 3)
                                                    <a href="{{ url('dno-resources-development/edit-delivery-transaction/'.$deliveryTransaction['id']) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                    @if(Auth::user()['role_type'] == 1)
                                                    <a id="delete" onClick="confirmDelete('{{ $deliveryTransaction['id'] }}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                                                    @endif
                                                    <a href="{{ url('dno-resources-development/view-dno-resources-delivery-transaction/'.$deliveryTransaction['id']) }}" title="View"><i class="fas fa-low-vision"></i></a>
                                                </td>
                                                </td>
                                                <td>{{ $deliveryTransaction['delivery_date']}}</td>
                                                <td>{{ $deliveryTransaction['supplier_name']}}</td>
                                                <td>{{ $deliveryTransaction['dr_no']}}</td>
                                                <td>{{ $deliveryTransaction['created_by']}}</td>
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
        const x = confirm("Do you want to delete this?");
          if(x){
              $.ajax({
                type: "DELETE",
                url: '/dno-resources-development/delivery-transaction/delete/' + id,
                data:{
                  _method: 'delete', 
                  "_token": "{{ csrf_token() }}",
                  "id": id
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