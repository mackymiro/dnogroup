@extends('layouts.ribos-bar-app')
@section('title', 'View Cashiers Report List|')
@section('content')
<div id="wrapper">
    <!-- Sidebar -->
    @include('sidebar.sidebar-ribos-bar')
    <div id="content-wrapper">
         <div class="container-fluid">
                <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                <a href="#">Ribo's Bar</a>
                </li>
                <li class="breadcrumb-item active">Cashier's Report</li>
                <li class="breadcrumb-item ">View List</li>
            </ol>
            <div class="col-lg-12">
            	   <img src="{{ asset('images/ribos.jpg')}}" width="390" height="250" class="img-responsive mx-auto d-block" alt="Rib's Bar">
                 
            	 
            	 <h4 class="text-center"><u>View Inventory Details List</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                         <div class="card-header">
                              <i class="fas fa-file-invoice" aria-hidden="true"></i>
                                Inventory List
                             <div class="float-right">
                               <a href="{{ url('ribos-bar/cashiers-report/printCashiersReport/'.$getViewCashierReport['id']) }}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                             </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">  
                                <div class="form-row">
                                    <div class="col-lg-6">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th >{{ $getViewCashierReport['date'] }}</th>
                                                </tr>
                                                <tr>
                                                    <th width="25%">Cashier's Name</th>
                                                    <th >{{ $getViewCashierReport['cashier_name'] }}</th>
                                                </tr>
                                                <tr>
                                                    <th width="15%">Bar Tender</th>
                                                    <th>{{ $getViewCashierReport['bar_tender_name']}}</th>
                                                </tr>
                                                <tr>
                                                    <th width="15%">Starting OS #</th>
                                                    <th>{{ $getViewCashierReport['starting_os']}}</th>
                                                </tr>
                                                <tr>
                                                    <th width="15%">Closing OS #</th>
                                                    <th>{{ $getViewCashierReport['closing_os']}}</th>
                                                </tr>

                                            </thead>
                                        </table>
                                    </div>
                                    <div class="col-lg-6">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="20%">Cash Sales</th>
                                                    <th>{{ $getViewCashierReport['cash_sales']}}</th>
                                                </tr>
                                                <tr>
                                                    <th width="30%">Credit Card Sales</th>
                                                    <th>{{ $getViewCashierReport['credit_card_sales']}}</th>
                                                </tr>
                                                <tr>
                                                    <th width="35%">Signing Privilage Sales</th>
                                                    <th>{{ $getViewCashierReport['signing_privilage_sales']}}</th>
                                                </tr>
                                                <tr>
                                                    <th width="30%">Total Reading</th>
                                                    <th><?php echo number_format($getViewCashierReport['total_reading'], 2); ?></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                </div>
                                <table class="table table-striped ">
                                 <thead>
                                    <tr>
                                        <th class="bg-info" style="color:#fff;">ITEMS</th>
                                        <th class="bg-info" style="color:#fff;">OPENING INVENTORY</th>
                                        <th class="bg-info" style="color:#fff;">SOLD</th>
                                        <th class="bg-info" style="color:#fff;">CLOSING</th>
                                        <th class="bg-info" style="color:#fff;">TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($getAllItems as $getAllItem)
                                    <tr>
                                        <td>{{ $getAllItem['items'] }}</td>
                                        <td>{{ $getAllItem['opening_inventory']}}</td>
                                        <td>{{ $getAllItem['sold']}}</td>
                                        <td>{{ $getAllItem['closing']}}</td>
                                        <td><?php echo number_format($getAllItem['total'], 2); ?></td>
                                    </tr>
                                    @endforeach
                                    <tr>
	                                        <td></td>
	                                        <td></td>
	                                        <td></td>
	                                        <td><strong>Total</strong></td>
	                                       
	                                        <td>₱ <?php echo number_format($total, 2)?></td>
                                      	</tr>
                                </tbody>
                            </table>
                            <br>
                            <br>
                            <table class="table table-striped ">
                                    <thead>
                                        <tr>
                                            <th width="15%">Prepared By</th>
                                            <th>{{ $getViewCashierReport['created_by']}}</th>
                                        </tr>
                                    </thead>
                                  
                              </table>
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