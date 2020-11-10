@extends('layouts.wimpys-food-express-app')
@section('title', 'Order Form |')
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
      <form action="{{ action('WimpysFoodExpressController@storeBillingStatement') }}" method="post">
          {{csrf_field()}}
    	<div class="container-fluid">
    		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Wimpy's Food Express</a>
              </li>
              <li class="breadcrumb-item active">Order Form</li>
            </ol>
            <div class="col-lg-12">
            <img src="{{ asset('images/digitized-logos/wimpys-logo1.jpg')}}" width="350" height="178" class="img-responsive mx-auto d-block" alt="Wimpy's Food Express">
            	 
             
            	 <h4 class="text-center"><u>Order Form</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            Order Form</div>
                          <div class="card-body">
                          <div class="form-group">
                              <div class="form-row">
                                    <div class="col-lg-12">
                                         <!-- Button trigger modal -->
                                        <a data-toggle="modal" data-target="exampleModalCenter" href="#" title="Edit" class="btn btn-primary btn-lg">KITCHEN</a>
                                        <!-- Button trigger modal -->
                                        <a data-toggle="modal" data-target="" href="#" title="Edit" class="btn btn-primary btn-lg">DESSERT</a>
                                        <a data-toggle="modal" data-target="" href="#" title="Edit" class="btn btn-primary btn-lg">DECOR</a>
                                        <a data-toggle="modal" data-target="" href="#" title="Edit" class="btn btn-primary btn-lg">EQUIPMENT & SUPPLIES</a>
									
                                    </div>
                                  	
                                </div>
                          </div>

                        <div class="form-group">
                            <div class="form-row">
            	 					
                                      
                      
                                <br>
                              <div>
                                <button type="submit" class="btn btn-success btn-lg float-right"><i class="fas fa-save"></i> Save Order Form</button>
                              </div>
                    	 		</div>
                          </div>
                    </div>
                </div>
            </div>
            
           
    	</div>
     </form>  
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            ...
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
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