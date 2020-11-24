@extends('layouts.wimpys-food-express-app')
@section('title', 'Edit Purchase Order |')
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
	 @include('sidebar.sidebar-wimpys-food-express')

    <div id="content-wrapper">   
     
    	<div class="container-fluid">
    		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Wimpy's Food Express</a>
              </li>
              <li class="breadcrumb-item active">Update Purchase Order Form</li>
            </ol>
            <a href="{{ url('wimpys-food-express/purchase-order-lists') }}">Back to Lists</a>
            <div class="col-lg-12">
                <img src="{{ asset('images/digitized-logos/wimpys-logo1.jpg')}}" width="350" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
                <h4 class="text-center"><u>PURCHASE ORDER</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                         <div class="card-header">
                       <i class="fab fa-first-order" aria-hidden="true"></i>
                         Edit Purchase Order</div>
                         <div class="card-body">
                               @if(session('SuccessE'))
                                 <p class="alert alert-success">{{ Session::get('SuccessE') }}</p>
                                @endif 
                               <form action="{{ action('WimpysFoodExpressController@update', $purchaseOrder[0]->id) }}" method="post">
                               {{csrf_field()}}
                              <input name="_method" type="hidden" value="put">
                              <div class="form-group">
                                <div class="form-row">
                                  <div class="col-lg-6">
                                    <label>Paid to</label>
                                  <input type="text" name="paidTo" class="form-control"  value="{{ $purchaseOrder[0]->paid_to }}" />
                                  <label>Address</label>
                                  <input type="text" name="address" class="form-control"  value="{{ $purchaseOrder[0]->address }}" />
                                 
                                  </div>
                                  <div class="col-lg-6">
                                    <label>P.O #</label>
                                    @foreach($purchaseOrder[0]->purchase_orders as $po)
                                        @if($po->module_name === "Purchase Order")
                                        <input type="text" name="poNum" class="form-control" disabled="disabled"  value="{{ $po->wimpys_food_express_code }}" />
                                  
                                        @endif
                                    @endforeach
                                     <label>Date</label>
                                    <input type="text" name="date" id="datepicker" class="form-control"  value="{{ $purchaseOrder[0]->date }}" />
                                  
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="form-row">
                                  <div class="col-lg-1">
                                    <label>Quantity</label>
                                    <input type="text" name="quantity" class="form-control" required="required" value="{{ $purchaseOrder[0]->quantity }}" />

                                  </div>
                                  <div class="col-lg-4">
                                    <label>Description</label>
                                    <input type="text" name="description" class="form-control" required="required" value="{{ $purchaseOrder[0]->description }}" />
                                  </div>
                                  <div class="col-lg-4">
                                    <label>Unit Price</label>
                                    <input type="text" name="unitPrice" class="form-control" required="required" value="{{ $purchaseOrder[0]->unit_price }}" />
                                  </div>
                                  <div class="col-lg-2">
                                    <label>Amount</label>
                                    <input type="text" name="amount" class="form-control" required="required" value="{{ $purchaseOrder[0]->amount }}" />
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
                         </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-3">
                         <div class="card-header">
                            <i class="fab fa-first-order" aria-hidden="true"></i>
                          Add Purchase Order</div>
                          <div class="card-body">
        					   		<form action="{{ action('WimpysFoodExpressController@addNewPurchaseOrder', $id) }}" method="post">
    					   				{{csrf_field()}}
    					   				 @if(session('purchaseOrderSuccess'))
						                   <p class="alert alert-success">{{ Session::get('purchaseOrderSuccess') }}</p>
						                  @endif 
	    					   		<div class="form-group">
	    					   			<div class="form-row">
    					   					<div class="col-lg-12">
					  						<label>Quantity</label>
						  						<input type="text" name="quantity" class="form-control" required="required" />
								              @if ($errors->has('quantity'))
								                  <span class="alert alert-danger">
								                    <strong>{{ $errors->first('quantity') }}</strong>
								                  </span>
								              @endif
						  					</div>
						  					<div class="col-lg-12">
						  						<label>Description</label>
						  						<input type="text" name="description" class="form-control" required="required" />
								              @if ($errors->has('description'))
								                  <span class="alert alert-danger">
								                    <strong>{{ $errors->first('description') }}</strong>
								                  </span>
								              @endif
						  					</div>
						  					<div class="col-lg-12">
						  						<label>Unit Price</label>
						  						<input type="text" name="unitPrice" class="form-control" required="required" />
								              @if ($errors->has('unitPrice'))
								                  <span class="alert alert-danger">
								                    <strong>{{ $errors->first('unitPrice') }}</strong>
								                  </span>
								              @endif
  											</div>
						  					<div class="col-lg-12">
						  						<label>Amount</label>
						  						<input type="text" name="amount" class="form-control" required="required" />
								               @if ($errors->has('amount'))
								                  <span class="alert alert-danger">
								                    <strong>{{ $errors->first('amount') }}</strong>
								                  </span>
								              @endif
						  					</div> 

						  					
	    					   			</div>
	    					   		</div>
	    					   		<div class="form-group">
	    					   			<div class="form-row">
	    					   				<div class="col-lg-12 float-right">
					  							<input type="submit" class="btn btn-primary btn-lg" value="Add" />
					  						
						  					</div> 
	    					   			</div>
	    					   		</div>
	    					   		</form>
        					   </div>
                    </div>
                </div>
                <div class="col-lg-8">
                     <div class="card mb-3">
                        <div class="card-header">
                       <i class="fab fa-first-order" aria-hidden="true"></i>
                          Edit Purchase Order</div>
                        <div class="card-body">
                            @if(session('SuccessEdit'))
                               <p class="alert alert-success">{{ Session::get('SuccessEdit') }}</p>
                              @endif 
                            @foreach($pOrders as $pOrder)
                            <form action="{{ action('WimpysFoodExpressController@updatePo', $pOrder['id']) }}" method="post">
                            <div class="form-group">
                                 {{csrf_field()}}
                                 <input name="_method" type="hidden" value="PUT">

                                <div id="deletedId{{ $pOrder['id'] }}" class="form-row">
                                    <div class="col-lg-1">
                                      
                                      <label>Quantity</label>
                                      <input type="text" name="quant" class="form-control" required="required" value="{{ $pOrder['quantity'] }}" />

                                    </div>
                                    <div class="col-lg-4">
                                      <label>Description</label>
                                      <input type="text" name="desc" class="form-control" required="required" value="{{ $pOrder['description'] }}" />
                                    </div>
                                 
                                    <div class="col-lg-2">
                                      <label>Unit Price</label>
                                      <input type="text" name="unitP" class="form-control" required="required" value="{{ $pOrder['unit_price'] }}" />
                                    </div>
                                    <div class="col-lg-2">
                                      <label>Amount</label>
                                      <input type="text" name="amt" class="form-control" required="required" value="{{ $pOrder['amount'] }}" />
                                    </div>
                                     <div class="col-lg-4">
                                      <br>
                                      <input type="hidden" id="poId" name="poId" value="{{ $purchaseOrder[0]->id }}" />
                                      <input type="submit" class="btn btn-success" value="Update" />
                                      @if(Auth::user()['role_type'] == 1)
                                      <a id="delete" onClick="confirmDelete('{{ $pOrder['id'] }}')" href="javascript:void" class="btn btn-danger">Remove</a>
                                      @endif
                                    </div>
                                </div>
                               
                            </div>
                          </form>
                            @endforeach
                          
                            
                            <br>
                        </div>
                     </div>
                </div>
            </div>
             			
      				
      	</div>
  
    </div>
     <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Ribos Food Corporation 2019</span>
            <br>
            <br>
            <span>Made with ❤️ at <a href="https://cebucodesolutions.com" target="_blank">Cebu Code Solutions</a></span>
          </div>
        </div>
      </footer>

</div>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script >
    const confirmDelete = (id) => {
        const x = confirm("Do you want to delete this?");
        const poId = $("#poId").val();
          if(x){
              $.ajax({
                type: "DELETE",
                url: '/wimpys-food-express/delete/' + id,
                data:{
                  _method: 'delete', 
                  "_token": "{{ csrf_token() }}",
                  "id": id,
                  "poId":poId,
                },
                success: function(data){
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