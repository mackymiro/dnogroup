@extends('layouts.lolo-pinoy-grill-branches-app')
@section('title', 'Stock Status |')
@section('content')
<script>
  $(document).ready(function(){
    $('table.display').DataTable( {} );
  });
</script>
<div id="wrapper">
    @include('sidebar.sidebar-lolo-pinoy-grill-branches')
    <div id="content-wrapper">
        <div class="container-fluid">
             <!-- Breadcrumbs-->
             <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">Lolo Pinoy Grill Branches</a>
                </li>
                <li class="breadcrumb-item active">Store Stock</li>
                @if(!empty($data))
                  <li class="breadcrumb-item active">
                    {{ $data }}
                  </li>
                @endif
                <li class="breadcrumb-item ">Stock Status</li>
              </ol>
              <div class="col-lg-12">
            	  <img src="{{ asset('images/digitized-logos/lolo-pinoy-grill.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lolo Pinoy Grill ">
            	  <h4 class="text-center"><u>STOCK STATUS </u></h4>
              </div>
              <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-tasks"></i>
                            Stock Status {{ $data }} -Branch 
                        </div>
                        <div class="card-body">
                            @if($data)
                            <div class="table-responsive">
                                <table class="table table-bordered display" width="100%" cellspacing="0">
                                     <thead>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Qty</th>
                                          <th class="bg-danger" style="color:white;">REMAINING</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </thead>
                                      <tfoot>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Qty</th>
                                          <th class="bg-danger" style="color:white;">REMAINING</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </tfoot>
                                      <tbody>
                                          @foreach($getStockStatuses as $getStockStatus)
                                          <tr>
                                            <td>{{ $getStockStatus->product_id_no }}</td>
                                            <td>{{ $getStockStatus->dr_no }}</td>
                                            <td>{{ $getStockStatus->supplier }}</td>
                                            <td>{{ $getStockStatus->product_name }}</td>
                                            <td>{{ $getStockStatus->qty }}</td>
                                            <td class="bg-danger" style="color:white;">{{ $getStockStatus->product_in }}</td>
                                            <td>{{ $getStockStatus->unit }}</td>
                                            <td><?php echo number_format($getStockStatus->amount, 2)?></td>
                                            <td>{{ $getStockStatus->created_by }}</td>
                                          </tr>
                                          @endforeach
                                      </tbody>
                                </table>
                               
                            </div>
                         
                          
                            @else
                                <h1> Login To Branch To View Transactions </h1>
                            @endif
                        </div>
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                     <div class="card mb-3">
                         <div class="card-header">
                            <i class="fas fa-tasks"></i>
                            Beverage Stock Status {{ $data }} -Branch 
                        </div>
                        <div class="card-body">
                        @if($data)
                            <div class="table-responsive">
                                <table class="table table-bordered display" width="100%" cellspacing="0">
                                     <thead>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Qty</th>
                                          <th class="bg-danger" style="color:white;">REMAINING</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </thead>
                                      <tfoot>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Qty</th>
                                          <th class="bg-danger" style="color:white;">REMAINING</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </tfoot>
                                      <tbody>
                                          @foreach($getStockStatusDrinks as $getStockStatusDrink)
                                          <tr>
                                            <td>{{ $getStockStatusDrink->product_id_no }}</td>
                                            <td>{{ $getStockStatusDrink->dr_no }}</td>
                                            <td>{{ $getStockStatusDrink->supplier }}</td>
                                            <td>{{ $getStockStatusDrink->product_name }}</td>
                                            <td>{{ $getStockStatusDrink->qty }}</td>
                                            <td class="bg-danger" style="color:white;">{{ $getStockStatusDrink->product_in }}</td>
                                            <td>{{ $getStockStatusDrink->unit }}</td>
                                            <td><?php echo number_format($getStockStatusDrink->amount, 2)?></td>
                                            <td>{{ $getStockStatusDrink->created_by }}</td>
                                          </tr>
                                          @endforeach
                                      </tbody>
                                </table>
                               
                            </div>
                         

                          @endif
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