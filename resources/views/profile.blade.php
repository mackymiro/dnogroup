@extends('layouts.app')
@section('content')
<div id="wrapper">
	<!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="index.html">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-folder"></i>
          <span>Pages</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">Login Screens:</h6>
          <a class="dropdown-item" href="login.html">Login</a>
          <a class="dropdown-item" href="register.html">Register</a>
          <a class="dropdown-item" href="forgot-password.html">Forgot Password</a>
          <div class="dropdown-divider"></div>
          <h6 class="dropdown-header">Other Pages:</h6>
          <a class="dropdown-item" href="404.html">404 Page</a>
          <a class="dropdown-item" href="blank.html">Blank Page</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="charts.html">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="tables.html">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables</span></a>
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
							<?php if($user->photo == NULL ): ?>
								<img src="{{ asset('images/profile-placeholder.gif')}}"  class="img-responsive" alt="">
							<?php else: ?>
								<img src="/uploads/<?php echo $user->photo; ?>"  width="284" height="295" class="img-responsive" alt="RMTG">
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
	                  	 				<td width="70%">{{ $user['first_name']}}</td>
	                  	 			</tr>
	                  	 		</thead>
	                  	 		<tbody>
                  	 				<tr>
                  	 					<td>Last Name</td>
                  	 					<td>{{ $user['last_name']}}</td>
                  	 				</tr>
                  	 				<tr>
                  	 					<td>Email Address</td>
                  	 					<td>{{ $user['email'] }}</td>
                  	 				</tr>

	                  	 		</tbody>
	                  	 	</table>
	                  	 	<div>
              	 			<a href="{{ url('profile/edit/'.$user['id']) }}" class="btn btn-success float-right"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
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
            <span>Copyright © Lolo Pinoy's Lechon de Cebu 2019</span>
          </div>
        </div>
      </footer>

    </div>
</div>
@endsection