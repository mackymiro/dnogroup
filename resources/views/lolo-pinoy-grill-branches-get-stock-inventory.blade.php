@extends('layouts.lolo-pinoy-grill-branches-app')
@section('title', 'Stock Inventory |')
@section('content')
<script>
    $(function(){
      $('table.display').DataTable( {} );
    });
</script>
<script>
 
  $(function() {
        $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd",
        });
      }); 
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
                <li class="breadcrumb-item ">Stock Inventory</li>
              </ol>
              <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
          					          <i class="fa fa-tasks" aria-hidden="true"></i>
          					           Stock Inventory {{ $data }} -Branch 
                            </div>
                                                    
                            <div class="card-body">
                            <form action="{{ action('LoloPinoyGrillBranchesController@getStockInventoryDate') }}" method="get">
                              
                               {{ csrf_field() }}
                               <div class="form-group">
                                    <div class="form-row">  
                                        <div class="col-lg-4">
                                              {{ csrf_field() }}
                                                <h1>Search Date</h1>
                                                <input type="text" name="selectDate" class="datepicker form-control"  required/>
                                                <br>
                                                
                                        </div>
                                        <div class="col-lg-2">
                                             <h1>Select</h1>
                                             <select name="chooseFlag" class="form-control">
                                                <option value="All">All</option>
                                                <option value="Foods">Foods</option>
                                                <option value="Drinks">Drinks</option>
                                                
                                             </select>
                                          
                                        </div>
                                         
                                    </div>
                                    <input type="hidden" name="branch" value="{{ Session::get('sessionBranch') }}" />
                                <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-search" aria-hidden="true"></i> Search Date</button>
                                   
                                </div>
                                </form>
                                <form action="{{ action('LoloPinoyGrillBranchesController@getStockInventoryDateMultiple')}}" method="get"> 
                                     {{ csrf_field() }}
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="col-lg-4">
                                            <h1>Search Start Date</h1>
                                            <input type="text" name="startDate" class="datepicker form-control"  required/>
                                                
                                            </div>
                                            <div class="col-lg-4">
                                            <h1>Search End Date</h1>

                                            <input type="text" name="endDate" class="datepicker form-control"  required/>
                                            
                                            </div>
                                            <div class="col-lg-2">
                                             <h1>Select</h1>
                                             <select name="chooseFlag" class="form-control">
                                                <option value="All">All</option>
                                                <option value="Foods">Foods</option>
                                                <option value="Drinks">Drinks</option>
                                                
                                             </select>
                                          
                                            </div>
                                        
                                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <br>
                                            <input type="hidden" name="branch" value="{{ Session::get('sessionBranch') }}" />
                                            <button type="submit" class="btn btn-success  btn-lg"><i class="fa fa-search" aria-hidden="true"></i> Search Date</button>
                                            
                                        </div>
                                    </div>
                                </form>
                                <div class="float-right">
                                    <a href="{{ action('LoloPinoyGrillBranchesController@printGetStockInventory', $getDate.'&'.$flag)}}" ><i class="fa fa-print fa-4x" aria-hidden="true"></i></a>
                                </div>
                                <br>
                                <br>
                                <br>
                                @if($data)
                               <h1> Search Date: {{ $getDate }}</h1>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                      <thead>
                                          <th>Date</th>
                                          <th>Product Name</th>
                                          <th>Price</th>
                                          <th>Opening Stock</th>
                                          <th class="bg bg-info" style="color:white;">IN</th>
                                          <th>Out</th>
                                          <th>Sold</th>
                                          <th class="bg bg-danger" style="color:white;">Remaining Stock</th>
                                          <th class="bg bg-success" style="color:white;">Amount</th>
                                          <th>Flag</th>
                                      </thead>
                                      <tfoot>
                                          <th>Date</th>
                                          <th>Product Name</th>
                                          <th>Price</th>
                                          <th>Opening Stock</th>
                                          <th class="bg bg-info" style="color:white;">IN</th>
                                          <th>Out</th>
                                          <th>Sold</th>
                                          <th class="bg bg-danger" style="color:white;">Remaining Stock</th>
                                          <th class="bg bg-success" style="color:white;">Amount</th>
                                          <th>Flag</th>
                                      </tfoot>
                                      <tbody>
                                          @foreach($getStockInventories as $getStockInventory)
                                            <tr>
                                                <td>{{ $getStockInventory->date }}</td>
                                                <td>{{ $getStockInventory->product_name }}</td>
                                                <td><?= number_format($getStockInventory->price, 2)?></td>
                                                <td><?= number_format($getStockInventory->opening_stock, 2)?></td>
                                                <td class="bg bg-info" style="color:white;"><?= number_format($getStockInventory->product_in, 2)?></td>
                                                <td><?= number_format($getStockInventory->product_out, 2)?></td>
                                                <td><?= number_format($getStockInventory->sold, 2)?></td>
                                                <td class="bg bg-danger" style="color:white;"><?= number_format($getStockInventory->remaining_stock, 2)?></td>
                                                <td class="bg bg-success" style="color:white;"><?= number_format($getStockInventory->amount, 2)?></td>
                                                <td>{{ $getStockInventory->flag }}</td>
                                            </tr>
                                          @endforeach
                                      </tbody>
                                    </table>
                                </div>  
                                <br>
                                <table class="table table-bordered">
                                <thead>
                                  <tr>
                                    <th width="30%" class="bg-info" style="color:white; font-size:28px;">TOTAL AMOUNT</th>
                                    <th class="bg-danger" style="color:white; font-size:28px;"><span id="totalDue">₱ <?= number_format($totalAmount , 2);?></span></th>
                                  </tr>
                                 

                                </thead>
                                </table>	
                             
                             
                               
                                @else
                                   <h1> Login To Branch To View Transactions </h1>
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