@extends('layouts.mr-potato-app')
@section('title', 'Petty Cash List |')
@section('content')
<div id="wrapper">
    @include('sidebar.sidebar-mr-potato')
    <div id="content-wrapper">
         <div class="container-fluid">
                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="#">Mr Potato</a>
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