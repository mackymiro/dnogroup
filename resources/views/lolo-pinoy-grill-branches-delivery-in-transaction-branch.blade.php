@extends('layouts.lolo-pinoy-grill-branches-app')
@section('title', 'Delivery In Transaction Branch| ')
@section('content')
<script>
    $(function(){
      $( ".datepicker" ).datepicker();
      $('table.display').DataTable( {} );
    });
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div id="wrapper">
    <!-- Sidebar -->
    @include('sidebar.sidebar-lolo-pinoy-grill-branches')
    <div id="content-wrapper">
        <div class="container-fluid">
             <!-- Breadcrumbs-->
             <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lolo Pinoy Grill Branches</a>
              </li>
              <li class="breadcrumb-item active">{{ Session::get('sessionDeliveryInTransaction') }}</li>
                 
              <li class="breadcrumb-item active">Delivery In Transaction Branch</li> 
            </ol> 
            <div class="col-lg-12">
            	<img src="{{ asset('images/digitized-logos/lolo-pinoy-grill.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lolo Pinoy Grill ">
            	 
            	 <h4 class="text-center"><u>DELIVERY IN TRANSACTION</u></h4>
                   
            </div>   
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            {{ Session::get('sessionDeliveryInTransaction') }} Branch
                            <div class="float-right">
                                <form action="{{ action('LoloPinoyGrillBranchesController@logoutDeliveryIn') }}" method="post">
                                     {{ csrf_field() }}
                                     <button type="submit" class="btn btn-danger btn-lg"><i class="fas fa-sign-out-alt"></i> Log Out</button>
                                </form>
                            </div>  
                        </div>
                        <div class="card-body">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deliveryIn">
                              Delivery In Form
                            </button>
                            <br>
                    			 <br>
                            @if($data )
                			 	    <div class="table-responsive">
                                  <table class="table table-bordered display"  width="100%" cellspacing="0">
                                      <thead>
                                          <th>Action</th>
                                          <th>Date</th>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Price</th>
                                          <th>Qty</th>
                                          <th>IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </thead>
                                      <tfoot>
                                          <th>Action</th>
                                          <th>Date</th>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Price</th>
                                          <th>Qty</th>
                                          <th>IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </tfoot>
                                      <tbody>
                                          @foreach($getDeliveryBranches as $getDeliveryBranch)
                                          <tr id="deletedId{{ $getDeliveryBranch->id}}">
                                            <td>
                                            	<!-- Button trigger modal -->
									                            <a data-toggle="modal" data-target="#deliveryBranch<?= $getDeliveryBranch->id?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
											                        @if(Auth::user()['role_type'] != 3 && Auth::user()['role_type'] != 2 && Auth::user()['role_type'] != 4)
                                              <a id="delete" href="javascript:void" onClick="confirmDelete('{{ $getDeliveryBranch->id }}')" title="Delete"><i class="fas fa-trash"></i></a>
                                              @endif
                                            </td>
                                            <td>{{ $getDeliveryBranch->date}}</td>
                                            <td>{{ $getDeliveryBranch->product_id_no}}</td>
                                            <td>{{ $getDeliveryBranch->dr_no}}</td>
                                            <td>{{ $getDeliveryBranch->supplier}}</td>
                                            <td>{{ $getDeliveryBranch->product_name}}</td>
                                            <td>₱ <?= number_format($getDeliveryBranch->price, 2)?></td>
                                            <td>{{ $getDeliveryBranch->qty}}</td>
                                            <td><?= number_format($getDeliveryBranch->product_in, 2)?></td>
                                            <td>{{ $getDeliveryBranch->unit}}</td>
                                            <td><?= number_format($getDeliveryBranch->amount, 2)?></td>
                                            <td>{{ $getDeliveryBranch->created_by}}</td>
                                          </tr>
                                          @endforeach
                                      </tbody>
                                  </table>
                            </div>
                            
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                 <div class="col-lg-12">
                     <div class="card mb-3">
                       <div class="card-header">
                            <i class="fas fa-glass-cheers"></i> 
                            Beverages
                        </div>
                        <div class="card-body">
                             <!-- Button trigger modal -->
                             <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deliveryInDrinks">
                              Delivery In Form
                            </button>
                            <br>
                            <br>
                            @if($data)
                            <div class="table-responsive">
                                <table class="table table-bordered display" width="100%" cellspacing="0">
                                       <thead>
                                          <th>Action</th>
                                          <th>Date</th>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Price</th>
                                          <th>Qty</th>
                                          <th>IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </thead>
                                      <tfoot>
                                          <th>Action</th>
                                          <th>Date</th>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Price</th>
                                          <th>Qty</th>
                                          <th>IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </tfoot>
                                      <tbody>
                                          @foreach($getDeliveryBranchDrinks as $getDeliveryBranchDrink)
                                          <tr id="deletedId{{ $getDeliveryBranchDrink->id}}">
                                            <td>
                                            	<!-- Button trigger modal -->
									                            <a data-toggle="modal" data-target="#getDeliveryBranchDrink<?= $getDeliveryBranchDrink->id?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
											                        @if(Auth::user()['role_type'] != 3 && Auth::user()['role_type'] != 2 && Auth::user()['role_type'] != 4)
                                              <a id="delete" href="javascript:void" onClick="confirmDelete('{{ $getDeliveryBranchDrink->id }}')" title="Delete"><i class="fas fa-trash"></i></a>
                                              @endif
                                            </td>
                                            <td>{{ $getDeliveryBranchDrink->date}}</td>
                                            <td>{{ $getDeliveryBranchDrink->product_id_no}}</td>
                                            <td>{{ $getDeliveryBranchDrink->dr_no}}</td>
                                            <td>{{ $getDeliveryBranchDrink->supplier}}</td>
                                            <td>{{ $getDeliveryBranchDrink->product_name}}</td>
                                            <td>₱ <?= number_format($getDeliveryBranchDrink->price, 2)?></td>
                                            <td>{{ $getDeliveryBranchDrink->qty}}</td>
                                            <td><?= number_format($getDeliveryBranchDrink->product_in, 2)?></td>
                                            <td>{{ $getDeliveryBranchDrink->unit}}</td>
                                            <td><?= number_format($getDeliveryBranchDrink->amount, 2)?></td>
                                            <td>{{ $getDeliveryBranchDrink->created_by}}</td>
                                          </tr>
                                          @endforeach
                                      </tbody>
                                </table>
                            </div>
                           
                            @endif
                        </div>  
                     </div>
                 </div>
            </div>
        </div>
    </div>
       <!-- Modal -->
    @foreach($getDeliveryBranches as $getDeliveryBranch)
    <div class="modal fade" id="deliveryBranch{{ $getDeliveryBranch->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Edit Delivery In</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="succUp{{ $getDeliveryBranch->id}}"></div>
            <div class="form-group">
              <div class="form-row"> 
                <div class="col-lg-2">
                  <label>Date</label>
                  <input type="text" id="dateUpdate{{ $getDeliveryBranch->id }}" name="date" class="datepicker form-control"  value="{{ $getDeliveryBranch->date}}" />
                </div>
                <div class="col-lg-2">
                  <label>Product ID</label>
                  <input type="text"  name="productId" class="form-control" value="{{ $getDeliveryBranch->product_id_no}}" disabled />
                </div>
                <div class="col-lg-2">
                  <label>DR No</label>
                  <input type="text" id="drNoUpdate{{ $getDeliveryBranch->id }}" name="drNo" class="form-control" value="{{ $getDeliveryBranch->dr_no }}" />
                </div>
                <div class="col-lg-4">
                  <label>Supplier</label>
                  <input type="text" id="supplierUpdate{{ $getDeliveryBranch->id }}" name="supplier" class="form-control" value="{{ $getDeliveryBranch->supplier}}" />
                </div>
                <div class="col-lg-4">
                  <label>Product Name</label>
                  <input type="text" id="productNameUpdate{{ $getDeliveryBranch->id }}" name="productName" class="form-control" value="{{ $getDeliveryBranch->product_name }}" />
                </div>
                @if(Auth::user()['role_type'] === 4)
                <div class="col-lg-4">
                  <label>Price</label>
                  <input type="text" name="price" class="form-control" value="{{ $getDeliveryBranch->price }}" onkeypress="return isNumber(event)" readonly />
                </div>
                @else 
                <div class="col-lg-4">
                  <label>Price</label>
                  <input type="text" id="priceUpdate{{ $getDeliveryBranch->id }}" name="price" class="form-control" value="{{ $getDeliveryBranch->price }}" onkeypress="return isNumber(event)" />
                </div>

                @endif
                <div class="col-lg-2">
                  <label>Qty</label>
                  <input type="text" id="qtyUpdate{{ $getDeliveryBranch->id}}" name="qty" class="form-control" value="{{ $getDeliveryBranch->qty }}" onkeypress="return isNumber(event)" />
                </div>
                <div class="col-lg-2">
                  <label>IN</label>
                  <input type="text" id="productInUpdate{{ $getDeliveryBranch->id}}" name="productIn" class="form-control" value="{{ $getDeliveryBranch->product_in }}" onkeypress="return isNumber(event)" />
                </div>
                <div class="col-lg-4">
                  <label>Unit</label>
                  <input type="text" id="unitUpdate{{ $getDeliveryBranch->id}}" name="unit" class="form-control" value="{{ $getDeliveryBranch->unit}}" />
                </div>
                <div class="col-lg-4">
                  <label>Amount</label>
                  <input type="text" id="amountUpdate{{ $getDeliveryBranch->id}}" name="amount" class="form-control" value="{{ $getDeliveryBranch->amount }}" onkeypress="return isNumber(event)" />
                </div>

              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
            <button type="button" onclick="updateDeliveryIn(<?= $getDeliveryBranch->id; ?>)" class="btn btn-success btn-lg">Update</button>
          </div>
        </div>
      </div>
    </div>  
    @endforeach
   


    @foreach($getDeliveryBranchDrinks as $getDeliveryBranchDrink)
    <div class="modal fade" id="getDeliveryBranchDrink{{ $getDeliveryBranchDrink->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Edit Delivery In</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="succUp{{ $getDeliveryBranchDrink->id}}"></div>
            <div class="form-group">
              <div class="form-row"> 
                <div class="col-lg-2">
                  <label>Date</label>
                  <input type="text" id="dateUpdate{{ $getDeliveryBranchDrink->id }}" name="date" class="datepicker form-control"  value="{{ $getDeliveryBranchDrink->date}}" />
                </div>
                <div class="col-lg-2">
                  <label>Product ID</label>
                  <input type="text"  name="productId" class="form-control" value="{{ $getDeliveryBranchDrink->product_id_no}}" disabled />
                </div>
                <div class="col-lg-2">
                  <label>DR No</label>
                  <input type="text" id="drNoUpdate{{ $getDeliveryBranchDrink->id }}" name="drNo" class="form-control" value="{{ $getDeliveryBranchDrink->dr_no }}" />
                </div>
                <div class="col-lg-4">
                  <label>Supplier</label>
                  <input type="text" id="supplierUpdate{{ $getDeliveryBranchDrink->id }}" name="supplier" class="form-control" value="{{ $getDeliveryBranchDrink->supplier}}" />
                </div>
                <div class="col-lg-4">
                  <label>Product Name</label>
                  <input type="text" id="productNameUpdate{{ $getDeliveryBranchDrink->id }}" name="productName" class="form-control" value="{{ $getDeliveryBranchDrink->product_name }}" />
                </div>
                @if(Auth::user()['role_type'] === 4)
                <div class="col-lg-4">
                  <label>Price</label>
                  <input type="text" name="price" class="form-control" value="{{ $getDeliveryBranchDrink->price }}" onkeypress="return isNumber(event)" readonly/>
                </div>
                @else
                <div class="col-lg-4">
                  <label>Price</label>
                  <input type="text" id="priceUpdate{{ $getDeliveryBranchDrink->id }}" name="price" class="form-control" value="{{ $getDeliveryBranchDrink->price }}" onkeypress="return isNumber(event)" />
                </div>
                @endif
                <div class="col-lg-2">
                  <label>Qty</label>
                  <input type="text" id="qtyUpdate{{ $getDeliveryBranchDrink->id}}" name="qty" class="form-control" value="{{ $getDeliveryBranchDrink->qty }}" onkeypress="return isNumber(event)" />
                </div>
                <div class="col-lg-2">
                  <label>IN</label>
                  <input type="text" id="productInUpdate{{ $getDeliveryBranchDrink->id}}" name="productIn" class="form-control" value="{{ $getDeliveryBranchDrink->product_in }}" onkeypress="return isNumber(event)" />
                </div>
                <div class="col-lg-4">
                  <label>Unit</label>
                  <input type="text" id="unitUpdate{{ $getDeliveryBranchDrink->id}}" name="unit" class="form-control" value="{{ $getDeliveryBranchDrink->unit}}" />
                </div>
                <div class="col-lg-4">
                  <label>Amount</label>
                  <input type="text" id="amountUpdate{{ $getDeliveryBranchDrink->id}}" name="amount" class="form-control" value="{{ $getDeliveryBranchDrink->amount }}" onkeypress="return isNumber(event)" />
                </div>

              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
            <button type="button" onclick="updateDeliveryIn(<?= $getDeliveryBranchDrink->id; ?>)" class="btn btn-success btn-lg">Update</button>
          </div>
        </div>
      </div>
    </div>  
    @endforeach

     <!-- Modal -->
     <div class="modal fade" id="deliveryInDrinks" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Delivery In Beverages -  {{ Session::get('sessionDeliveryInTransaction') }} Branch</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="succAdd"></div>
            <div class="validate" class="col-lg-12">
              <p class="alert alert-danger">Please fill up field</p>
            </div>
            <div class="form-group">
              <div class="form-row">
                  <div class="col-lg-2">
                    <label>Date</label>
                    <input type="text" id="date" name="date" class="datepicker form-control" required/>
                  </div>
                  <div class="col-lg-2">
                    <label>DR No</label>
                    <input type="text" id="drNo" name="drNo" class="form-control" required />
                  </div>
                  <div class="col-lg-4">
                    <label>Supplier</label>
                    <input type="text" id="supplier" name="supplier" class="form-control" />
                  </div>
                  <div class="col-lg-4">
                    <label>Product Name</label>
                    <input type="text" id="productName" name="productName" class="form-control" />
                  </div>
                  <div class="col-lg-4">
                    <label>Price</label>
                    <input type="text" id="price" name="price" class="form-control" onkeypress="return isNumber(event)"  />
                  </div>
                  <div class="col-lg-2">
                    <label>Qty</label>
                    <input type="text" id="qty" name="qty" class="form-control" onkeypress="return isNumber(event)" />
                  </div>
                  <div class="col-lg-2">
                    <label>Unit</label>
                    <input type="text" id="unit" name="unit" class="form-control" />
                  </div>
                  <div class="col-lg-2">
                    <label>IN</label>
                    <input type="text" id="productIn" name="productIn" class="form-control" onkeypress="return isNumber(event)" />
                  </div>
                  <div class="col-lg-2">
                    <label>Amount</label>
                    <input type="text" id="amount" name="amount" class="form-control" onkeypress="return isNumber(event)"/>
                  </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" id="branchName" value="{{ Session::get('sessionDeliveryInTransaction') }}" />
            <input type="hidden" id="flag" value="Drinks" /> 
            <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
            <button type="button" onclick="saveDeliveryInDrinks()" class="btn btn-success btn-lg">Save</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="deliveryIn" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Delivery In Transaction -  {{ Session::get('sessionDeliveryInTransaction') }} Branch</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="succAdd"></div>
            <div class="validate" class="col-lg-12">
              <p class="alert alert-danger">Please fill up field</p>
            </div>
            <div class="form-group">
              <div class="form-row">
                  <div class="col-lg-2">
                    <label>Date</label>
                    <input type="text"  name="date" class="date datepicker form-control" required/>
                  </div>
                  <div class="col-lg-2">
                    <label>DR No</label>
                    <input type="text" name="drNo" class="drNo form-control" required />
                  </div>
                  <div class="col-lg-4">
                    <label>Supplier</label>
                    <input type="text" name="supplier" class="supplier form-control" />
                  </div>
                  <div class="col-lg-4">
                    <label>Product Name</label>
                    <input type="text"  name="productName" class="productName form-control" />
                  </div>
                  <div class="col-lg-4">
                    <label>Price</label>
                    <input type="text"  name="price" class="price form-control" onkeypress="return isNumber(event)"  />
                  </div>
                  <div class="col-lg-2">
                    <label>Qty</label>
                    <input type="text"  name="qty" class="qty form-control" onkeypress="return isNumber(event)" />
                  </div>
                  <div class="col-lg-2">
                    <label>Unit</label>
                    <input type="text"  name="unit" class="unit form-control" />
                  </div>
                  <div class="col-lg-2">
                    <label>IN</label>
                    <input type="text" name="productIn" class="productIn form-control" onkeypress="return isNumber(event)" />
                  </div>
                  <div class="col-lg-2">
                    <label>Amount</label>
                    <input type="text"  name="amount" class="amount form-control" onkeypress="return isNumber(event)"/>
                  </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" class="branchName" value="{{ Session::get('sessionDeliveryInTransaction') }}" />
            <input type="hidden" class="flag" value="Foods"/>
            <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
            <button type="button" onclick="saveDeliveryIn()" class="btn btn-success btn-lg">Save</button>
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
<script>
    $(".validate").hide();

    const confirmDelete = (id) =>{
        const  x = confirm("Do you want to delete this?");
        if(x){
              $.ajax({
                type: "DELETE",
                url: '/lolo-pinoy-grill-branches/delivery-in-transaction/delete/' + id,
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

    const saveDeliveryInDrinks = () =>{
        const date = $("#date").val();
        const drNo = $("#drNo").val();
        const supplier = $("#supplier").val();
        const productName = $("#productName").val();
        const price = $("#price").val();
        const qty = $("#qty").val();
        const unit = $("#unit").val();
        const productIn = $("#productIn").val();
        const amount = $("#amount").val();
        const branchName = $("#branchName").val();
        const flag = $("#flag").val();

        if(date.length === 0 || supplier.length === 0){
          $(".validate").fadeIn().delay(3000).fadeOut();
        }else{
            //make ajax call
            $.ajax({
                type: "POST",
                url: '/lolo-pinoy-grill-branches/store-delivery-in',
                data:{
                  _method: 'post',
                  "_token": "{{ csrf_token() }}",
                  "date":date,
                  "drNo":drNo,
                  "supplier":supplier,
                  "productName":productName,
                  "price":price,
                  "qty":qty,
                  "unit":unit,
                  "productIn":productIn,
                  "amount":amount,
                  "branchName":branchName,
                  "flag":flag,
                },
                success: function(data){
                  console.log(data);
                  const getData = data;
                  const succData = getData.split(":");
                  const succDataArr = succData[0];

                  if(succDataArr == "Success"){
                      $("#succAdd").fadeIn().delay(3000).fadeOut();
                      $("#succAdd").html(`<p class="alert alert-success">${data}</p>`);
                    
                      setTimeout(function(){
                        document.location.reload();
                      }, 3000);
                  }

                  $("#date").val('');
                  $("#drNo").val('');
                  $("#supplier").val('');
                  $("#productName").val('');
                  $("#price").val('');
                  $("#qty").val('');
                  $("#unit").val('');
                  $("#productIn").val('');
                  $("#amount").val('');

                },
                error: function (data){

                }
            });
        }

    }

    const updateDeliveryIn = (id) =>{
      const dateUpdate = $("#dateUpdate"+id).val();
      const drNoUpdate = $("#drNoUpdate"+id).val();
      const supplierUpdate = $("#supplierUpdate"+id).val();
      const productNameUpdate = $("#productNameUpdate"+id).val();
      const priceUpdate = $("#priceUpdate"+id).val();
      const qtyUpdate = $("#qtyUpdate"+id).val();
      const productInUpdate = $("#productInUpdate"+id).val();
      const unitUpdate = $("#unitUpdate"+id).val();
      const amountUpdate = $("#amountUpdate"+id).val();

  
      //make ajax call
      $.ajax({
              type: "PATCH",
              url: '/lolo-pinoy-grill-branches/update-store-delivery-in/'+id,
              data:{
                _method: 'patch',
                "_token": "{{ csrf_token() }}",
                "dateUpdate":dateUpdate,
                "drNoUpdate":drNoUpdate,
                "supplierUpdate":supplierUpdate,
                "productNameUpdate":productNameUpdate,
                "priceUpdate":priceUpdate,
                "qtyUpdate":qtyUpdate,
                "productInUpdate":productInUpdate,
                "unitUpdate":unitUpdate,
                "amountUpdate":amountUpdate,
              },
              success: function(data){
                console.log(data);
                const getData = data;
                const succData = getData.split(":");
                const succDataArr = succData[0];

                if(succDataArr == "Success"){
                  $("#succUp"+id).fadeIn().delay(3000).fadeOut();
                  $("#succUp"+id).html(`<p class="alert alert-success">${data}</p>`);
                  
                  setTimeout(function(){
                    document.location.reload();
                  }, 3000);
                }
              },
              error: function (data){
                  console.log('Error:', data);
              }
          });
     
    }

    const isNumber =(evt) => {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
          return false;
        }
        return true;
    }

    const saveDeliveryIn = () =>{
        const date = $(".date").val();
        const drNo = $(".drNo").val();
        const supplier = $(".supplier").val();
        const productName = $(".productName").val();
        const price = $(".price").val();
        const qty = $(".qty").val();
        const unit = $(".unit").val();
        const productIn = $(".productIn").val();
        const amount = $(".amount").val();
        const branchName = $(".branchName").val();
        const flag = $(".flag").val(); 

        if(date.length === 0 || supplier.length === 0){
          $(".validate").fadeIn().delay(3000).fadeOut();
        }else{
          //make ajax call
          $.ajax({
              type: "POST",
              url: '/lolo-pinoy-grill-branches/store-delivery-in',
              data:{
                _method: 'post',
                "_token": "{{ csrf_token() }}",
                "date":date,
                "drNo":drNo,
                "supplier":supplier,
                "productName":productName,
                "price":price,
                "qty":qty,
                "unit":unit,
                "productIn":productIn,
                "amount":amount,
                "branchName":branchName,
                "flag":flag,
              },
              success: function(data){
                console.log(data);
                const getData = data;
                const succData = getData.split(":");
                const succDataArr = succData[0];

                if(succDataArr == "Success"){
                  $(".succAdd").fadeIn().delay(3000).fadeOut();
                  $(".succAdd").html(`<p class="alert alert-success">${data}</p>`);
                  
                  setTimeout(function(){
                    document.location.reload();
                  }, 3000);
                }
              },
              error: function (data){
                  console.log('Error:', data);
              }
          });

        }
    }
</script>
@endsection