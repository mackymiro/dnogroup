@extends('layouts.wimpys-food-express-app')
@section('title', 'Order Form |')
@section('content')

<div id="wrapper">
	<!-- Sidebar -->
    @include('sidebar.sidebar-wimpys-food-express')
    <div id="content-wrapper">
      <form action="{{ action('WimpysFoodExpressController@storeBillingStatement') }}" method="post">
          {{csrf_field()}}
    	<div class="container-fluid">
    		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Wimpy's Food Express</a>
              </li>
              <li class="breadcrumb-item active">Order Form</li>
              <li class="breadcrumb-item active">Transactions</li>
            </ol>
            <div class="col-lg-12">
            <img src="{{ asset('images/digitized-logos/wimpys-logo1.jpg')}}" width="350" height="178" class="img-responsive mx-auto d-block" alt="Wimpy's Food Express">
            	 
             
            	 <h4 class="text-center"><u>Order Form</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            Kitchen</div>
                          <div class="card-body">
                            <div class="form-group">
                                <div class="form-row">
                                    <?php foreach($getMaterials as $getMaterial): ?>
                                      <div class="col-lg-4">
                                            <button type="button" class="bbq btn btn-primary btn-lg" data-toggle="modal" data-target="#orderForm" data-id="1" data-price="<?= $getMaterial['price']; ?>" data-unit="<?= $getMaterial['unit'];?>" data-menu="<?= $getMaterial['product_name']?>" ><?= $getMaterial['product_name']; ?> ₱ <?= number_format($getMaterial['price'], 2)?></button>
                                            <br>
                                            <br>
                                      </div>
                                    <?php endforeach; ?>
                                    
                                      
                                  </div>
                            </div>
                    </div>
                </div>
            </div>
            
           
    	  </div>
        <div class="row">
              <div class="col-lg-12">
                  <div class="card mb-3">
                      <div class="card-header">
                            <i class="fas fa-receipt" aria-hidden="true"></i>
                          Dessert</div>
                        <div class="card-body">
                        <div class="form-group">
                            <div class="form-row">
                                  <?php foreach($getMaterials2 as $getMaterial2): ?>
                                      <div class="col-lg-4">
                                            <button type="button" class="bbq btn btn-primary btn-lg" data-toggle="modal" data-target="#orderForm" data-id="1" data-price="<?= $getMaterial2['price']?>" data-unit="<?= $getMaterial2['unit']; ?>" data-menu="<?= $getMaterial2['product_name'] ?>" ><?= $getMaterial2['product_name']; ?> ₱ <?= number_format($getMaterial2['price'], 2) ?></button>
                                            <br>
                                            <br>
                                      </div>
                                    <?php endforeach; ?>
                                  
                              </div>
                        </div>

                    
                  </div>
              </div>
          </div>
            
           
    	  </div>
        <div class="row">
              <div class="col-lg-12">
                  <div class="card mb-3">
                      <div class="card-header">
                            <i class="fas fa-receipt" aria-hidden="true"></i>
                          Decor</div>
                        <div class="card-body">
                        <div class="form-group">
                            <div class="form-row">
                                    <?php foreach($getMaterials3 as $getMaterial3): ?>
                                      <div class="col-lg-4">00
                                            <button type="button" class="bbq btn btn-primary btn-lg" data-toggle="modal" data-target="#orderForm" data-id="1" data-price="<?= $getMaterial3['price']; ?>" data-unit="<?= $getMaterial3['unit'];?>" data-menu="<?= $getMaterial3['product_name']?>" ><?= $getMaterial3['product_name']; ?> ₱ <?= number_format($getMaterial3['price'], 2) ?></button>
                                            <br>
                                            <br>
                                      </div>
                                    <?php endforeach; ?>
                                  
                              </div>
                        </div>

                    
                  </div>
              </div>
          </div>
            
           
    	  </div>
        <div class="row">
              <div class="col-lg-12">
                  <div class="card mb-3">
                      <div class="card-header">
                            <i class="fas fa-receipt" aria-hidden="true"></i>
                          Equipment & Supplies</div>
                        <div class="card-body">
                        <div class="form-group">
                            <div class="form-row">
                                    <?php foreach($getMaterials4 as $getMaterial4): ?>
                                      <div class="col-lg-4">
                                            <button type="button" class="bbq btn btn-primary btn-lg" data-toggle="modal" data-target="#orderForm" data-id="1" data-price="<?= $getMaterial4['price']?>" data-menu="<?= $getMaterial4['product_name']?>" ><?= $getMaterial4['product_name']; ?> ₱ <?= number_format($getMaterial4['price'], 2) ?></button>
                                            <br>
                                            <br>
                                      </div>
                                    <?php endforeach; ?>
                                  
                              </div>
                        </div>

                    
                  </div>
              </div>
          </div>   
    	  </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-receipt" aria-hidden="true"></i>
                        Order Form
                    </div>
                    <div class="card-body">
                       <div class="form-group">
                            <div class="form-row">
                                <div class="col-lg-2">
                                    <label>Date</label>
                                    <input type="text" name="date" class="form-control" />
                                </div>
                                <div class="col-lg-2">
                                    <label>Time</label>
                                    <input type="text" name="time" class="form-control" />
                                </div>
                                <div class="col-lg-2">
                                    <label>No Of People</label>
                                    <input type="text" name="noOfPeople" class="form-control" />
                                </div>
                            </div>
                       </div>
                       <table id="output"  class="table table-bordered">
                          <thead>
                              
                              <th>ITEMS</th>
                              <th>QUANTITY</th>
                              <th>UNIT</th>
                              <th>PRICE</th>
                              <th>TOTAL</th>
                              <th>ACTIONS</th>
                          </thead>
                          <tbody id="rows">
                             @if($transaction[0]->deleted_at == NULL)
                            <tr>
                                <td>{{ $transaction[0]->items}}</td>
                                <td>{{ $transaction[0]->qty }}</td>
                                <td>{{ $transaction[0]->unit }}</td>
                                <td><?= number_format($transaction[0]->price, 2)?></td>
                                <td><?= number_format($transaction[0]->total, 2)?></td>
                                <td><a href="#" class="btn btn-danger">Delete</a></td>
                            </tr>
                            @endif
                          
                          </tbody>
                          
                       </table>
                       <input type="hidden" id="orderId" name="orderId" value="{{ $id }}" />
                    </div>
                </div>
            </div>
        </div>
     </form>  
    </div>
    <!-- Modal -->
    <div class="modal fade" id="orderForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Add Item</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <div class="form-row">
                  <div class="col-lg-4">
                      <label>Product Name</label>
                      <input type="text" id="productName" name="productName" class="form-control" readonly/>
                  </div>
                  <div class="col-lg-2">
                      <label>Quantity</label>
                      <input type="number"  id="quantity" name="quantity" class="form-control"  value="1" onchange="javascript:checkQuant()" onkeypress="return isNumber(event)" autocomplete="off" />
                  </div>
                  <div class="col-lg-2">
                      <label>Unit</label>
                      <input type="text"  id="unit" name="unit" class="form-control" readonly />
                  </div>
                  <div class="col-lg-4">
                      <label>Price</label>
                      <div id="priceOrder"></div>
                      <input type="text" id="price" name="price" class="form-control" readonly/>
                  </div>
              </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" onclick="closeOrder()" class="btn btn-danger btn-lg" data-dismiss="modal" >Close</button>
            <button type="button" onclick="addMaterial()" class="btn btn-success btn-lg" >Add Item</button>
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
  

     $('#orderForm').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var orderF = button.data('menu'); // Extract info from data-* attributes
        var price = button.data('price');
        var unit = button.data('unit');

        var modal = $(this);
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      
        modal.find('.modal-body #productName').val(orderF);  
        modal.find('.modal-body #price').val(price);
        modal.find('.modal-body #unit').val(unit);
        
    })


    const isNumber =(evt) => {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
          return false;
        }
        return true;
    }


    $("#priceOrder").hide();
    checkQuant = function(){
        const price = $("#price").val();
        const quantity = $("#quantity").val();
        const compute = parseInt(quantity) * parseInt(price);
        const result = compute.toFixed(2);

        if(quantity === 1) {
          $("#price").show();
          $("#priceOrder").hide();
        }else{
          $("#price").hide();
          $("#priceOrder").show();
          $("#priceOrder").html(`<input type="text" id="newPrice" name="price" value="${result}" class="form-control" readonly>`);
        }
    }

    const closeOrder = () =>{
        $("#quantity").val('1'); 
        $("#priceOrder").hide();
        $("#price").show();

    }

    const addMaterial = () =>{
        const productName = $("#productName").val();
        const quantity = parseInt($("#quantity").val());
        const price = $("#price").val();
        const unit = $("#unit").val();
      
        const newPrice = $("#newPrice").val();

        const text = "<a href='#' class='btn btn-danger'>Delete</a>";
        const delt =  text;
       

        if(quantity === 1){
            
            const table =  document.getElementById("output");
            const row = document.createElement("tr");
            
            const nameOfProduct = row.insertCell(0);
            const qty = row.insertCell(1);
            const units = row.insertCell(2);
            const priceT = row.insertCell(3);
            const totT = row.insertCell(4);
            const del = row.insertCell(5);
    
    
            nameOfProduct.innerHTML = `${productName}`;
            qty.innerHTML = `${quantity}`;
            units.innerHTML = `${unit}`;
            priceT.innerHTML = `${price}`;
            totT.innerHTML = `${price}`;
            del.innerHTML = `${delt}`;

            row.append(nameOfProduct);  
            row.append(qty);
            row.append(units);
            row.append(priceT);
            row.append(totT);
            row.append(del);
            document.getElementById("rows").appendChild(row);

            //make ajax call
            $.ajax({
                type: 'POST',
                url: '/wimpys-food-express/transaction/additional',
                data:{
                    _method:'post',
                    "_token":"{{ csrf_token() }}",
                    "productName":productName,
                    "quantity":quantity,
                    "unit":unit,
                    "price":price,

                },
                success:function(data){
                    console.log(data);
                    setTimeout(function(){
                        window.location = "/wimpys-food-express/order-form/" + data + "/transaction";
                    }, 1000);
                
                },
                error:function(data){
                    console.log('Error', data);
                }
             });



            $('#orderForm').modal('hide');
            
        }else{
        
            const table =  document.getElementById("output");
            const row = document.createElement("tr");
            
            const nameOfProduct = row.insertCell(0);
            const qty = row.insertCell(1);
            const units = row.insertCell(2);
            const priceT = row.insertCell(3);
            const priceNew = row.insertCell(4);
            const del = row.insertCell(5);
    
    
            nameOfProduct.innerHTML = `${productName}`;
            qty.innerHTML = `${quantity}`;
            units.innerHTML = `${unit}`;
            priceT.innerHTML = `${price}`;
            priceNew.innerHTML = `${newPrice}`;
            del.innerHTML = `${delt}`;


            row.append(nameOfProduct);  
            row.append(qty);
            row.append(units);
            row.append(priceT);
            row.append(priceNew);
            row.append(del);
            document.getElementById("rows").appendChild(row);


            $('#orderForm').modal('hide');
        }

    }
  
</script>
@endsection