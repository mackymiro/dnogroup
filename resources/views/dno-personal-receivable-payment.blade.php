@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Receivables Payments|')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
 
</script>
<div id="wrapper">
     @include('sidebar.sidebar-dno-personal')
     <div id="content-wrapper">
        <div class="container-fluid">
              <!-- Breadcrumbs-->
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                <a href="#">DNO Personal</a>
                </li>
                <li class="breadcrumb-item active">Recievables</li>
                <li class="breadcrumb-item "> Payments</li>
            </ol>
            <a href="{{ url('dno-personal/receivables/list') }}">Back to Lists</a>
            <div class="col-lg-12">
                <img src="{{ asset('images/DIC-LOGO.png')}}" width="255" height="172" class="img-responsive mx-auto d-block" alt="DNO Personal">
                
                <h4 class="text-center"><u>RECEIVABLE PAYMENT </u></h4>
            </div>
            <div class="row">
                 <div class="col-lg-12">
                     <div class="card mb-3">
                          <div class="card-header">
                                <i class="fas fa-stamp"></i>
                                Receivables List
                          </div>
                          <div class="card-body">
                          <div class="form-group">
                                <div class="form-row">
                                   
                                    <div class="col-lg-4">
                                        <label>Name of Tenant</label>
                                        <input type="text" name="nameOfTenant" class="form-control" value="{{ $receivable['name_of_tenant']}}" />
                                    </div>
                                  
                                    <div class="col-lg-2">
                                        <label>Contract Date</label>
                                        <input type="text" name="contractDate" class="form-control" value="{{ $receivable['contract_date'] }}" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Unit No</label>
                                        <input type="text" name="unitNo" class="form-control" value="{{ $receivable['unit_no'] }}" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Monthly Rent</label>
                                        <input type="text" name="monthlyRent" class="form-control" value="{{ $receivable['monthly_rent'] }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                  
                                    <div class="col-lg-4">
                                        <label>Advance Deposit</label>
                                        <input type="text" name="advanceDep" class="form-control"  value="{{ $receivable['advance_deposit'] }}" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Amount</label>
                                        <input type="text" name="amount" class="form-control bg-danger" style="color:#fff;" value="<?php echo number_format($receivable['advance_deposit_amount'], 2)?>" />
                                    </div>
                                </div>
                            </div>
                          
                          </div>
                     </div>
                 </div>
            </div><!-- end of row-->
            <div class="row">
                 <div class="col-lg-12">
                     <div class="card mb-3">
                          <div class="card-header">
                                <i class="fas fa-stamp"></i>
                                Receivables List
                          </div>
                          <div class="card-body">
                                 @if(session('paidSuccess'))
                                    <p class="alert alert-success">{{ Session::get('paidSuccess') }}</p>
                                @endif
                               @foreach($receivableDatas  as $receivableData)
                                <form action="{{ action('DnoPersonalController@paid', $receivableData['id'] ) }}" method="post">
                                {{csrf_field()}}
                                   <input name="_method" type="hidden" value="PATCH">
                                <div class="form-group">
                                    
                                    <div class="form-row">
                                    
                                        <div class="col-lg-2">
                                            <label>Period</label>
                                            <input type="text" name="period" class="datepicker form-control" value="{{ $receivableData['period'] }}" disabled="disabled"/>
                                        </div>
                                    
                                        <div class="col-lg-2">
                                            <label>Amount</label>
                                            <input type="text" name="amount" class="form-control bg-danger" style="color:#fff;" value="<?php echo number_format($receivableData['amount'], 2)?>" disabled="disabled"/>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Remarks</label>
                                            <input type="text" name="remarks" class="form-control" />
                                        </div>
                                      
                                        <div class="col-lg-2">
                                            <br>
                                            <input type="hidden" name="rpId" value="{{ $receivable['id']}}" />
                                            <input type="submit" class="btn btn-success btn-lg" value="Paid" />    
                                        </div>
                                    </div>
                                </div>  
                                </form>
                                @endforeach
                          </div>
                     </div>
                 </div>
            </div><!-- end of row-->
            <div class="row">
                <div class="col-lg-12"> 
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-tasks" aria-hidden="true"></i>
                            Lists (Unpaid)
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>PERIOD</th>
                                            <th class="bg-danger" style="color:#fff;">AMOUNT</th>
                                            <th class="bg-danger" style="color:#fff;">STATUS</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>PERIOD</th>
                                            <th class="bg-danger" style="color:#fff;">AMOUNT</th>
                                            <th class="bg-danger" style="color:#fff;">STATUS</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                         @foreach($receivableDatas as $receivableData)
                                        <tr>
                                            <td>{{ $receivableData['period']}}</td>
                                            <td class="bg-danger" style="color:#fff;"><?php echo number_format($receivableData['amount'], 2)?></td>
                                            
                                            <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                          
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end of row-->
            <div class="row">
                <div class="col-lg-12"> 
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-tasks" aria-hidden="true"></i>
                            Lists (Paid)
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>PERIOD</th>
                                            <th class="bg-success" style="color:#fff;">AMOUNT</th>
                                            <th class="bg-success" style="color:#fff;">STATUS</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>PERIOD</th>
                                            <th class="bg-success" style="color:#fff;">AMOUNT</th>
                                            <th class="bg-success" style="color:#fff;">STATUS</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                         @foreach($receivableDataPaids as $receivableDataPaid)
                                        <tr>
                                            <td>{{ $receivableDataPaid['period']}}</td>
                                            <td class="bg-success" style="color:#fff;"><?php echo number_format($receivableDataPaid['amount'], 2)?></td>
                                            <td class="bg-success" style="color:#fff;">PAID</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
