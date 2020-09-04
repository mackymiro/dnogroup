@extends('layouts.app')
@section('title', 'Create User |')
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
              <li class="breadcrumb-item active">Create User</li>
            </ol>
	        <div class="row">
            	
            	 <div class="col-lg-8">
            	 	<div class="card mb-3">
            	 		<div class="card-header">
		                  <i class="fa fa-user-plus"></i>
		                  Create User</div>
	                  	 <div class="card-body">
                          <form action="{{ action('ProfileController@storeCreateUser') }}" method="post">
                             {{ csrf_field() }}
                              @if(session('createSuccess'))
                                 <p class="alert alert-success">{{ Session::get('createSuccess') }}</p>
                             @endif 
                               @if(session('error'))
                                 <p class="alert alert-danger">{{ Session::get('error') }}</p>
                             @endif 
                          <div class="form-group">  
                              <div class="form-row">
                                    <div class="col-lg-4">
                                        <label>First Name</label>
                                        <input type="text" name="firstName" class="form-control" required="required" value="{{ old('firstName')}}" />
                                     </div>
                                      @if ($errors->has('firstName'))
                                          <span class="alert alert-danger">
                                              <strong>{{ $errors->first('firstName') }}</strong>
                                          </span>
                                      @endif
                                      <div class="col-lg-4">
                                        <label>Last Name</label>
                                        <input type="text" name="lastName" class="form-control" required="required" value="{{ old('lastName')}}" />
                                     </div> 
                                    @if ($errors->has('lastName'))
                                        <span class="alert alert-danger">
                                            <strong>{{ $errors->first('lastName') }}</strong>
                                        </span>
                                    @endif        
                              </div>
                          </div>
                           <div class="form-group">  
                              <div class="form-row">
                                    <div class="col-lg-8">
                                        <label>Email Address</label>
                                        <input type="email" name="email" class="form-control" required="required"  value="{{ old('email')}}" />
                                     </div>
                                      @if ($errors->has('email'))
                                          <span class="alert alert-danger">
                                              <strong>{{ $errors->first('email') }}</strong>
                                          </span>
                                      @endif
                                                             
                              </div>
                          </div>
                           @if ($errors->has('password'))
                                <span class="alert alert-danger">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                          <div class="form-group">  
                              <div class="form-row">

                                    <div class="col-lg-4">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" />
                                     </div>
                                     
                                     <div class="col-lg-4">
                                        <label>Confirm Password</label>
                                        <input  id="password-confirm" type="password" name="password_confirmation" class="form-control" />
                                     </div>
                              </div>
                          </div>
                  	      <div class="form-group">
                              <div class="form-row">
                                  <div class="col-lg-8">
                                    <label>User Type</label>
                                    <div id="app-user-type">
                                      <select name="userType" class="form-control">
                                          <option value="0">--Please Select--</option>
                                          <option v-for="userType in userTypes" v-bind:value="userType.value">
                                            @{{ userType.text }}
                                          </option>
                                      </select>
                                    </div>
                                  </div>

                              </div>
                          </div>
                          <div class="form-group">
                              <div class="form-row">
                                  <div class="col-lg-4">
                                      <button type="submit" class="btn btn-primary btn-block">
                                          Create User
                                      </button>
                                  </div>
                              </div>
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

    </div>
</div>
<script>
   //User Type
  new Vue({
  el: '#app-user-type',
    data: {
      userTypes:[
        { text:'Admin', value: '1' },
        { text:'Sales', value: '2'},
        { text:'User',  value:'3' },
        { text:'Cashier', value:'4'}
      ]
    }
  })  
</script>
@endsection