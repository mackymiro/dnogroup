@extends('layouts.dno-resources-development-corp-app')
@section('title', 'Edit Delivery Transaction |')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
</script>
<div id="wrapper">
   @include('sidebar.sidebar-dno-resources-development-corp')
   <div id="content-wrapper">
        <div class="container-fluid">
        	<!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                <a href="#">Dno Resources and Development Corp</a>
                </li>
                <li class="breadcrumb-item active">Edit Delivery Transaction</li>
            </ol>
            <a href="{{ url('dno-resources-development/delivery-transaction/records') }}">Back to Lists</a>
            <div class="col-lg-12">
                <img src="{{ asset('images/dno-resources.jpg')}}" width="420" height="250" class="img-responsive mx-auto d-block" alt="DNO Resources and Development Corp">
	            
            	 <h4 class="text-center"><u>DELIVERY TRANSACTION</u></h4>
            </div>
            <div class="row">
                 <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                                <i class="fas fa-receipt" aria-hidden="true"></i>
                            Edit Delivery Transaction
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="form-row">
                                  
                                    <div class="col-lg-4">
                                        <label>Supplier Name</label>
                                        <input type="text" name="supplierName" class="form-control" value="{{ $deliveryT['supplier_name']}}"/>
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Delivery Date</label>
                                        <input type="text" name="deliveryDate" class="datepicker form-control"  value="{{ $deliveryT['delivery_date']}}"/>
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Delivery To</label>
                                        <input type="text" name="deliveredTo" class="form-control" value="{{ $deliveryT['delivered_to'] }}"/>
                                    </div>
                                    <div class="col-lg-2">
                                        <label>DR No</label>
                                        <input type="text" name="drNo" class="form-control"  value="{{ $deliveryT['dr_no']}}" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                  
                                    <div class="col-lg-4">
                                        <label>Delivery Description</label>
                                        <input type="text" name="deliveryDescription" class="form-control" value="{{ $deliveryT['delivery_description'] }}" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Qty</label>
                                        <input type="text" name="qty" class="form-control" value="{{ $deliveryT['qty'] }}" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Total</label>
                                        <input type="text" name="total" class="form-control" value="{{ $deliveryT['total'] }}"  />
                                    </div>
                                </div>
                            </div>
                            <div>
                                <input type="submit" class="btn btn-success float-right" value="Update" />
                            </div>
                        </div>
                    </div>
                 </div>
            </div><!-- end of row -->
            <div class="row">
                 <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="card-header">
                             <i class="fa fa-plus" aria-hidden="true"></i>
                              Add 
                        </div>
                        <div class="card-body">
                             @if(session('addNewSuccess'))
                                <p class="alert alert-success">{{ Session::get('addNewSuccess') }}</p>
                            @endif
                            <form action="{{ action('DnoResourcesDevelopmentController@addDelivery', $deliveryT['id']) }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="form-row">
                                  
                                    <div class="col-lg-12">
                                        <label>Delivery Description</label>
                                        <input type="text" name="deliveryDescription" class="form-control" required  />
                                    </div>
                                    <div class="col-lg-12">
                                        <label>Qty</label>
                                        <input type="text" name="qty" class="form-control" required />
                                    </div>
                                    <div class="col-lg-12">
                                        <label>Total</label>
                                        <input type="text" name="total" class="form-control"  required />
                                    </div>
                                </div>
                            </div>
                            <div>
                                <input type="submit" class="btn btn-primary" value="Add" />
                            
                            </div>
                            </form>
                        </div>
                    </div>
                 </div>
                 <div class="col-lg-8">
                    <div class="card mb-3">
                         <div class="card-header">
                            <i class="fas fa-receipt" aria-hidden="true"></i>
                            Edit Delivery Transaction
                        </div>
                        <div class="card-body">
                             @if(session('SuccessEdit'))
                               <p class="alert alert-success">{{ Session::get('SuccessEdit') }}</p>
                            @endif 
                           
                            @foreach($deliveryTransactions as $deliveryTransaction)
                            <form action="{{ action('DnoResourcesDevelopmentController@updateDT', $deliveryTransaction['id']) }}" method="post">
                             {{csrf_field()}}
                            <input name="_method" type="hidden" value="PATCH">
                             <div id="deletedId{{$deliveryTransaction['id']}}" class="form-group">
                                <div class="form-row">
                                  
                                    <div class="col-lg-4">
                                        <label>Delivery Description</label>
                                        <input type="text" name="deliveryDescription" class="form-control" value="{{ $deliveryTransaction['delivery_description']}}" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Qty</label>
                                        <input type="text" name="qty" class="form-control" value="{{ $deliveryTransaction['qty']}}" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Total</label>
                                        <input type="text" name="total" class="form-control" value="{{ $deliveryTransaction['total']}}"/>
                                    </div>
                                    <div class="col-lg-4">
                                          <br>
                                          
                                          <input type="hidden" name="dtId" value="{{ $deliveryT['id'] }}" />
                                          <input type="submit" class="btn btn-success" value="Update" />
                                          @if(Auth::user()['role_type'] == 1)
                                          <a id="delete" onClick="confirmDelete('{{ $deliveryTransaction['id'] }}')" href="javascript:void" class="btn btn-danger">Remove</a>
                                          @endif
                                      </div> 
                                </div>
                            </div>
                            </form>
                            @endforeach
                        </div>
                    </div>
                 </div>
            </div><!-- end of row -->
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
<script type="text/javascript">
    const confirmDelete = (id) => {
       
        const x = confirm("Do you want to delete this?");
          if(x){
              $.ajax({
                type: "DELETE",
                url: '/dno-resources-development/delivery-transaction/delete/' + id,
                data:{
                  _method: 'delete', 
                  "_token": "{{ csrf_token() }}",
                  "id": id
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