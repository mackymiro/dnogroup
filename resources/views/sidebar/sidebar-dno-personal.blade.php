<!-- Sidebar  DNO Personal-->
 <ul class="sidebar navbar-nav">
       <li class="nav-item active">
        <a class="nav-link" href="{{ url('/') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Ribo's Food Corporation</span>
        </a>
      </li>
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-user"></i>
          <span>Personal Expenses</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <div class="sb-sidenav-menu-heading">&nbsp;Cash Expenses</div>
          <a class="dropdown-item" href="{{ url('dno-personal') }}">ALD ACCOUNTS</a>
          <a class="dropdown-item" href="{{ url('dno-personal/personal-expenses/mod-accounts') }}">MOD ACCOUNTS</a>
          
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
            <a class="dropdown-item" href="{{ url('dno-personal/cebu-properties') }}">Cebu Properties</a> 
            <a class="dropdown-item" href="{{ url('dno-personal/manila-properties') }}">Manila Properties</a>
          
        </div>
      </li>
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-car"></i>
          <span>Transportation</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="{{ url('dno-personal/vehicles') }}">Vehicles</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-money-bill-alt"></i>

          <span>Petty Cash</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="{{ url('dno-personal/petty-cash-list') }}">Petty Cash List</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-money-bill-alt"></i>

          <span>Receivables</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="{{ url('dno-personal/receivables') }}"> List</a>
        </div>
      </li>
      @if(Auth::user()['role_type'] != 3)
       <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-credit-card" aria-hidden="true"></i>
          <span>Payables</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
        
           <a class="dropdown-item" href="{{ url('dno-personal/payment-voucher-form') }}">Payment Voucher Form</a>
           <a class="dropdown-item" href="{{ url('dno-personal/payables/transaction-list') }}">Transaction List</a>
        
         
        </div>
      </li>
      @endif  
 </ul>
