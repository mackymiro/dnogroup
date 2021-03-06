@extends('layouts.lolo-pinoy-grill-branches-app')
@section('title', 'View Requistion Slip |')
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
              <li class="breadcrumb-item active">View Requisition Slip</li>
            </ol>
            <a href="{{ url('lolo-pinoy-grill-branches/requisition-slip-lists') }}">Back to Lists</a>
             <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoy-grill.jpeg')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lolo Pinoy Grill ">
            	 
            	 <h4 class="text-center"><u>VIEW REQUISITION SLIP</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                              <i class="fab fa-first-order" aria-hidden="true"></i>
                            View Purchase Order
                            @if($requisitionSlip[0]->deleted_at == NULL)
                             <div class="float-right">
                               
                                 <a href="{{ action('LoloPinoyGrillBranchesController@printRS', $requisitionSlip[0]->id)}}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                               
                              </div>

                              @endif
                        </div>
                        <div class="card-body">
                            @if($requisitionSlip[0]->deleted_at != NULL)
                              <h1 style="color:red; font-size:28px; font-weight:bold">This Item Has Been Deleted! (CLERICAL ERROR)</h1>
                              @endif
                            <div class="form-group">
                                <div class="form-row">
                                  <div class="col-lg-6">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="20%">Requesting Department</th>
                                                <th>{{ $requisitionSlip[0]->requesting_department }}</th>
                                            </tr>
                                            <tr>
                                                <th>Request Date</th>
                                                <th>{{ $requisitionSlip[0]->request_date}}</th>
                                            </tr>
                                        </thead>

                                    </table>
                                   
                                  </div>
                                  <div class="col-lg-6">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="20%">RS No</th>
                                                <th><a href="#">{{ $requisitionSlip[0]->module_code}}{{ $requisitionSlip[0]->lolo_pinoy_branches_code}}</a></th>
                                            </tr>
                                            <tr>
                                                <th>Date Released</th>
                                                <th> {{ $requisitionSlip[0]->date_released }}</th>
                                            </tr>
                                        </thead>
                                    </table>
                                   
                                  </div>
                                </div>
                               </div>
                               <table class="table table-striped">
                                  <thead>
                                    <tr>
                                      <th class="bg-info" style="color:white;">QUANTITY REQUESTED</th>
                                      <th class="bg-info" style="color:white;">UNIT</th>
                                     
                                      <th class="bg-info" style="color:white;">ITEM</th>
                                      <th class="bg-info" style="color:white;">QUANTITY GIVEN</th>
                                    </tr>
                                  </thead>
                                  <tbody>

                                    <tr>
                                      <td>{{ $requisitionSlip[0]->quantity_requested}}</td>
                                      <td>{{ $requisitionSlip[0]->unit}}</td>
                                     
                                      <td>{{ $requisitionSlip[0]->item}}</td>
                                      <td>{{ $requisitionSlip[0]->quantity_given}}</td>
                                    </tr>
                                    @foreach($rSlips as $rSlips)
                                    <tr>
                                      <td>{{ $rSlips['quantity_requested'] }}</td>
                                      <td>{{ $rSlips['unit'] }}</td>
                                     
                                      <td>{{ $rSlips['item'] }}</td>
                                      <td>{{ $rSlips['quantity_given']}}</td>
                                    </tr> 
                                    @endforeach
                                   
                                    </tbody>
                               </table>
                            
                               <div class="form-group">
                                  <div class="form-row">
                                      <div class="col-lg-6">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="30%">Released By</th>
                                                    <th></th>
                                                </tr>
                                                 <tr>
                                                    <th>Checked By</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                        </table>
                                       
                                      </div>
                                      <div class="col-lg-6">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="20%">Prepared By</th>
                                                    <th>{{ $requisitionSlip[0]->created_by }}</th>
                                                </tr>
                                            </thead>
                                        </table>
                                       
                                      </div>
                                  </div>
                               </div>
                              
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