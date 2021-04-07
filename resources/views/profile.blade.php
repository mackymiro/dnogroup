@extends('layouts.app')
@section('title', 'Profile |')
@section('content')
<div id="wrapper">
	  <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="{{ url('/') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>   
     
    </ul>
    <div id="content-wrapper">
    	<div class="container-fluid">
    		  <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Dashboard</a>
              </li>
              <li class="breadcrumb-item active">Profile</li>
            </ol>
	        <div class="row">
            	 <div class="col-lg-4">
            	 	<div class="card mb-3">
            	 		<div class="card-header">
		                  <i class="fa fa-user"></i>
		                  Profile</div>
		                   <div class="card-body">
                        <?php if(Auth::user()['photo'] == NULL ): ?>
                          <img src="{{ asset('images/profile-placeholder.gif')}}"  class="img-responsive" alt="">
                        <?php else: ?>
                          <img src="/uploads/<?php echo Auth::user()['photo']; ?>"  width="284" height="295" class="img-responsive" alt="">
                        <?php endif; ?>
                          
                          
                        </div>
                    </div>
                  </div>
            	 <div class="col-lg-8">
            	 	<div class="card mb-3">
            	 		<div class="card-header">
		                  <i class="fa fa-user-plus"></i>
		                  Profile Details</div>
	                  	 <div class="card-body">
	                  	 	<table class="table table-striped">
	                  	 		<thead>
	                  	 			<tr>
	                  	 				<td width="20%">First Name</td>
	                  	 				<td width="70%">{{ Auth::user()['first_name']}}</td>
	                  	 			</tr>
	                  	 		</thead>
	                  	 		<tbody>
                  	 				<tr>
                  	 					<td>Last Name</td>
                  	 					<td>{{ Auth::user()['last_name']}}</td>
                  	 				</tr>
                  	 				<tr>
                  	 					<td>Email Address</td>
                  	 					<td>{{ Auth::user()['email'] }}</td>
                  	 				</tr>

	                  	 		</tbody>
	                  	 	</table>
	                  	 	<div>
              	 			<a href="{{ url('profile/edit/'.Auth::user()['id']) }}" class="btn btn-success float-right"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
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
</div>
@endsection