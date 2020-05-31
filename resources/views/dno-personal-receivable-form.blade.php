@extends('layouts.dno-personal-app')
@section('title', 'Receivables Form |')
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
            <li class="breadcrumb-item active">Receivables Form</li>

            </ol>
            <div class="col-lg-12">
                    <img src="{{ asset('images/DIC-LOGO.png')}}" width="255" height="172" class="img-responsive mx-auto d-block" alt="DNO Personal">
                    
                    <h4 class="text-center"><u>RECEIVABLES FORM</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-stamp"></i>
                                Recievables
                        </div>
                        <div class="card-body">
                            <form action="{{ action('DnoPersonalController@storeReceivables')}}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="form-row">
                                    @if ($errors->has('nameOfTenant'))
                                        <span class="alert alert-danger">
                                        <strong>{{ $errors->first('nameOfTenant') }}</strong>
                                        </span>
                                    @endif
                                    <div class="col-lg-4">
                                        <label>Name of Tenant</label>
                                        <input type="text" name="nameOfTenant" class="form-control" required />
                                    </div>
                                    @if ($errors->has('contractDate'))
                                        <span class="alert alert-danger">
                                        <strong>{{ $errors->first('contractDate') }}</strong>
                                        </span>
                                    @endif
                                    <div class="col-lg-2">
                                        <label>Contract Date</label>
                                        <input type="text" name="contractDate" class="form-control" required/>
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Unit No</label>
                                        <input type="text" name="unitNo" class="form-control" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Monthly Rent</label>
                                        <input type="text" name="monthlyRent" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                   @if ($errors->has('advanceDep'))
                                        <span class="alert alert-danger">
                                        <strong>{{ $errors->first('advanceDep') }}</strong>
                                        </span>
                                    @endif
                                    <div class="col-lg-4">
                                        <label>Advance Deposit</label>
                                        <input type="text" name="advanceDep" class="form-control" required/>
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Amount</label>
                                        <input type="text" name="amount" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-success float-right btn-lg"><i class="fas fa-save"></i> Save Receivables</button>
                            </div>
                            </form>
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