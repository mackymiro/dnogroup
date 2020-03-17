<!-- Sidebar  Lolo Pinoy Grill Commissary-->
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
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-commissary/sales-invoice-form')}}">Sales Invoice Form</a>
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-commissary/') }}">Lists</a>
         
        </div>
      </li>
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-receipt"></i>
          <span>Delivery Receipt</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-commissary/delivery-receipt-form')}}">Delivery Receipt Form</a>
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-commissary/delivery-receipt/lists') }}">Lists</a>
         
        </div>
      </li>
       <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fab fa-first-order"></i>
          <span>Purchase Order</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          @if($user->role_type == 1)
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-commissary/purchase-order') }}">P.O Form</a>
          @endif
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-commissary/purchase-order-lists') }}">Lists</a>
         
        </div>
      </li>
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-receipt"></i>
          <span>Statement Of Account</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-commissary/statement-of-account-form')}}">Statement Of Account <br>Form</a>
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-commissary/statement-of-account-lists') }}">Lists</a>
         
        </div>
      </li>
       <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-receipt"></i>
          <span>Billing Statement</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          @if($user->role_type == 1)
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-commissary/billing-statement-form') }}">Billing Statement Form</a>
          @endif
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-commissary/billing-statement-lists') }}">Lists</a>
         
        </div>
      </li>
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-file-invoice"></i>
          <span>Payment Vouchers</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-commissary/payment-voucher-form') }}">Payment Voucher Form</a>
            <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-commissary/cash-vouchers') }}">Cash Vouchers</a>
            <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-commissary/cheque-vouchers') }}">Cheque Vouchers</a>  
        </div>
      </li>
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-apple-alt"></i>
          <span>Commissary Stock</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-commissary/commissary/raw-materials') }}">RAW Materials</a>
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-commissary/commissary/production') }}">Production</a>
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-commissary/commissary/stocks-inventory') }}">Stocks Inventory</a>     
          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-commissary/commissary/delivery-outlets') }}">Delivery Outlets</a>

          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-commissary/commissary/sales-of-outlets') }}">Sales Of Outlets</a>

          <a class="dropdown-item" href="{{ url('lolo-pinoy-grill-commissary/commissary/inventory-of-stocks') }}">Inventory Of Stocks</a>
         
        </div>
      </li>
      <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-credit-card" aria-hidden="true"></i>
          <span>Payables</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          @if($user->role_type == 1)
          <a class="dropdown-item" href="">Transaction List</a>
          @endif
          <a class="dropdown-item" href="">test</a>
         
        </div>
      </li>
 </ul>
