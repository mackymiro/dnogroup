<!-- Sidebar  DNO RESOURCES-->
<ul class="sidebar navbar-nav">
       <li class="nav-item active">
        <a class="nav-link" href="{{ url('/') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>DNO Holdings & Co</span>
        </a>
      </li>
      @if(Auth::user()['role_type'] != 3)
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-flag"></i>
          <span>Summary Report(s)</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="{{ url('dno-food-ventures/summary-report') }}">Summary Report(s)</a>
            <a class="dropdown-item" href="{{ url('dno-food-ventures/summary-report/search-number-code') }}">Search Number Code</a>
      
        </div>
      </li>
      @endif
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-cash-register"></i>
          <span>Sales Invoice</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <a class="dropdown-item" href="{{ url('dno-food-ventures/sales-invoice-form') }}">Sales Invoice Form</a>
          <a class="dropdown-item" href="{{ url('dno-food-ventures') }}">Lists</a>
          
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-receipt"></i>
          <span>Delivery Receipt</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <a class="dropdown-item" href="{{ url('dno-food-ventures/delivery-receipt-form')}}">Delivery Receipt Form</a>
          <a class="dropdown-item" href="{{ url('dno-food-ventures/delivery-receipt/lists') }}">Lists</a>
  

        </div>
      </li>
      <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fab fa-first-order"></i>
          <span>Purchase Order</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
         
          <a class="dropdown-item" href="{{ url('dno-food-ventures/purchase-order') }}">P.O Form</a>
        
          <a class="dropdown-item" href="{{ url('dno-food-ventures/purchase-order-lists') }}">Lists</a>
         
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-receipt"></i>
          <span>Statement Of Account</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <a class="dropdown-item" href="{{ url('dno-food-ventures/statement-of-account/lists') }}">Lists</a>
         
        </div>
      </li>
      <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-receipt"></i>
          <span>Billing Statement</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          @if(Auth::user()['role_type'] == 1)
          <a class="dropdown-item" href="{{ url('dno-food-ventures/billing-statement-form') }}">Billing Statement Form</a>
          @endif
          <a class="dropdown-item" href="{{ url('dno-food-ventures/billing-statement-lists') }}">Lists</a>
         
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-money-bill-alt"></i>

          <span>Petty Cash</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="{{ url('dno-food-ventures/petty-cash-list') }}">Petty Cash List</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-industry" aria-hidden="true"></i>


          <span>Suppliers</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="{{ url('dno-food-ventures/suppliers') }}"> Suppliers</a>
            
        </div>
      </li>
     
      @if(Auth::user()['role_type'] != 3)
  	   <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-credit-card" aria-hidden="true"></i>
          <span>Payables</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
         
           <a class="dropdown-item" href="{{ url('dno-food-ventures/payment-voucher-form') }}">Payment Voucher Form</a>
           <a class="dropdown-item" href="{{ url('dno-food-ventures/payables/transaction-list') }}">Transaction List</a>
         
        </div>
      </li>
      @endif
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-apple-alt"></i>
          <span>Commissary Stock</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          
          <a class="dropdown-item" href="{{ url('dno-food-ventures/commissary/raw-materials') }}">RAW Materials</a>
          <a class="dropdown-item" href="{{ url('dno-food-ventures/commissary/production') }}">Production</a>
          <a class="dropdown-item" href="{{ url('dno-food-ventures/commissary/stocks-inventory') }}">Stocks Inventory</a>     
          <a class="dropdown-item" href="{{ url('dno-food-ventures/commissary/delivery-outlets') }}">Delivery Outlets</a>

          <a class="dropdown-item" href="{{ url('dno-food-ventures/commissary/inventory-of-stocks') }}">Inventory Of Stocks</a>
         
        </div>
      </li>
 </ul>