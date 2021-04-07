@extends('layouts.lolo-pinoy-grill-branches-app')
@section('title', 'Sales Form| ')
@section('content')
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
              <li class="breadcrumb-item active">{{ Session::get('sessionBranch') }}</li>
                 
              <li class="breadcrumb-item active">Sales Invoice Form</li> 
            </ol>          
            <div class="col-lg-12">
            	<img src="{{ asset('images/digitized-logos/lolo-pinoy-grill.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lolo Pinoy Grill ">
            	 
            	 <h4 class="text-center"><u>SALES INVOICE FORM</u></h4>
                   
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                             <i class="fas fa-utensils"></i>
                            Menu
                            <div class="float-right">
                                <form action="{{ action('LoloPinoyGrillBranchesController@logOutBranch') }}" method="post">
                                     {{ csrf_field() }}
                                     <button type="submit" class="btn btn-danger btn-lg"><i class="fas fa-sign-out-alt"></i> Log Out Branch</button>
                                </form>
                            </div>  
                        </div>
                          <div class="card-body">
                                <div class="form-group">
                                  <div class="form-row">
                                   <?php foreach($getBranches as $getBranch): ?>
                                    <?php if($getBranch->product_in == 0): ?>
                                     <div class="col-lg-4">
                                        <button 
                                            type="button" 
                                            class="bbq btn btn-danger btn-lg" 
                                          
                                            data-id="<?= $getBranch->id ?>" 
                                            data-menu="<?= $getBranch->product_name?>" 
                                            data-price="<?= number_format($getBranch->price, 2) ?>" 
                                            data-available="<?= $getBranch->product_in ?>" 
                                            data-flag="<?= $getBranch->flag; ?>">
                                            <?= $getBranch->product_name?> 
                                            ₱ <?= number_format($getBranch->price, 2) ?>
                                            <br>
                                            NOT Available
                                        </button>
                                        <br>
                                        <br>
                                     </div>    
                                     <?php else:?>
                                        <div class="col-lg-4">
                                        <button 
                                            type="button" 
                                            class="bbq btn btn-warning btn-lg" 
                                            data-toggle="modal" 
                                            data-target="#bbq" 
                                            data-id="<?= $getBranch->id ?>" 
                                            data-menu="<?= $getBranch->product_name?>" 
                                            data-price="<?= number_format($getBranch->price, 2) ?>" 
                                            data-available="<?= $getBranch->product_in ?>" 
                                            data-flag="<?= $getBranch->flag; ?>">
                                            <?= $getBranch->product_name?> 
                                            ₱ <?= number_format($getBranch->price, 2) ?>
                                        </button>
                                        <br>
                                        <br>
                                     </div> 

                                     <?php endif; ?>                     
                                     <?php endforeach ; ?>  
                                     
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
                                    <?php foreach($getBranchDrinks as $getBranchDrink): ?>
                                    <div class="col-lg-2">
                                        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-id="<?php echo $getBranchDrink->id?>" data-target="#softdrinks" data-menu="<?= $getBranchDrink->product_name ?>" data-price="<?= number_format($getBranchDrink->price, 2)?>" data-available="<?= number_format($getBranchDrink->product_in, 2) ?>" data-flag="<?= $getBranchDrink->flag;?>"><?= $getBranchDrink->product_name?> ₱ <?= number_format($getBranchDrink->price, 2)?></button>
                                        <br>
                                        <br>
                                    </div>
                                  
                                    <?php endforeach; ?>
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
                           
                            <table id="output" class="table table-bordered">
                                <thead>
                                    <th>QTY</th>
                                    <th>ITEM DESCRIPTION</th>
                                    <th>AMOUNT</th>
                                </thead>
                                <tbody id="rows">
                                    
                                </tbody>
                                <tr>
                                    <td></td>
                                    <td class="bg-danger" style="color:#fff;">Total</td>
                                </tr>
                            </table>
                           
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
            <h1 >Available Pcs - <span id="availPcs"></span></h1>
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
                       <input type="hidden" id="softDrinksPcs" />
                       <input type="hidden" id="drinkId" />
                       <input type="hidden" class="getPcs" />
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
            <h1 >Available pcs - <span id="availPcs"></span></h1>
            <h1 class="modal-title"></h1>
            <div class="form-group">
                <div class="form-row">
                    <div id="flavorShow" class="col-lg-4">
                        <label>Flavor</label>
                        <select id="flavor" name="flavor" class="form-control">
                            <option value="Regular">Regular</option>
                            <option value="Spicy">Spicy</option>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label>Quantity</label>
                       <input type="number" name="quantity" class="quantityBBQ form-control" value="1" onchange="javascript:checkPrice()" onkeypress="return isNumber(event)" autocomplete="off" />   
                    </div>
                    <div class="col-lg-4">
                       <label>Price</label>
                       <div id="price"></div>
                       <input type="text" id="originalPrice" name="price" class=" form-control" readonly />
                      
                       <input type="hidden" id="foodName" />
                       <input type="hidden" id="pcsBbq" />
                       <input type="hidden" id="foodId" />
                       <input type="hidden" id="flag" />
                       <input type="hidden" id="getPcs" />
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
        var available = button.data('available');
        var foodId = button.data('id');
        var flag = button.data('flag');
       // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-title').text(recipient);
        if(recipient === "PORK REGULAR BBQ" || recipient === "PORK JUMBO BBQ" || recipient === "CHICKEN BBQ B&W"
        || recipient === "CHICKEN BBQ Q- LEG"){
            $("#flavorShow").show();
        }else{
            $("#flavorShow").hide();
        }

        modal.find('.modal-title').text(recipient);
        modal.find('.modal-body #availPcs').text(available);
        modal.find('.modal-body #getPcs').val(available);
        modal.find('.modal-body #flag').val(flag);
        modal.find('.modal-body #pcsBbq').val(available);
        modal.find('.modal-body #foodId').val(foodId);
        modal.find('.modal-body #originalPrice').val(price);
        modal.find('.modal-body #foodName').val(recipient);
        
        
    })

  
    $('#softdrinks').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('menu') // Extract info from data-* attributes
        var price = button.data('price');
        var available = button.data('available');
        var drinkId = button.data('id');
        var flag = button.data('flag');
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-title').text(recipient);
        modal.find('.modal-body #availPcs').text(available);
        modal.find('.modal-body .getPcs').val(available);
        modal.find('.modal-body #softDrinksPcs').val(available);
        modal.find('.modal-body #drinkId').val(drinkId);
        modal.find('.modal-body #originalPriceDrinks').val(price);
        modal.find('.modal-body #softDrinksName').val(recipient);
        modal.find('.modal-body #flagDrink').val(flag);
        
    })

    $("#originalPriceDrinks").show();
    checkDrinks = function(){
        const originalPriceDrinks = $("#originalPriceDrinks").val();
        const quantity = parseInt($(".quantityDrinks").val());
        const compute = parseInt(quantity) * parseInt(originalPriceDrinks);
        const result = compute.toFixed(2);

        const getPcs = $(".getPcs").val();
        if(quantity === 1){
            $("#originalPriceDrinks").show();
            $("#priceDrinks").hide();
        }else{
            if(quantity > getPcs){
                let roundPcs = getPcs;
                let resPcs = roundPcs.split(".");
                $(".quantityDrinks").val(resPcs[0]);

                const oPrice = $("#originalPriceDrinks").val();
                const qt = parseInt($(".quantityDrinks").val());
                const mul = parseInt(qt) * parseInt(oPrice);
                const res = mul.toFixed();
                $("#originalPriceDrinks").hide();
                $("#priceDrinks").show();
                $("#priceDrinks").html(`<input type="text" id="newPriceDrinks" name="price" value="${res}" class="form-control" readonly>`);
     
            }else{
                $("#originalPriceDrinks").hide();
                $("#priceDrinks").show();
                $("#priceDrinks").html(`<input type="text" id="newPriceDrinks" name="price" value="${result}" class="form-control" readonly>`);
     
            }

        }

    }

   
   

    const isNumber =(evt) => {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
          return false;
        }
        return true;
    }

    const addDrinks = () =>{
        const quantityDrinks = $(".quantityDrinks").val();
        const originalPriceDrinks = $("#originalPriceDrinks").val();
        const softDrinksName = $("#softDrinksName").val();
        const newPriceDrinks = $("#newPriceDrinks").val();
        const branch = "{{ Session::get('sessionBranch') }}";

        const softDrinksPcs = $("#softDrinksPcs").val();

        const foodId = $("#drinkId").val();

         //compute minus available pcs to quantity
         const compute = softDrinksPcs - quantityDrinks;

        const flagDrink = $("#flagDrink").val();

        if(quantityDrinks == "1"){
            //make ajax call
            $.ajax({
                type: 'POST',
                url: '/lolo-pinoy-grill-branches/sales-form/add-transaction',
                data:{
                    _method:'post',
                    "_token":"{{ csrf_token() }}",
                    "quantity":quantityDrinks,
                    "itemDescription":softDrinksName,
                    "branch":branch,
                    "amount":originalPriceDrinks,
                    "softDrinksPcs":softDrinksPcs,
                    "compute":compute,
                    "foodId":foodId,
                    "flag":flagDrink,
                },
                success:function(data){
                    console.log(data);
                    setTimeout(function(){
                        window.location = "/lolo-pinoy-grill-branches/{{ Session::get('sessionBranch') }}/sales-form/transaction/" + data;
                    }, 1000);
                
                },
                error:function(data){
                    console.log('Error', data);
                }
            });

            $('#softdrinks').modal('hide');
        }else{
            
             //make ajax call
             $.ajax({
                type: 'POST',
                url: '/lolo-pinoy-grill-branches/sales-form/add-transaction',
                data:{
                    _method:'post',
                    "_token":"{{ csrf_token() }}",
                    "quantity":quantityDrinks,
                    "itemDescription":softDrinksName,
                    "branch":branch,
                    "amount":newPriceDrinks,
                    "softDrinksPcs":softDrinksPcs,
                    "compute":compute,
                    "foodId":foodId,
                    "flag":flagDrink,
                },
                success:function(data){
                    console.log(data);
                    setTimeout(function(){
                        window.location = "/lolo-pinoy-grill-branches/{{ Session::get('sessionBranch') }}/sales-form/transaction/" + data;
                    }, 1000);
                
                },
                error:function(data){
                    console.log('Error', data);
                }
            });


            $('#softdrinks').modal('hide');
        }
    }

  


    $("#price").hide();  
    checkPrice = function(){
        const originalPrice = $("#originalPrice").val();
        const quantity = parseInt($(".quantityBBQ").val());
        const compute = parseInt(quantity) * parseInt(originalPrice);
        const result = compute.toFixed(2);

        const getPcs = $("#getPcs").val();
        if(quantity === 1){
            $("#originalPrice").show();
            $("#price").hide();

        }else{
           
            if(quantity > getPcs){
                let roundPcs = getPcs;
                let resPcs = roundPcs.split(".");
                $(".quantityBBQ").val(resPcs[0]);

                const oPrice = $("#originalPrice").val();
                const qt = parseInt($(".quantityBBQ").val());
                const mul = parseInt(qt) * parseInt(oPrice);
                const res = mul.toFixed(2);
                $("#originalPrice").hide();
                $("#price").show();
                $("#price").html(`<input type="text" id="newPrice" name="price" value="${res}" class="form-control" readonly>`);
     
            }else{
                $("#originalPrice").hide();
                $("#price").show();
                $("#price").html(`<input type="text" id="newPrice" name="price" value="${result}" class="form-control" readonly>`);

            }

           

        }
                   
    };


    const closeDrinks = () =>{
        $(".quantityDrinks").val('1');
        $("#priceDrinks").hide();
        $("#originalPriceDrinks").show();
        
    };

  
  
    const closeBBQ = () =>{
        $(".quantityBBQ").val('1');
        $("#price").hide();
        $("#originalPrice").show();
    };

    const addBBQ = () =>{
        const quantity = parseInt($(".quantityBBQ").val());
        const newPrice = $("#newPrice").val();
        const originalPrice = $("#originalPrice").val();
        const flavor = $("#flavor").val();
        const foodName = $("#foodName").val();


        if(foodName === "PORK REGULAR BBQ" || foodName === "PORK JUMBO BBQ" || foodName === "CHICKEN BBQ B&W"
        || foodName === "CHICKEN BBQ Q-LEG"){
            $("#flavorShow").show();
            const combineFoodName = `${foodName}`;
            const branch = "{{ Session::get('sessionBranch') }}";

            const availPcs = $("#pcsBbq").val();
            
            const foodId = $("#foodId").val();

            //compute minus available pcs to quantity
            const compute = availPcs - quantity;

            const flag = $("#flag").val();

            if(quantity === 1){
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
                url: '/lolo-pinoy-grill-branches/sales-form/add-transaction',
                data:{
                    _method:'post',
                    "_token":"{{ csrf_token() }}",
                    "quantity":quantity,
                    "itemDescription":combineFoodName,
                    "flavor":flavor,
                    "originalPrice":originalPrice,
                    "branch":branch,
                    "amount":originalPrice,
                    "compute":compute,
                    "foodId":foodId,
                    "flag":flag,
                },
                success:function(data){
                    console.log(data);
                    setTimeout(function(){
                        window.location = "/lolo-pinoy-grill-branches/{{ Session::get('sessionBranch') }}/sales-form/transaction/" + data;
                    }, 1000);
                
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
                url: '/lolo-pinoy-grill-branches/sales-form/add-transaction',
                data:{
                    _method:'post',
                    "_token":"{{ csrf_token() }}",
                    "quantity":quantity,
                    "itemDescription":combineFoodName,
                    "flavor":flavor,
                    "originalPrice":originalPrice,
                    "branch":branch,
                    "amount":newPrice,
                    "compute":compute,
                    "foodId":foodId,
                    "flag":flag,
                },
                success:function(data){
                    console.log(data);
                    setTimeout(function(){
                        window.location = "/lolo-pinoy-grill-branches/{{ Session::get('sessionBranch') }}/sales-form/transaction/" + data;
                    }, 1000);
                
                },
                error:function(data){
                    console.log('Error', data);
                }
             });
           
            $('#bbq').modal('hide');
        }
       
    }else{
        $("#flavorShow").hide();
        const combineFoodName = `${foodName}`;
        const branch = "{{ Session::get('sessionBranch') }}";

        const availPcs = $("#pcsBbq").val();
        
        const foodId = $("#foodId").val();

        //compute minus available pcs to quantity
        const compute = availPcs - quantity;

        const flag = $("#flag").val();
        if(quantity === 1){
            console.log(originalPrice);
          
            
            const table =  document.getElementById("output");
            const row = document.createElement("tr");
            
            const item = row.insertCell(0);
            const qty = row.insertCell(1);
            const amount = row.insertCell(2);

    
            qty.innerHTML = `${quantity}`;
            item.innerHTML = `${foodName}`;
            amount.innerHTML = `${originalPrice}`;
              
            row.append(qty);
            row.append(item);
            row.append(amount);
            document.getElementById("rows").appendChild(row);

            //make ajax call
            $.ajax({
                type: 'POST',
                url: '/lolo-pinoy-grill-branches/sales-form/add-transaction',
                data:{
                    _method:'post',
                    "_token":"{{ csrf_token() }}",
                    "quantity":quantity,
                    "itemDescription":combineFoodName,
                    "originalPrice":originalPrice,
                    "branch":branch,
                    "amount":originalPrice,
                    "compute":compute,
                    "foodId":foodId,
                    "flag":flag,
                },
                success:function(data){
                    console.log(data);
                    setTimeout(function(){
                        window.location = "/lolo-pinoy-grill-branches/{{ Session::get('sessionBranch') }}/sales-form/transaction/" + data;
                    }, 1000);
                
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
            item.innerHTML = `${foodName}`;
            amount.innerHTML = `${newPrice}`;
           
            
            row.append(qty);
            row.append(item);
            row.append(amount);
            document.getElementById("rows").appendChild(row);

             //make ajax call
             $.ajax({
                type: 'POST',
                url: '/lolo-pinoy-grill-branches/sales-form/add-transaction',
                data:{
                    _method:'post',
                    "_token":"{{ csrf_token() }}",
                    "quantity":quantity,
                    "itemDescription":combineFoodName,
                    "originalPrice":originalPrice,
                    "branch":branch,
                    "amount":newPrice,
                    "compute":compute,
                    "foodId":foodId,
                    "flag":flag,
                },
                success:function(data){
                    console.log(data);
                    setTimeout(function(){
                        window.location = "/lolo-pinoy-grill-branches/{{ Session::get('sessionBranch') }}/sales-form/transaction/" + data;
                    }, 1000);
                
                },
                error:function(data){
                    console.log('Error', data);
                }
             });
           
            $('#bbq').modal('hide');
        }
       
        
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