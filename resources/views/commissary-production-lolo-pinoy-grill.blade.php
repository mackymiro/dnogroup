@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'Production |')
@section('content')

<div id="wrapper">
	 @include('sidebar.sidebar-lolo-pinoy-grill')
	 <div id="content-wrapper">

		<div class="container-fluid">
			 <!-- Breadcrumbs-->
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">Lolo Pinoy Grill Commissary</a>
                </li>
                <li class="breadcrumb-item ">Commissary</li>
                <li class="breadcrumb-item active">Production</li>
              </ol>
              <div class="row">
              		<div class="col-lg-12">
              			<div class="card mb-3">
              				<div class="card-header">
          					  <i class="fa fa-tasks" aria-hidden="true"></i>
          					  All Lists</div>
      					  	<div class="card-body">
  					  			
                			 	<div class="table-responsive">
                			 		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                			 			
                			 		</table>
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