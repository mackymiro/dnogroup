@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Sales Of Outlets |')
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
              <li class="breadcrumb-item active">Sales Of Outlets</li>
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
                                        @foreach($getSalesOfOutlets as $getSalesOfOutlet)
                                        <tr>
                                            <td>{{ $getSalesOfOutlet['date'] }}</td>
                                            <td>{{ $getSalesOfOutlet['reference_no'] }}</td>
                                             @if($getSalesOfOutlet['description'] == "DELIVERY IN")
                                                <td class="bg-success" style="color:white;">{{ $getSalesOfOutlet['description']}}</td>
                                            @else
                                               <td class="bg-danger" style="color:white;">{{ $getSalesOfOutlet['description']}}</td>

                                            @endif
                                            <td>{{ $getSalesOfOutlet['item'] }}</td>
                                            <td>{{ $getSalesOfOutlet['qty'] }}</td>
                                            <td>{{ $getSalesOfOutlet['unit'] }}</td>
                                            <td>{{ $getSalesOfOutlet['amount'] }}</td>
                                             @if($getSalesOfOutlet['status'] == "Paid")
                                                <td class="bg-success" style="color:white;">{{ $getSalesOfOutlet['status']}}</td>
                                            @else
                                               <td class="bg-danger" style="color:white;">{{ $getSalesOfOutlet['status']}}</td>

                                            @endif
                                            <td>{{ $getSalesOfOutlet['requesting_branch'] }}</td>
                                            <td>{{ $getSalesOfOutlet['cheque_no_issued'] }}</td>
                                        </tr>
                                        @endforeach
                                     </tbody>
                                </table>
                                <br>
                                <br>
                                 <table class="table table-bordered">
                                    <thead>
                                       <tr>
                                        <th colspan="10" class="bg-info" style="color:white;">TOTAL SALES</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="15%" class="bg-success" style="color:white; ">DELIVERY IN</td>
                                            <td><strong>₱ <?php echo number_format($totalDeliveryIn, 2);?></strong></td>
                                        </tr>
                                        <tr>
                                            <td class="bg-danger" style="color:white; ">DELIVERY OUT</td>
                                            <td><strong>₱ <?php echo number_format($totalDeliveryOut, 2); ?></strong></td>
                                        </tr>
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