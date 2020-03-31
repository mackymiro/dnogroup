@extends('layouts.lolo-pinoy-grill-branches-app')
@section('title', 'Transaction List |')
@section('content')
<div id="wrapper">
  <!-- Sidebar -->

   @include('sidebar.sidebar-lolo-pinoy-grill-branches')
     <div id="content-wrapper">
      <div class="container-fluid">
         <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lolo Pinoy Grill Branches</a>
              </li>
              <li class="breadcrumb-item active">Transaction List</li>
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
                        <th>RS #</th>
                        <th>Requesting Department</th>
                        <th>Request Date</th>
                        <th>Date Released</th>
                        <th>Created by</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>RS #</th>
                        <th>Requesting Department</th>
                        <th>Request Date</th>
                        <th>Date Released</th>
                        <th>Created by</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      @foreach($requisitionLists as $requisitionList)
                      <tr>
                       
                        <td><a href="#">R.S-{{ $requisitionList['rs_number'] }}</a></td>
                        <td>{{ $requisitionList['requesting_department'] }}</td>
                        <td>{{ $requisitionList['request_date'] }}</td>
                        <td>{{ $requisitionList['date_released'] }}</td>
                        <td>{{ $requisitionList['created_by']}}</td>
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