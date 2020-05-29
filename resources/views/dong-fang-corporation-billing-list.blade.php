@extends('layouts.dong-fang-corporation-app')
@section('title', 'Billing Statement List |')
@section('content')
<div id="wrapper">
      @include('sidebar.sidebar-dong-fang-corporation')
      <div id="content-wrapper">
            <div class="container-fluid">
                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="#">Dong Fang Corporation</a>
                    </li>
                    <li class="breadcrumb-item active">Billing List</li>
                   
                </ol>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <i class="fas fa-receipt"></i>
	    					  Billing Lists
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                     <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                         <thead>
					  						<tr>
				  								<th width="10%">Action</th>
				  								<th>Date </th>
                                                <th>Account No</th>
				  								<th>Company Name</th>
											
												<th>Created By</th>
					  						</tr>
				  						</thead>
                                        <tfoot>
					  						<tr>
				  								<th width="10%">Action</th>
				  								<th>Date </th>
                                                <th>Account No</th>
				  								<th>Company Name</th>
											
												<th>Created By</th>
					  						</tr>
				  						</tfoot>
                                        <tbody>
                                            @foreach($billingLists as $billingList)
                                            <tr>
                                                <td>
                                                @if(Auth::user()['role_type'] != 3)
                                                    <a href="{{ url('dong-fang-corporation/edit-billing-statment/'.$billingList['id']) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                @if(Auth::user()['role_type'] == 1 || Auth::user()['role_type'] == 2        )
                                                    <a id="delete" onClick="confirmDelete('{{ $billingList['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                                                @endif
                                                </td>
                                                <td>{{ $billingList['date']}}</td>
                                                <td><a href="{{ url('dong-fang-corporation/view-billing-statement/'.$billingList['id']) }}">{{ $billingList['account_no']}}</a></td>
                                                <td>{{ $billingList['company_name']}}</td>
                                                <td>{{ $billingList['created_by']}}</td>
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
@endsection