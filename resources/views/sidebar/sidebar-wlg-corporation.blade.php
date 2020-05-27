<!-- Sidebar  WLG Corporation -->
<ul class="sidebar navbar-nav">
       <li class="nav-item active">
        <a class="nav-link" href="{{ url('/') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Ribo's Food Corporation</span>
        </a>
      </li>
      <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fa fa-file-invoice"></i>
          <span>Invoice</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          @if(Auth::user()['role_type'] == 1)
          <a class="dropdown-item" href="{{ url('wlg-corporation/invoice-form') }}">Invoice Form</a>
          @endif
          <a class="dropdown-item" href="{{ url('wlg-corporation/') }}">Lists</a>
         
        </div>
      </li>
      <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fab fa-first-order"></i>
          <span>Purchase Order</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          @if(Auth::user()['role_type'] == 1)
          <a class="dropdown-item" href="{{ url('wlg-corporation/purchase-order') }}">P.O Form</a>
          @endif
          <a class="dropdown-item" href="{{ url('wlg-corporation/purchase-order-lists') }}">Lists</a>
         
        </div>
      </li>
      @if(Auth::user()['role_type'] != 3)
       <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-credit-card" aria-hidden="true"></i>
          <span>Payables</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
        
           <a class="dropdown-item" href="{{ url('wlg-corporation/payment-voucher-form') }}">Payment Voucher Form</a>
           <a class="dropdown-item" href="{{ url('wlg-corporation/payables/transaction-list') }}">Transaction List</a>
        
         
        </div>
      </li>
      @endif  
 </ul>