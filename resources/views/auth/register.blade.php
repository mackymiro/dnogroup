@extends('layouts.register')

@section('registerContent')
<style>
    .help-block{color:red;}
</style>
<div class="container" >
    <div class="card card-login mx-auto mt-5">
         <div class="card-header">Register an Account </div>
         <a style="text-align:center;" class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/ribos.jpg')}}" width="300" height="200" class="img-responsive" alt="Ribos Food Corporation">
        </a>
        <div class="card-body">
            <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                 {{ csrf_field() }}
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-label-group{{ $errors->has('firstName') ? ' has-error' : '' }}">
                                <input id="firstName" type="text" class="form-control" name="firstName" value="{{ old('firstName') }}" required autofocus>
                                <label for="firstName">First name</label>
                                 @if ($errors->has('firstName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('firstName') }}</strong>
                                    </span>
                                @endif
                              </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-label-group{{ $errors->has('lastName') ? ' has-error' : '' }}">
                               <input id="lastName" type="text" class="form-control" name="lastName" value="{{ old('lastName') }}" required autofocus>
                                <label for="lastName">Last name</label>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lastName') }}</strong>
                                    </span>
                                @endif
                              </div>
                        </div>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                  <div class="form-label-group">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                    <label for="inputEmail">Email address</label>
                    @if ($errors->has('email'))
                        <span class="alert alert-danger">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                  <div class="form-label-group">
                    <input id="password" type="password" class="form-control" name="password" value="" required>
                    <label for="inputPassword">Password</label>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>
                <div class="form-label-group">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    <label for="confirmPassword">Confirm password</label>
                </div>
                <br>
                <div class="form-label-group">
                    <select name="userType" class="form-control">
                        <option value="">--Please Select--</option>
                        <option value="1">Admin</option>
                        <option value="2">Sales</option>
                        <option value="3">User</option>
                    </select>
                    @if ($errors->has('userType'))
                        <span class="help-block">
                            <strong>{{ $errors->first('userType') }}</strong>
                        </span>
                    @endif
                </div>
                <br>
                <button type="submit" class="btn btn-primary btn-block">
                    Register
                </button>
            </form>
             <div class="text-center">
            <a class="d-block small mt-3" href="{{ route('login') }}">Login Page</a>
            <a class="d-block small" href="{{ route('password.request') }}">Forgot Password?</a>
          </div>
        </div>
    </div>
</div>
@endsection

<!--
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
-->