@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


  <script>
    $(function() {
      $( "#datepicker").datepicker();
    });
  </script>
<div id="wrapper">
	<!-- Sidebar -->
    <ul class="sidebar navbar-nav">
       <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-cash-register"></i>
          <span>Sales Invoice</span>
        </a>
      </li>
     
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fab fa-first-order"></i>
          <span>Purchase order</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/purchase-order') }}">P.O Form</a>
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/lists') }}">Lists</a>
         
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-receipt"></i>
          <span>Statement of account</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-receipt"></i>
          <span>Billing statement</span>
        </a>
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
              <li class="breadcrumb-item active">Purchase Order Form</li>
            </ol>

            <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
            	 <h4 class="text-center"><u>PURCHASE ORDER</u></h4>
            </div>
        <form action="{{ action('LoloPinoyLechonDeCebuController@store') }}" method="post">
          {{csrf_field()}}
        <div class="form-group">
        		<div class="form-row">
      			 	<div class="col-lg-6">
      			 		<label>Paid to</label>
      			 		<input type="text" name="paidTo" class="form-control" required="required" />
                @if ($errors->has('paidTo'))
                  <span class="alert alert-danger">
                    <strong>{{ $errors->first('paidTo') }}</strong>
                  </span>
                @endif
      			 		<label>Address</label>
      			 		<input type="text" name="address" class="form-control" required="required" />
                @if ($errors->has('address'))
                  <span class="alert alert-danger">
                    <strong>{{ $errors->first('address') }}</strong>
                  </span>
                @endif
      			 	</div>
      			 	<div class="col-lg-6">
      			 		<label>P.O Number</label>
      			 		<input type="text" name="poNum" class="form-control" disabled="disabled" />
      			 		<label>Date</label>
      			 		<input type="text" name="date" id="datepicker" class="form-control" required="required" />
                @if ($errors->has('date'))
                  <span class="alert alert-danger">
                    <strong>{{ $errors->first('date') }}</strong>
                  </span>
                @endif
      			 	</div>
      			</div>
  			</div>
  			<div class="form-group">
  				<div class="form-row">
  					<div class="col-lg-1">
  						<label>Quantity</label>
  						<input type="text" name="quantity" class="form-control" required="required" />
              @if ($errors->has('quantity'))
                  <span class="alert alert-danger">
                    <strong>{{ $errors->first('quantity') }}</strong>
                  </span>
              @endif
  					</div>
  					<div class="col-lg-4">
  						<label>Description</label>
  						<input type="text" name="description" class="form-control" required="required" />
              @if ($errors->has('description'))
                  <span class="alert alert-danger">
                    <strong>{{ $errors->first('description') }}</strong>
                  </span>
              @endif
  					</div>
  					<div class="col-lg-4">
  						<label>Unit Price</label>
  						<input type="text" name="unitPrice" class="form-control" required="required" />
              @if ($errors->has('unitPrice'))
                  <span class="alert alert-danger">
                    <strong>{{ $errors->first('unitPrice') }}</strong>
                  </span>
              @endif
  					</div>
  					<div class="col-lg-2">
  						<label>Amount</label>
  						<input type="text" name="amount" class="form-control" required="required" />
               @if ($errors->has('amount'))
                  <span class="alert alert-danger">
                    <strong>{{ $errors->first('amount') }}</strong>
                  </span>
              @endif
  					</div>            
  				</div>
          <br>
          <div>
              <input type="submit" class="btn btn-success float-right" value="Add Purchase Order" />
          </div>
  			</div>
        </form>

        </div>

    </div>

     <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Lolo Pinoy Lechon de Cebu 2019</span>
          </div>
        </div>
      </footer>

    <!-- /.content-wrapper -->
</div>

@endsection