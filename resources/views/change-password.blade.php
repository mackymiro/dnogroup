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
              <li class="breadcrumb-item active">Change Password</li>
            </ol>
            <div class="row">
           	<div class="col-lg-12">
       			<form action="{{ action('ChangePasswordController@update', $user['id']) }}" method="post">
       				{{ csrf_field() }}
					<input name="_method" type="hidden" value="PATCH">
	        	 	<div class="card mb-3">
	        	 		<div class="card-header">
		                  <i class="fa fa-key"></i>
		                  Change Password</div>
	                  	 <div class="card-body">
	                  	 	@if(session('success'))
									<p class="alert alert-success">{{ Session::get('success') }}</p>
							@endif	
							@if(session('error'))
									<p class="alert alert-danger">{{ Session::get('error') }}</p>
							@endif	
	          				<label>Current Password</label> 
	          				<input type="password" name="currentPass" class="col-md-6 form-control" required="required" />   
	          				<label>New Password</label>
	          				<input type="password" name="password" class="col-md-6 form-control" required="required" />	 
	          				<label>Confirm New Password</label>
	          				<input id="password-confirm" type="password" name="password_confirmation" class="col-md-6 form-control" required="required" />
	          				@if ($errors->has('password'))
								<span class="alert alert-danger">
									<strong>{{ $errors->first('password') }}</strong>
								</span>
							@endif
	          				<br>
	          				<input type="submit" class="btn btn-success" value="Change password" />
	                  	 </div>
	        	 	</div>
        		</form>
        	 </div>
    		</div>

		</div>

	</div>
</div>
@endsection