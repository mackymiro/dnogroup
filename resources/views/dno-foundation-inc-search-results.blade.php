@extends('layouts.dno-foundation-inc-app')
@section('title', 'Search Results |')
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css" >
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<div id="wrapper">
     @include('sidebar.sidebar-dno-foundation-inc')
     <div id="content-wrapper">
        <div class="container-fluid">
             <!-- Breadcrumbs-->
             <h1 class="mt-4">Search Number Code</h1>
             <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">DNO Foundation Inc </a>
                </li>
                <li class="breadcrumb-item active">Search Number Code</li>
                
              </ol>
              <div class="row">
                 <div class="col-lg-12">
                     <div class="card mb-3">
                        <div class="card-header">
                        <i class="fa fa-search" aria-hidden="true"></i>

	    					  Search Number Code
                        </div>
                        <div class="card-body">
                            <form action="{{ action('DnoFoundationIncController@search') }}" method="get">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="form-row">
                                     <div class="col-lg-4">
                                        <label>Search </label>
                                        <select data-live-search="true" name="searchCode" class="form-control selectpicker">
                                            @foreach($getAllCodes as $getAllCode)
                                            <option value="{{ $getAllCode['dno_foundation_code']}}">{{ $getAllCode['dno_foundation_code']  }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <br>
                                        
                                       <button class="btn btn-success btn-lg"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                     </div>
                 </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                     <div class="card mb-3">
                        <div class="card-header">
                         <i class="fa fa-search" aria-hidden="true"></i>
                             Search Result
                        </div>
                        <div class="card-body">
                            @if($module === "Payment Voucher")
                                @foreach($getSearchPaymentVouchers as $getSearchPaymentVoucher)
                                    @if($getSearchPaymentVoucher->deleted_at ==  NULL)
                                    <p style="font-size:28px;">
                                        {{ $getSearchPaymentVoucher->module_name}} <br>{{ $getSearchPaymentVoucher->module_code }}{{ $getSearchPaymentVoucher->dno_foundation_code }}
                                        <a href="{{ url('dno-foundation-inc/view-payables-details/'.$getSearchPaymentVoucher->id) }}">View Number Code</a> 
                                    </p>
                                    @else
                                    <p style="color:red; font-weight:bold; font-size:20px;">This Item Has Been Deleted! (CLERICAL ERROR)</p>
                                
                                    <p style="font-size:28px;">
                                        {{ $getSearchPaymentVoucher->module_name}} <br>{{ $getSearchPaymentVoucher->module_code }}{{ $getSearchPaymentVoucher->dno_foundation_code }}
                                        <a href="{{ url('dno-foundation-inc/view-payables-details/'.$getSearchPaymentVoucher->id) }}">View Number Code</a> 
                                    </p>
                                    @endif
                                @endforeach
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