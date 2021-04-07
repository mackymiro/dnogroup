@extends('layouts.lolo-pinoy-grill-branches-app')
@section('content')
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
                    @if(!empty($data))
                    <li class="breadcrumb-item active">
                    {{ $data }}
                    </li>
                    @endif
                    <li class="breadcrumb-item active"> Transaction List All</li>
                
                </ol>
                <div class="row">
                     <div class="col-lg-12">
                         <div class="card mb-3">
                            <div class="card-header">
                                <i class="fas fa-search"></i>
                                Search Date
                            </div>
                            <div class="card-body">
                                 <div class="form-group">
                                    <div class="form-row">
                                        
                                        <div class="col-lg-4">
                                            <form action="{{ action('LoloPinoyGrillBranchesController@getTransactionList') }}" method="get">
                                            {{ csrf_field() }}
                                                <h1>Search Date</h1>
                                                <input type="text" name="selectDate" class="datepicker form-control"  required/>
                                                <br>
                                                <input type="hidden" name="branch" value="{{ Session::get('sessionBranch') }}" />
                                                <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-search" aria-hidden="true"></i> Search Date</button>
                                            </form>
                                        </div>
                                        
                                    </div>
                                </div>
                                <form action="{{ action('LoloPinoyGrillBranchesController@getMultipleTransactionList')}}" method="get"> 
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
                                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <br>
                                            <button type="submit" class="btn btn-success  btn-lg"><i class="fa fa-search" aria-hidden="true"></i> Search Date</button>
                                            
                                        </div>
                                    </div>
                                </form>
                            </div>
                         </div>
                     </div>
                </div>
                <div>
                    <h1>Search Result For: {{ $startDate }} TO {{ $endDate }}</h1>
                </div>
                <div class="row">
                     <div class="col-lg-12">
                         <div class="card mb-3">
                            <div class="card-header">
                                <i class="fa fa-file-invoice" aria-hidden="true"></i>
                                Transaction List All
                              
						            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                          <th>Date</th>
                                          <th>Transaction ID</th>
                                          <th>Branch</th>
                                          <th class="bg-danger" style="color:#fff;">Total Amount Of Sales</th>
                                          <th >Total Discounts (Seniors/PWD's)</th>
                                          <th >Gift Cert</th>
                                        
                                          <th>Cashier</th>
                                        </tr>
                                      </thead>
                                    <tfoot>	
                                      <tr>
                                        <th>Date</th>
                                        <th>Transaction ID</th>
                                        <th>Branch</th>
                                        <th class="bg-danger" style="color:#fff;">Total Amount Of Sales</th>
                                        <th >Total Discounts (Seniors/PWD's)</th>
                                        <th >Gift Cert</th>
                                      
                                        <th>Cashier</th>
                                      </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($getSalesItems as $getSalesItem)
                                      <tr>
                                         <td>{{ $getSalesItem->date}}</td>
                                         <td><a href="/lolo-pinoy-grill-branches/transaction-list-details/{{ $getSalesItem->id}}">{{ $getSalesItem->id}}</a></td>
                                        <td>{{ $getSalesItem->branch}}</td>
                                        <td class="bg-danger" style="color:#fff;"><?= number_format($getSalesItem->total_amount_of_sales, 2); ?></td>
                                        <td><?= number_format($getSalesItem->total_discounts_seniors_pwds); ?></td>
                                        <td><?= number_format($getSalesItem->gift_cert, 2)?></td>
                                        <td>{{ $getSalesItem->created_by }}</td>
                                      </tr>
                                      @endforeach
                                      </tbody>
                                    </table>
                                </div>
                                <table class="table table-bordered">
                                    <thead>	
                                    <tr>
                                      <th width="20%" class="bg-info" style="color:white;">TOTAL SALES </th>
                                      <th class="bg-danger" style="color:white; font-size:30px;">₱ <?= number_format($sum, 2)?></th>
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