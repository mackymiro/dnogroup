@extends('layouts.login')
@section('title', 'Login | DNO Holdings & Co')
@section('loginContent')
<div class="container" >
    <div class="card card-login mx-auto mt-5">
        <div class="card-header">Login </div>
        <a style="text-align:center;" class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/digitized-logos/dno-holding-co.jpg')}}" width="399" height="200" class="img-responsive" alt="DNO Holdings Inc">
        </a>
        <div class="card-body">
          <form class="form-horizontal" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              <div class="form-label-group">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                <label for="inputEmail">Email address</label>
                @if ($errors->has('email'))
                    <div class="alert alert-danger">
                        <strong>{{ $errors->first('email') }}</strong>
                    </div>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              <div class="form-label-group">
                 <input id="password" type="password" class="form-control" name="password" required>
                <label for="inputPassword">Password</label>
                  @if ($errors->has('password'))
                        <div class="alert alert-danger">
                            <strong>{{ $errors->first('password') }}</strong>
                        </div>
                    @endif
              </div>
            </div>
            <div class="form-group">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                
                </label>
              </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block ">
                Login
            </button>
          </form>
          <div class="text-center">
            <!--<a class="d-block small mt-3" href="{{ route('register') }}">Register an Account</a>-->
            <a class="d-block small" href="{{ route('password.request') }}">Forgot Password?</a>
          </div>
        </div>
      </div>
</div>
@endsection
