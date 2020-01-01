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
              <li class="breadcrumb-item active">Edit Profile</li>
            </ol>
        	 <form action="{{ action('ProfileController@update', $profile['id']) }}" method="post" enctype="multipart/form-data">
            	{{csrf_field()}}
		    	<input name="_method" type="hidden" value="POST">
	    	 <div class="row">
            	 <div class="col-lg-4">
            	 	<div class="card mb-3">
            	 		<div class="card-header">
		                  <i class="fa fa-user"></i>
		                  Profile</div>
		                   <div class="card-body">
							 	 <?php if($profile->photo == NULL ): ?>
									<img src="{{ asset('images/profile-placeholder.gif')}}"  class="img-responsive" alt="">
								<?php else: ?>
									<img src="/uploads/<?php echo $profile->photo; ?>"  width="284" height="295" class="img-responsive" alt="RMTG">
								<?php endif; ?>
								<br>
								<input type="file" name="photo" />
								
							</div>
            	 	</div>
            	 	  <a href="{{ url('profile') }}">Go Back</a>
            	 </div>
            	  <div class="col-lg-8">
	            	  	<div class="card mb-3">
            	  			<div class="card-header">
			                  <i class="fa fa-user-plus"></i>
			                  Profile Details</div>
		                  	 <div class="card-body">
		                  	 	@if(session('updated'))
									<p class="alert alert-success">{{ Session::get('updated') }}</p>
								@endif

		                  	 	@if(session('err'))
									<p class="alert alert-danger">{{ Session::get('err') }}</p>
								@endif
		                  	 	<label>First Name</label>
		                  	 	<input type="text" name="firstName" class="form-control" value="{{ $profile['first_name']}}" />
		                  	 	<label>Last Name</label>
		                  	 	<input type="text" name="lastName" class="form-control" value="{{ $profile['last_name']}}" />
		                  	 	<label>Email</label>
		                  	 	<input type="text" name="email" class="form-control" value="{{ $profile['email'] }}" disabled="disabled" />
		                  	 	<br>
		                  	 	 <input type="submit" class="btn btn-success float-right" value="Update" />
		                  	 </div>

	            	  	</div>

            	  </div>          	 
            </div>
        	</form>
     	</div>
     </div>
</div>
@endsection