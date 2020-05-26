@extends('layouts.wlg-corporation-app')
@section('title', 'Edit Purchase Order |')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
</script>
<div id="wrapper">
  	@include('sidebar.sidebar-wlg-corporation')
    <div id="content-wrapper"> 
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                <a href="#">WLG Corporation</a>
                </li>
                <li class="breadcrumb-item active">Update Purchase Order Form</li>
            </ol>
            <a href="{{ url('wlg-corporation/purchase-order-lists') }}">Back to Lists</a>
            <div class="col-lg-12">
                <img src="{{ asset('images/wlg-corporation.png')}}" width="235" height="114" class="img-responsive mx-auto d-block" alt="WLG Corporation">                
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
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-4">
                                        <label>Paid To</label>
                                        <input type="text" name="paidTo" class="form-control" value="{{ $purchaseOrder['paid_to'] }}" />
                                     
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Address</label>
                                        <input type="text" name="address" class="form-control"  value="{{ $purchaseOrder['address'] }}" />
                                      
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Date</label>
                                        <input type="text" name="date" class="datepicker form-control" value="{{ $purchaseOrder['date'] }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-2">
                                        <label>Model</label>
                                        <input type="text" name="model" class="form-control"  value="{{ $purchaseOrder['model'] }}" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Particulars</label>
                                        <input type="text" name="particulars" class="form-control" value="{{ $purchaseOrder['particulars'] }}" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Quantity</label>
                                        <input type="text" name="quantity" class="form-control"  value="{{ $purchaseOrder['quantity'] }}" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Unit Price</label>
                                        <input type="text" name="unitPrice" class="form-control" value="{{ $purchaseOrder['unit_price'] }}" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Amount</label>
                                        <input type="text" name="amount" class="form-control"  value="{{ $purchaseOrder['amount'] }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="float-right">
                                <button type="submit" class="btn btn-success"><i class="fas fa-redo-alt"></i> Update Purchase Order</button>
                            </div> 
                         </div>
                    </div>      
                </div>
            </div>
            <div class="row">
                 <div class="col-lg-4">
                     <div class="card mb-3">
                         <div class="card-header">
                      		 <i class="fa fa-plus" aria-hidden="true"></i>
                         	 Add Particulars
                         </div>
                         <div class="card-body">
                            <form action="{{ action('WlgCorporationController@addNewParticulars', $purchaseOrder['id']) }}" method="post">
                            {{csrf_field()}}
                            @if(session('particularsAdded'))
                                <p class="alert alert-success">{{ Session::get('particularsAdded') }}</p>
                            @endif
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-12">
                                        <label>Model</label>
                                        <input type="text" name="model" class="form-control" />
                                    </div>
                                    <div class="col-lg-12">
                                        <label>Particulars</label>
                                        <input type="text" name="particulars" class="form-control" />
                                    </div>
                                    <div class="col-lg-12">
                                        <label>Quantity</label>
                                        <input type="text" name="quantity" class="form-control" />
                                    </div>
                                    <div class="col-lg-12">
                                        <label>Unit Price</label>
                                        <input type="text" name="unitPrice" class="form-control" />
                                    </div>
                                    <div class="col-lg-12 ">
                                        <label>Amount</label>
                                        <input type="text" name="amount" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary"> <i class="fa fa-plus" aria-hidden="true"></i> Add New</button>
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
                             <form action="{{ action('WlgCorporationController@updatePo', $pOrder['id']) }}" method="post">
                             {{csrf_field()}}
                            <input name="_method" type="hidden" value="PATCH">
                             <div id="deletedId{{ $pOrder['id'] }}"> 
                             <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-2">
                                            <label>Model</label>
                                            <input type="text" name="model" class="form-control" value="{{ $pOrder['model'] }}" />
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Particulars</label>
                                            <input type="text" name="particulars" class="form-control" value="{{ $pOrder['particulars'] }}"/>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Quantity</label>
                                            <input type="text" name="quantity" class="form-control" value="{{ $pOrder['quantity'] }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Unit Price</label>
                                            <input type="text" name="unitPrice" class="form-control" value="{{ $pOrder['unit_price'] }}" />
                                        </div>
                                        <div class="col-lg-2 ">
                                            <label>Amount</label>
                                            <input type="text" name="amount" class="form-control" value="{{ $pOrder['amount'] }}"/>
                                        </div>
                                    </div>
                              </div>
                              <div class="form-group">
                                    <div class="form-row">
                                        <div>
                                            <input type="hidden" name="poId" value="{{ $purchaseOrder['id'] }}" />
                                            <button type="submit" class="btn btn-success"> <i class="fas fa-redo-alt"></i></button>
                                            
                                            @if(Auth::user()['role_type'] == 1)
                                              <a href="javascript:void" onclick="confirmDelete('{{ $pOrder['id'] }}')" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
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
<script type="text/javascript">
    const confirmDelete = (id) =>{
        const x = confirm("Do you want to delete this?");
        if(x){
            $.ajax({
              type: "DELETE",
              url: '/wlg-corporation/delete/' + id,
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