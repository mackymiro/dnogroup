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
                                              <th>Invoice #</th>
                                              <th>SI NO</th>
                                              <th>Date</th>
                                              <th>Ordered By</th>
                                              <th>Address</th>
                                              <th>QTY</th>
                                              <th>Total KlS</th>
                                              <th>Item Description</th>
                                              <th>Unit Price</th>
                                              <th>Amount</th>
                                              <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                              <th>Action</th>
                                              <th>Invoice #</th>
                                              <th>SI NO</th>
                                              <th>Date</th>
                                              <th>Ordered By</th>
                                              <th>Address</th>
                                              <th>QTY</th>
                                              <th>Total KlS</th>
                                              <th>Item Description</th>
                                              <th>Unit Price</th>
                                              <th>Amount</th>
                                              <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach($statementOfAccountT1s as $statementOfAccountT1) 
                                            <tr>
                                                <td>
                                                   <a href="{{ url('lolo-pinoy-lechon-de-cebu/view-statement-account/'.$statementOfAccountT1->id) }}" title="View"><i class="fas fa-low-vision"></i></a>
                                                </td>
                                                <td><p style="width:150px;">{{ $statementOfAccountT1->invoice_number}}</p></td>
                                                <td><p style="width:130px;">{{ $statementOfAccountT1->module_code}}{{ $statementOfAccountT1->lechon_de_cebu_code}}</p></td>
                                                <td>{{ $statementOfAccountT1->date}}</td>
                                                <td><p style="width:230px;">{{ $statementOfAccountT1->ordered_by }}</p></td>
                                                <td><p style="width:300px;">{{ $statementOfAccountT1->address}}</p></td>
                                                <td>{{ $statementOfAccountT1->qty}}</td>
                                                <td><?php echo number_format($statementOfAccountT1->total_kls, 2); ?></td>
                                                <td><p style="width:190px;">{{ $statementOfAccountT1->item_description}}</p></td>
                                                <td><?php echo number_format($statementOfAccountT1->unit_price, 2);?></td>
                                                <td class="bg-danger" style="color:#fff;"><?php echo number_format($statementOfAccountT1->amount, 2); ?></td>
                                                <td><p style="width:130px;">{{ $statementOfAccountT1->created_by}}</p></td>
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
                                              <th>Invoice #</th>
                                              <th>SI NO</th>
                                              <th>Date</th>
                                              <th>Ordered By</th>
                                              <th>Address</th>
                                              <th>QTY</th>
                                              <th>Total KlS</th>
                                              <th>Item Description</th>
                                              <th>Unit Price</th>
                                              <th class="bg-danger" style="color:#fff;">Amount</th>
                                              <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                             <tr>
                                              <th>Action</th>
                                              <th>Invoice #</th>
                                              <th>SI NO</th>
                                              <th>Date</th>
                                              <th>Ordered By</th>
                                              <th>Address</th>
                                              <th>QTY</th>
                                              <th>Total KlS</th>
                                              <th>Item Description</th>
                                              <th>Unit Price</th>
                                              <th class="bg-danger" style="color:#fff;">Amount</th>
                                              <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach($statementOfAccountT2s as $statementOfAccountT2) 
                                            <tr>
                                                <td>
                                                   <a href="" title="View"><i class="fas fa-low-vision"></i></a>
                                                </td>
                                                <td><p style="width:150px;">{{ $statementOfAccountT2->invoice_number}}</p></td>
                                                <td><p style="width:130px;">{{ $statementOfAccountT2->module_code}}{{ $statementOfAccountT2->lechon_de_cebu_code}}</p></td>
                                                <td>{{ $statementOfAccountT2->date}}</td>
                                                <td><p style="width:230px;">{{ $statementOfAccountT2->ordered_by }}</p></td>
                                                <td><p style="width:300px;">{{ $statementOfAccountT2->address}}</p></td>
                                                <td>{{ $statementOfAccountT2->qty}}</td>
                                                <td><?php echo number_format($statementOfAccountT2->total_kls, 2); ?></td>
                                                <td><p style="width:190px;">{{ $statementOfAccountT2->item_description}}</p></td>
                                                <td><?php echo number_format($statementOfAccountT2->unit_price, 2);?></td>
                                                <td class="bg-danger" style="color:#fff;"><?php echo number_format($statementOfAccountT2->amount, 2); ?></td>
                                                <td><p style="width:130px;">{{ $statementOfAccountT2->created_by}}</p></td>
                                           
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