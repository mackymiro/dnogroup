@extends('layouts.app')
@section('title', 'Settings |')
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
              <li class="breadcrumb-item active">Settings</li>
            </ol>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-cogs"></i> 
                            Settings 
                        </div>
                        <div class="card-body">
                            <div class=col-lg-12>
                                <label>Whole Lechon KL (Price)</label>
                                <input type="text" name="settingLechon" class="form-control" />
                            </div>
                            <div class=col-lg-12>
                                <br>
                                <button type="submit" class="btn btn-success btn-lg"><i class="fas fa-save"></i> Save KL Price</button>
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
            <span>Copyright © Ribos Food Corporation 2019</span>
            <br>
            <br>
            <span>Made with ❤️ at <a href="https://cebucodesolutions.com" target="_blank">Cebu Code Solutions</a></span>
          </div>
        </div>
      </footer>
</div>
@endsection