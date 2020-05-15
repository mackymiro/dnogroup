<!-- Sidebar  DNO RESOURCES-->
<ul class="sidebar navbar-nav">
       <li class="nav-item active">
        <a class="nav-link" href="{{ url('/') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Ribo's Food Corporation</span>
        </a>
      </li>
      <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fab fa-first-order"></i>
          <span>Purchase Order</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
        
          <a class="dropdown-item" href="{{ url('dno-resources-development/purchase-order') }}">P.O Form</a>
       
          <a class="dropdown-item" href="{{ url('dno-resources-development/purchase-order-lists') }}">Lists</a>
         
        </div>
      </li>
      <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-shipping-fast"></i>
          <span>Delivery Transaction</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
        
          <a class="dropdown-item" href="{{ url('dno-resources-development/delivery-form') }}">Delivery Form</a>
       
          <a class="dropdown-item" href="{{ url('dno-resources-development/delivery-transaction/records') }}">Delivery Transaction <br>Record</a>
         
        </div>
      </li>
      <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-hotel"></i>
          <span>D Botique hotel</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
         
          <a class="dropdown-item" href="{{ url('') }}">On Going Construction</a>
         
          <a class="dropdown-item" href="{{ url('') }}">Progress Report</a>
         
        </div>
      </li>
    
      @if(Auth::user()['role_type'] != 3)
  	   <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-credit-card" aria-hidden="true"></i>
          <span>Payables</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
         
           <a class="dropdown-item" href="{{ url('dno-resources-development/payment-voucher-form') }}">Payment Voucher Form</a>
           <a class="dropdown-item" href="{{ url('dno-resources-development/payables/transaction-list') }}">Transaction List</a>
         
        </div>
      </li>
      @endif
 </ul>