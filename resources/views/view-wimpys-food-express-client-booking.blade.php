@extends('layouts.wimpys-food-express-app')
@section('title', 'View Client Booking |')
@section('content')
<div id="wrapper">
	<!-- Sidebar -->
    @include('sidebar.sidebar-wimpys-food-express')
    <div id="content-wrapper">
    	<div class="container-fluid">
    		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Wimpy's Food Express</a>
              </li>
              <li class="breadcrumb-item active">View Client Booking</li>
            </ol>
            <a href="{{ url('wimpys-food-express/client-booking-form/lists') }}">Back to Lists</a>
             <div class="col-lg-12">
             <img src="{{ asset('images/digitized-logos/wimpys-logo1.jpg')}}" width="350" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 <h4 class="text-center"><u>VIEW Client Booking</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                              <i class="fab fa-first-order" aria-hidden="true"></i>
                            View Client Booking
                            @if($viewClientBooking[0]->deleted_at == NULL)
                             <div class="float-right">
                                <a href="{{ action('WimpysFoodExpressController@printClientBooking', $viewClientBooking[0]->id)}}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                               
                              </div>
                            @endif
                        </div>
                        <div class="card-body">
                      
                            <div class="form-group">
                                <div class="form-row">
                                  <div class="col-lg-6">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="30%">Date of Event</th>
                                                <th>{{ $viewClientBooking[0]->date_of_event }}</th>
                                            </tr>
                                            <tr>
                                                <th>Time of Event</th>
                                                <th>{{ $viewClientBooking[0]->time_of_event }}</th>
                                            </tr>
                                            <tr>
                                                <th>No of People</th>
                                                <th>{{ $viewClientBooking[0]->no_of_people }}</th>
                                            </tr>
                                            <tr>
                                                <th>Motiff</th>
                                                <th>{{ $viewClientBooking[0]->motiff }}</th>
                                            </tr>
                                            <tr>
                                                <th>Type of Package</th>
                                                <th>{{ $viewClientBooking[0]->type_of_package }}</th>
                                            </tr>
                                        </thead>

                                    </table>
                                   
                                  </div>
                                  <div class="col-lg-6">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="40%">Client Booking No</th>
                                                <th>
                                                   @foreach($viewClientBooking[0]->client_bookings as $clientBooking)
                                                        @if($clientBooking->module_name === "Client Booking")          
                                                            {{ $clientBooking->module_code }} {{ $clientBooking->wimpys_food_express_code}}
                                                        @endif
                                                    @endforeach
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Client</th>
                                                <th> {{ $viewClientBooking[0]->client }}</th>
                                            </tr>
                                            <tr>
                                                <th>Place of Event</th>
                                                <th>{{ $viewClientBooking[0]->place_of_event }}</th>
                                            </tr>
                                            <tr>
                                                <th>Mobile Number</th>
                                                <th>{{ $viewClientBooking[0]->mobile_number }}</th>
                                            </tr>
                                            <tr>
                                                <th>Email Address</th>
                                                <th>{{ $viewClientBooking[0]->email }}</th>
                                            </tr>
                                            <tr>
                                                <th>Special Requests</th>
                                                <th>{{ $viewClientBooking[0]->special_requests }}</th>
                                            </tr>
                                        </thead>
                                    </table>
                                   
                                  </div>
                                </div>
                               </div>
                               <table class="table table-striped">
                                  <thead>
                                    <tr>
                                      <th colspan="2" class="bg-info" style="color:white;">MENU</th>
                                     
                                    </tr>
                                  </thead>
                                  <tbody>
                                      <tr>
                                          <th style="width:20%">Soup</th>
                                          <td>
                                             @foreach($getMenuItems as $getMenuItem)
                                              @if($getMenuItem['menu_cat'] === "Soup")
                                                <p >{{ $getMenuItem['menu']}} </p>
                                              @endif
                                              @endforeach
                                          </td>
                                          
                                        </tr>
                                        <tr>
                                          <th style="width:20%">Salad</th>
                                          <td>
                                              @foreach($getMenuItems as $getMenuItem)
                                              @if($getMenuItem['menu_cat'] === "Salad")
                                                <p >{{ $getMenuItem['menu']}} </p>
                                              @endif
                                            @endforeach
                                          </td>
                                          
                                        </tr>
                                        <tr>
                                          <th style="width:20%">Entrees</th>
                                          <td>
                                            @foreach($getMenuItems as $getMenuItem)
                                              @if($getMenuItem['menu_cat'] === "Entrees")
                                                <p >{{ $getMenuItem['menu']}} </p>
                                              @endif
                                            @endforeach
                                          </td>
                                          
                                        </tr>
                                        <tr>
                                          <th style="width:20%">Vegetables</th>
                                          <td>
                                              @foreach($getMenuItems as $getMenuItem)
                                              @if($getMenuItem['menu_cat'] === "Vegetables")
                                                <p >{{ $getMenuItem['menu']}} </p>
                                              @endif
                                            @endforeach
                                          </td>
                                          
                                        </tr>
                                        <tr>
                                          <th style="width:20%">Noodles</th>
                                          <td>
                                             @foreach($getMenuItems as $getMenuItem)
                                              @if($getMenuItem['menu_cat'] === "Noodles")
                                                <p >{{ $getMenuItem['menu']}} </p>
                                              @endif
                                            @endforeach
                                          </td>
                                          
                                        </tr>
                                        <tr>
                                          <th style="width:20%">Rice</th>
                                          <td>
                                              @foreach($getMenuItems as $getMenuItem)
                                              @if($getMenuItem['menu_cat'] == "Rice")
                                                <p>{{ $getMenuItem['menu']}} </p>
                                              @endif
                                            @endforeach
                                          </td>
                                          
                                        </tr>
                                        <tr>
                                          <th style="width:20%">Dessert</th>
                                          <td>
                                            @foreach($getMenuItems as $getMenuItem)
                                              @if($getMenuItem['menu_cat'] == "Dessert")
                                                <p >{{ $getMenuItem['menu']}}</p>
                                              @endif
                                            @endforeach
                                          </td>
                                          
                                        </tr>
                                        <tr>
                                          <th style="width:20%">Drinks</th>
                                          <td>
                                              @foreach($getMenuItems as $getMenuItem)
                                              @if($getMenuItem['menu_cat'] == "Drinks")
                                                <p >{{ $getMenuItem['menu']}} </p>
                                              @endif
                                            @endforeach
                                          </td>
                                          
                                        </tr>
                                        <tr>
                                          <th style="width:20%">Additional Orders</th>
                                          <td>
                                              @foreach($getMenuItems as $getMenuItem)
                                              @if($getMenuItem['menu_cat'] == "Additional Orders")
                                                <p >{{ $getMenuItem['menu']}}</p>
                                              @endif
                                            @endforeach
                                          </td>
                                          
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