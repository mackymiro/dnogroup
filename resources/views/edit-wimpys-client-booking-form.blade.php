@extends('layouts.wimpys-food-express-app')
@section('title', 'Client Booking Form |')
@section('content')
<script>
    $(function() {
        $( ".datepicker" ).datepicker();
    });
</script>
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css" >
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

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
              <li class="breadcrumb-item active">Client Booking Form</li>
            </ol>
            <a href="{{ url('/wimpys-food-express/client-booking-form/lists') }}">Back to Lists</a>
            <div class="col-lg-12">
            <img src="{{ asset('images/digitized-logos/wimpys-logo1.jpg')}}" width="350" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
             	 
            		 
            	 <h4 class="text-center"><u>Edit Client Booking Form</u></h4>
            </div>
            <div class="row">
                 <div class="col-lg-12">
                      <div class="card mb-3">
                             <div class="card-header">
                              <i class="fa fa-receipt" aria-hidden="true"></i>
                            Client Booking Form</div>
                          <div class="card-body">
                               @if(session('updateItem'))
	                               <p class="alert alert-success">{{ Session::get('updateItem') }}</p>
	                              @endif 
                                <form action="{{ action('WimpysFoodExpressController@updateClientBooking', $menuItem->id ) }}" method="post">
                                {{csrf_field()}}
                                <input name="_method" type="hidden" value="PUT">
                              <div class="form-group">
                                  <div class="form-row">
                                    <div class="col-lg-2">
                                      <label>Date of Event</label>
                                      <input type="text" name="dateOfEvent" class="datepicker form-control" value="{{ $menuItem->date_of_event}}" />
                                    </div>
                                    <div class="col-lg-2">
                                      <label>Time of Event</label>
                                      <input type="text" name="timeOfEvent" class="form-control" value="{{ $menuItem->time_of_event }}" />
                                    </div>
                                    <div class="col-lg-2">
                                      <label>No of People (PAX)</label>
                                      <input type="text" name="noOfPeople" class="form-control"  value="{{ $menuItem->no_of_people }}"  onkeypress="return isNumber(event)" autocomplete="off" />
                                    </div>
                                    <div class="col-lg-2">
                                      <label>Motiff</label>
                                      <input type="text" name="motiff" class="form-control"  value="{{ $menuItem->motiff }}" />
                                    </div>
                                    <div class="col-lg-4">
                                      <label>Type of Package</label>
                                       <div id="app-package">
                                        <select name="package" class="form-control">
                                            <option value="0">--Please Select--</option>
                                            <option v-for="package in packages" v-bind:value="package.value"
                                            :selected="package.value=={{json_encode($menuItem->type_of_package)}}?true : false">
                                                @{{ package.text }}
                                            </option>
                                        </select>
                                      </div>
                                    </div>
                                
                                  </div>
                              </div>
                              <div class="form-group">
                                <div class="form-row">
                                  <div class="col-lg-4">
                                      <label>Client</label>
                                      <input type="text" name="client" class="form-control" value="{{ $menuItem->client }}"/>
                                  </div>
                                  <div class="col-lg-4">
                                    <label>Place of Event</label>
                                    <input type="text" name="placeOfEvent" class="form-control" value="{{ $menuItem->place_of_event }}" />
                                   
                                  </div>
                                 
                                  <div class="col-lg-2">
                                    <label>Mobile Number</label>
                                    <input type="text" name="mobileNumber" class="form-control" value="{{ $menuItem->mobile_number }}" />
                                    
                                  </div>
                                  <div class="col-lg-2">
                                    <label>Email Address</label>
                                    <input typeE="text" name="emailAddress" class="form-control" value="{{ $menuItem->email }}" />
                                    
                                  </div>            
                                </div>
                                <div class="form-group">
                                  <div class="form-row">
                                    <div class="col-lg-4">
                                      <label>Special Requests</label>
                                      <input typeE="text" name="specialRequests" class="form-control"  value="{{ $menuItem->special_requests }}"/>
                                      
                                    </div>
                                    <div class="col-lg-4">
                                      <label>Total Amount</label>
                                      <input typeE="text" name="totalAmount" class="form-control bg-success" style="color:white;" disabled value="<?= number_format($menuItem->total, 2)?>"/>
                                      
                                    </div>
                                  </div>
                                </div>
                              
                              </div>
                                <div>
                                <button type="submit" class="btn btn-success btn-lg float-right"><i class="fas fa-resf"></i> Update Booking</button>
                                <br>
                                </div>
                              </form>
                          </div>
                      </div>  
                 </div>
               
                
            </div>
            <div class="row">
                 <div class="col-lg-4">
                     @if($menuItem->type_of_package != "Cooking Charge - 0.00" && $menuItem->type_of_package != "Staff Meals - 0.00")
                      <div class="card mb-3">
                            <div class="card-header">
                            <i class="fas fa-soup"></i>
                              Soup</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                            <form action="{{ action('WimpysFoodExpressController@addItem', $menuItem->id)}}" method="post">
                                            {{csrf_field()}}
                                            <select data-live-search="true"  name="entrees" class="selectpicker form-control">
                                                @foreach($menuLists as $menuList)
                                                @if($menuList['category'] === "Soup")
                                                <option value="{{ $menuList['name'] }}">{{ $menuList['name']}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                            <br>
                                            <br>
                                            	<div>
                                                <input type="hidden" name="menuCat" value="Soup" />
                                                <button type="submit" class="btn btn-primary btn-lg float-right">Add</button>
                                              
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                      </div>
                      <div class="card mb-3">
                            <div class="card-header">
                            <i class="fas fa-soup"></i>
                              Salad</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                           <form action="{{ action('WimpysFoodExpressController@addItem', $menuItem->id)}}" method="post">
                                            {{csrf_field()}}
                                            <select data-live-search="true"  name="entrees" class="selectpicker form-control">
                                                @foreach($menuLists as $menuList)
                                                @if($menuList['category'] === "Salads")
                                                  <option value="{{ $menuList['name'] }}">{{ $menuList['name']}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                            <br>
                                            <br>
                                            	<div>
                                                <input type="hidden" name="menuCat" value="Salad" />
                                                <button type="submit" class="btn btn-primary btn-lg float-right">Add</button>
                                              
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                      </div>
                      <div class="card mb-3">
                            <div class="card-header">
                            <i class="fas fa-soup"></i>
                              Entrees</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        
                                        <div class="col-lg-12">
                                            <form action="{{ action('WimpysFoodExpressController@addItem', $menuItem->id)}}" method="post">
                                            {{csrf_field()}}
                                            <select data-live-search="true"  name="entrees" class="selectpicker form-control">
                                                @foreach($menuLists as $menuList)
                                                <option value="{{ $menuList['name'] }}">{{ $menuList['name']}}</option>
                                                @endforeach
                                            </select>
                                            <br>
                                            <br>
                                            	<div>
                                                <input type="hidden" name="menuCat" value="Entrees" />
                                                <button type="submit" class="btn btn-primary btn-lg float-right">Add</button>
                                              
                                            </div>
                                            </form>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                      </div>
                      <div class="card mb-3">
                            <div class="card-header">
                            <i class="fas fa-soup"></i>
                              Vegetables</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                            <form action="{{ action('WimpysFoodExpressController@addItem', $menuItem->id)}}" method="post">
                                            {{csrf_field()}}
                                            <select data-live-search="true"  name="entrees" class="selectpicker form-control">
                                                @foreach($menuLists as $menuList)
                                                @if($menuList['category'] === "Vegetables")
                                                  <option value="{{ $menuList['name'] }}">{{ $menuList['name']}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                            <br>
                                            <br>
                                            	<div>
                                                <input type="hidden" name="menuCat" value="Vegetables" />
                                                <button type="submit" class="btn btn-primary btn-lg float-right">Add</button>
                                              
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                      </div>
                      <div class="card mb-3">
                            <div class="card-header">
                            <i class="fas fa-soup"></i>
                              Noodles</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                            <form action="{{ action('WimpysFoodExpressController@addItem', $menuItem->id)}}" method="post">
                                            {{csrf_field()}}
                                            <select data-live-search="true"  name="entrees" class="selectpicker form-control">
                                                @foreach($menuLists as $menuList)
                                                @if($menuList['category'] === "Noodles")
                                                  <option value="{{ $menuList['name'] }}">{{ $menuList['name']}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                            <br>
                                            <br>
                                            	<div>
                                                <input type="hidden" name="menuCat" value="Noodles" />
                                                <button type="submit" class="btn btn-primary btn-lg float-right">Add</button>
                                              
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                      </div>
                      <div class="card mb-3">
                            <div class="card-header">
                            <i class="fas fa-soup"></i>
                              Rice</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                            <form action="{{ action('WimpysFoodExpressController@addItem', $menuItem->id)}}" method="post">
                                            {{csrf_field()}}
                                            <select data-live-search="true"  name="entrees" class="selectpicker form-control">
                                                @foreach($menuLists as $menuList)
                                                @if($menuList['category'] === "Rice")
                                                  <option value="{{ $menuList['name'] }}">{{ $menuList['name']}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                            <br>
                                            <br>
                                            	<div>
                                                <input type="hidden" name="menuCat" value="Rice" />
                                                <button type="submit" class="btn btn-primary btn-lg float-right">Add</button>
                                              
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                      </div>
                      <div class="card mb-3">
                            <div class="card-header">
                            <i class="fas fa-soup"></i>
                              Dessert</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                             <form action="{{ action('WimpysFoodExpressController@addItem', $menuItem->id)}}" method="post">
                                            {{csrf_field()}}
                                            <select data-live-search="true"  name="entrees" class="selectpicker form-control">
                                                @foreach($menuLists as $menuList)
                                                @if($menuList['category'] === "Desserts")
                                                  <option value="{{ $menuList['name'] }}">{{ $menuList['name']}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                            <br>
                                            <br>
                                            	<div>
                                                <input type="hidden" name="menuCat" value="Dessert" />
                                                <button type="submit" class="btn btn-primary btn-lg float-right">Add</button>
                                              
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                      </div>
                      <div class="card mb-3">
                            <div class="card-header">
                            <i class="fas fa-soup"></i>
                              Drinks</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                         <form action="{{ action('WimpysFoodExpressController@addItem', $menuItem->id)}}" method="post">
                                            {{csrf_field()}}
                                            <select data-live-search="true"  name="entrees" class="selectpicker form-control">
                                                @foreach($menuLists as $menuList)
                                                @if($menuList['category'] === "Drinks")
                                                <option value="{{ $menuList['name'] }}">{{ $menuList['name']}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                            <br>
                                            <br>
                                            	<div>
                                                <input type="hidden" name="menuCat" value="Drinks" />
                                                <button type="submit" class="btn btn-primary btn-lg float-right">Add</button>
                                              
                                            </div>
                                            </form>
                                         </div>
                                    </div>
                                </div>
                            </div>
                      </div>

                      @endif
                      @if($menuItem->type_of_package != "Cooking Charge - 0.00" && $menuItem->type_of_package != "Staff Meals - 0.00")
                      <div class="card mb-3">
                            <div class="card-header">
                            <i class="fas fa-soup"></i>
                              Additional Orders</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                           <form action="{{ action('WimpysFoodExpressController@addItem', $menuItem->id)}}" method="post">
                                            {{csrf_field()}}
                                            <label>Qty</label>
                                            <input type="text" name="qty" class="form-control"  onkeypress="return isNumber(event)" autocomplete="off"/>
                                            <br>
                                            <label>Amount</label>
                                            <input type="text" name="amount" class="form-control" onkeypress="return isNumber(event)" autocomplete="off" />
                                            <br>
                                            <select data-live-search="true"  name="entrees" class="selectpicker form-control">
                                               
                                               @foreach($menuLists as $menuList)
                                                <option value="{{ $menuList['name'] }}">{{ $menuList['name']}}</option>
                                               
                                                @endforeach
                                            </select>
                                            <br>
                                            <br>
                                            	<div>
                                                <input type="hidden" name="menuCat" value="Additional Order" />
                                                <input type="hidden" name="menuId" value="{{ $menuItem->id }}" />
                                                <button type="submit" class="btn btn-primary btn-lg float-right">Add</button>
                                              
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                      </div>
                      @endif
                      @if($menuItem->type_of_package == "Cooking Charge - 0.00" || $menuItem->type_of_package == "Staff Meals - 0.00")
                      <div class="card mb-3" >
                          <div class="card-header">
                              <i class="fas fa-soup"></i>
                                Additional Orders
                           </div>
                           <div class="card-body">
                              <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                           <form action="{{ action('WimpysFoodExpressController@addItemCookingCharge', $menuItem->id)}}" method="post">
                                            {{csrf_field()}}
                                            <label>Qty</label>
                                            <input type="text" name="qty" class="form-control"  onkeypress="return isNumber(event)" autocomplete="off"/>
                                            <br>
                                            
                                            <label>Item</label>
                                            <input type="text" name="item" class="form-control"  autocomplete="off" />
                                            <br>
                                            <label>Amount</label>
                                            <input type="text" name="amount" class="form-control" onkeypress="return isNumber(event)" autocomplete="off" />
                                           
                                            <br>
                                            <br>
                                            	<div>
                                                
                                                <input type="hidden" name="menuId" value="{{ $menuItem->id }}" />
                                                <button type="submit" class="btn btn-primary btn-lg float-right">Add</button>
                                              
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                           </div>
                      </div>
                      <div class="card mb-3" >
                          <div class="card-header">
                              <i class="fas fa-soup"></i>
                                Amount
                           </div>
                           <div class="card-body">
                              <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                           <form action="{{ action('WimpysFoodExpressController@addItemCookingCharge', $menuItem->id)}}" method="post">
                                            {{csrf_field()}}
                                            <label>Description</label>
                                            <input type="text" name="description" class="form-control" autocomplete="off" required/>
                                           
                                            <br>
                                            <label>Less</label>
                                            <input type="text" name="less" class="form-control"  onkeypress="return isNumber(event)" autocomplete="off" required/>
                                           
                                            <br>
                                            	<div>
                                                <input type="hidden" name="menuCat" value="lessAmount" />
                                                <input type="hidden" name="menuId" value="{{ $menuItem->id }}" />
                                                <button type="submit" class="btn btn-primary btn-lg float-right">Add</button>
                                              
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                           </div>
                      </div>
                      @endif
                 </div>
                 
                 <div class="col-lg-8">
                      @if($menuItem->type_of_package != "Cooking Charge - 0.00" &&  $menuItem->type_of_package != "Staff Meals - 0.00")
                      <div class="card mb-3">
                            <div class="card-header">
                            <i class="fas fa-hamburger"></i>
                              Menu</div>
                            <div class="card-body">
                                @if(session('addItem'))
	                               <p class="alert alert-success">{{ Session::get('addItem') }}</p>
	                              @endif 
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                          <th style="width:20%">Soup</th>
                                          <td>
                                              @foreach($getMenuItems as $getMenuItem)
                                              @if($getMenuItem['menu_cat'] === "Soup")
                                                <p id="deletedId<?= $getMenuItem['id']?>">{{ $getMenuItem['menu']}} <a href="javascript:void" onclick="confirmDelete('{{ $getMenuItem['id']}}')"><i class="fas fa-times-circle" style="font-size:20px;"></i></a></p>
                                              @endif
                                              @endforeach
                                          </td>
                                          
                                        </tr>
                                        <tr>
                                          <th style="width:20%">Salad</th>
                                          <td>
                                              @foreach($getMenuItems as $getMenuItem)
                                              @if($getMenuItem['menu_cat'] === "Salad")
                                                <p id="deletedId<?= $getMenuItem['id']?>">{{ $getMenuItem['menu']}} <a href="javascript:void" onclick="confirmDelete('{{ $getMenuItem['id']}}')"><i class="fas fa-times-circle" style="font-size:20px;"></i></a></p>
                                              @endif
                                            @endforeach
                                          </td>
                                          
                                        </tr>
                                        <tr>
                                          <th style="width:20%">Entrees</th>
                                          <td>
                                            @foreach($getMenuItems as $getMenuItem)
                                              @if($getMenuItem['menu_cat'] === "Entrees")
                                                <p id="deletedId<?= $getMenuItem['id']?>">{{ $getMenuItem['menu']}} <a href="javascript:void" onclick="confirmDelete('{{ $getMenuItem['id']}}')"><i class="fas fa-times-circle" style="font-size:20px;"></i></a></p>
                                              @endif
                                            @endforeach
                                          </td>
                                          
                                        </tr>
                                        <tr>
                                          <th style="width:20%">Vegetables</th>
                                          <td>
                                              @foreach($getMenuItems as $getMenuItem)
                                              @if($getMenuItem['menu_cat'] === "Vegetables")
                                                <p id="deletedId<?= $getMenuItem['id']?>">{{ $getMenuItem['menu']}} <a href="javascript:void" onclick="confirmDelete('{{ $getMenuItem['id']}}')"><i class="fas fa-times-circle" style="font-size:20px;"></i></a></p>
                                              @endif
                                            @endforeach
                                          </td>
                                          
                                        </tr>
                                        <tr>
                                          <th style="width:20%">Noodles</th>
                                          <td>
                                             @foreach($getMenuItems as $getMenuItem)
                                              @if($getMenuItem['menu_cat'] === "Noodles")
                                                <p id="deletedId<?= $getMenuItem['id']?>">{{ $getMenuItem['menu']}} <a href="javascript:void" onclick="confirmDelete('{{ $getMenuItem['id']}}')"><i class="fas fa-times-circle" style="font-size:20px;"></i></a></p>
                                              @endif
                                            @endforeach
                                          </td>
                                          
                                        </tr>
                                        <tr>
                                          <th style="width:20%">Rice</th>
                                          <td>
                                              @foreach($getMenuItems as $getMenuItem)
                                              @if($getMenuItem['menu_cat'] == "Rice")
                                                <p id="deletedId<?= $getMenuItem['id']?>">{{ $getMenuItem['menu']}} <a href="javascript:void" onclick="confirmDelete('{{ $getMenuItem['id']}}')"><i class="fas fa-times-circle" style="font-size:20px;"></i></a></p>
                                              @endif
                                            @endforeach
                                          </td>
                                          
                                        </tr>
                                        <tr>
                                          <th style="width:20%">Dessert</th>
                                          <td>
                                            @foreach($getMenuItems as $getMenuItem)
                                              @if($getMenuItem['menu_cat'] == "Dessert")
                                                <p id="deletedId<?= $getMenuItem['id']?>">{{ $getMenuItem['menu']}} <a href="javascript:void" onclick="confirmDelete('{{ $getMenuItem['id']}}')"><i class="fas fa-times-circle" style="font-size:20px;"></i></a></p>
                                              @endif
                                            @endforeach
                                          </td>
                                          
                                        </tr>
                                        <tr>
                                          <th style="width:20%">Drinks</th>
                                          <td>
                                              @foreach($getMenuItems as $getMenuItem)
                                              @if($getMenuItem['menu_cat'] == "Drinks")
                                                <p id="deletedId<?= $getMenuItem['id']?>">{{ $getMenuItem['menu']}} <a href="javascript:void" onclick="confirmDelete('{{ $getMenuItem['id']}}')"><i class="fas fa-times-circle" style="font-size:20px;"></i></a></p>
                                              @endif
                                            @endforeach
                                          </td>
                                          
                                        </tr>
                                        <tr>
                                          <th style="width:20%">Additional Orders</th>
                                          <td>
                                              @foreach($getMenuItems as $getMenuItem)
                                              @if($getMenuItem['menu_cat'] == "Additional Order")
                                                <p id="deletedId<?= $getMenuItem['id']?>">
                                                  {{ $getMenuItem['menu']}} , 
                                                  Qty - {{ $getMenuItem['qty']}}, 
                                                  Amount - {{ $getMenuItem['amount']}} <a href="javascript:void" onclick="confirmDelete('{{ $getMenuItem['id']}}')"><i class="fas fa-times-circle" style="font-size:20px;"></i></a></p>
                                              @endif
                                            @endforeach
                                          </td>
                                          <input type="hidden" id="menuId" name="menuId" value="{{ $menuItem->id }}" />
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                      </div>
                      @endif
                      @if($menuItem->type_of_package == "Cooking Charge - 0.00" || $menuItem->type_of_package == "Staff Meals - 0.00")
                      <div class="card mb-3">
                            <div class="card-header">
                            <i class="fas fa-hamburger"></i>
                              Menu</div>
                            <div class="card-body">
                               @foreach($getMenuItems as $getMenuItem)
                                <p id="deletedId{{ $getMenuItem['id'] }}">
                                  Qty-{{ $getMenuItem['qty']}}, {{ $getMenuItem['item'] }},
                                  Amount - {{ $getMenuItem['amount']}} 
                                  <a href="javascript:void" onclick="confirmDelete('{{ $getMenuItem['id']}}')"><i class="fas fa-times-circle" style="font-size:20px;"></i></a>
                                  <input type="hidden" id="menuId" name="menuId" value="{{ $menuItem->id }}" />
                                </p>
                                @endforeach
                            </div>
                      </div>
                      <div class="card mb-3">
                            <div class="card-header">
                            <i class="fas fa-receipt"></i>
                              Amount</div>
                            <div class="card-body">
                            <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                          <th style="width:20%">Total</th>
                                          <td>
                                             <?= number_format($menuItem->total, 2)?> 
                                          </td>
                                          
                                        </tr>
                                        <tr>
                                          <th style="width:20%">Less</th>
                                          <td>  
                                          {{ $menuItem->description }} - 
                                          <?= number_format($menuItem->less, 2)?> 
                                          </td>
                                          
                                        </tr>
                                        <tr>
                                          <th style="width:20%">Balance</th>
                                          <?php
                                            $total = $menuItem->total - $menuItem->less;
                                          ?>
                                          <td>
                                             <?= number_format($total, 2) ?>
                                          </td>
                                          
                                        </tr>
                                     
                                       
                                    </thead>
                                </table>
                            </div>
                      </div>
                      @endif
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
    <!-- /.content-wrapper -->
</div>
<script>
    new Vue({
      el: "#app-package",
      data: {
      packages:[
            { text:'SET A - 300', value: 'SET A - 300' },
            { text:'SET B - 350', value: 'SET B - 350' },
            { text:'SET C - 400', value: 'SET C - 400'},
            { text:'EXECUTIVE SET - 600', value: 'EXECUTIVE SET - 600'},
            { text:'Cooking Charge - 0.00', value: 'Cooking Charge - 0.00'},
            { text:'Staff Meals - 0.00', value: 'Staff Meals - 0.00'},
            { text:'Packed Meals - 210.00', value: 'Packed Meals - 210.00'},
          ]
      }
    })
</script>
<script>
 

  const confirmDelete = (id) =>{
    const x = confirm("Do you want to delete this?"); 
    const menuId = $("#menuId").val();

    if(x){
      $.ajax({
          type: "DELETE",
          url: '/wimpys-food-express/delete-client-booking/' + id,
          data:{
            _method: 'delete', 
            "_token": "{{ csrf_token() }}",
            "id": id,
            "menuId":menuId,
          },
          success: function(data){
            console.log(data);
            $("#deletedId"+id).fadeOut('slow');
            
          },
          error: function(data){
            console.log('Error:', data);
          }

        });

    }else{
      return false;
    }


  }

  const isNumber =(evt) => {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
          return false;
        }
        return true;
      }
      
</script>
@endsection