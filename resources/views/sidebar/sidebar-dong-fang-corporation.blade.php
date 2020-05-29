<!-- Sidebar  Dong Fang Corporation -->
<ul class="sidebar navbar-nav">
       <li class="nav-item active">
        <a class="nav-link" href="{{ url('/') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Ribo's Food Corporation</span>
        </a>
      </li>
      <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-receipt" aria-hidden="true"></i>
          <span>Billing Statement</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
        
           <a class="dropdown-item" href="{{ url('dong-fang-corporation/billing-statement-form') }}">Billing Statement Form</a>
           <a class="dropdown-item" href="{{ url('dong-fang-corporation/billing-statement/list') }}">List</a>
        
         
        </div>
      </li>
      @if(Auth::user()['role_type'] != 3)
       <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-credit-card" aria-hidden="true"></i>
          <span>Payables</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
        
           <a class="dropdown-item" href="{{ url('dong-fang-corporation/payment-voucher-form') }}">Payment Voucher Form</a>
           <a class="dropdown-item" href="{{ url('dong-fang-corporation/payables/transaction-list') }}">Transaction List</a>
        
         
        </div>
      </li>
      @endif  
 </ul>
