@extends('layouts.register')

@section('registerContent')
<style>
    .help-block{color:red;}
</style>
<div class="container" >
    <div class="card card-login mx-auto mt-5">
        <div class="card-header">Forgot password </div>
         <a style="text-align:center;" class="navbar-brand" href="{{ url('/') }}">
             <img src="{{ asset('images/ribos.jpg')}}" width="300" height="200" class="img-responsive" alt="Ribos Food Corporation">
        </a>
        <div class="card-body">
            <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}
                     @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
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
                 <button type="submit" class="btn btn-primary">
                    Send Password Reset Link
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

<!--
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

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

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>-->