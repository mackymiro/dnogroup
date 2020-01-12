@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('content')
<div id="wrapper">
	<ul class="sidebar navbar-nav">
       <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-cash-register"></i>
          <span>Sales Invoice</span>
        </a>
      </li>
     
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fab fa-first-order"></i>
          <span>Purchase order</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/purchase-order') }}">P.O Form</a>
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/purchase-order-lists') }}">Lists</a>
         
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-receipt"></i>
          <span>Statement of account</span>
        </a>
      </li>
       <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-receipt"></i>
          <span>Billing statement</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/billing-statement-form') }}">Billing Statement Form</a>
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/billing-statement-lists') }}">Lists</a>
         
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-file-invoice"></i>
          <span>Cash vouchers</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-book"></i>
          <span>Check vouchers</span>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-apple-alt"></i>
          <span>Commissary</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          
          <a class="dropdown-item" href="login.html">RAW materials</a>
          <a class="dropdown-item" href="register.html">Production</a>
          <a class="dropdown-item" href="forgot-password.html">Stocks inventory</a>     
          <a class="dropdown-item" href="forgot-password.html">Delivery Outlets</a>

          <a class="dropdown-item" href="forgot-password.html">Sales of outlets</a>

          <a class="dropdown-item" href="forgot-password.html">Inventory of stocks</a>
         
        </div>
      </li>
     
     
    </ul>
     <div id="content-wrapper"> 
     	<div class="container-fluid">
     		<!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lechon de Cebu</a>
              </li>
              <li class="breadcrumb-item active">Update Billing Statement Form</li>
            </ol>
             <a href="{{ url('lolo-pinoy-lechon-de-cebu/billing-statement-lists') }}">Back to Lists</a>
             <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
            	 <h4 class="text-center"><u>UPDATE BILLING STATEMENT</u></h4>
            </div>
            <div class="form-group">
            	<div class="form-row">
            		<div class="col-lg-6">
            			<label>Bill to</label>
            			<input type="text" name="billTo" class="form-control" value="{{ $billingStatement['bill_to'] }}" />
            			<label>Address</label>
            			<input type="text" name="address" class="form-control" value="{{ $billingStatement['date'] }}" />
            			<label>Period Covered</label>
            			<input type="text" name="periodCovered" class="form-control" value="{{ $billingStatement['period_cover'] }}" />
            		</div>
            		<div class="col-lg-6">
        				<label>Date</label>
            			<input type="text" name="date" class="form-control" value="{{ $billingStatement['date'] }}" />
            			<label>Reference #</label>
            			<input type="text" name="refNumber" class="form-control" disabled="disabled"  value="#-{{ $billingStatement['reference_number']}}" />
            			<label>PO Number</label>
            			<input type="text" name="poNumber" class="form-control" disabled="disabled" value="PO-{{ $billingStatement['p_o_number'] }}" />
            			<label>Terms</label>
            			<input type="text" name="terms" class="form-control" required="required" value="{{ $billingStatement['terms'] }}" />
            		</div>
            	</div>
            </div>
            <div class="form-group">
            	<div class="form-row">
            		<div class="col-lg-1">
            			<label>Date</label>
            			<input type="text" name="transactionDate" class="form-control" value="{{ $billingStatement['date_of_transaction'] }}" />
            		</div>
            		<div class="col-lg-1">
            			<label>Invoice #</label>
          					<input type="text" name="invoiceNumber" class="form-control" disabled="disabled" value="#-{{ $billingStatement['invoice_number'] }}" />
            		</div>
            		<div class="col-lg-4">
            			<label>Whole Lechon 500/KL</label>
            			<input type="text" name="wholeLechon" class="form-control"  value="{{ $billingStatement['whole_lechon'] }}" />
            		</div>
            		<div class="col-lg-4">
            			<label>Description</label>
        				<input type="text" name="description" class="form-control"  value="{{ $billingStatement['description'] }}" />
            		</div>
            		<div class="col-lg-1">
        				<label>Amount</label>
        				<input type="text" name="amount" class="form-control" disabled="disabled" value="<?php echo number_format($billingStatement['amount'], 2); ?>" />
        			</div>
        			<br>
        			<div class="col-lg-12 float-right">
	                  <br>
	                  <br>
	                  <input type="submit" class="btn btn-success"  value="Update Billing Statement" />
	                </div>
            	</div>		
            </div>	
            <div class="form-group">

            </div>
             <div>
              <a href="{{ url('lolo-pinoy-lechon-de-cebu/add-new-billing/'.$billingStatement['id'] ) }}" class="btn btn-primary">Add New</a>
            </div>
     	</div>
     </div>
</div>
@endsection