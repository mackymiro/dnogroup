@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Statement Of Account Lists |')
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
                <li class="breadcrumb-item active">Statement Of Account All Lists</li>
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
      			  							<th>Action</th>
      			  							<th>Date</th>
                            <th>SOA No</th>
      			  							<th>Invoice#</th>
                            <th>Bill To</th>
      			  							<th>Branch</th>
                            <th  class="bg-info" style="color:white;">Period Covered</th>
      			  							<th>Created By</th>
      				  					</thead>
      				  					<tfoot>
      			  							<th>Action</th>
                            <th>Date</th>
                            <th>SOA No</th>
                            <th>Invoice#</th>
                            <th>Bill To</th>
                            <th>Branch</th>
                            
                            <th  class="bg-info" style="color:white;">Period Covered</th>
                            <th>Created By</th>
      				  					</tfoot>
      				  					<tbody>
                            @foreach($statementOfAccounts as $statementOfAccount)
      				  						<tr id="deletedId{{ $statementOfAccount->id}}">
                              <td>
                                 @if(Auth::user()['role_type'] !== 3)
                                  <a href="{{ url('lolo-pinoy-lechon-de-cebu/edit-statement-of-account/'.$statementOfAccount->id ) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                  @endif
                                
                                  <a href="{{ url('lolo-pinoy-lechon-de-cebu/view-statement-account/'.$statementOfAccount->id) }}" title="View"><i class="fas fa-low-vision"></i></a>

                              </td>
                              <td>{{ $statementOfAccount->date }}</td>
                              <td>SOA-{{ $statementOfAccount->lechon_de_cebu_code}}</td>
                              <td>{{ $statementOfAccount->invoice_number}}</td>
                              <td>{{ $statementOfAccount->bill_to}}</td>
                              <td>{{ $statementOfAccount->branch}}</td>
                             
                              <td class="bg-info" style="color:white;">{{ $statementOfAccount->period_cover}}</td>
                              <td>{{ $statementOfAccount->created_by}}</td>
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