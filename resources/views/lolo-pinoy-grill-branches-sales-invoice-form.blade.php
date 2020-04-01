@extends('layouts.lolo-pinoy-grill-branches-app')
@section('title', 'Sales Invoice Form| ')
@section('content')
<div id="wrapper">
	<!-- Sidebar -->
     @include('sidebar.sidebar-lolo-pinoy-grill-branches')
     <div id="content-wrapper">
     	<div class="container-fluid">
     		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lolo Pinoy Grill Bracnhes</a>
              </li>
              <li class="breadcrumb-item active">Sales Invoice Form</li>
            </ol>
            <div class="col-lg-12">
            	<img src="{{ asset('images/lolo-pinoy-grill.jpeg')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lolo Pinoy Grill ">
            	 
            	 <h4 class="text-center"><u>SALES INVOICE FORM</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="card-header">
                             <i class="fas fa-utensils"></i>
                            Menu </div>
                          <div class="card-body">
                              <div class="form-group">
                                  <div class="form-row">
                                     <div class="col-lg-4">
                                         <label>Menu</label>
                                         <button type="button" class="btn btn-primary btn-lg">PORK REGULAR BBQ 30.00</button>
                                         <br>
                                         <br>
                                         <button type="button" class="btn btn-primary btn-lg">BEEF BBQ ₱ 50.00</button>
                                         <br>
                                         <br>
                                         <button type="button" class="btn btn-primary btn-lg">CHICKEN BBQ B&W ₱ 70.00</button>
                                         <br>
                                         <br>
                                         <button type="button" class="btn btn-primary btn-lg">CHICKEN BBQ Q- LEG ₱ 70.00</button>
                                         <br>
                                         <br>
                                         <button type="button" class="btn btn-primary btn-lg">CHICKEN PECHO  ₱ 70.00</button>
                                         <br>
                                         <br>
                                         <button type="button" class="btn btn-primary btn-lg">CHORIZO  ₱ 30.00</button>
                                         <br>
                                         <br>
                                         <button type="button" class="btn btn-primary btn-lg">PORK JUMBO BBQ  ₱ 40.00</button>
                                         <br>
                                         <br>
                                         <button type="button" class="btn btn-primary btn-lg">DINUGUAN ₱ 77.00</button>
                                         <br>
                                         <br>
                                         <button type="button" class="btn btn-primary btn-lg">LECHON SISIG ₱ 177.00</button>
                                        <br>
                                         <br>
                                         <button type="button" class="btn btn-primary btn-lg">ICE CREAM ₱ 20.00</button>
                                         <br>
                                         <br>
                                         <button type="button" class="btn btn-primary btn-lg">POSO ₱ 10.00</button>
                                     </div>

                                    
                                  </div>
                              </div>
                          </div>  
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-3">
                        <div class="card-header">
                              <i class="fas fa-cash-register" aria-hidden="true"></i>
                            Sales Invoice Form</div>
                             <div class="card-body">
                                
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-2">
                                            <label>Order Slip No</label>
                                            <input type="text" name="orderSlipNo" class="form-control" />
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Ordered By</label>
                                            <div id="app-order">
                                            <select name="orderedBy" class="form-control">
                                                <option value="0">--Please Select--</option>
                                                <option v-for="order in orders" v-bind:value="order.value">
                                                    @{{ order.text }}
                                                </option>
                                            </select> 
                                        </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Table #</label>
                                            <input type="text" name="tableNum" class="form-control" />
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
<script >
   //qty
   new Vue({
    el: '#app-qty',
        data: {
            qauntities:[
                { text:'1', value: '1' },
                { text:'2', value: '2' },
                { text:'3', value: '3' },
                { text:'4', value: '4' }
            ]
        }
    }) 

    //Menu
   new Vue({
    el: '#app-menu',
        data: {
            menus:[
                { text:'PORK REGULAR BBQ', value: 'PORK REGULAR BBQ' },
                { text:'BEEF BBQ', value: 'BEEF BBQ' },
                { text:'CHICKEN BBQ B&W', value: 'CHICKEN BBQ B&W' },
                { text:'CHICKEN BBQ Q-LEG', value: 'CHICKEN BBQ Q-LEG' },
                { text:'CHICKEN PECHO', value:'CHICKEN PECHO'},
                { text:'CHORIZO', value:'CHORIZO'},
                { text:'PORK JUMBO BBQ', value:'PORK JUMBO BBQ'},
                { text:'DINUGUAN', value:'DINUGUAN'}
            ]
        }
    }) 

     //Order By
   new Vue({
    el: '#app-order',
        data: {
            orders:[
                { text:'DINE-IN', value: 'DINE-IN' },
                { text:'PRIVATE', value: 'PRIVATE' },
                { text:'TAKE-OUT', value: 'TAKE-OUT'},
                { text:'STAFF MEAL', value: 'STAFF MEAL'}
            ]
        }
    }) 
</script>
@endsection