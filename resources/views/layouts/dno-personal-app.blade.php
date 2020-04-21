<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') {{ config('app.name', 'CRM DNOGROUP') }}</title>

    <!-- Styles -->
   
    <link href="{{ asset('vendor/all.min.css') }}" rel="stylesheet">


     <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin.css') }}" rel="stylesheet">

    <!-- Bootstrap core CSS-->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

     <!-- Page level plugin CSS-->
    <link href="{{ asset('vendor/dataTables.bootstrap4.css') }}" rel="stylesheet">
   
     <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="{{ asset('vendor/jquery/jquery.min.js') }} "></script>

</head>
<body>
 <div id="app">
        <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="{{ url('/dno-personal') }}">DNO Personal</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group">
      
      </div>
    </div>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown no-arrow mx-1">
         
      <a class="nav-link dropdown-toggle" href="#" aria-haspopup="true" aria-expanded="false">
      Welcome! {{ ucfirst(Auth::user()->first_name) }} {{ ucfirst(Auth::user()->last_name) }} <span class="caret"></span>
          </a>
        </li>
  
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <div class="dropdown-header text-center">
            <strong>
                  Account Type: 
                  @if($user->role_type == 1)
                    Admin
                  @elseif($user->role_type == 2)
                    Sales
                  @elseif($user->role_type == 3)
                    User
                  @endif                  
           </strong>
           </div>
          <a class="dropdown-item" href="{{ url('profile') }}"><i class="fa fa-user"></i> Profile</a>
           @if($user->role_type == 1)
           <a class="dropdown-item" href="{{ url('profile/create-user') }}"><i class="fa fa-user-plus" aria-hidden="true"></i> Create User</a>
           @endif
          <a class="dropdown-item" href="{{ url('change-password') }}"><i class="fa fa-key" aria-hidden="true"></i> Change Password</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out" aria-hidden="true"></i>Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
      </li>
    </ul>

  </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
   <!-- <script src="{{ asset('js/app.js') }}"></script>-->

     <!-- Bootstrap core JavaScript-->
      
      <script src="{{ asset('vendor/bootstrap.bundle.min.js') }} "></script>

      <!-- Core plugin JavaScript-->
      <script src="{{ asset('vendor/jquery.easing.min.js') }}"></script>

      <!-- Page level plugin JavaScript-->
      <script src="{{ asset('vendor/Chart.min.js') }}"></script>
      <script src="{{ asset('vendor/jquery.dataTables.js') }}"></script>
      <script src="{{ asset('vendor/dataTables.bootstrap4.js') }} "></script>

      <!-- Custom scripts for all pages-->
      <script src="{{ asset('js/sb-admin.min.js') }} "></script>
      <script src="{{ asset('js/datatables-demo.js') }} "></script>
      <script src="{{ asset('js/chart-area-demo.js') }} "></script>

      
</body>
</html>
