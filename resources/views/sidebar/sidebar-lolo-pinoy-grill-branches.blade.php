<!-- Sidebar  Lolo Pinoy Grill Branches-->
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
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/sales-invoice-form')}}">Sales Invoice Form</a>
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/') }}">Lists</a>
         
        </div>
      </li>
    
      <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fab fa-first-order"></i>
          <span>Requisition Slip</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          @if($user->role_type == 1)
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/requisition-slip') }}">Requisition Form</a>
          @endif
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/requisition-slip-lists') }}">Lists</a>
         
        </div>
      </li>
       <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fab fa-first-order"></i>
          <span>Transaction List</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          @if($user->role_type == 1)
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/requistion/transaction-list') }}">Lists</a>
          @endif
                  
        </div>
      </li>
       <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <i class="fas fa-money-bill-alt"></i>
          <span>Petty Cash</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          @if($user->role_type == 1)
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/petty-cash/transaction-list') }}">Transaction List</a>
          @endif
         
        </div>
      </li>
     <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <i class="fas fa-tools"></i>
          <span>Utility</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/petty-cash/transaction-list') }}">Veco</a>
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/petty-cash/transaction-list') }}">Phone & Internet</a>
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/petty-cash/transaction-list') }}">Water</a>
           <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/petty-cash/transaction-list') }}">Rental</a>
        </div>
      </li>

    
       <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-credit-card" aria-hidden="true"></i>
          <span>Payables</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          @if($user->role_type == 1)
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/payment-voucher-form') }}">Payment Voucher Form</a>
          @endif
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/payables/transaction-list') }}">Transaction List</a>
         
        </div>
      </li>
       <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-store"></i>
          <span>Store Stock</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          @if($user->role_type == 1)
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/purchase-order') }}">Delivery In Transactions</a>
          @endif
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/purchase-order-lists') }}">Stock Status</a>
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-branches/purchase-order-lists') }}">Stock Inventory</a>
         
        </div>
      </li>
    
 </ul>
