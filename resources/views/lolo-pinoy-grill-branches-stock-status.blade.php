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
                            @if($data  == "Urgello")
                            <div class="table-responsive">
                                <table class="table table-bordered display" width="100%" cellspacing="0">
                                     <thead>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Qty</th>
                                          <th class="bg-danger" style="color:white;">OUT</th>
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
                                          <th class="bg-danger" style="color:white;">OUT</th>
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
                                            <td>{{ $getStockStatusUrgello->qty }}</td>
                                            <td class="bg-danger" style="color:white;">{{ $getStockStatusUrgello->product_out }}</td>
                                            <td>{{ $getStockStatusUrgello->unit }}</td>
                                            <td><?php echo number_format($getStockStatusUrgello->amount, 2)?></td>
                                            <td>{{ $getStockStatusUrgello->created_by }}</td>
                                          </tr>
                                          @endforeach
                                      </tbody>
                                </table>
                                <table class="table table-bordered">
                                    <thead>	
                                    <tr>
                                      <th width="20%" class="bg-info" style="color:white;">TOTAL OUT </th>
                                      <th class="bg-danger" style="color:white; font-size:30px;">₱ <?php echo number_format($totalStockOut, 2)?></th>
                                    </tr>
                                  
                                  </thead>
                                </table>
                            </div>
                            @elseif($data == "Velez")
                            <div class="table-responsive">
                                <table class="table table-bordered display" width="100%" cellspacing="0">
                                     <thead>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Qty</th>
                                          <th class="bg-danger" style="color:white;">OUT</th>
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
                                          <th class="bg-danger" style="color:white;">OUT</th>
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
                                            <td>{{ $getStockStatusVelez->qty }}</td>
                                            <td class="bg-danger" style="color:white;">{{ $getStockStatusVelez->product_out }}</td>
                                            <td>{{ $getStockStatusVelez->unit }}</td>
                                            <td><?php echo number_format($getStockStatusVelez->amount, 2)?></td>
                                            <td>{{ $getStockStatusVelez->created_by }}</td>
                                          </tr>
                                          @endforeach
                                      </tbody>
                                </table>
                                <table class="table table-bordered">
                                    <thead>	
                                    <tr>
                                      <th width="20%" class="bg-info" style="color:white;">TOTAL OUT </th>
                                      <th class="bg-danger" style="color:white; font-size:30px;">₱ <?php echo number_format($totalStockOutVelez, 2)?></th>
                                    </tr>
                                  
                                  </thead>
                                </table>
                            </div>
                            @elseif($data == "Banilad")
                            <div class="table-responsive">
                                <table class="table table-bordered display" width="100%" cellspacing="0">
                                     <thead>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Qty</th>
                                          <th class="bg-danger" style="color:white;">OUT</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                      </thead>
                                      <tfoot>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th class="bg-danger" style="color:white;">Qty</th>
                                          <th>OUT</th>
                                          <th>Unit</th>`
                                          <th>Amount</th>
                                      </tfoot>
                                      <tbody>
                                           @foreach($getStockStatusBanilads as $getStockStatusBanilad)
                                          <tr>
                                            <td>{{ $getStockStatusBanilad->product_id_no }}</td>
                                            <td>{{ $getStockStatusBanilad->dr_no }}</td>
                                            <td>{{ $getStockStatusBanilad->supplier }}</td>
                                            <td>{{ $getStockStatusBanilad->product_name }}</td>
                                            <td>{{ $getStockStatusBanilad->qty }}</td>
                                            <td class="bg-danger" style="color:white;">{{ $getStockStatusBanilad->product_out }}</td>
                                            <td>{{ $getStockStatusBanilad->unit }}</td>
                                            <td><?php echo number_format($getStockStatusBanilad->amount, 2)?></td>
                                            <td>{{ $getStockStatusBanilad->created_by }}</td>
                                          </tr>
                                          @endforeach
                                      </tbody>
                                </table>
                                <table class="table table-bordered">
                                    <thead>	
                                    <tr>
                                      <th width="20%" class="bg-info" style="color:white;">TOTAL OUT </th>
                                      <th class="bg-danger" style="color:white; font-size:30px;">₱ <?php echo number_format($totalStockOutBanilad, 2)?></th>
                                    </tr>
                                  
                                  </thead>
                                </table>
                            </div>
                            @elseif($data  == "GQS")
                            <div class="table-responsive">
                                <table class="table table-bordered display" width="100%" cellspacing="0">
                                     <thead>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Qty</th>
                                          <th class="bg-danger" style="color:white;">OUT</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                      </thead>
                                      <tfoot>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th >Qty</th>
                                          <th class="bg-danger" style="color:white;">OUT</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                      </tfoot>
                                      <tbody>
                                         @foreach($getStockStatusGqses as $getStockStatusGqs)
                                          <tr>
                                            <td>{{ $getStockStatusGqs->product_id_no }}</td>
                                            <td>{{ $getStockStatusGqs->dr_no }}</td>
                                            <td>{{ $getStockStatusGqs->supplier }}</td>
                                            <td>{{ $getStockStatusGqs->product_name }}</td>
                                            <td>{{ $getStockStatusGqs->qty }}</td>
                                            <td class="bg-danger" style="color:white;">{{ $getStockStatusGqs->product_out }}</td>
                                            <td>{{ $getStockStatusGqs->unit }}</td>
                                            <td><?php echo number_format($getStockStatusGqs->amount, 2)?></td>
                                            <td>{{ $getStockStatusGqs->created_by }}</td>
                                          </tr>
                                          @endforeach
                                      </tbody>
                                </table>
                                <table class="table table-bordered">
                                    <thead>	
                                    <tr>
                                      <th width="20%" class="bg-info" style="color:white;">TOTAL OUT </th>
                                      <th class="bg-danger" style="color:white; font-size:30px;">₱ <?php echo number_format($totalStockOutGqs, 2)?></th>
                                    </tr>
                                  
                                  </thead>
                                </table>
                            </div>
                            @else
                                <h1> Login To Branch To View Transactions </h1>
                            @endif
                        </div>
                    </div>
                </div>
              </div>
        </div>
    </div>
</div>
@endsection