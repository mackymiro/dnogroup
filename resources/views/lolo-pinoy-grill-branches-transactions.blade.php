@extends('layouts.lolo-pinoy-grill-branches-app')
@section('title', 'Transaction Form| ')
@section('content')
<div id="wrapper">
    <!-- Sidebar -->
    @include('sidebar.sidebar-lolo-pinoy-grill-branches')
    <div id="content-wrapper">
        <div class="container-fluid">
             <!-- Breadcrumbs-->
             <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lolo Pinoy Grill Bracnhes</a>
              </li>
              <li class="breadcrumb-item active">{{ Session::get('sessionBranch') }}</li>
              <li class="breadcrumb-item active">Sales Invoice Form Transaction</li>
            </ol>
            <div class="col-lg-12">
            	<img src="{{ asset('images/lolo-pinoy-grill.jpeg')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lolo Pinoy Grill ">
            	 
            	 <h4 class="text-center"><u>SALES INVOICE FORM</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                             <i class="fas fa-utensils"></i>
                            Menu </div>
                          <div class="card-body">
                                <div class="form-group">
                                  <div class="form-row">
                                     <div class="col-lg-4">
                                        <button type="button" class="bbq btn btn-warning btn-lg" data-toggle="modal" data-target="#bbq" data-menu="PORK REGULAR BBQ" data-price="30.00">PORK REGULAR BBQ ₱ 30.00</button>
                                     </div>
                                     <div class="col-lg-4">
                                         <button type="button" class="bbq btn btn-warning btn-lg" data-toggle="modal" data-target="#bbq" data-menu="BEEF BBQ" data-price="50.00">BEEF BBQ ₱ 50.00</button>
                                     </div>
                                     <div class="col-lg-4">
                                         <button type="button" class="bbq btn btn-warning btn-lg" data-toggle="modal" data-target="#bbq"  data-menu="CHICKEN BBQ B&W" data-price="70.00">CHICKEN BBQ B&W ₱ 70.00</button>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-4">
                                            <button type="button" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#bbq" data-menu="CHICKEN BBQ Q- LEG" data-price="70.00">CHICKEN BBQ Q- LEG ₱ 70.00</button>
                                        </div>
                                        <div class="col-lg-4">
                                            <button type="button" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#food" data-menu="CHICKEN PECHO" data-price="70.00">CHICKEN PECHO  ₱ 70.00</button>
                                        </div>
                                        <div class="col-lg-4">
                                            <button type="button" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#food" data-menu="CHORIZO" data-price="30.00">CHORIZO  ₱ 30.00</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-4">
                                            <button type="button" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#bbq" data-menu="PORK JUMBO BBQ" data-price="40.00">PORK JUMBO BBQ  ₱ 40.00</button>
                                        </div>
                                        <div class="col-lg-4">
                                            <button type="button" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#food" data-menu="DINUGUAN" data-price="77.00">DINUGUAN ₱ 77.00</button>
                                        </div>
                                        <div class="col-lg-4">
                                            <button type="button" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#food" data-menu="LECHON SISIG" data-price="177.00">LECHON SISIG ₱ 177.00</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-4">
                                            <button type="button" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#food" data-menu="ICE CREAM" data-price="20.00">ICE CREAM ₱ 20.00</button>
                                        </div>
                                        <div class="col-lg-4">
                                            <button type="button" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#food" data-menu="POSO" data-price="10.00">POSO ₱ 10.00</button>
                                        </div>
                                    </div>
                                </div>
                                   
                            </div>
                             
                          </div>  
                    </div>
            </div> <!-- end of row-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                             <i class="fas fa-glass-cheers"></i>
                            Beverages 
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-2">
                                        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#softdrinks" data-menu="COKE" data-price="27.00">Coke ₱ 27.00</button>
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="button" class="btn btn-info btn-lg"  data-toggle="modal" data-target="#softdrinks" data-menu="MIRINDA" data-price="27.00">Mirinda ₱ 27.00</button>
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="button" class="btn btn-info btn-lg"  data-toggle="modal" data-target="#softdrinks" data-menu="SPRITE" data-price="27.00">Sprite ₱ 27.00</button>
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="button" class="btn btn-info btn-lg"  data-toggle="modal" data-target="#softdrinks" data-menu="7-UP" data-price="27.00">7-UP ₱ 27.00</button>
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="button" class="btn btn-info btn-lg"  data-toggle="modal" data-target="#softdrinks" data-menu="Mt.Dew" data-price="27.00">Mt.Dew ₱ 27.00</button>
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="button" class="btn btn-info btn-lg"  data-toggle="modal" data-target="#softdrinks" data-menu="Water" data-price="27.00">Water ₱ 27.00</button>
                                    </div>
                                  
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-2">
                                        <button type="button" class="btn btn-info btn-lg"  data-toggle="modal" data-target="#softdrinks" data-menu="ROYAL" data-price="27.00">Royal ₱ 27.00</button>
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="button" class="btn btn-info btn-lg"  data-toggle="modal" data-target="#softdrinks" data-menu="CALAMANSI JUICE" data-price="27.00">Calamansi Juice ₱ 27.00</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end of row-->
            <div class="row">
                 <div class="col-lg-12">
                     <div class="card mb-3">
                         <div class="card-header">
                             <i class="fas fa-list"></i>
                            Items 
                        </div>
                        <div class="card-body">
                            <form action="{{ action('LoloPinoyGrillBranchesController@settleTransactions', $transaction['id']) }}" method="post">
                            {{ csrf_field() }}
                            
                            <div class="form-group"> 
                                <div class="form-row">
                                    <div class="col-lg-2">
                                        <label>Invoice #</label>
                                        <input type="text" name="invoiceNum" class="form-control form-control-lg" required />
                                    </div> 
                                    <div class="col-lg-2">
                                        <label>Ordered By</label>
                                        <div id="app-order">
                                            <select name="orderedBy" class="form-control form-control-lg">
                                                <option v-for="order in orders" v-bind:value="order.value">
                                                    @{{ order.text }}
                                                </option>
                                            </select>
                                        </div>

                                    </div> 
                                    <div class="col-lg-2">
                                        <label>Table #</label>
                                        <input type="text" name="tableNo" class="form-control form-control-lg" />
                                    </div> 
                                </div>
                            </div>
                            <table  id="output" class="table table-striped">
                                <thead>
                                    <th class="bg-success" style="color:#ffff">QTY</th>
                                    <th class="bg-success" style="color:#ffff">ITEM DESCRIPTION</th>
                                    <th class="bg-success" style="color:#ffff">AMOUNT</th>
                                </thead>
                                <tbody id="rows">
                                    <tr>
                                        <td>{{ $transaction['qty']}}</td>
                                        <td>{{ $transaction['item_description']}}</td>
                                        <td>{{ $transaction['amount']}}</td>
                                    </tr>
                                    @foreach($getTransactions as $getTransaction)
                                    <tr>
                                      <td>{{ $getTransaction['qty']}}</td>
                                      <td>{{ $getTransaction['item_description']}}</td>
                                      <td>{{ $getTransaction['amount']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tr>
                                    <td></td>
                                    <td class="bg-success" style="color:#fff; font-size:35px; font-weight:bold">Total</td>
                                    <td class="bg-danger" ><span id="totalCharge" style="color:#fff; font-size:35px; font-weight:bold">₱ <?php echo number_format($transaction['total_amount_of_sales'], 2);?></span></td>
                                </tr>
                            </table>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-4">
                                        <button class="btn btn-success btn-lg">SETTLE</button>
                                        <input type="hidden" id="transactionId" name="transactionId" value="{{ $id }}" />
                                    </div>
                                    <div class="col-lg-4">
                                        <button class="btn btn-danger btn-lg">CANCEL</button>
                                    </div>
                                </div>
                            </div>
                         </form>
                        </div>
                     </div>
                 </div>
            </div><!-- end of row-->
        </div>      
    </div>
     <!-- Modal -->
     <div class="modal fade" id="softdrinks" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5  id="exampleModalLongTitle"><i class="fas fa-glass-cheers"></i>Beverages</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <h1 class="modal-title"></h1>
            <div class="form-group">
                <div class="form-row">
                   
                    <div class="col-lg-4">
                        <label>Quantity</label>
                       <input type="number" name="quantity" class="quantityDrinks form-control" value="1" onchange="javascript:checkDrinks()" />
                    </div>
                    <div class="col-lg-4">
                        <label>Price</label>
                       <div id="priceDrinks"></div>
                       <input type="text" id="originalPriceDrinks" name="price" class=" form-control" readonly />
                       <input type="hidden" id="softDrinksName" />
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" onclick="closeDrinks()" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
            <button type="button" onclick="addDrinks()" class="btn btn-success btn-lg">Add Drinks</button>
        </div>
        </div>
    </div>
    </div><!--end of MOdal -->
     <!-- Modal -->
     <div class="modal fade" id="food" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5  id="exampleModalLongTitle"><i class="fas fa-utensils"></i>Menu</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <h1 class="modal-title"></h1>
            <div class="form-group">
                <div class="form-row">
                   
                    <div class="col-lg-4">
                        <label>Quantity</label>
                       <input type="number" name="quantity" class="quantityFood quantity form-control" value="1"  onchange="javascript:checkPriceFood()"/>
                    </div>
                    <div class="col-lg-4">
                        <label>Price</label>
                       <div id="priceFood"></div>
                       <input type="text" id="originalPriceFood" name="price" class=" form-control" readonly />
                       <input type="hidden" id="foodNameNotBbq" />
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" onclick="closeFood()" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
            <button type="button" onclick="addFood()" class="btn btn-success btn-lg">Add</button>
        </div>
        </div>
    </div>
    </div><!--end of MOdal -->
    <!-- Modal -->
    <div class="modal fade" id="bbq" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5  id="exampleModalLongTitle"><i class="fas fa-utensils"></i>Menu</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <h1 class="modal-title"></h1>
            <div class="form-group">
                <div class="form-row">
                    <div class="col-lg-4">
                        <label>Flavor</label>
                        <select id="flavor" name="flavor" class="form-control">
                            <option value="Regular">Regular</option>
                            <option value="Spicy">Spicy</option>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label>Quantity</label>
                       <input type="number" name="quantity" class="quantityBBQ form-control" value="1" onchange="javascript:checkPrice()" />   
                    </div>
                    <div class="col-lg-4">
                        <label>Price</label>
                       <div id="price"></div>
                       <input type="text" id="originalPrice" name="price" class=" form-control" readonly />
                       <input type="hidden" id="foodName" />
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
           
            <button type="button" onclick="closeBBQ()" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
            <button type="button" onclick="addBBQ()" class="btn btn-success btn-lg">Add</button>
        </div>
        </div>
    </div>
    </div><!--end of MOdal -->
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

    


      $('#bbq').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('menu') // Extract info from data-* attributes
        var price = button.data('price');
       // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-title').text(recipient);
        modal.find('.modal-body #originalPrice').val(price);
        modal.find('.modal-body #foodName').val(recipient);
    })

    $('#food').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('menu') // Extract info from data-* attributes
        var price = button.data('price');
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-title').text(recipient);
        modal.find('.modal-body #originalPriceFood').val(price);
        modal.find('.modal-body #foodNameNotBbq').val(recipient);
    
    })

    $('#softdrinks').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('menu') // Extract info from data-* attributes
        var price = button.data('price');
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-title').text(recipient);
        modal.find('.modal-body #originalPriceDrinks').val(price);
        modal.find('.modal-body #softDrinksName').val(recipient);
    })


    $("#originalPriceDrinks").show();
    checkDrinks = function(){
        const originalPriceDrinks = $("#originalPriceDrinks").val();
        const quantity = $(".quantityDrinks").val();
        const compute = parseInt(quantity) * parseInt(originalPriceDrinks);
        const result = compute.toFixed(2);

        if(quantity == "1"){
            $("#originalPriceDrinks").show();
            $("#priceDrinks").hide();
        }else{
            $("#originalPriceDrinks").hide();
            $("#priceDrinks").show();
            $("#priceDrinks").html(`<input type="text" id="newPriceDrinks" name="price" value="${result}" class="form-control" readonly>`);
        }

    }

    const addDrinks = () =>{
        const transactionId = $("#transactionId").val();
        const quantityDrinks = $(".quantityDrinks").val();
        const originalPriceDrinks = $("#originalPriceDrinks").val();
        const softDrinksName = $("#softDrinksName").val();
        const newPriceDrinks = $("#newPriceDrinks").val();
        const branch = "{{ Session::get('sessionBranch') }}";
        if(quantityDrinks == "1"){
            const table =  document.getElementById("output");
            const row = document.createElement("tr");
            
            const item = row.insertCell(0);
            const qty = row.insertCell(1);
            const amount = row.insertCell(2);

    
            qty.innerHTML = `${quantityDrinks}`;
            item.innerHTML = `${softDrinksName}`;
            amount.innerHTML = `${originalPriceDrinks}`;
           
            
            row.append(qty);
            row.append(item);
            row.append(amount);
            document.getElementById("rows").appendChild(row);

            //make ajax call
            $.ajax({
                type: 'POST',
                url: '/lolo-pinoy-grill-branches/sales-form/transaction/additional',
                data:{
                    _method:'post',
                    "_token":"{{ csrf_token() }}",
                    "transactionId":transactionId,
                    "quantity":quantityDrinks,
                    "itemDescription":softDrinksName,
                    "branch":branch,
                    "amount":originalPriceDrinks,
                },
                success:function(data){
                    console.log(data);
                   
                },
                error:function(data){
                    console.log('Error', data);
                }  
            });

            $('#softdrinks').modal('hide');
        }else{
            const table =  document.getElementById("output");
            const row = document.createElement("tr");
            
            const item = row.insertCell(0);
            const qty = row.insertCell(1);
            const amount = row.insertCell(2);

    
            qty.innerHTML = `${quantityDrinks}`;
            item.innerHTML = `${softDrinksName}`;
            amount.innerHTML = `${newPriceDrinks}`;
           
            
            row.append(qty);
            row.append(item);
            row.append(amount);
            document.getElementById("rows").appendChild(row);
            
            //make ajax call
            $.ajax({
                type: 'POST',
                url: '/lolo-pinoy-grill-branches/sales-form/transaction/additional',
                data:{
                    _method:'post',
                    "_token":"{{ csrf_token() }}",
                    "transactionId":transactionId,
                    "quantity":quantityDrinks,
                    "itemDescription":softDrinksName,
                    "branch":branch,
                    "amount":newPriceDrinks,
                },
                success:function(data){
                    console.log(data);
                   
                },
                error:function(data){
                    console.log('Error', data);
                }  
            });
            $('#softdrinks').modal('hide');
        }
    }

    $("#priceFood").hide();  
    checkPriceFood = function(){
        const originalPrice = $("#originalPriceFood").val();
        const quantity = $(".quantityFood").val();
        const compute = parseInt(quantity) * parseInt(originalPrice);
        const result = compute.toFixed(2);

        if(quantity == "1"){
            $("#originalPriceFood").show();
            $("#priceFood").hide();
        }else{
            $("#originalPriceFood").hide();
            $("#priceFood").show();
            $("#priceFood").html(`<input type="text" id="newPriceFood" name="price" value="${result}" class="form-control" readonly>`);
        }
    }

    const addFood = () =>{
        const transactionId = $("#transactionId").val();
        const quantityFood = $(".quantityFood").val();
        const originalPriceFood = $("#originalPriceFood").val();
        const newPriceFood = $("#newPriceFood").val();
        const foodNameNotBbq = $("#foodNameNotBbq").val();
        
        const branch = "{{ Session::get('sessionBranch') }}";
        if(quantityFood == "1"){
            console.log(originalPriceFood);
            const table =  document.getElementById("output");
            const row = document.createElement("tr");
            
            const item = row.insertCell(0);
            const qty = row.insertCell(1);
            const amount = row.insertCell(2);

    
            qty.innerHTML = `${quantityFood}`;
            item.innerHTML = `${foodNameNotBbq}`;
            amount.innerHTML = `${originalPriceFood}`;
           
            
            row.append(qty);
            row.append(item);
            row.append(amount);
            document.getElementById("rows").appendChild(row);

             //make ajax call
             $.ajax({
                type: 'POST',
                url: '/lolo-pinoy-grill-branches/sales-form/transaction/additional',
                data:{
                    _method:'post',
                    "_token":"{{ csrf_token() }}",
                    "transactionId":transactionId,
                    "quantity":quantityFood,
                    "itemDescription":foodNameNotBbq,
                    "branch":branch,
                    "amount":originalPriceFood,
                },
                success:function(data){
                    console.log(data);
                   
                },
                error:function(data){
                    console.log('Error', data);
                }
             });

            $('#food').modal('hide');
        }else{
           
            const table =  document.getElementById("output");
            const row = document.createElement("tr");
            
            const item = row.insertCell(0);
            const qty = row.insertCell(1);
            const amount = row.insertCell(2);

    
            qty.innerHTML = `${quantityFood}`;
            item.innerHTML = `${foodNameNotBbq}`;
            amount.innerHTML = `${newPriceFood}`;
           
            
            row.append(qty);
            row.append(item);
            row.append(amount);
            document.getElementById("rows").appendChild(row);

            //make ajax
            $.ajax({
                type: 'POST',
                url: '/lolo-pinoy-grill-branches/sales-form/transaction/additional',
                data:{
                    _method:'post',
                    "_token":"{{ csrf_token() }}",
                    "transactionId":transactionId,
                    "quantity":quantityFood,
                    "itemDescription":foodNameNotBbq,
                    "branch":branch,
                    "amount":newPriceFood,
                },
                success:function(data){
                    console.log(data);
                   
                },
                error:function(data){
                    console.log('Error', data);
                }
            });

            $('#food').modal('hide');
            closeFood();
        }
    }




    $("#price").hide();  
    checkPrice = function(){
        const originalPrice = $("#originalPrice").val();
        const quantity = $(".quantityBBQ").val();

        const compute = parseInt(quantity) * parseInt(originalPrice);
        const result = compute.toFixed(2);
        if(quantity == "1"){
            $("#originalPrice").show();
            $("#price").hide();
        }else{
            $("#originalPrice").hide();
            $("#price").show();
            $("#price").html(`<input type="text" id="newPrice" name="price" value="${result}" class="form-control" readonly>`);
        }
                   
    };

    const closeDrinks = () =>{
        $(".quantityDrinks").val('1');
        $("#priceDrinks").hide();
        $("#originalPriceDrinks").show();
        
    }

    const closeFood = () =>{
        $(".quantityFood").val('1');
        $("#priceFood").hide();
        $("#originalPriceFood").show();
    }
  
    const closeBBQ = () =>{
        $(".quantityBBQ").val('1');
        $("#price").hide();
        $("#originalPrice").show();
    }


    const addBBQ = () =>{
        const transactionId = $("#transactionId").val();
        const quantity = $(".quantityBBQ").val();
        const newPrice = $("#newPrice").val();
        const originalPrice = $("#originalPrice").val();
        const flavor = $("#flavor").val();
        const foodName = $("#foodName").val();
      
        const combineFoodName = `${foodName} - ${flavor}`;
        const branch = "{{ Session::get('sessionBranch') }}";
        if(quantity == "1"){
            console.log(originalPrice);
            const table =  document.getElementById("output");
            const row = document.createElement("tr");
            
            const item = row.insertCell(0);
            const qty = row.insertCell(1);
            const amount = row.insertCell(2);

    
            qty.innerHTML = `${quantity}`;
            item.innerHTML = `${foodName} - ${flavor}`;
            amount.innerHTML = `${originalPrice}`;
              
            row.append(qty);
            row.append(item);
            row.append(amount);
            document.getElementById("rows").appendChild(row);

            //make ajax call
            $.ajax({
                type: 'POST',
                url: '/lolo-pinoy-grill-branches/sales-form/transaction/additional',
                data:{
                    _method:'post',
                    "_token":"{{ csrf_token() }}",
                    "transactionId":transactionId,
                    "quantity":quantity,
                    "itemDescription":combineFoodName,
                    "branch":branch,
                    "amount":originalPrice,
                },
                success:function(data){
                    console.log(data);
                   
                },
                error:function(data){
                    console.log('Error', data);
                }
            });

            $('#bbq').modal('hide');
           
           
        }else{
            console.log(newPrice);
            const table =  document.getElementById("output");
            const row = document.createElement("tr");
            
            const item = row.insertCell(0);
            const qty = row.insertCell(1);
            const amount = row.insertCell(2);
    
           
            qty.innerHTML = `${quantity}`;
            item.innerHTML = `${foodName} - ${flavor}`;
            amount.innerHTML = `${newPrice}`;
           
            
            row.append(qty);
            row.append(item);
            row.append(amount);
            document.getElementById("rows").appendChild(row);

              //make ajax call
              $.ajax({
                type: 'POST',
                url: '/lolo-pinoy-grill-branches/sales-form/transaction/additional',
                data:{
                    _method:'post',
                    "_token":"{{ csrf_token() }}",
                    "transactionId":transactionId,
                    "quantity":quantity,
                    "itemDescription":combineFoodName,
                    "branch":branch,
                    "amount":newPrice,
                },
                success:function(data){
                    console.log(data);
                    $('#bbq').modal('hide');
                },
                error:function(data){
                    console.log('Error', data);
                }
            });
           
           
        }
       
        
    }
</script>
<script >
   
   //qty
   new Vue({
    el: '#app-qty',
        data: {
            qauntities:[
                { text:'1', value: '1' },
                { text:'2', value: '2' },
                { text:'3', value: '3' },
                { text:'4', value: '4' }
            ]
        }
    }) 

   

     //Order By
   new Vue({
    el: '#app-order',
        data: {
            orders:[
                { text:'DINE-IN', value: 'DINE-IN' },
                { text:'PRIVATE', value: 'PRIVATE' },
                { text:'TAKE-OUT', value: 'TAKE-OUT'},
                { text:'STAFF MEAL', value: 'STAFF MEAL'}
            ]
        }
    }) 
</script>
@endsection