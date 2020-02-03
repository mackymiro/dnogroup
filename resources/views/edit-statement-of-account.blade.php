@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
</script>
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
          @if($user->role_type == 1)
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/purchase-order') }}">P.O Form</a>
          @endif
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/purchase-order-lists') }}">Lists</a>
         
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-receipt"></i>
          <span>Statement of account</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/statement-of-account-form')}}">Statement of Account</a>
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/statement-of-account/lists') }}">Lists</a>
         
        </div>
      </li>
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-receipt"></i>
          <span>Billing statement</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          @if($user->role_type == 1)
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/billing-statement-form') }}">Billing Statement Form</a>
          @endif
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
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/commissary/stocks-inventory') }}">Stocks inventory</a>     
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
              <li class="breadcrumb-item active">Update Statement Of Account Form</li>
            </ol>
            <a href="{{ url('lolo-pinoy-lechon-de-cebu/statement-of-account/lists') }}">Back to Lists</a>
            <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
            	 <h4 class="text-center"><u>UPDATE STATEMENT OF ACCOUNT</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            Edit Statement Of Account</div>
                        <div class="card-body">
                              @if(session('SuccessE'))
                                 <p class="alert alert-success">{{ Session::get('SuccessE') }}</p>
                                @endif 
                              <form action="{{ action('LoloPinoyLechonDeCebuController@updateStatementInfo', $getStatementOfAccount['id']) }}" method="post">
                                 {{csrf_field()}}
                               <input name="_method" type="hidden" value="PATCH">
                              <div class="form-group">
                                <div class="form-row">
                                  <div class="col-lg-6">
                                    <label>Date</label>
                                    <input type="text" name="date" class="form-control" value="{{ $getStatementOfAccount['date'] }}" />
                                    <label>Branch</label>
                                    <select name="branch" class="form-control">
                                      <option value="0">--Please Select--</option>
                                      <option value="Terminal 1" <?php echo ("Terminal 1" == $getStatementOfAccount['branch']) ? 'selected="selected"' : '' ?> >Terminal 1</option>
                                      <option value="Terminal 2" <?php echo ("Terminal 2" == $getStatementOfAccount['branch']) ? 'selected="selected"' : '' ?> >Terminal 2</option>
                                    </option>
                                    </select>
                              <label>Invoice #</label>
                                <input type="text" name="invoiceNumber" class="form-control" value="{{ $getStatementOfAccount['invoice_number'] }}" disabled="disabled" />
                                <label>Kilos</label>
                                <input type="text" name="kilos" class="form-control" value="{{ $getStatementOfAccount['kilos'] }}" />
                                <label>Unit price</label>
                                <input type="text" name="unitPrice" class="form-control" value="{{ $getStatementOfAccount['unit_price'] }}" />
                                <label>Payment Method</label>
                              
                                  <select name="paymentMethod" class="form-control">
                                    <option value="0">--Please Select--</option>
                                    <option value="CHEQUE" <?php echo ("CHEQUE" == $getStatementOfAccount['payment_method']) ? 'selected="selected"' : '' ?>>CHEQUE</option>
                                    <option value="ACCOUNT"  <?php echo ("ACCOUNT" == $getStatementOfAccount['payment_method']) ? 'selected="selected"' : '' ?>>ACCOUNT</option>
                                  </option>
                                  </select>
                               
                                </div>
                                  <div class="col-lg-6">
                                    <label>Amount</label>
                                <input type="text" name="amount" class="form-control" value="{{ $getStatementOfAccount['amount'] }}" />
                                  <label>Status</label>
                                  <select name="status" class="form-control">
                                    <option value="0">--Please Select--</option>
                                    <option value="Unpaid"  <?php echo ("Unpaid" == $getStatementOfAccount['status']) ? 'selected="selected"' : '' ?>>Unpaid</option>
                                    <option value="Paid"  <?php echo ("Paid" == $getStatementOfAccount['status']) ? 'selected="selected"' : '' ?>>Paid</option>
                                  </select>
                               
                                <label>Paid Amount</label>
                                <input type="text" name="paidAmount" class="form-control" value="{{ $getStatementOfAccount['paid_amount'] }}" />
                                <label>Collection Date</label>
                                <input type="text" name="collectionDate" class="form-control" value="{{ $getStatementOfAccount['collection_date'] }}" />
                              <label>Check Number</label>
                                <input type="text" name="checkNumber" class="form-control"  value="{{ $getStatementOfAccount['check_number'] }}" />
                                <label>Check Amount</label>
                                <input type="text" name="checkAmount" class="form-control" value="{{ $getStatementOfAccount['check_amount'] }}" />
                              <label>OR Number</label>
                              <input type="text" name="orNumber" class="form-control" value="{{ $getStatementOfAccount['or_number'] }}" />
                                  </div>
                                </div>
                                 <div class="col-lg-12 float-right">
                                    <br>
                                    <br>
                                    <input type="submit" class="btn btn-success"  value="Update Statement Of Account" />
                                  </div>
                              </div>
                            </form>
                        </div>
                    </div>  
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                         <div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            Edit Statement Of Account</div>
                          <div class="card-body">
                               @if(session('SuccessEdit'))
                               <p class="alert alert-success">{{ Session::get('SuccessEdit') }}</p>
                              @endif 
                              @foreach($sAccounts as $sAccount)
                              <form action="{{ action('LoloPinoyLechonDeCebuController@updateAddStatement', $sAccount['id'] ) }}" method="post">
                                 {{csrf_field()}}
                              <input name="_method" type="hidden" value="PATCH">
                              <div class="form-group">
                                <div id="deletedId{{ $sAccount['id'] }}" class="form-row">
                                  <div class="col-lg-6">
                                      <label>Date</label>
                                      <input type="text" name="date" class="form-control" value="{{ $sAccount['date'] }}" />
                                      <label>Branch</label>
                                  <select name="branch" class="form-control">
                                    <option value="0">--Please Select--</option>
                                    <option value="Terminal 1"  <?php echo ("Terminal 1" == $sAccount['branch']) ? 'selected="selected"' : '' ?>>Terminal 1</option>
                                    <option value="Terminal 2" <?php echo ("Terminal 2" == $sAccount['branch']) ? 'selected="selected"' : '' ?>>Terminal 2</option>
                                  </select>
                                <label>Invoice #</label>
                                  <input type="text" name="invoiceNumber" class="form-control" value="{{ $sAccount['invoice_number'] }}" disabled="disabled" />
                                  <label>Kilos</label>
                                  <input type="text" name="kilos" class="form-control" value="{{ $sAccount['kilos'] }}" />
                                  <label>Unit price</label>
                                  <input type="text" name="unitPrice" class="form-control" value="{{ $sAccount['unit_price'] }}" />
                                  <label>Payment Method</label>
                                  <select name="paymentMethod" class="form-control">
                                    <option value="0">--Please Select--</option>
                                    <option value="CHEQUE" <?php echo ("CHEQUE" == $sAccount['payment_method']) ? 'selected="selected"' : '' ?>>CHEQUE</option>
                                    <option value="ACCOUNT" <?php echo ("ACCOUNT" == $sAccount['payment_method']) ? 'selected="selected"' : '' ?>>ACCOUNT</option>
                                  </select>
                                  </div>
                                  <div class="col-lg-6">
                                    <label>Amount</label>
                                  <input type="text" name="amount" class="form-control" value="{{ $sAccount['amount'] }}" />
                                  <label>Status</label>
                                  <select name="status" class="form-control">
                                    <option value="0">--Please Select--</option>
                                    <option value="Unpaid" <?php echo ("Unpaid" == $sAccount['status']) ? 'selected="selected"' : '' ?>>Unpaid</option>
                                    <option value="Paid" <?php echo ("Paid" == $sAccount['status']) ? 'selected="selected"' : '' ?>>Paid</option>
                                  </select>
                                  <label>Paid Amount</label>
                                  <input type="text" name="paidAmount" class="form-control" value="{{ $sAccount['paid_amount'] }}"  />
                                  <label>Collection Date</label>
                                  <input type="text" name="collectionDate" class="form-control" value="{{ $sAccount['collection_date'] }}" />
                                <label>Check Number</label>
                                  <input type="text" name="checkNumber" class="form-control" value="{{ $sAccount['check_number'] }}" />
                                  <label>Check Amount</label>
                                  <input type="text" name="checkAmount" class="form-control" value="{{ $sAccount['check_amount'] }}" />
                                <label>OR Number</label>
                                <input type="text" name="orNumber" class="form-control"  value="{{ $sAccount['or_number']}}" />
                                  </div>
                                  <div class="col-lg-2">
                                      <input type="hidden" name="statementAccountId" value="{{ $getStatementOfAccount['id'] }}" />
                                      <input type="submit" class="btn btn-success" value="Update" />
                                      @if($user->role_type == 1)
                                      <a id="delete" onClick="confirmDelete('{{ $sAccount['id'] }}')" href="javascript:void" class="btn btn-danger">Remove</a>
                                      @endif
                                    </div>
                                </div>
                              </div>
                              </form>
                              @endforeach
                                <br>
                              
                                <div>
                                  @if($user->role_type == 1)
                                  <a href="{{ url('lolo-pinoy-lechon-de-cebu/add-new-statement-account/'.$getStatementOfAccount['id'] ) }}" class="btn btn-primary">Add New</a>
                                  @endif
                                </div>
                          </div>
                    </div>
                </div>
            </div>
        	
		</div>
	</div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript">
    function confirmDelete(id){
        var x = confirm("Do you want to delete this?");
        if(x){
             $.ajax({
              type: "DELETE",
              url: '/lolo-pinoy-lechon-de-cebu/delete-statement-account/' + id,
              data:{
                _method: 'delete', 
                "_token": "{{ csrf_token() }}",
                "id": id
              },
              success: function(data){
                console.log(data);
                $("#deletedId"+id).fadeOut('slow');
              },
              error: function(data){
                console.log('Error:', data);
              }

            });
        }else{
            return false;
        }
    }
</script>
<script>
	

	//status data
	new Vue({
	el: '#app-status',
		data: {
			statuses:[
				{ text:'Unpaid', value: 'Unpaid' },
				{ text:'Paid', value: 'Paid'}
			]
		}
	})	

	//payment data
	new Vue({
	el: '#app-payment',
		data: {
			payments:[
				{ text:'CHEQUE', value: 'CHEQUE' },
				{ text:'ACCOUNT', value: 'ACCOUNT'}
			]
		}
	})	
</script>
@endsection