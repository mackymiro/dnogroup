<!-- Sidebar  Ribos Bar-->
 <ul class="sidebar navbar-nav">
       <li class="nav-item active">
        <a class="nav-link" href="{{ url('/') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Ribos Food Corporation</span>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-cash-register"></i>
          <span>Sales Invoice</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <a class="dropdown-item" href="{{ url('ribos-bar/sales-invoice-form')}}">Sales Invoice Form</a>
          <a class="dropdown-item" href="{{ url('ribos-bar/') }}">Lists</a>
         
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-cash-register"></i>
          <span>Cashier's Report</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <a class="dropdown-item" href="{{ url('ribos-bar/cashiers-form')}}">Cashier's Form</a>
          <a class="dropdown-item" href="{{ url('ribos-bar/cashiers-report/inventory-list') }}">Inventory List</a>
         
        </div>
      </li>
	 <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-receipt"></i>
          <span>Delivery Receipt</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <a class="dropdown-item" href="{{ url('ribos-bar/delivery-receipt-form')}}">Delivery Receipt Form</a>
          <a class="dropdown-item" href="{{ url('ribos-bar/delivery-receipt-lists') }}">Lists</a>
         
        </div>
      </li>
      <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fab fa-first-order"></i>
          <span>Purchase Order</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          @if($user->role_type == 1)
          <a class="dropdown-item" href="{{ url('ribos-bar/purchase-order') }}">P.O Form</a>
          @endif
          <a class="dropdown-item" href="{{ url('ribos-bar/purchase-order-lists') }}">Lists</a>
         
        </div>
      </li>
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-receipt"></i>
          <span>Statement Of Account</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <a class="dropdown-item" href="{{ url('ribos-bar/statement-of-account-form')}}">Statement Of Account <br>Form</a>
          <a class="dropdown-item" href="{{ url('ribos-bar/statement-of-account-lists') }}">Lists</a>
         
        </div>
      </li>
       <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-receipt"></i>
          <span>Billing Statement</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          @if($user->role_type == 1)
          <a class="dropdown-item" href="{{ url('ribos-bar/billing-statement-form') }}">Billing Statement Form</a>
          @endif
          <a class="dropdown-item" href="{{ url('ribos-bar/billing-statement-lists') }}">Lists</a>
         
        </div>
      </li>
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-credit-card" aria-hidden="true"></i>
          <span>Payables</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="{{ url('ribos-bar/payment-voucher-form') }}">Payment Voucher Form</a>
             <a class="dropdown-item" href="{{ url('ribos-bar/payables/transaction-list') }}">Transaction List</a>
            <!--<a class="dropdown-item" href="{{ url('ribos-bar/cash-vouchers') }}">Cash Vouchers</a>
            <a class="dropdown-item" href="{{ url('ribos-bar/cheque-vouchers') }}">Cheque Vouchers</a>  -->
        </div>
      </li>
     
 </ul>
