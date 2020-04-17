@extends('layouts.ribos-bar-app')
@section('title', 'Cashiers Report Inventory List | ')
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
                <li class="breadcrumb-item active">Cashier's Report Inventory List</li>
            </ol>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
	    					  <i class="fa fa-tasks" aria-hidden="true"></i>
	    					  Inventory List
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <th>Action</th>
                                        <th>Date</th>
                                        <th width="180px;">Cashier Name</th>
                                        <th width="130px;">Bar Tender</th>
                                        <th width="150px;">Shift Schedule</th>
                                        <th width="140px;">Cash Sales</th>
                                        <th width="200px;">Credit Card Sales</th>
                                        <th width="300px;">Signing Privilage Sales</th>
                                        <th width="200px;">Total Reading</th>
                                        <th width="200px;">Created By</th>   
                                    </thead>
                                    <tfoot>
                                        <th>Action</th>
                                        <th>Date</th>
                                        <th width="180px;">Cashier Name</th>
                                        <th width="130px;">Bar Tender</th>
                                        <th width="150px;">Shift Schedule</th>
                                        <th width="140px;">Cash Sales</th>
                                        <th width="200px;">Credit Card Sales</th>
                                        <th width="300px;">Signing Privilage Sales</th>
                                        <th width="200px;">Total Reading</th>
                                        <th width="200px;">Created By</th> 
                                    </tfoot>
                                    <tbody>
                                        @foreach($getAllCashiersReports as $getAllCashiersReport)
                                        <tr id="deletedId{{ $getAllCashiersReport['id'] }}">
                                            <td>
                                            @if($user->role_type !== 3)
                                                <a href="{{ url('ribos-bar/edit-cashiers-report-inventory-list/'.$getAllCashiersReport['id'] ) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                            @endif
                                            @if($user->role_type == 1)
                                                <a id="delete" onClick="confirmDelete('{{ $getAllCashiersReport['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                                            @endif
                                                <a href="{{ url('ribos-bar/cashiers-report/view-inventory-list/'.$getAllCashiersReport['id'])}}" title="View"><i class="fas fa-low-vision"></i></a>
						                         
                                            </td>
                                            <td>{{ $getAllCashiersReport['date']}}</td>
                                            <td>{{ $getAllCashiersReport['cashier_name']}}</td>
                                            <td>{{ $getAllCashiersReport['bar_tender_name']}}</td>
                                            <td>{{ $getAllCashiersReport['shifting_schedule']}}</td>
                                            <td>{{ $getAllCashiersReport['cash_sales']}}</td>
                                            <td>{{ $getAllCashiersReport['credit_card_sales']}}</td>
                                            <td>{{ $getAllCashiersReport['signing_privilage_sales']}}</td>
                                            <td>{{ $getAllCashiersReport['total_reading']}}</td>
                                            <td>{{ $getAllCashiersReport['created_by']}}</td>
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
</div>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript">
   function confirmDelete(id){
      const x = confirm("Do you want to delete this?");
        if(x){
            $.ajax({
              type: "DELETE",
              url: '/ribos-bar/cashiers-report-form/delete-item/' + id,
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