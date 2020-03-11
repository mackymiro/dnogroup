@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'Billing Statement Form |')
@section('content')
<div id="wrapper">
	<!-- Sidebar -->
    @include('sidebar.sidebar-lolo-pinoy-grill')
    <div id="content-wrapper">
    	<div class="container-fluid">
    		 	<!-- Breadcrumbs-->
	            <ol class="breadcrumb">
	              <li class="breadcrumb-item">
	                <a href="#">Lolo Pinoy Grill Commissary</a>
	              </li>
	              <li class="breadcrumb-item active">Billing Statement Form</li>
	            </ol>
	            <div class="col-lg-12">
            	  <img src="{{ asset('images/lolo-pinoy-grill.jpeg')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lolo Pinoy Grill ">
            	 
            	 <h4 class="text-center"><u>BILLING STATEMENT</u></h4>
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