@extends('layouts.app')
@section('title', 'Change Password |')
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
      <li class="nav-item">
        <a class="nav-link" href="{{ url('lolo-pinoy-lechon-de-cebu') }}">
          <i class="fas fa-book"></i>
          <span>Lolo Pinoy Lechon de Cebu</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('lolo-pinoy-grill-commissary') }}">
          <i class="fas fa-book"></i>
          <span>Lolo Pinoy Grill Commissary</span>
        </a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="{{ url('lolo-pinoy-grill-branches') }}">
          <i class="fas fa-book"></i>
          <span>Lolo Pinoy Grill Branches</span>
        </a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="{{ url('mr-potato') }}">
          <i class="fas fa-book"></i>
          <span>Mr Potato</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('ribos-bar') }}">
          <i class="fas fa-book"></i>
          <span>Ribos Bar</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('dno-personal') }}">
          <i class="fas fa-book"></i>
          <span>DNO Personal</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fas fa-book"></i>
          <span>DNO Food Ventures</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fas fa-book"></i>
          <span>DNO Resources and Development Corp</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('dong-fang-corporation')}}">
          <i class="fas fa-book"></i>
          <span>Dong Fang Corporation</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('wlg-corporation') }}">
          <i class="fas fa-book"></i>
          <span>WLG Corporation</span>
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