<!-- Sidebar  WLG Corporation -->
<ul class="sidebar navbar-nav">
       <li class="nav-item active">
        <a class="nav-link" href="{{ url('/') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Ribo's Food Corporation</span>
        </a>
      </li>
      @if(Auth::user()['role_type'] != 3)
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-flag"></i>
          <span>Summary Report(s)</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="{{ url('local-ground/summary-report') }}">Summary Report(s)</a>
            <a class="dropdown-item" href="{{ url('local-ground/summary-report/search-number-code') }}">Search Number Code</a>
      
        </div>
      </li>
      @endif


      @if(Auth::user()['role_type'] != 3)
       <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-credit-card" aria-hidden="true"></i>
          <span>Payables</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
        
           <a class="dropdown-item" href="{{ url('local-ground/payment-voucher-form') }}">Payment Voucher Form</a>
           <a class="dropdown-item" href="{{ url('local-ground/payables/transaction-list') }}">Transaction List</a>
        
         
        </div>
      </li>
      @endif  
 </ul>
