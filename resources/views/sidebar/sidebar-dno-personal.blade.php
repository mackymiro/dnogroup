<!-- Sidebar  DNO Personal-->
 <ul class="sidebar navbar-nav">
       <li class="nav-item active">
        <a class="nav-link" href="{{ url('/') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Ribos Food Corporation</span>
        </a>
      </li>
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-user"></i>
          <span>Personal Expenses</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <div class="sb-sidenav-menu-heading">&nbsp;Credit Cards</div>
          <a class="dropdown-item" href="{{ url('dno-personal') }}">ALD ACCOUNTS</a>
          <a class="dropdown-item" href="#">MOD ACCOUNTS</a>
           <div class="sb-sidenav-menu-heading">&nbsp;Cash Expenses</div>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-credit-card"></i>
          <span>Credit Card Accounts</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <div class="sb-sidenav-menu-heading">&nbsp;Credit Cards</div>
          <a class="dropdown-item" href="{{ url('dno-personal/credit-card/ald-accounts') }}">ALD ACCOUNTS</a>
          <a class="dropdown-item" href="{{ url('dno-personal/credit-card/mod-accounts') }}">MOD ACCOUNTS</a>
           
        </div>
      </li>
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-building"></i>
          <span>Properties</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <div class="sb-sidenav-menu-heading">&nbsp;Cebu Properties</div>
            <a class="dropdown-item" href="">House #28</a>
            <a class="dropdown-item" href="#">House #29</a>
            <a class="dropdown-item" href="#">House #50</a>
            <div class="sb-sidenav-menu-heading">&nbsp;Manila Properties</div>
            <a class="dropdown-item" href="">Greenbelt</a>
            <a class="dropdown-item" href="#">Gotesco</a>
        </div>
      </li>
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-tools"></i>
          <span>Utilities</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <div class="sb-sidenav-menu-heading">&nbsp;Vehicles</div>
            <a class="dropdown-item" href="">Hi-Ace Grandia</a>
            <a class="dropdown-item" href="#">Hilux</a>
           
        </div>
      </li>
       <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-credit-card" aria-hidden="true"></i>
          <span>Payables</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          @if($user->role_type == 1)
           <a class="dropdown-item" href="{{ url('dno-personal/payment-voucher-form') }}">Payment Voucher Form</a>
           <a class="dropdown-item" href="{{ url('dno-personal/payables/transaction-list') }}">Transaction List</a>
          @endif
         
        </div>
      </li>
    
 </ul>
