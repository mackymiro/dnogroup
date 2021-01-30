@extends('layouts.wimpys-food-express-app')
@section('title', 'Client Booking Form |')
@section('content')
<script>
    $(function() {
        $( ".datepicker" ).datepicker();
    });
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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

            <div class="col-lg-12">
            <img src="{{ asset('images/digitized-logos/wimpys-logo1.jpg')}}" width="350" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
             	 
            		 
            	 <h4 class="text-center"><u>Client Booking Form</u></h4>
            </div>
            <div class="row">
                 <div class="col-lg-12">
                      <div class="card mb-3">
                             <div class="card-header">
                              <i class="fa fa-receipt" aria-hidden="true"></i>
                            Client Booking Form</div>
                          <div class="card-body">
                                <form action="{{ action('WimpysFoodExpressController@storeBookingForm') }}" method="post">
                                {{csrf_field()}}
                              <div class="form-group">
                                  <div class="form-row">
                                    <div class="col-lg-2">
                                      <label>Date of Event</label>
                                      <input type="text" name="dateOfEvent" class="datepicker form-control" required />
                                    </div>
                                    <div class="col-lg-2">
                                      <label>Time of Event</label>
                                      <input type="text" name="timeOfEvent" class="form-control" required />
                                    </div>
                                    <div class="col-lg-2">
                                      <label>No of People (PAX)</label>
                                      <input type="text" name="noOfPeople" class="form-control"  onkeypress="return isNumber(event)" required autocomplete="off"/>
                                    </div>
                                    <div class="col-lg-2">
                                      <label>Motiff</label>
                                      <input type="text" name="motiff" class="form-control"  required/>
                                    </div>
                                    <div class="col-lg-4">
                                      <label>Type of Package</label>
                                       <div id="app-package">
                                        <select name="package" class="form-control">
                                            <option value="0">--Please Select--</option>
                                            <option v-for="package in packages" v-bind:value="package.value">
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
                                      <input type="text" name="client" class="form-control" required/>
                                  </div>
                                  <div class="col-lg-4">
                                    <label>Place of Event</label>
                                    <input type="text" name="placeOfEvent" class="form-control" required />
                                   
                                  </div>
                                 
                                  <div class="col-lg-2">
                                    <label>Mobile Number</label>
                                    <input type="text" name="mobileNumber" class="form-control" required="required" />
                                    
                                  </div>
                                  <div class="col-lg-2">
                                    <label>Email Address</label>
                                    <input typeE="text" name="emailAddress" class="form-control"  />
                                    
                                  </div>            
                                </div>
                                <div class="form-group">
                                  <div class="form-row">
                                    <div class="col-lg-4">
                                      <label>Special Requests</label>
                                      <input typeE="text" name="specialRequests" class="form-control"  />
                                      
                                    </div>
                                  </div>
                                </div>
                              
                              </div>
                               <div>
                                <button type="submit" class="btn btn-success btn-lg float-right"><i class="fas fa-save"></i> Create Booking</button>
                                <br>
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
            { text:'EXECUTIVE SET - 600', value: 'EXECUTIVE SET - 600'}
          ]
      }
    })
</script>
<script>
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