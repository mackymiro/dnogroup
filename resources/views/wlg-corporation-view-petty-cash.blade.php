@extends('layouts.wlg-corporation-app')
@section('title', 'View Petty Cash |')
@section('content')
<div id="wrapper">
    <!-- Sidebar -->
    @include('sidebar.sidebar-wlg-corporation')
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">WLG Corporation</a>
              </li>
              <li class="breadcrumb-item ">Petty Cash</li>
              <li class="breadcrumb-item active">View Petty Cash</li>
            </ol>
            <a href="{{ url('wlg-corporation/petty-cash-list') }}">Back to Lists</a>
            <div class="col-lg-12">
            <img src="{{ asset('images/wlg-corporation.png')}}" width="235" height="114" class="img-responsive mx-auto d-block" alt="WLG Corporation">
	           
                <h4 class="text-center"><u>PETTY CASH SUMMARY</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-money-bill-alt"></i>
                            Petty Cash Summary
                            @if($getPettyCash[0]->deleted_at == NULL)
                            <div class="float-right">
                               <a href="{{ action('WlgCorporationController@printPettyCash', $getPettyCash[0]->id)}}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                             </div>
                            @endif
                        </div>
                        <div class="card-body">
                          @if($getPettyCash[0]->deleted_at != NULL)
                                <h1 style="color:red; font-size:28px; font-weight:bold">This Item Has Been Deleted! (CLERICAL ERROR)</h1>
                            @endif
                        <div class="form-group">
                                <div class="form-row">
                                     <div class="col-lg-6">
                                         <table class="table table-bordered"> 
                                         <thead>
                                            <tr>
                                                <th width="30%">Petty Cash No</th>
                                                <th>{{ $getPettyCash[0]->wlg_code }}</th>
                                            </tr>
                                            <tr>
                                                <th>Date</th>
                                                <th>{{ $getPettyCash[0]->date }}</th>
                                            </tr>
                                           
                                        </thead>
                                         </table>
                                     </div>
                                     <div class="col-lg-6">
                                         <table class="table table-bordered"> 
                                         <thead>
                                           
                                            <tr>
                                                <th>Petty Cash Name</th>
                                                <th> {{ $getPettyCash[0]->petty_cash_name }} </th>
                                            </tr>
                                            <tr>
                                                <th>Petty Cash Summary</th>
                                                <th>{{ $getPettyCash[0]->petty_cash_summary }}</th>
                                            </tr>
                                        </thead>
                                         </table>
                                     </div>
                                </div>
                             </div>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>DATE</th>
                                        <th >ITEM DESCRIPTION</th>
                                        <th>AMOUNT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  
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