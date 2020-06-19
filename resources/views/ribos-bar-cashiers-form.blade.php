@extends('layouts.ribos-bar-app')
@section('title', 'Cashiers Report Form |')
@section('content')
<div id="wrapper">
    <!-- Sidebar -->
    @include('sidebar.sidebar-ribos-bar')
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Ribo's Bar</a>
                </li>
                <li class="breadcrumb-item active">Cashier's Report Form</li>
            </ol>
            <div class="col-lg-12">
            	<img src="{{ asset('images/digitized-logos/ribos-food-corp.png')}}" width="390" height="250" class="img-responsive mx-auto d-block" alt="Rib's Bar">
            	 
            	 <h4 class="text-center"><u>CASHIER'S REPORT FORM</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-receipt" aria-hidden="true"></i>
                            Cashier's Form
                        </div>
                        <div class="card-body">
                            <form action="{{ action('RibosBarController@cashiersFormStore') }}" method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-2">
                                        <label>Date</label>
                                        <input type="text" name="date" class="form-control" required="required"/>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Cashier</label>
                                        <input type="text" name="cashierName" class="form-control" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Bar Tender</label>
                                        <input type="text" name="barTender" class="form-control" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Shift Schedule</label>
                                        <input type="text" name="shiftSchedule" class="form-control"  required="required" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-2">
                                        <label>Starting OS #</label>
                                        <input type="text" name="startingOs" class="form-control" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Closing OS #</label>
                                        <input type="text" name="closingOs" class="form-control" />
                                    </div>
                                   
                                </div>
                            </div>
                           
                           
                            <div class="float-right">
                                <input type="submit" class="btn btn-success" value="Create" />
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection