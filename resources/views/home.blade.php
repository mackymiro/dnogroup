@extends('layouts.app')
@section('title', 'Home |')
@section('content')
<!--<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>-->

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
          <span>Ribo's Bar</span>
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
              <li class="breadcrumb-item active">Overview</li>
            </ol>

             <!-- Icon Cards-->
        <div class="row">
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                   <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">

                </div>
                <div class="mr-5">Lolo Pinoy Lechon de Cebu</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="{{ url('lolo-pinoy-lechon-de-cebu') }}">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <img src="{{ asset('images/lolo-pinoy-grill.jpeg')}}" width="200" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">

                </div>
                <div class="mr-5">Lolo Pinoy Grill Commissary</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="{{ url('lolo-pinoy-grill-commissary') }}">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                   <img src="{{ asset('images/lolo-pinoy-grill.jpeg')}}" width="200" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
                </div>
                <div class="mr-5">Lolo Pinoy Grill Branches</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="{{ url('lolo-pinoy-grill-branches') }}">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <img src="{{ asset('images/mr-potato.png')}}" width="200" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
                </div>
                <div class="mr-5">Mr Potato</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="{{ url('mr-potato') }}">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-secondary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <img src="{{ asset('images/digitized-logos/ribos-food-corp.png')}}" width="200" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
                </div>
                <div class="mr-5">Ribo's Bar</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="{{ url('ribos-bar') }}">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-info o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                     <img src="{{ asset('images/digitized-logos/dno-personal1.png')}}" width="250" height="160" class="img-responsive mx-auto d-block" alt="DNO Personal ">
                </div>
                <div class="mr-5">DNO Personal</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="{{ url('dno-personal') }}">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                     <img src="{{ asset('images/DNO_Food_Ventures.jpg')}}" width="255" height="172" class="img-responsive mx-auto d-block" alt="DIC ">
                </div>
                <div class="mr-5">DNO Food Ventures</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="{{ url('dno-food-ventures') }}">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>

          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-info o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <img src="{{ asset('images/dno-resources.jpg')}}" width="200" height="178" class="img-responsive mx-auto d-block" alt="DNO Resources and Development Corp">
                </div>
                <div class="mr-5">DNO Resources and Development Corp</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="{{ url('dno-resources-development') }}">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <img src="{{ asset('images/dong-fang-corporation.png')}}" width="277" height="139" class="img-responsive mx-auto d-block" alt="Dong Fang Corporation">
                </div>
                <div class="mr-5">Dong Fang Corporation</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="{{ url('dong-fang-corporation') }}">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <img src="{{ asset('images/wlg-corporation.png') }}" width="235" height="114" class="img-responsive mx-auto d-block" alt="WLG Corporation">
                </div>
                <div class="mr-5">WLG Corporation</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="{{ url('wlg-corporation') }}">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <img src="{{ asset('images/DIC-LOGO.png') }}" width="255" height="172" class="img-responsive mx-auto d-block" alt="WLG Corporation">
                </div>
                <div class="mr-5">DINO Industrial Corporation</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="{{ url('dino-industrial-corporation') }}">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <img src="{{ asset('images/local-ground.jpg')}}" width="200" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
                </div>
                <div class="mr-5">Local Ground</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="{{ url('local-ground') }}">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
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

    <!-- /.content-wrapper -->
</div>
 
@endsection
