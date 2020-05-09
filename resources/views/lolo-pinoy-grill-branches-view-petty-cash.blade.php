@extends('layouts.lolo-pinoy-grill-branches-app')
@section('title', 'View Petty Cash |')
@section('content')
<div id="wrapper">
     <!-- Sidebar -->
     @include('sidebar.sidebar-lolo-pinoy-grill-branches')
     <div id="content-wrapper">
         <div class="container-fluid">
                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="#">Lolo Pinoy Grill Branches</a>
                    </li>
                    <li class="breadcrumb-item ">Petty Cash</li>
                    <li class="breadcrumb-item active">View Petty Cash</li>
                </ol>
                <a href="{{ url('lolo-pinoy-grill-branches/petty-cash-list') }}">Back to Lists</a>
                <div class="col-lg-12">
                    <img src="{{ asset('images/lolo-pinoy-grill.jpeg')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lolo Pinoy Grill ">
                    
                    <h4 class="text-center"><u>PETTY CASH SUMMARY</u></h4>
                 </div>
                 <div class="row">
                     <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <i class="fas fa-money-bill-alt"></i>
                                Petty Cash Summary
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>DATE</th>
                                            <th >PETTY CASH SUMMARY</th>
                                            <th>AMOUNT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>    
                                            <td>{{ $getPettyCash['issued_date']}}</td>
                                            <td>{{ $getPettyCash['particulars']}}</td>
                                            <td><?php echo number_format($getPettyCash['amount'], 2)?></td>
                                        </tr>
                                        @foreach($getPettyCashSummaries as $getPettyCashSummarry)
                                        <tr>
                                        
                                            <td>{{ $getPettyCashSummarry['date']}}</td>
                                            <td>{{ $getPettyCashSummarry['particulars']}}</td>
                                            <td><?php echo number_format($getPettyCashSummarry['amount'], 2)?></td>
                                        
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <td><b>TOTAL</b></td>
                                            <td><?php echo number_format($sum, 2); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                     </div> 
                 </div><!-- end of row-->
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