@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Sales |')
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
              <li class="breadcrumb-item ">Sales Invoice</li>
              <li class="breadcrumb-item active">View Sales Per Outlet</li>
            </ol>
           
             <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                          <div class="card-header">
                            <i class="fa fa-cash-register" aria-hidden="true"></i>
                            SSP FOOD AVENUE TERMINAL 1</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                              <th>Action</th>
                                              <th>Date</th>
                                              <th>Bill To</th>
                                              <th>Reference #</th>
                                              <th>Invoice #</th>
                                              <th>Period Covered</th>
                                              <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                              <th>Action</th>
                                              <th>Date</th>
                                              <th>Bill To</th>
                                              <th>Reference #</th>
                                              <th>Invoice #</th>
                                              <th>Period Covered</th>
                                              <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach($statementOfAccountT1s as $statementOfAccountT1) 
                                            <tr>
                                                <td>
                                                   <a href="{{ url('lolo-pinoy-lechon-de-cebu/view-statement-account/'.$statementOfAccountT1['id']) }}" title="View"><i class="fas fa-low-vision"></i></a>
                                                </td>
                                                <td>{{ $statementOfAccountT1['transaction_date']}}</td>
                                                <td>{{ $statementOfAccountT1['bill_to']}}</td>
                                                <td>{{ $statementOfAccountT1['reference_number']}}</td>
                                                <td>{{ $statementOfAccountT1['invoice_number']}}</td>
                                                <td>{{ $statementOfAccountT1['period_cover']}}</td>
                                                <td>{{ $statementOfAccountT1['created_by']}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <br>
                                    <table class="table ">
                                        <thead>
                                            <tr>
                                              <th class="bg-info" style="color:white;" width="10%">Total Sales </th>
                                               <th class="bg-success" style="color:white;">
                                                  ₱ <?php echo number_format($totalSalesInTerminal1, 2);?>
                                               </th>
                                            </tr>
                                           
                                          </thead>
                                    </table>
                                </div>
                            </div>
                    </div>
                </div>
            </div>

             <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                          <div class="card-header">
                            <i class="fa fa-cash-register" aria-hidden="true"></i>
                            SSP FOOD AVENUE TERMINAL 2</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                              <th>Action</th>
                                              <th>Date</th>
                                              <th>Bill To</th>
                                              <th>Reference #</th>
                                              <th>Invoice #</th>
                                              <th>Period Covered</th>
                                              <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                              <th>Action</th>
                                              <th>Date</th>
                                              <th>Bill To</th>
                                              <th>Reference #</th>
                                              <th>Invoice #</th>
                                              <th>Period Covered</th>
                                              <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach($statementOfAccountT2s as $statementOfAccountT2) 
                                            <tr>
                                                <td>
                                                   <a href="" title="View"><i class="fas fa-low-vision"></i></a>
                                                </td>
                                                <td>{{ $statementOfAccountT2['transaction_date']}}</td>
                                                <td>{{ $statementOfAccountT2['bill_to']}}</td>
                                                <td>{{ $statementOfAccountT2['reference_number']}}</td>
                                                <td>{{ $statementOfAccountT2['invoice_number']}}</td>
                                                <td>{{ $statementOfAccountT2['period_cover']}}</td>
                                                <td>{{ $statementOfAccountT2['created_by']}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <br>
                                      <table class="table ">
                                        <thead>
                                            <tr>
                                              <th class="bg-info" style="color:white;" width="10%">Total Sales </th>
                                               <th class="bg-success" style="color:white;">
                                                  ₱ <?php echo number_format($totalSalesInTerminal2, 2);?>
                                               </th>
                                            </tr>
                                           
                                          </thead>
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

    <!-- /.content-wrapper -->
</div>

@endsection