@extends('layouts.dong-fang-corporation-app')
@section('title', 'Edit Purchase Order |')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
</script>
<div id="wrapper">
  	<!-- Sidebar -->
      @include('sidebar.sidebar-dong-fang-corporation')
    <div id="content-wrapper">  
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Dong Fang Corporation</a>
              </li>
              <li class="breadcrumb-item active">Update Purchase Order Form</li>
            </ol>
            <a href="{{ url('dong-fang-corporation/purchase-order-lists') }}">Back to Lists</a>
            <div class="col-lg-12">
            	 <img src="{{ asset('images/dong-fang-corporation.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Dong Fang Corporation">
            	 
            	 <h4 class="text-center"><u>PURCHASE ORDER</u></h4>
            </div>
            <div class="row">
                 <div class="col-lg-12">
                     <div class="card mb-3">
                         <div class="card-header">
                            <i class="fab fa-first-order" aria-hidden="true"></i>
                            Edit Purchase Order
                        </div>
                        <div class="card-body">
                            @if(session('SuccessE'))
                                <p class="alert alert-success">{{ Session::get('SuccessE') }}</p>
                            @endif 
                            <form action="{{ action('DongFangCorporationController@update', $purchaseOrder['id']) }}" method="post">
                                {{csrf_field()}}
                            <input name="_method" type="hidden" value="PATCH">
                            <div class="form-group">
                                <div class="form-row">
                                <div class="col-lg-4">
                                
                                    <label>Paid to</label>
                                    <input type="text" name="paidTo" class="form-control" value="{{ $purchaseOrder['paid_to'] }}" />
                                </div>
                                <div class="col-lg-4">
                                    <label>Address</label>
                                    <input type="text" name="address" class="form-control"  value="{{ $purchaseOrder['address'] }}"  />
                                   
                                </div>
                                <div class="col-lg-2">
                                        <label>Date</label>
                                    <input type="text" name="date"  class="datepicker form-control"  autocomplete="off" value="{{ $purchaseOrder['date'] }}" />
                                  
                                </div>
                                </div>     
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                      <div class="col-lg-2">
                                        <label>Quantity</label>
                                        <input type="text" name="quantity" class="form-control" value="{{ $purchaseOrder['quantity'] }}" />
                                        
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Description</label>
                                        <input type="text" name="description" class="form-control" value="{{ $purchaseOrder['description'] }}" />
                                         
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Unit Price</label>
                                        <input type="text" name="unitPrice" class="form-control" value="{{ $purchaseOrder['unit_price'] }}"  />
                                       
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Amount</label>
                                        <input type="text" name="amount" class="form-control" value="{{ $purchaseOrder['amount'] }}" />
                                        
                                    </div>  
                                </div>
                            </div>
                            <br>
                            <div>
                                <input type="submit" class="btn btn-success float-right" value="Update" />
                                
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
                             <i class="fa fa-plus" aria-hidden="true"></i>
                              Add 
                          </div>
                          <div class="card-body">
                          <form action="{{ action('DongFangCorporationController@addNew', $purchaseOrder['id'] )}}" method="post">
                             {{csrf_field()}}
                          @if(session('addNewSuccess'))
                            <p class="alert alert-success">{{ Session::get('addNewSuccess') }}</p>
                          @endif
                          <div class="form-group">  
                                  <div class="form-row">
                                      <div class="col-lg-12">
                                          <label>Quantity</label>
                                          <input type="text" name="quantity" class="form-control" />
                                      </div>
                                      
                                  </div>
                                  <div class="form-group">
                                      <div class="form-row">
                                          <div class="col-lg-12">
                                              <label>Description</label>
                                              <input type="text" name="description" class="form-control" />
                                            
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <div class="form-row">
                                        <div class="col-lg-12">
                                            <label>Unit Price</label>
                                            <input type="text" name="unitPrice" class="form-control" />
                                        </div>
                                      </div>
                                  </div>
                                  @if ($errors->has('amount'))
                                    <span class="alert alert-danger">
                                      <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                  @endif
                                  <div class="form-group">
                                      <div class="form-row">
                                          <div class="col-lg-12">
                                              <label>Amount</label>
                                              <input type="text" name="amount" class="form-control" required="required" />
                                            
                                          </div>
                                      </div>
                                  </div>
                                 
                                  <div>
                                    @if(Auth::user()['role_type'] == 1)
                                       <input type="submit" class="btn btn-primary btn-lg" value="Add" />
                                    @endif
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
                            Edit Purchase Order
                        </div>
                        <div class="card-body">
                              @if(session('SuccessEdit'))
                               <p class="alert alert-success">{{ Session::get('SuccessEdit') }}</p>
                              @endif 
                            @foreach($pOrders as $pOrder)
                            <form action="{{ action('DongFangCorporationController@updatePo', $pOrder['id']) }}" method="post">
                            <div id="deletedId{{ $pOrder['id'] }}">
                            <div class="form-group">
                                 {{csrf_field()}}
                                 <input name="_method" type="hidden" value="PATCH">

                                <div  class="form-row">
                                <div class="col-lg-2">
                                        <label>Quantity</label>
                                        <input type="text" name="quantity" class="form-control" value="{{ $pOrder['quantity']}}" />
                                    
                                    </div>
                                    <div class="col-lg-4">
                                      <label>Description</label>
                                      <input type="text" name="description" class="form-control" value="{{ $pOrder['description']}}" />
                                    
                                    </div>
                                    <div class="col-lg-2">
                                      <label>Unit Price</label>
                                      <input type="text" name="unitPrice" class="form-control" value="{{ $pOrder['unit_price']}}" />
                                    
                                    </div>
                                  
                                    <div class="col-lg-2">
                                      <label>Amount</label>
                                      <input type="text" name="amount" class="form-control" value="{{ $pOrder['amount']}}" />
                                     
                                    </div>
                                </div>
                               
                            </div>
                            <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-4">
                                          
                                            <input type="hidden" id="poId" name="poId" value="{{ $purchaseOrder['id'] }}" />
                                            <input type="submit" class="btn btn-success" value="Update" />
                                            @if(Auth::user()['role_type'] == 1)
                                            <a id="delete" onClick="confirmDelete('{{ $pOrder['id'] }}')" href="javascript:void" class="btn btn-danger">Remove</a>
                                            @endif
                                        </div> 
                                    </div>
                                </div>
                            </div>
                          </form>

                              @endforeach
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
<script>
    const confirmDelete = (id) => {
      const  x = confirm("Do you want to delete this?");
      const poId = $("#poId").val();
          if(x){
              $.ajax({
                type: "DELETE",
                url: '/dong-fang-corporation/delete/' + id,
                data:{
                  _method: 'delete', 
                  "_token": "{{ csrf_token() }}",
                  "id": id,
                  "poId":poId,
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