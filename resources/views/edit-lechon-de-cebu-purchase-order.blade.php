@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Edit Purchase Order |')
@section('content')

<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
</script>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css" >
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>


<div id="wrapper">
	 @include('sidebar.sidebar')

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
                               <form action="{{ action('LoloPinoyLechonDeCebuController@update', $purchaseOrder[0]->id) }}" method="post">
                               {{csrf_field()}}
                              <input name="_method" type="hidden" value="PATCH">
                              <div class="form-group">
                                <div class="form-row">
                                  <div class="col-lg-6">
                                    <label>Paid to</label>
                                  <input type="text" name="paidTo" class="form-control"  value="{{ $purchaseOrder[0]->paid_to }}" />
                                  <label>Address</label>
                                  <input type="text" name="address" class="form-control"  value="{{ $purchaseOrder[0]->address }}" />
                                 
                                  </div>
                                  <div class="col-lg-6">
                                    <label>P.O Number</label>
                                    <input type="text" name="poNum" class="form-control" disabled="disabled"  value="{{ $purchaseOrder[0]->lechon_de_cebu_code }}" />
                                    <label>Date</label>
                                    <input type="text" name="date" id="datepicker" class="form-control"  value="{{ $purchaseOrder[0]->date }}" />
                                   
                                    <label>Received By</label>
                                    <select data-live-search="true" name="recievedBy" class="form-control selectpicker">
                                          @foreach($getSuppliers as $getSupplier)
                                          <option value="{{ $getSupplier['supplier_name']}}">{{ $getSupplier['supplier_name']}}</option>
                                          @endforeach
                                      </select>
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
                                    <input type="submit" class="btn btn-success btn-lg"  value="Update Purchase Order" />
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
                             <div class="form-group">
                                <div class="form-row">  
                                    <div class="col-lg-12">
                                    
                                      <label>Quantity</label>
                                      <input type="text" name="quant" class="form-control" required="required"  />

                                    </div>
                                    <div class="col-lg-12">
                                      <label>Description</label>
                                      <input type="text" name="desc" class="form-control" required="required"  />
                                    </div>
                                    <div class="col-lg-12">
                                      <label>Unit Price</label>
                                      <input type="text" name="unitPrice" class="form-control" required="required"  />
                                    </div>
                                    <div class="col-lg-12">
                                      <label>Amount</label>
                                      <input type="text" name="amount" class="form-control" required="required" />
                                    </div>
                                  </div>
                              </div>
                          
                            <div>
                              @if(Auth::user()['role_type'] == 1)
                              <a href="{{ url('lolo-pinoy-lechon-de-cebu/add-new/'.$purchaseOrder[0]->id) }}" class="btn btn-primary btn-lg">Add</a>
                              @endif
                            </div>
                            
                            <br>
                        </div>
                     </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-3">
                          <div class="card-header">
                          <i class="fab fa-first-order" aria-hidden="true"></i>
                              Edit Purchase Order</div>
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
                                  <div class="col-lg-2">
                                    <label>Total Kls</label>
                                    <input type="text" name="totalKls" class="form-control" value="{{ $pOrder['total_kls']}}" />
                                   
                                  </div>
                                    <div class="col-lg-2">
                                      <label>Unit Price</label>
                                      <input type="text" name="unitP" class="form-control" required="required" value="{{ $pOrder['unit_price'] }}" />
                                    </div>
                                    <div class="col-lg-2">
                                      <label>Amount</label>
                                      <input type="text" name="amt" class="form-control" required="required" value="{{ $pOrder['amount'] }}" />
                                    </div>
                                     <div class="col-lg-2">
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
<script type="text/javascript">
    const confirmDelete = (id) => {
        const x = confirm("Do you want to delete this?");
        const poId = $("#poId").val();
          if(x){
              $.ajax({
                type: "DELETE",
                url: '/lolo-pinoy-lechon-de-cebu/delete/' + id,
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