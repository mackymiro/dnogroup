@extends('layouts.lolo-pinoy-grill-branches-app')
@section('title', 'Stock Inventory |')
@section('content')
<script>
    $(function(){
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
                <li class="breadcrumb-item ">Store Stock</li>
                @if(!empty($data))
                  <li class="breadcrumb-item active">
                    {{ $data }}
                  </li>
                @endif
                <li class="breadcrumb-item active">Stock Inventory</li>
              </ol>
              <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
          					          <i class="fa fa-tasks" aria-hidden="true"></i>
          					           Stock Inventory {{ $data }} -Branch 
                            </div>
                            <div class="card-body">
                                @if($data == "Urgello")
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                      <thead>
                                          
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Price</th>
                                          <th>Qty</th>
                                          <th class="bg bg-success" style="color:white;">IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </thead>
                                      <tfoot>
                                         
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Price</th>
                                          <th>Qty</th>
                                          <th  class="bg bg-success" style="color:white;">IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </tfoot>
                                      <tbody>
                                         @foreach($getStockStatusUrgellos as $getStockStatusUrgello)
                                          <tr>
                                            
                                            <td>{{ $getStockStatusUrgello->product_id_no }}</td>
                                            <td>{{ $getStockStatusUrgello->dr_no }}</td>
                                            <td>{{ $getStockStatusUrgello->supplier }}</td>
                                            <td>{{ $getStockStatusUrgello->product_name }}</td>
                                            <td>₱ <?php echo number_format($getStockStatusUrgello->price, 2)?></td>
                                            <td>{{ $getStockStatusUrgello->qty }}</td>
                                            <td  class="bg bg-success" style="color:white;">{{ $getStockStatusUrgello->product_in }}</td>
                                            <td>{{ $getStockStatusUrgello->unit }}</td>
                                            <td><?php echo number_format($getStockStatusUrgello->amount, 2)?></td>
                                            <td>{{ $getStockStatusUrgello->created_by }}</td>
                                          </tr>
                                          @endforeach 
                                      </tbody>
                                    </table>
                                </div>  
                                
                                @elseif($data == "Velez")
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                      <thead>
                                          
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Qty</th>
                                          <th>IN</th>
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
                                          <th>IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </tfoot>
                                      <tbody>
                                         @foreach($getStockStatusVelezes as $getStockStatusVelez)
                                          <tr>
                                           
                                            <td>{{ $getStockStatusVelez->product_id_no }}</td>
                                            <td>{{ $getStockStatusVelez->dr_no }}</td>
                                            <td>{{ $getStockStatusVelez->supplier }}</td>
                                            <td>{{ $getStockStatusVelez->product_name }}</td>
                                            <td>₱ <?php echo number_format($getStockStatusVelez->price, 2)?></td>
                                            <td>{{ $getStockStatusVelez->qty }}</td>
                                            <td>{{ $getStockStatusVelez->product_in }}</td>
                                            <td>{{ $getStockStatusVelez->unit }}</td>
                                            <td><?php echo number_format($getStockStatusVelez->amount, 2)?></td>
                                            <td>{{ $getStockStatusVelez->created_by }}</td>
                                          </tr>
                                          @endforeach 
                                      </tbody>
                                    </table>
                                </div> 
                                @elseif($data == "Banilad")
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                      <thead>
                                         
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Qty</th>
                                          <th>IN</th>
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
                                          <th>IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </tfoot>
                                      <tbody>
                                         @foreach($getStockStatusBanilads as $getStockStatusBanilad)
                                          <tr>
                                           
                                            <td>{{ $getStockStatusBanilad->product_id_no }}</td>
                                            <td>{{ $getStockStatusBanilad->dr_no }}</td>
                                            <td>{{ $getStockStatusBanilad->supplier }}</td>
                                            <td>{{ $getStockStatusBanilad->product_name }}</td>
                                            <td>₱ <?php echo number_format($getStockStatusBanilad->price, 2)?></td>
                                            <td>{{ $getStockStatusBanilad->qty }}</td>
                                            <td>{{ $getStockStatusBanilad->product_in }}</td>
                                            <td>{{ $getStockStatusBanilad->unit }}</td>
                                            <td><?php echo number_format($getStockStatusBanilad->amount, 2)?></td>
                                            <td>{{ $getStockStatusBanilad->created_by }}</td>
                                          </tr>
                                          @endforeach 
                                      </tbody>
                                    </table>
                                </div>
                                @elseif($data == "GQS")
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                      <thead>
                                          
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Qty</th>
                                          <th>IN</th>
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
                                          <th>IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </tfoot>
                                      <tbody>
                                         @foreach($getStockStatusGqses as $getStockStatusGqs)
                                          <tr>
                                    
                                            <td>{{ $getStockStatusGqs->product_id_no }}</td>
                                            <td>{{ $getStockStatusGqs->dr_no }}</td>
                                            <td>{{ $getStockStatusGqs->supplier }}</td>
                                            <td>{{ $getStockStatusGqs->product_name }}</td>
                                            <td>₱ <?php echo number_format($getStockStatusGqs->price, 2)?></td>
                                            <td>{{ $getStockStatusGqs->qty }}</td>
                                            <td>{{ $getStockStatusGqs->product_in }}</td>
                                            <td>{{ $getStockStatusGqs->unit }}</td>
                                            <td><?php echo number_format($getStockStatusGqs->amount, 2)?></td>
                                            <td>{{ $getStockStatusGqs->created_by }}</td>
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
          					          <i class="fa fa-tasks" aria-hidden="true"></i>
          					           Beverages Stock Inventory {{ $data }} -Branch 
                            </div>
                            <div class="card-body">
                               @if($data == "Urgello")
                                  <div class="table-responsive">
                                       <table class="table table-bordered display"  width="100%" cellspacing="0">
                                       <thead>
                                          
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Price</th>
                                          <th>Qty</th>
                                          <th class="bg bg-success" style="color:white;">IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </thead>
                                      <tfoot>
                                         
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Price</th>
                                          <th>Qty</th>
                                          <th  class="bg bg-success" style="color:white;">IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </tfoot>
                                      <tbody>
                                         @foreach($getStockStatusUrgelloDrinks as $getStockStatusUrgelloDrink)
                                          <tr>
                                            
                                            <td>{{ $getStockStatusUrgelloDrink->product_id_no }}</td>
                                            <td>{{ $getStockStatusUrgelloDrink->dr_no }}</td>
                                            <td>{{ $getStockStatusUrgelloDrink->supplier }}</td>
                                            <td>{{ $getStockStatusUrgelloDrink->product_name }}</td>
                                            <td>₱ <?php echo number_format($getStockStatusUrgelloDrink->price, 2)?></td>
                                            <td>{{ $getStockStatusUrgelloDrink->qty }}</td>
                                            <td  class="bg bg-success" style="color:white;">{{ $getStockStatusUrgelloDrink->product_in }}</td>
                                            <td>{{ $getStockStatusUrgelloDrink->unit }}</td>
                                            <td><?php echo number_format($getStockStatusUrgelloDrink->amount, 2)?></td>
                                            <td>{{ $getStockStatusUrgelloDrink->created_by }}</td>
                                          </tr>
                                          @endforeach 
                                      </tbody>
                                      </table>
                                  </div>
                                @elseif($data == "Velez")
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                      <thead>
                                          
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Qty</th>
                                          <th class="bg bg-success" style="color:white;">IN</th>
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
                                          <th class="bg bg-success" style="color:white;">IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </tfoot>
                                      <tbody>
                                         @foreach($getStockStatusVelezDrinks as $getStockStatusVelezDrink)
                                          <tr>
                                           
                                            <td>{{ $getStockStatusVelezDrink->product_id_no }}</td>
                                            <td>{{ $getStockStatusVelezDrink->dr_no }}</td>
                                            <td>{{ $getStockStatusVelezDrink->supplier }}</td>
                                            <td>{{ $getStockStatusVelezDrink->product_name }}</td>
                                            <td>₱ <?php echo number_format($getStockStatusVelezDrink->price, 2)?></td>
                                            <td>{{ $getStockStatusVelezDrink->qty }}</td>
                                            <td class="bg bg-success" style="color:white;">{{ $getStockStatusVelezDrink->product_in }}</td>
                                            <td>{{ $getStockStatusVelezDrink->unit }}</td>
                                            <td><?php echo number_format($getStockStatusVelezDrink->amount, 2)?></td>
                                            <td>{{ $getStockStatusVelezDrink->created_by }}</td>
                                          </tr>
                                          @endforeach 
                                      </tbody>
                                    </table>
                                </div> 
                               @elseif($data == "Banilad")
                               <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                      <thead>
                                         
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Qty</th>
                                          <th class="bg bg-success" style="color:white;">IN</th>
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
                                          <th class="bg bg-success" style="color:white;">IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </tfoot>
                                      <tbody>
                                         @foreach($getStockStatusBaniladDrinks as $getStockStatusBaniladDrink)
                                          <tr>
                                           
                                            <td>{{ $getStockStatusBaniladDrink->product_id_no }}</td>
                                            <td>{{ $getStockStatusBaniladDrink->dr_no }}</td>
                                            <td>{{ $getStockStatusBaniladDrink->supplier }}</td>
                                            <td>{{ $getStockStatusBaniladDrink->product_name }}</td>
                                            <td>₱ <?php echo number_format($getStockStatusBaniladDrink->price, 2)?></td>
                                            <td>{{ $getStockStatusBaniladDrink->qty }}</td>
                                            <td class="bg bg-success" style="color:white;">{{ $getStockStatusBaniladDrink->product_in }}</td>
                                            <td>{{ $getStockStatusBaniladDrink->unit }}</td>
                                            <td><?php echo number_format($getStockStatusBaniladDrink->amount, 2)?></td>
                                            <td>{{ $getStockStatusBaniladDrink->created_by }}</td>
                                          </tr>
                                          @endforeach 
                                      </tbody>
                                    </table>
                                </div>
                               @elseif($data == "GQS")
                               <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                      <thead>
                                          
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Qty</th>
                                          <th class="bg bg-success" style="color:white;">IN</th>
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
                                          <th class="bg bg-success" style="color:white;">IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </tfoot>
                                      <tbody>
                                         @foreach($getStockStatusGqsDrinks as $getStockStatusGqsDrink)
                                          <tr>
                                    
                                            <td>{{ $getStockStatusGqsDrink->product_id_no }}</td>
                                            <td>{{ $getStockStatusGqsDrink->dr_no }}</td>
                                            <td>{{ $getStockStatusGqsDrink->supplier }}</td>
                                            <td>{{ $getStockStatusGqsDrink->product_name }}</td>
                                            <td>₱ <?php echo number_format($getStockStatusGqsDrink->price, 2)?></td>
                                            <td>{{ $getStockStatusGqsDrink->qty }}</td>
                                            <td class="bg bg-success" style="color:white;">{{ $getStockStatusGqsDrink->product_in }}</td>
                                            <td>{{ $getStockStatusGqsDrink->unit }}</td>
                                            <td><?php echo number_format($getStockStatusGqsDrink->amount, 2)?></td>
                                            <td>{{ $getStockStatusGqsDrink->created_by }}</td>
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