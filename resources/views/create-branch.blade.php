@extends('layouts.app')
@section('title', 'Create Branch Account |')
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
              <li class="breadcrumb-item active">Create Branch Account</li>
            </ol>
            <div class="row">
                 <div class="col-lg-6">
                    <div class="card mb-3">
                        <div class="card-header">
		                  <i class="fa fa-user-plus"></i>
		                  Create Branch User
                        </div>
                        <div class="card-body">
                            <form action="{{ action('ProfileController@storeCreateBranch') }}" method="post">
                            {{ csrf_field() }}
                            @if(session('createBranch'))
                                 <p class="alert alert-success">{{ Session::get('createBranch') }}</p>
                             @endif 
                            @if(session('error'))
                                 <p class="alert alert-danger">{{ Session::get('error') }}</p>
                             @endif 
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-4">
                                        <label>Select Branch</label>
                                        <div id="app-branches"> 
                                            <select name="selectBranch" class="form-control">
                                                <option v-for="branch in branches" v-bind:value="branch.value">
                                                    @{{ branch.text }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Set Password</label>
                                        <input type="password" name="password" class="form-control" required />
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div>
                                        <button class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i>
                                            Create
                                        </button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                 </div>
                 <div class="col-lg-6">
                     <div class="card mb-3">
                        <div class="card-header">
                          <i class="fa fa-user-plus"></i>
                          Reset Branch Password
                        </div>
                        <div class="card-body">
                            <form action="{{ action('ProfileController@resetBranchPassword') }}" method="post">
                            {{ csrf_field() }}
                            @if(session('resetPassword'))
                                 <p class="alert alert-success">{{ Session::get('resetPassword') }}</p>
                             @endif 
                             @if(session('errorBranch'))
                                 <p class="alert alert-danger">{{ Session::get('errorBranch') }}</p>
                             @endif 
                            <div class="form-group">
                                 <div class="form-row">
                                    <div class="col-lg-4">
                                        <label>Select Branch</label>
                                        <div id="app-reset"> 
                                            <select name="selectBranch" class="form-control">
                                                <option v-for="branch in branches" v-bind:value="branch.value">
                                                    @{{ branch.text }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Set Password</label>
                                        <input type="password" name="password" class="form-control" required />
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div>
                                        <button class="btn btn-success"><i class="fa fa-key" aria-hidden="true"></i>

                                            Reset Password
                                        </button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                     </div>
                 </div>
            </div><!-- end of row -->
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
<script>
    //branches
    new Vue({
        el: '#app-branches',
            data:{
                branches:[
                    {text:'Urgello', value:'Urgello'},
                    {text:'Velez', value:'Velez'},
                    {text:'Banilad', value:'Banilad'},
                    {text:'GQS', value:'GQS' }
                ]
            }
    });

    new Vue({
        el: '#app-reset',
            data:{
                branches:[
                    {text:'Urgello', value:'Urgello'},
                    {text:'Velez', value:'Velez'},
                    {text:'Banilad', value:'Banilad'},
                    {text:'GQS', value:'GQS' }
                ]
            }
    });
</script>
@endsection