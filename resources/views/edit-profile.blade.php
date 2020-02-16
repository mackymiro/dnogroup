@extends('layouts.app')
@section('title', 'Edit Profile |')
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