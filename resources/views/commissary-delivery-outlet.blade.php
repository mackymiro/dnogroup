@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Delivery Outlet |')
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
              <li class="breadcrumb-item ">Commissary</li>
              <li class="breadcrumb-item active">Delivery Outlets</li>
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
                                      <th>Date</th>
                                      <th>Reference </th>
                                      <th>Description</th>
                                      <th>Item</th>
                                      <th>Qty</th>
                                      <th>Unit</th>
                                      <th>Amount</th>
                                      <th>Status</th>
                                      <th>Requesting Branch</th>
                                      <th>Cheque No Issued</th>
                                    
                                     </thead>
                                     <tfoot>
                                        <th>Date</th>
                                        <th>Reference </th>

                                        <th>Description</th>
                                        <th>Item</th>
                                        <th>Qty</th>
                                        <th>Unit</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Requesting Branch</th>
                                        <th>Cheque No Issued</th>
                                     </tfoot>
                                     <tbody>
                                        @foreach($getDeliveryOutlets as $getDeliveryOutlet)
                                        <tr>
                                          <td>{{ $getDeliveryOutlet['date'] }}</td>
                                          <td>{{ $getDeliveryOutlet['reference_no']}}</td>
                                          @if($getDeliveryOutlet['description'] == "DELIVERY IN")
                                             <td class="bg-success" style="color:white;">{{ $getDeliveryOutlet['description']}}</td>
                                          @else
                                             <td class="bg-danger" style="color:white;">{{ $getDeliveryOutlet['description']}}</td>

                                          @endif
                                          <td>{{ $getDeliveryOutlet['item']}}</td>
                                          <td>{{ $getDeliveryOutlet['qty']}}</td>
                                          <td>{{ $getDeliveryOutlet['unit']}}</td>
                                          <td>{{ $getDeliveryOutlet['amount']}}</td>
                                          <td>{{ $getDeliveryOutlet['status']}}</td>
                                          <td>{{ $getDeliveryOutlet['requesting_branch']}}</td>
                                          <td>{{ $getDeliveryOutlet['cheque_no_issued']}}</td>
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