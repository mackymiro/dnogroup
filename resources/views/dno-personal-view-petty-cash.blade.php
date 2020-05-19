@extends('layouts.dno-personal-app')
@section('title', 'View Petty Cash |')
@section('content')
<div id="wrapper">
    <!-- Sidebar -->
    @include('sidebar.sidebar-dno-personal')
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Dno Personal</a>
              </li>
              <li class="breadcrumb-item ">Petty Cash</li>
              <li class="breadcrumb-item active">View Petty Cash</li>
            </ol>
            <a href="{{ url('/dno-personal/petty-cash-list') }}">Back to Lists</a>
            <div class="col-lg-12">
                <img src="{{ asset('images/DIC-LOGO.png')}}"  width="255" height="172" class="img-responsive mx-auto d-block" alt="DNO Personal">
                
                <h4 class="text-center"><u>PETTY CASH SUMMARY</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-money-bill-alt"></i>
                            Petty Cash Summary
                            <div class="float-right">
                               <a href="{{ action('DnoPersonalController@printPettyCash', $getPettyCash['id'])}}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                             </div>
                           
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
                                      
                                        <td>{{ $getPettyCash['date']}}</td>
                                        <td>{{ $getPettyCash['petty_cash_summary']}}</td>
                                        <td><?php echo number_format($getPettyCash['amount'], 2)?></td>
                                    </tr>
                                    @foreach($getPettyCashSummaries as $getPettyCashSummarry)
                                    <tr>
                                       
                                        <td>{{ $getPettyCashSummarry['date']}}</td>
                                        <td>{{ $getPettyCashSummarry['petty_cash_summary']}}</td>
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