@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'Petty Cash List |')
@section('content')
<div id="wrapper">
     @include('sidebar.sidebar-lolo-pinoy-grill')
     <div id="content-wrapper">
         <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">Lolo Pinoy Grill Commissary</a>
                </li>
                <li class="breadcrumb-item active">Petty Cash</li>
                <li class="breadcrumb-item ">Petty Cash List</li>
            </ol>
            <div class="row">
                <div class="col-lg-12">
                     <div class="card mb-3">
                        <div class="card-header">
                                <i class="fas fa-money-bill-alt"></i>
                            Petty Cash List
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                 <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
					  						<tr>
				  								<th>Date </th>
				  								<th>Paid To</th>			
												<th>Created By</th>
					  						</tr>
				  						</thead>
                                        <tfoot>
					  						<tr>
				  								<th>Date </th>
				  								<th>Paid To</th>											
												<th>Created By</th>
					  						</tr>
				  						</tfoot>
                                        <tbody>
                                            @foreach($getPettyCashLists as $getPettyCashList)
                                            <tr>
                                               
                                                <td>{{ $getPettyCashList['issued_date']}}</td>
                                                <td><a href="{{ url('/lolo-pinoy-grill-commissary/petty-cash/view/'.$getPettyCashList['id']) }}">{{ $getPettyCashList['paid_to']}}</a></td>
                                                <td>{{  $getPettyCashList['created_by'] }}</td>
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