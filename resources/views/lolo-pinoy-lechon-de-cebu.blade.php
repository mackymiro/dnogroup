@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('content')
<div id="wrapper">
    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
       <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-cash-register"></i>
          <span>Sales Invoice</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fab fa-first-order"></i>
          <span>Purchase order</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-receipt"></i>
          <span>Statement of account</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-receipt"></i>
          <span>Billing statement</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-file-invoice"></i>
          <span>Cash vouchers</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-book"></i>
          <span>Check vouchers</span>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-apple-alt"></i>
          <span>Commissary</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          
          <a class="dropdown-item" href="login.html">RAW materials</a>
          <a class="dropdown-item" href="register.html">Production</a>
          <a class="dropdown-item" href="forgot-password.html">Stocks inventory</a>     
          <a class="dropdown-item" href="forgot-password.html">Delivery Outlets</a>

          <a class="dropdown-item" href="forgot-password.html">Sales of outlets</a>

          <a class="dropdown-item" href="forgot-password.html">Inventory of stocks</a>
         
        </div>
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

    
        </div>

    </div>


      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Lolo Pinoy Lechon de Cebu 2019</span>
          </div>
        </div>
      </footer>

    <!-- /.content-wrapper -->
</div>


@endsection