@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('content')
<script>
	function addFunction(){
	    var table = document.getElementById("textbox");
	  	var rowlen = table.rows.length;
	  	var row = table.insertRow(rowlen);
	  	row.id = rowlen;
	  	var arr = ['Quantity'];
	  	for (i = 0; i < 2; i++) {
	  		 var x = row.insertCell(i)
	  		 if (i == 1) {
	  		 	x.innerHTML = "<input class='btn btn-danger' type='button' onclick='removeCell(" + row.id + ")' value=Remove>"
  		  	}else{
  		  		x.innerHTML = "<div class='col-lg-12'><label>" + arr[i] + ":</label><br><input class='form-control' type='textbox' name='quantity[]'><label>Description</label><input type='textbox' class='form-control' name='description[]' ><label>Unit Price</label><input type='textbox' class='form-control' name='unitPrice[]' ><label>Amount</label><input type='textbox' class='form-control' name='amount[]' ></div>"
  	
  		  	}
  		}
	}



	function removeCell(rowid) {
      var table = document.getElementById(rowid).remove();
	}
</script>
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
          <a class="dropdown-item" href="{{ url('lolo-pinoy-lechon-de-cebu/purchase-order') }}">P.O Form</a>
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
              <li class="breadcrumb-item active">Update Purchase Order Form</li>
            </ol>
            <a href="{{ url('lolo-pinoy-lechon-de-cebu/purchase-order-lists') }}">Back to Lists</a>
            <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
            	 <h4 class="text-center"><u>UPDATED PURCHASE ORDER</u></h4>
            </div>
              @if(session('SuccessE'))
               <p class="alert alert-success">{{ Session::get('SuccessE') }}</p>
              @endif 
             <form action="{{ action('LoloPinoyLechonDeCebuController@update', $purchaseOrder['id']) }}" method="post">
             {{csrf_field()}}
            <input name="_method" type="hidden" value="PATCH">
            <div class="form-group">
            	<div class="form-row">
            		<div class="col-lg-6">
            			<label>Paid to</label>
      			 		<input type="text" name="paidTo" class="form-control" required="required" value="{{ $purchaseOrder['paid_to'] }}" />
      			 		<label>Address</label>
      			 		<input type="text" name="address" class="form-control" required="required" value="{{ $purchaseOrder['address'] }}" />
                <label>Checked By</label>
                <select class="form-control" name="checkedBy">
                    <option value="0">--Please Select--</option>
                    @foreach($getUsers as $getUser)
                    <option value="{{ $getUser['first_name']}} {{ $getUser['last_name'] }}">{{ $getUser['first_name']}} {{ $getUser['last_name'] }}</option>
                    @endforeach
                </select>
            		</div>
            		<div class="col-lg-6">
            			<label>P.O Number</label>
            			<input type="text" name="poNum" class="form-control" disabled="disabled"  value="{{ $purchaseOrder['p_o_number'] }}" />
            			<label>Date</label>
            			<input type="text" name="date" id="datepicker" class="form-control" required="required" value="{{ $purchaseOrder['date'] }}" />
                  <label>Requested By</label>
                  <select class="form-control" name="requestedBy">
                      <option value="0">--Please Select--</option>
                      @foreach($getUsers as $getUser)
                      <option value="{{ $getUser['first_name']}} {{ $getUser['last_name'] }}">{{ $getUser['first_name']}} {{ $getUser['last_name']}}</option>
                      @endforeach
                  </select>
            		</div>
            	</div>
            </div>
            <div class="form-group">
            	<div class="form-row">
      					<div class="col-lg-1">
      						<label>Quantity</label>
      						<input type="text" name="quantity" class="form-control" required="required" value="{{ $purchaseOrder['quantity'] }}" />

      					</div>
      					<div class="col-lg-4">
      						<label>Description</label>
      						<input type="text" name="description" class="form-control" required="required" value="{{ $purchaseOrder['description'] }}" />
      					</div>
      					<div class="col-lg-4">
      						<label>Unit Price</label>
      						<input type="text" name="unitPrice" class="form-control" required="required" value="{{ $purchaseOrder['unit_price'] }}" />
      					</div>
      					<div class="col-lg-2">
      						<label>Amount</label>
      						<input type="text" name="amount" class="form-control" required="required" value="{{ $purchaseOrder['amount'] }}" />
      					</div>
                <br>
                <div class="col-lg-12 float-right">
                  <br>
                  <br>
                  <input type="submit" class="btn btn-success"  value="Update Purchase Order" />
                </div>
            	</div>	
            </div>
            
            </form>

             @if(session('SuccessEdit'))
               <p class="alert alert-success">{{ Session::get('SuccessEdit') }}</p>
              @endif 
            @foreach($pOrders as $pOrder)
            <form action="{{ action('LoloPinoyLechonDeCebuController@updatePo', $pOrder['id']) }}" method="post">
            <div class="form-group">
                 {{csrf_field()}}
                 <input name="_method" type="hidden" value="PATCH">

                <div id="deletedId{{ $pOrder['id'] }}" class="form-row">
                    <div class="col-lg-1">
                      
                      <label>Quantity</label>
                      <input type="text" name="quant" class="form-control" required="required" value="{{ $pOrder['quantity'] }}" />

                    </div>
                    <div class="col-lg-2">
                      <label>Description</label>
                      <input type="text" name="desc" class="form-control" required="required" value="{{ $pOrder['description'] }}" />
                    </div>
                    <div class="col-lg-4">
                      <label>Unit Price</label>
                      <input type="text" name="unitP" class="form-control" required="required" value="{{ $pOrder['unit_price'] }}" />
                    </div>
                    <div class="col-lg-2">
                      <label>Amount</label>
                      <input type="text" name="amt" class="form-control" required="required" value="{{ $pOrder['amount'] }}" />
                    </div>
                     <div class="col-lg-2">
                      <br>
                      <input type="hidden" name="poId" value="{{ $purchaseOrder['id'] }}" />
                      <input type="submit" class="btn btn-success" value="Update" />
                      @if($user->role_type == 1)
                      <a id="delete" onClick="confirmDelete('{{ $pOrder['id'] }}')" href="javascript:void" class="btn btn-danger">Remove</a>
                      @endif
                    </div>
                </div>
               
            </div>
          </form>
            @endforeach
            <div>
              @if($user->role_type == 1)
              <a href="{{ url('lolo-pinoy-lechon-de-cebu/add-new/'.$purchaseOrder['id']) }}" class="btn btn-primary">Add New</a>
              @endif
            </div>
          	
      			<br>
      			
      				
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
              url: '/lolo-pinoy-lechon-de-cebu/delete/' + id,
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
@endsection