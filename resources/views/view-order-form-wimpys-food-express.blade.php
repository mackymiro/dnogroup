@extends('layouts.wimpys-food-express-app')
@section('title', 'View Order Form |')
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
              <li class="breadcrumb-item active">View Order Form</li>
            </ol>
              <a href="{{ url('wimpys-food-express/order-form/lists') }}">Back to Lists</a>
          	<div class="col-lg-12">
              <img src="{{ asset('images/digitized-logos/wimpys-logo1.jpg')}}" width="350" height="178" class="img-responsive mx-auto d-block" alt="Wimpy's Food Express">
            		 	  
            	 <h4 class="text-center"><u>VIEW ORDER FORM</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            View Order Form
                            <div class="float-right">
                               <a href="{{ action('WimpysFoodExpressController@printOrderForm', $viewOrder[0]->id)}}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                             </div>
                        </div>
                        <div class="card-body">
                      
                             <div class="form-group">
                                <div class="form-row">
                                  <div class="col-lg-6">
                                    <table class="table table-bordered">  
                                        <thead>
                                            <tr>
                                                <th width="30%">Date</th>
                                                <th>{{ $viewOrder[0]->date}}</th>
                                            </tr>
                                            <tr>
                                                <th>Time</th>
                                                <th>{{ $viewOrder[0]->time}}</th>
                                            </tr>
                                            <tr>
                                                <th>No of people</th>
                                                <th>{{ $viewOrder[0]->no_of_people}}</th>
                                            </tr>
                                          
                                        </thead>
                                    </table>
                                  
                                  </div>
                                  <div class="col-lg-6">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="30%">Order Form #</th>
                                                <th>
                                                  {{ $viewOrder[0]->module_code}}{{ $viewOrder[0]->wimpys_food_express_code}}
                                                </th>
                                            </tr>
                                           
                                           
                                        </thead>

                                    </table>
                        
                                  </div>
                                </div>
                                </div>
                                <table class="table table-striped">
                                    <thead>
                                      <tr>
                                        <th class="bg-info" style="color:white;">ITEMS</th>
                                        <th class="bg-info" style="color:white;">QUANTITY</th>
                                        <th class="bg-info" style="color:white;">UNIT</th>
                                        <th class="bg-info" style="color:white;">PRICE</th>
                                        <th class="bg-info" style="color:white;">TOTAL</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                     
                                      <tr>
                                        <td>{{ $viewOrder[0]->items}}</td>
                                        <td>{{ $viewOrder[0]->qty}}</td>
                                        <td>{{ $viewOrder[0]->unit}}</td>
                                        <td><?= number_format($viewOrder[0]->price, 2)?></td>
                                        <td><?= number_format($viewOrder[0]->total, 2)?></td>
                                       
                                      </tr>
                                      @foreach($viewOtherOrders as $viewOtherOrder)
                                      <tr>
                                          <td>{{ $viewOtherOrder['items'] }}</td>
                                          <td>{{ $viewOtherOrder['qty'] }}</td>
                                          <td>{{ $viewOtherOrder['unit']}}</td>
                                          <td><?= number_format($viewOtherOrder['price'], 2)?></td>
                                        <td><?= number_format($viewOtherOrder['total'], 2)?></td>
                                      </tr>
                                      @endforeach
                                      <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><strong>Total</strong></td>
                                        <td><?= number_format($sum, 2)?></td>
                                      </tr>
                                    </tbody>
                              </table>
                               <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Ordered By</th>
                                                        <th>Note By</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $viewOrder[0]->ordered_by }}</td>
                                                        <td>{{ $viewOrder[0]->noted_by }}</td>
                                                    </tr>
                                                </tbody>
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