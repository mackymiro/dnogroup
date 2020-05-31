@extends('layouts.dno-personal-app')
@section('title', 'View Receivables |')
@section('content')
<div id="wrapper">
    <!-- Sidebar -->
    @include('sidebar.sidebar-dno-personal')
    <div id="content-wrapper">
        <div class="container-fluid">
              <!-- Breadcrumbs-->
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                <a href="#">DNO Personal</a>
                </li>
                <li class="breadcrumb-item active">Recievables</li>
                <li class="breadcrumb-item "> View</li>
            </ol>
            <a href="{{ url('dno-personal/receivables/list') }}">Back to Lists</a>
            <div class="col-lg-12">
                <img src="{{ asset('images/DIC-LOGO.png')}}" width="255" height="172" class="img-responsive mx-auto d-block" alt="DNO Personal">
                
                <h4 class="text-center"><u>VIEW RECEIVABLE </u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                         <div class="card-header">
                            <i class="fas fa-stamp"></i>
                            View Receivables
                              <div class="float-right">
                               <a href=""><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                             </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="form-row">
                                  <div class="col-lg-6">
                                    <table class="table table-bordered">  
                                        <thead>
                                            <tr>
                                                <th width="30%">Name of Tenant</th>
                                                <th> {{ $receivable['name_of_tenant'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>Contract Date</th>
                                                <th>{{ $receivable['contract_date'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>Unit No</th>
                                                <th> {{ $receivable['unit_no'] }} </th>
                                            </tr>
                                          
                                        </thead>
                                    </table>
                                  
                                  </div>
                                  <div class="col-lg-6">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="20%">Monthly Rent</th>
                                                <th>{{ $receivable['monthly_rent'] }}</th>
                                            </tr>
                                            <tr>
                                                <th width="30%">Advance Deposit</th>
                                                <th> {{ $receivable['advance_deposit'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>Amount</th>
                                                <th><?php echo number_format($receivable['advance_deposit_amount'], 2)?></th>
                                            </tr>
                                        </thead>

                                    </table>
                        
                                  </div>
                                </div>
                            </div><!-- end of form group -->
                            <table class="table table-striped">
                                 <thead>
                                    <tr>
                                        <th class="bg-info" style="color:white;">PERIOD </th>
                                        <th class="bg-info" style="color:white;">AMOUNT</th>
                                        <th class="bg-info" style="color:white;">STATUS</th>
                                       
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($receivableDatas as $receivableData)
                                     <tr>
                                        <td>{{ $receivableData['period']}}</td>
                                        <td><?php echo number_format($receivableData['amount'], 2)?></td>
                                        <td>{{ $receivableData['status']}}</td> 
                                    </tr>
                                     @endforeach
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