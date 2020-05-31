@extends('layouts.dno-personal-app')
@section('title', 'Receivables List |')
@section('content')
<div id="wrapper">
     @include('sidebar.sidebar-dno-personal')
     <div id="content-wrapper">
         <div class="container-fluid">
             <!-- Breadcrumbs-->
             <ol class="breadcrumb">
                <li class="breadcrumb-item">
                <a href="#">DNO Personal</a>
                </li>
                <li class="breadcrumb-item active">Recievables</li>
                <li class="breadcrumb-item "> List</li>
            </ol>
            <div class="row">
                 <div class="col-lg-12">
                     <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-stamp"></i>
	    					  Receivables List
                        </div>
                        <div class="card-body">
                             <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="10%">Action</th>
                                            <th>Name of Tenant </th>
                                            <th>Contract Date</th>
                                            <th>Unit No</th>
                                        
                                            <th>Created By</th>
                                        </tr>
				  					</thead>
                                    <tfoot>
                                        <tr>
                                            <th width="10%">Action</th>
                                            <th>Name of Tenant </th>
                                            <th>Contract Date</th>
                                            <th>Unit No</th>
                                        
                                            <th>Created By</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($receivableLists as $receivableList)
                                        <tr>
                                            <td>
                                                @if(Auth::user()['role_type'] != 3)
                                                    <a href="{{ url('dno-personal/receivables/edit/'.$receivableList['id']) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                @if(Auth::user()['role_type'] == 1 || Auth::user()['role_type'] == 2        )
                                                    <a id="delete" onClick="confirmDelete('{{ $receivableList['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                                                @endif
                                                @if(Auth::user()['role_type'] == 1 || Auth::user()['role_type'] == 2        )
                                                    <a href="{{ url('dno-personal-controller/receivables/payments/'.$receivableList['id']) }}" ><i class="fas fa-file-invoice-dollar"></i></a>
                                                @endif
                                            </td>
                                            <td><a href="{{ url('dno-personal/receivables/view/'.$receivableList['id']) }}">{{ $receivableList['name_of_tenant'] }}</a></td>
                                            <td>{{ $receivableList['contract_date']}}</td>
                                            <td>{{ $receivableList['unit_no']}}</td>
                                            <td>{{ $receivableList['created_by']}}</td>
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