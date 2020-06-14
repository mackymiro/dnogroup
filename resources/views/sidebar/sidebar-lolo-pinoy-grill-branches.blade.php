<!-- Sidebar  Lolo Pinoy Grill Branches-->
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
            <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/summary-report') }}">Summary Report(s)</a>
            <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/summary-report/search-number-code') }}">Search Number Code</a>
      
        </div>
      </li>
      @endif
     <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-cash-register"></i>
          <span>Sales Form</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/sales-form')}}">Sales Form</a>
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/') }}">Transaction List</a>
         
        </div>
      </li>
    
      <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fab fa-first-order"></i>
          <span>Requisition Slip</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
    
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/requisition-slip') }}">Requisition Form</a>
        
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/requisition-slip-lists') }}">Lists</a>
         
        </div>
      </li>
       <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fab fa-first-order"></i>
          <span>Transaction List</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">      
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/requistion/transaction-list') }}">Lists</a>
      
                  
        </div>
      </li>
      <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <i class="fas fa-money-bill-alt"></i>
          <span>Petty Cash</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/petty-cash-list') }}">Petty Cash List</a>
        </div>
      </li>
     <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <i class="fas fa-tools"></i>
          <span>Utility</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/utilities') }}">List</a>
        </div>
      </li>
       @if(Auth::user()['role_type'] != 3)
       <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-credit-card" aria-hidden="true"></i>
          <span>Payables</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
         
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/payment-voucher-form') }}">Payment Voucher Form</a>
         
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/payables/transaction-list') }}">Transaction List</a>
         
        </div>
      </li>
      @endif 
       <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-store"></i>
          <span>Store Stock</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
             <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/store-stock/delivery-in-transactions') }}">Delivery In Transactions</a>
      
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/store-stock/stock-status') }}">Stock Status</a>
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/store-stock/stock-inventory') }}">Stock Inventory</a>
         
        </div>
      </li>
    
 </ul>
