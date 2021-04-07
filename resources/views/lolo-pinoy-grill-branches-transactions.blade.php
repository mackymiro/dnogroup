@extends('layouts.lolo-pinoy-grill-branches-app')
@section('title', 'Transaction Form| ')
@section('content')
<script>
     
</script>
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
                                                <?= $getBranch->product_name?> ₱ <?= number_format($getBranch->price, 2) ?>
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
                                                data-toggle="modal" data-target="#bbq" 
                                                data-id="<?= $getBranch->id ?>" 
                                                data-menu="<?= $getBranch->product_name?>" 
                                                data-price="<?= number_format($getBranch->price, 2) ?>" 
                                                data-available="<?= $getBranch->product_in ?>" 
                                                data-flag="<?= $getBranch->flag; ?>">
                                                <?= $getBranch->product_name?> ₱ <?= number_format($getBranch->price, 2) ?></button>
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
                                    <?php if($getBranchDrink->product_in == 0): ?>
                                    <div class="col-lg-2">
                                        <button 
                                            type="button" 
                                            class="btn btn-danger btn-lg" 
                                            data-target="#softdrinks" 
                                            data-id="<?= $getBranchDrink->id?>" 
                                            data-menu="<?= $getBranchDrink->product_name ?>" 
                                            data-price="<?= number_format($getBranchDrink->price, 2)?>" 
                                            data-available="<?= number_format($getBranchDrink->product_in, 2) ?>"
                                             data-flag="<?= $getBranchDrink->flag?>">
                                             <?= $getBranchDrink->product_name?> ₱ <?= number_format($getBranchDrink->price, 2)?>
                                             <br>
                                             NOT Available
                                             </button>
                                        <br>
                                        <br>
                                    </div>
                                    <?php else:?>
                                    <div class="col-lg-2">
                                        <button 
                                            type="button" 
                                            class="btn btn-info btn-lg" 
                                            data-toggle="modal" 
                                            data-target="#softdrinks" 
                                            data-id="<?= $getBranchDrink->id?>" 
                                            data-menu="<?= $getBranchDrink->product_name ?>" 
                                            data-price="<?= number_format($getBranchDrink->price, 2)?>" 
                                            data-available="<?= number_format($getBranchDrink->product_in, 2) ?>"
                                             data-flag="<?= $getBranchDrink->flag?>">
                                             <?= $getBranchDrink->product_name?> ₱ <?= number_format($getBranchDrink->price, 2)?></button>
                                        <br>
                                        <br>
                                    </div>
                                    <?php endif; ?>
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
                            <form action="{{ action('LoloPinoyGrillBranchesController@settleTransactions', $transaction[0]->id ) }}" method="post">
                            {{ csrf_field() }}
                            
                            <div class="form-group"> 
                                <div class="form-row">
                                     <div class="col-lg-2">
                                        <label>Transaction ID</label>
                                        <input type="text" name="transId" style="color:white; " class="bg-success form-control form-control-lg" value="{{ $transaction[0]->id }}"  disabled />
                                    </div> 
                                    <div class="col-lg-2">
                                        <label>Invoice #</label>
                                        <input type="text" name="invoiceNum" class="form-control form-control-lg" required onkeypress="return isNumber(event)"  value="{{ $transaction[0]->invoice_number}}" />
                                    </div> 
                                    <div class="col-lg-2">
                                        <label>Ordered By</label>
                                        <div id="app-order">
                                            <select name="orderedBy" class="form-control form-control-lg">
                                                <option v-for="order in orders" v-bind:value="order.value"
                                                :selected="order.value=={{json_encode($transaction[0]->ordered_by )}}?true : false">
                                                    @{{ order.text }}
                                                </option>
                                            </select>
                                        </div>

                                    </div> 
                                    <div class="col-lg-2">
                                        <label>Table #</label>
                                        <input type="text" name="tableNo" class="form-control form-control-lg" onkeypress="return isNumber(event)" value="{{ $transaction[0]->table_no }}" />
                                    </div> 
                                </div>
                            </div>
                            <table  id="output" class="table table-striped">
                                <thead>
                                    <th class="bg-success" style="color:#ffff">QTY</th>
                                    <th class="bg-success" style="color:#ffff">ITEM DESCRIPTION</th>
                                    <th class="bg-success" style="color:#ffff">AMOUNT</th>
                                    <th class="bg-success" style="color:#ffff">OPTONS</th>
                                </thead>
                                <tbody id="rows">
                                    @if($transaction[0]->deleted_at == NULL)
                                    <tr id="deletedId1{{ $transaction[0]->id }}">
                                        <td class="qty{{ $transaction[0]->id }}">{{ $transaction[0]->qty}}</td>
                                        <td>{{ $transaction[0]->item_description }}

                                            @if($transaction[0]->flavor != NULL)
                                                <span class="updateFlavor{{ $transaction[0]->id }}">
                                                    - {{ $transaction[0]->flavor }}
                                                   </span>
                                            @endif
                                        </td>
                                        <td class="amt{{ $transaction[0]->id }}">{{ $transaction[0]->amount }}</td>
                                        <td >
                                            <a href="javascript::void(0)"  
                                            data-toggle="modal" 
                                            data-target=".editMeal1{{ $transaction[0]->id }}"  onclick="editMeal1({{ $transaction[0]->id }})" class="btn btn-warning btn-lg"><i class="fas fa-edit"></i></a> 
                                            <a href="javascript::void(0)" 
                                                data-toggle="modal"
                                                data-target=".deleteMeal1{{ $transaction[0]->id }}"
                                                class="btn btn-danger btn-lg"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endif
                                    @foreach($getTransactions as $getTransaction)
                                    <tr id="deletedId{{ $getTransaction['id'] }}">
                                      <td class="qty{{ $getTransaction['id'] }}">{{ $getTransaction['qty']}}</td>
                                      <td>
                                        {{ $getTransaction['item_description']}} 
                                        @if($getTransaction['flavor'] != "NULL")
                                              <span class="updateFlavor{{ $getTransaction['id']}}"> - {{ $getTransaction['flavor']}}</span>
                                        @endif
                                        </td>
                                      <td class="amt{{ $getTransaction['id'] }}">{{ $getTransaction['amount']}}</td>
                                      <td >
                                        <a href="javascript::void(0)" 
                                        data-toggle="modal" 
                                        data-target=".editMeal{{ $getTransaction['id'] }}"  onclick="editMeal({{ $getTransaction['id'] }})" class="btn btn-warning btn-lg"><i class="fas fa-edit"></i></a>
                                        <a href="javascript::void(0)" 
                                        data-toggle="modal"
                                        data-target=".deleteMeal{{ $getTransaction['id']}}"
                                        class="btn btn-danger btn-lg"><i class="fas fa-trash"></i></a>
                                      </td>
                                     
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tr>
                                    <td></td>
                                    <td class="bg-success" style="color:#fff; font-size:35px; font-weight:bold">Total</td>
                                    <td class="bg-danger" ><span id="totalCharge" style="color:#fff; font-size:35px; font-weight:bold">₱ <?php echo number_format($transaction[0]->total_amount_of_sales, 2);?></span></td>
                                    <td class="bg-danger">
                                </tr>
                            </table>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-4">
                                        <button class="btn btn-success btn-lg">SETTLE</button>
                                        <input type="hidden" id="transactionId" name="transactionId" value="{{ $id }}" />
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
                       <input type="hidden" id="flagDrinks" />
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
            <h1 >Available Pcs - <span id="availPcs"></span></h1>
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
                       <input type="number"  name="quantity" class="quantityBBQ form-control" value="1" onchange="javascript:checkPrice()" onkeypress="return isNumber(event)" autocomplete="off" />   
                    </div>
                    <div class="col-lg-4">
                        <label>Price</label>
                       <div id="price"></div>
                       <input type="text" id="originalPrice" name="price" class=" form-control" readonly />
                       <input type="hidden" id="foodName" />
                       <input type="hidden" id="pcsBbq" />
                       <input type="hidden" id="foodId" />
                       <input type="hidden" id="flag" />
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" onclick="closeBBQ()" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
            <button type="button" onclick="addBBQ()" class="disabledBtn btn btn-success btn-lg">Add</button>
        </div>
        </div>
    </div>
    </div><!--end of MOdal -->
    <div class="deleteMeal1{{ $transaction[0]->id }} modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5  id="exampleModalLongTitle"><i class="fas fa-utensils"></i> Remove Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to remove this? This can't be undone.</p>
                    
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="branch1" value="{{ Session::get('sessionBranch') }}" />
                    <button type="button" onclick="closeMenu()" class="btn  btn-success btn-lg" data-dismiss="modal">Close</button>
                    <button type="button" onclick="deleteMenuOrder1({{ $transaction[0]->id }})" class="btn btn-danger btn-lg">Remove</button>
                </div>
                </div>
            </div>
        </div><!--end of MOdal -->
   
    <!-- Modal -->
    @foreach($getTransactions as $getTransaction)
    <div class="deleteMeal{{ $getTransaction['id'] }} modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5  id="exampleModalLongTitle"><i class="fas fa-utensils"></i> Remove Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to remove this? This can't be undone.</p>
                    
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="getMainId" value="{{ $transaction[0]->id }}" />
                    <input type="hidden" id="branch" value="{{ Session::get('sessionBranch') }}" />
                    <button type="button" onclick="closeMenu()" class="btn  btn-success btn-lg" data-dismiss="modal">Close</button>
                    <button type="button" onclick="deleteMenuOrder({{ $getTransaction['id'] }})" class="btn btn-danger btn-lg">Remove</button>
                </div>
                </div>
            </div>
        </div><!--end of MOdal -->
    @endforeach
    <div class="editMeal1{{ $transaction[0]->id }} modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5  id="exampleModalLongTitle"><i class="fas fa-utensils"></i> Edit Menu</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <h1  >{{ $transaction[0]->item_description }}</h1>
            <h1 class="modal-title"></h1>
            <div class="form-group">
                
                <div class="form-row">
                    @if($transaction[0]->flavor === "Regular")
                    <div class="flavor col-lg-4">
                        <label>Flavor</label>
                        <select  name="flavor" class="flavorEdit{{ $transaction[0]->id }} form-control">
                            <option value="Regular" {{ ( 'Regular' == $transaction[0]->flavor)? 'selected' : '' }}>Regular</option>
                            <option value="Spicy" {{ ('Spicy' == $transaction[0]->flavor) ? 'selected' : '' }}>Spicy</option>
                        </select>
                    </div>
                    @elseif($transaction[0]->flavor === "Spicy")
                    <div id="flavor" class="flavor col-lg-4">
                        <label>Flavor</label>
                        <select name="flavor" class="flavorEdit{{ $transaction[0]->id }} form-control">
                            <option value="Regular" {{ ( 'Regular' == $transaction[0]->flavor)? 'selected' : '' }}>Regular</option>
                            <option value="Spicy" {{ ('Spicy' == $transaction[0]->flavor) ? 'selected' : '' }}>Spicy</option>
                        </select>
                    </div>

                    @endif
                    <div class="col-lg-4">
                        <label>Quantity</label>
                       <input 
                        type="number" 
                        name="quantity" 
                        class="quantityBBQEdit{{ $transaction[0]->id }} form-control" 
                        value="{{ $transaction[0]->qty }}" 
                        onchange="javascript:checkPriceFoodEdit({{ $transaction[0]->id }})" 
                        onkeypress="return isNumber(event)" 
                        autocomplete="off" />   
                    </div>
                    <div class="col-lg-4">
                        <label>Price</label>
                       <div class="priceEdit{{ $transaction[0]->id }}"></div>
                       <div></div>
                       <input type="text"  name="price" class="originalPriceEdit{{ $transaction[0]->id }} form-control" value="{{ $transaction[0]->amount }}" readonly />
                       <input type="text"  name="orgPrice" class="orgPrice{{ $transaction[0]->id }} form-control" value="{{ $transaction[0]->original_price }}" readonly />
                       
                       <input type="hidden" id="foodNameEdit" />
                       <input type="hidden" id="pcsBbqEdit" />
                       <input type="hidden" id="foodIdEdit" />
                       <input type="hidden" id="flagEdit" />
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" id="updateBranch1{{ $transaction[0]->id }}" value="{{ Session::get('sessionBranch') }}" />
          
            <input type="hidden" class="mainId{{ $transaction[0]->id }}" name="mainId" value="{{ $transaction[0]->id }}" />
            <button type="button" onclick="closeMenu('{{ $transaction[0]->id }}')" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
            <button type="button" onclick="updateMenu1('{{ $transaction[0]->id }}')" class="btn btn-success btn-lg">Update</button>
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

    const isNumber =(evt) => {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
          return false;
        }
        return true;
    }
    

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
        || recipient === "CHICKEN BBQ Q-LEG"){
            $("#flavorShow").show();
        }else{
            $("#flavorShow").hide();
        }

        modal.find('.modal-body #availPcs').text(available);
        modal.find('.modal-body #pcsBbq').val(available);
        modal.find('.modal-body #foodId').val(foodId);
        modal.find('.modal-body #originalPrice').val(price);
        modal.find('.modal-body #foodName').val(recipient);
        modal.find('.modal-body #flag').val(flag);
        
    })

    
    $('#softdrinks').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('menu') // Extract info from data-* attributes
        var price = button.data('price');
        var available = button.data('available');
        var drinkId = button.data('id');
        var flag = button.data('flag')
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
        modal.find('.modal-body #flagDrinks').val(flag);
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

  
    const editMeal1 = (id) =>{
        $(".orgPrice" +id).hide();
        checkPriceFoodEdit = function(id){
            const orgPrice = $(".orgPrice" +id).val();
            console.log(orgPrice);
            const originalPriceEdit = $(".originalPriceEdit" +id).val();
            
            const quantity = parseInt($(".quantityBBQEdit"+id).val());
            const compute = parseInt(quantity) * parseInt(orgPrice);
            const result = compute.toFixed(2);

            if(quantity === 1){
                
                $(".orgPrice"+id).hide();
                $(".originalPriceEdit"+id).hide();
                
                $(".priceEdit"+id).show();
                $(".priceEdit"+id).html(`<input type="text" class="newPriceEdit${id} form-control" name="newPriceEdit" value="${result}"  readonly>`);
            

            }else{  
                const quantity = parseInt($(".quantityBBQEdit"+id).val());
                const compute = parseInt(quantity) * parseInt(orgPrice);
                const result2 = compute.toFixed(2);
                console.log("res"+result2);

                $(".originalPriceEdit"+id).hide();
                $(".orgPrice"+id).hide();
                $(".priceEdit"+id).show();
                $(".priceEdit"+id).html(`<input type="text" class="newPriceEdit${id} form-control" name="newPriceEdit" value="${result2}"  readonly>`);
            }
         }
    };

    const editMeal = (id) =>{
        $(".orgPrice" +id).hide();
        checkPriceFoodEdit = function(id){
            const orgPrice = $(".orgPrice" +id).val();
            console.log(orgPrice);
            const originalPriceEdit = $(".originalPriceEdit" +id).val();
            
            const quantity = parseInt($(".quantityBBQEdit"+id).val());
            const compute = parseInt(quantity) * parseInt(orgPrice);
            const result = compute.toFixed(2);

            if(quantity === 1){
                
                $(".orgPrice"+id).hide();
                $(".originalPriceEdit"+id).hide();
                
                $(".priceEdit"+id).show();
                $(".priceEdit"+id).html(`<input type="text" class="newPriceEdit${id} form-control" name="newPriceEdit" value="${result}"  readonly>`);
            

            }else{  
                const quantity = parseInt($(".quantityBBQEdit"+id).val());
                const compute = parseInt(quantity) * parseInt(orgPrice);
                const result2 = compute.toFixed(2);
                console.log("res"+result2);

                $(".originalPriceEdit"+id).hide();
                $(".orgPrice"+id).hide();
                $(".priceEdit"+id).show();
                $(".priceEdit"+id).html(`<input type="text" class="newPriceEdit${id} form-control" name="newPriceEdit" value="${result2}"  readonly>`);
            }
         }
    };

    const addDrinks = () =>{
        const transactionId = $("#transactionId").val();
        const quantityDrinks = parseInt($(".quantityDrinks").val());
        const originalPriceDrinks = $("#originalPriceDrinks").val();
        const softDrinksName = $("#softDrinksName").val();
        const newPriceDrinks = $("#newPriceDrinks").val();
        const branch = "{{ Session::get('sessionBranch') }}";

        const softDrinksPcs = $("#softDrinksPcs").val();
      
        const foodId = $("#drinkId").val();

          //compute minus available pcs to quantity
         const compute = softDrinksPcs - quantityDrinks;

        const flagDrink = $("#flagDrinks").val();

        if(quantityDrinks === 1){
            const table =  document.getElementById("output");
            const row = document.createElement("tr");
            
            const item = row.insertCell(0);
            const qty = row.insertCell(1);
            const amount = row.insertCell(2);
            const action = row.insertCell(3);
    
            qty.innerHTML = `${quantityDrinks}`;
            item.innerHTML = `${softDrinksName}`;
            amount.innerHTML = `${originalPriceDrinks}`;
            action.innerHTML = `
                <span class="getIds"></span>
                 `;  
              
            row.append(qty);
            row.append(item);
            row.append(amount);
            row.append(action);
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
                    "originalPrice":originalPriceDrinks,
                    "branch":branch,
                    "amount":originalPriceDrinks,
                    "softDrinksPcs":softDrinksPcs,
                    "compute":compute,
                    "foodId":foodId,
                    "flag":flagDrink,
                },
                success:function(data){
                    console.log(data.getTotalSales);
                    $("#totalCharge").html(`<span  style="color:#fff; font-size:35px; font-weight:bold">₱ ${data.getTotalSales}.00</span>`);
                    $(".getIds").html(`
                         <a href="javascript::void(0)" 
                            onclick="editMeal(${data.getId})"
                            data-toggle="modal" 
                            data-target="#bbq" 
                             class="btn btn-warning btn-lg"><i class="fas fa-edit"></i></a>
                            <a href="javascript::void(0)" 
                                class="btn btn-danger btn-lg"><i class="fas fa-trash"></i></a>
                    `);

                    setTimeout(function(){
                        location.reload(true);
                    }, 2000);
                   
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
            const action = row.insertCell(3);

    
            qty.innerHTML = `${quantityDrinks}`;
            item.innerHTML = `${softDrinksName}`;
            amount.innerHTML = `${newPriceDrinks}`;
            action.innerHTML = `
                <span class="getIds"></span>
                 `;  
              
            row.append(qty);
            row.append(item);
            row.append(amount);
            row.append(action);
        
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
                    "originalPrice":originalPriceDrinks,
                    "branch":branch,
                    "amount":newPriceDrinks,
                    "softDrinksPcs":softDrinksPcs,
                    "compute":compute,
                    "foodId":foodId,
                    "flag":flagDrink,
                },
                success:function(data){
                    console.log(data.getTotalSales);
                    $("#totalCharge").html(`<span  style="color:#fff; font-size:35px; font-weight:bold">₱ ${data.getTotalSales}.00</span>`);
                    $(".getIds").html(`
                         <a href="javascript::void(0)" 
                            onclick="editMeal(${data.getId})"
                            data-toggle="modal" 
                            data-target="#bbq" 
                             class="btn btn-warning btn-lg"><i class="fas fa-edit"></i></a>
                        <a href="javascript::void(0)" 
                           
                            class="btn btn-danger btn-lg"><i class="fas fa-trash"></i></a>
                    `);

                    setTimeout(function(){
                        location.reload(true);
                    }, 2000);
                   
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

        const getPcs = $("#pcsBbq").val();
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
                   
    }

    const closeDrinks = () =>{
        $(".quantityDrinks").val('1');
        $("#priceDrinks").hide();
        $("#originalPriceDrinks").show();
        
    };

    const closeMenu = (id) =>{
        $(".editMeal"+id).modal('hide');
    };
   
    const closeBBQ = () =>{
        $(".quantityBBQ").val('1');
        $("#price").hide();
        $("#originalPrice").show();
    };


    const addBBQ = () =>{
        const transactionId = $("#transactionId").val();
        const quantity = parseInt($(".quantityBBQ").val());
        const newPrice = $("#newPrice").val();
        const originalPrice = $("#originalPrice").val();
       
        const foodName = $("#foodName").val();

        console.log("original price"+originalPrice);

        if(foodName === "PORK REGULAR BBQ" || foodName === "PORK JUMBO BBQ" || foodName === "CHICKEN BBQ B&W"
        || foodName === "CHICKEN BBQ Q-LEG"){
            $("#flavorShow").show();
            const flavor = $("#flavor").val();
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
                const action = row.insertCell(3);

                qty.innerHTML = `${quantity}`;
                item.innerHTML = `${foodName} - ${flavor}`;
                amount.innerHTML = `${originalPrice}`;
                action.innerHTML = `
                    <span class="getIds"></span>
                    `;  
                
                row.append(qty);
                row.append(item);
                row.append(amount);
                row.append(action);
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
                        $("#totalCharge").html(`<span  style="color:#fff; font-size:35px; font-weight:bold">₱ ${data.getTotalSales}.00</span>`);
                        $(".getIds").html(`
                            <a href="javascript::void(0)" 
                                onclick="editMeal(${data.getId})"
                                data-toggle="modal" 
                                data-target="#bbq" 
                                class="btn btn-warning btn-lg"><i class="fas fa-edit"></i></a>
                            <a href="javascript::void(0)" 
                              
                                class="btn btn-danger btn-lg"><i class="fas fa-trash"></i></a>
                        `);

                        setTimeout(function(){
                            location.reload(true);
                        }, 2000);
                    },
                    error:function(data){
                        console.log('Error', data);
                    }
                });

                $('#bbq').modal('hide');
            
            
            }else{
                console.log(newPrice);
                const flavor = $("#flavor").val();
                const table =  document.getElementById("output");
                const row = document.createElement("tr");
                
                const item = row.insertCell(0);
                const qty = row.insertCell(1);
                const amount = row.insertCell(2);
                const action = row.insertCell(3);

            
                qty.innerHTML = `${quantity}`;
                item.innerHTML = `${foodName} - ${flavor}`;
                amount.innerHTML = `${newPrice}`;
                action.innerHTML = `
                    <span class="getIds">
                    </span>
                `; 
            
                
                row.append(qty);
                row.append(item);
                row.append(amount);
                row.append(action);
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
                        "flavor":flavor,
                        "originalPrice":originalPrice,
                        "branch":branch,
                        "amount":newPrice,
                        "compute":compute,
                        "foodId":foodId,
                        "flag":flag,
                    },
                    success:function(data){
                        console.log(data.getTotalSales);
                        $("#totalCharge").html(`<span  style="color:#fff; font-size:35px; font-weight:bold">₱ ${data.getTotalSales}.00</span>`);
                        $(".getIds").html(`
                            <a href="javascript::void(0)" 
                                data-toggle="modal" 
                                data-target="#bbq" 
                                onclick="editMeal(${data.getId})" 
                                class="btn btn-warning btn-lg"><i class="fas fa-edit"></i></a>
                            <a href="javascript::void(0)" 
                                    class="btn btn-danger btn-lg"><i class="fas fa-trash"></i></a>
                        `);

                        setTimeout(function(){
                            location.reload(true);
                        }, 2000);

                        $('#bbq').modal('hide');
                    },
                    error:function(data){
                        console.log('Error', data);
                    }
                });
            
            
            }
        
        }else{
            $("#flavorShow").hide();
          
            const flavor = "NULL";
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
                const action = row.insertCell(3);

                qty.innerHTML = `${quantity}`;
                item.innerHTML = `${foodName}`;
                amount.innerHTML = `${originalPrice}`;
                action.innerHTML = `
                    <span class="getIds"></span>
                    `;  
                
                row.append(qty);
                row.append(item);
                row.append(amount);
                row.append(action);
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
                        "flavor":flavor,
                        "originalPrice":originalPrice,
                        "branch":branch,
                        "amount":originalPrice,
                        "compute":compute,
                        "foodId":foodId,
                        "flag":flag,
                    },
                    success:function(data){
                        console.log(data.getTotalSales);
                        $("#totalCharge").html(`<span  style="color:#fff; font-size:35px; font-weight:bold">₱ ${data.getTotalSales}.00</span>`);
                        $(".getIds").html(`
                            <a href="javascript::void(0)" 
                                onclick="editMeal(${data.getId})"
                                data-toggle="modal" 
                                data-target="#bbq" 
                                class="btn btn-warning btn-lg"><i class="fas fa-edit"></i></a>
                            <a href="javascript::void(0)" 
                                    class="btn btn-danger btn-lg"><i class="fas fa-trash"></i></a>
                        `);

                        setTimeout(function(){
                            location.reload(true);
                        }, 2000);
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
                const action = row.insertCell(3);

            
                qty.innerHTML = `${quantity}`;
                item.innerHTML = `${foodName}`;
                amount.innerHTML = `${newPrice}`;
                action.innerHTML = `
                    <span class="getIds">
                    </span>
                `; 
            
                
                row.append(qty);
                row.append(item);
                row.append(amount);
                row.append(action);
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
                        "flavor":flavor,
                        "originalPrice":originalPrice,
                        "branch":branch,
                        "amount":newPrice,
                        "compute":compute,
                        "foodId":foodId,
                        "flag":flag,
                    },
                    success:function(data){
                        console.log(data.getTotalSales);
                        $("#totalCharge").html(`<span  style="color:#fff; font-size:35px; font-weight:bold">₱ ${data.getTotalSales}.00</span>`);
                        $(".getIds").html(`
                            <a href="javascript::void(0)" 
                                data-toggle="modal" 
                                data-target="#bbq" 
                                onclick="editMeal(${data.getId})" 
                                class="btn btn-warning btn-lg"><i class="fas fa-edit"></i></a>
                            <a href="javascript::void(0)" 
                                    class="btn btn-danger btn-lg"><i class="fas fa-trash"></i></a>
                        `);

                        setTimeout(function(){
                            location.reload(true);
                        }, 2000);

                        $('#bbq').modal('hide');
                    },
                    error:function(data){
                        console.log('Error', data);
                    }
                });
            
            }      

        }
      
         
    };

    //delete first item 
    const deleteMenuOrder1 = (id) =>{
        let branch = $("#branch1").val();

        $.ajax({
            type: 'DELETE',
            url: '/lolo-pinoy-grill-branches/sales-form/transaction/first-item/delete/'+id,
            data:{
                _method: 'delete', 
                "_token": "{{ csrf_token() }}",
                "id": id,
                "branch":branch,
            },
            success:function(data){
                console.log(data);
                $("#totalCharge").html(`<span  style="color:#fff; font-size:35px; font-weight:bold">₱ ${data}</span>`);
                $(".deleteMeal1"+id).modal('hide')
                $("#deletedId1"+id).fadeOut('slow');
               
            },
            error:function(data){
                console.log('Error'+data);
            }
         });
    };
   

    const deleteMenuOrder = (id) =>{
        const getMainId = $("#getMainId").val();
        let branch = $("#branch").val();

        $.ajax({
            type: 'DELETE',
            url: '/lolo-pinoy-grill-branches/sales-form/transaction/delete/'+id,
            data:{
                _method: 'delete', 
                "_token": "{{ csrf_token() }}",
                "id": id,
                "getMainId":getMainId,
                "branch":branch,
            },
            success:function(data){
                console.log(data);
                $("#totalCharge").html(`<span  style="color:#fff; font-size:35px; font-weight:bold">₱ ${data}.00</span>`);
                $(".deleteMeal"+id).modal('hide')
                $("#deletedId"+id).fadeOut('slow');
               
            },
            error:function(data){
                console.log('Error'+data);
            }
         });
    };

    const updateMenu1 = (id) =>{
        let flavor = $(".flavorEdit"+id).val();
        let qty = $(".quantityBBQEdit"+id).val();
        let price = $(".newPriceEdit"+id).val();
        let branch = $("#updateBranch1"+id).val();

        let originalPrice = $(".originalPriceEdit"+id).val();


        let mainId = $(".mainId"+id).val();
      

        if(flavor === undefined){
            //make ajax call
            closeMenu();
            $.ajax({
                type:'PUT',
                url:'/lolo-pinoy-grill-branches/sales-form/transaction/update/'+id,
                data:{
                    _method:'PUT',
                    "_token":"{{ csrf_token() }}",
                    "id":id,
                    "mainId":mainId,
                    "flavor":flavor,
                    "qty":qty,
                    "price":price,
                    "originalPrice":originalPrice,
                    "branch":branch,
                },
                success:function(data){
                    console.log(data.sum);
                    $(".qty"+id).html(`${data.qty}`);
                    $(".amt"+id).html(`${data.amt}`);
                    if(data.flavor != "NULL"){
                        $(".updateFlavor"+id).html(`- ${data.flavor}`);
                    }
                  
                    $("#totalCharge").html(`<span  style="color:#fff; font-size:35px; font-weight:bold">₱ ${data.sum}.00</span>`);
                    $(".editMeal1"+id).modal('hide');
                },
                error:function(data){
                    console.log('Error'+data);
                }
            });
        }else{
            //make ajax call
            $.ajax({
                type:'PUT',
                url:'/lolo-pinoy-grill-branches/sales-form/transaction/update/'+id,
                data:{
                    _method:'put',
                    "_token":"{{ csrf_token() }}",
                    "id":id,
                    "mainId":mainId,
                    "flavor":flavor,
                    "qty":qty,
                    "price":price,
                    "originalPrice":originalPrice,
                    "branch":branch,
                },
                success:function(data){
                    console.log(data.sum);
                    $(".qty"+id).html(`${data.qty}`);
                    $(".amt"+id).html(`${data.amt}`);
                    if(data.flavor != "NULL"){
                        $(".updateFlavor"+id).html(`- ${data.flavor}`);
                    }
                    $("#totalCharge").html(`<span  style="color:#fff; font-size:35px; font-weight:bold">₱ ${data.sum}.00</span>`);
                    $(".editMeal1"+id).modal('hide');

                },
                error:function(data){
                    console.log('Error'+data);
                }
            });
        }
       

    };
  

    const updateMenu = (id) =>{
        let flavor = $(".flavorEdit"+id).val();
        let qty = $(".quantityBBQEdit"+id).val();
        let price = $(".newPriceEdit"+id).val();
        let branch = $("#updateBranch"+id).val();
        let originalPrice = $(".originalPriceEdit"+id).val();
        let mainId = $(".mainId"+id).val();
      

        if(flavor === undefined){
            //make ajax call
            closeMenu();
            $.ajax({
                type:'PUT',
                url:'/lolo-pinoy-grill-branches/sales-form/transaction/update/'+id,
                data:{
                    _method:'put',
                    "_token":"{{ csrf_token() }}",
                    "id":id,
                    "mainId":mainId,
                    "flavor":flavor,
                    "qty":qty,
                    "price":price,
                    "originalPrice":originalPrice,
                    "branch":branch,
                },
                success:function(data){
                    console.log(data);
                    $(".qty"+id).html(`${data.qty}`);
                    $(".amt"+id).html(`${data.amt}`);
                    if(data.flavor != "NULL"){
                        $(".updateFlavor"+id).html(`- ${data.flavor}`);
                    }
                    $("#totalCharge").html(`<span  style="color:#fff; font-size:35px; font-weight:bold">₱ ${data.sum}.00</span>`);
                    $(".editMeal"+id).modal('hide');
                },
                error:function(data){
                    console.log('Error'+data);
                }
            });
        }else{
            //make ajax call
            $.ajax({
                type:'PUT',
                url:'/lolo-pinoy-grill-branches/sales-form/transaction/update/'+id,
                data:{
                    _method:'put',
                    "_token":"{{ csrf_token() }}",
                    "id":id,
                    "mainId":mainId,
                    "flavor":flavor,
                    "qty":qty,
                    "price":price,
                    "originalPrice":originalPrice,
                    "branch":branch,
                },
                success:function(data){
                    console.log(data.sum);
                    $(".qty"+id).html(`${data.qty}`);
                    $(".amt"+id).html(`${data.amt}`);
                    if(data.flavor != "NULL"){
                        $(".updateFlavor"+id).html(`- ${data.flavor}`);
                    }
                    $("#totalCharge").html(`<span  style="color:#fff; font-size:35px; font-weight:bold">₱ ${data.sum}.00</span>`);
                    $(".editMeal"+id).modal('hide');

                },
                error:function(data){
                    console.log('Error'+data);
                }
            });
        }
       

    };
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


   
   
 @foreach($getTransactions as $getTransaction)
<div class="editMeal{{ $getTransaction['id'] }} modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5  id="exampleModalLongTitle"><i class="fas fa-utensils"></i> Edit Menu</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <h1  >{{ $getTransaction['item_description'] }}</h1>
            <h1 class="modal-title"></h1>
            <div class="form-group">
                
                <div class="form-row">
                    @if($getTransaction['flavor'] === "Regular")
                    <div class="flavor col-lg-4">
                        <label>Flavor</label>
                        <select  name="flavor" class="flavorEdit{{ $getTransaction['id'] }} form-control">
                            <option value="Regular" {{ ( 'Regular' == $getTransaction['flavor'])? 'selected' : '' }}>Regular</option>
                            <option value="Spicy" {{ ('Spicy' == $getTransaction['flavor']) ? 'selected' : '' }}>Spicy</option>
                        </select>
                    </div>
                    @elseif($getTransaction['flavor'] === "Spicy")
                    <div id="flavor" class="flavor col-lg-4">
                        <label>Flavor</label>
                        <select name="flavor" class="flavorEdit{{ $getTransaction['id'] }} form-control">
                            <option value="Regular" {{ ( 'Regular' == $getTransaction['flavor'])? 'selected' : '' }}>Regular</option>
                            <option value="Spicy" {{ ('Spicy' == $getTransaction['flavor']) ? 'selected' : '' }}>Spicy</option>
                        </select>
                    </div>

                    @endif
                    <div class="col-lg-4">
                        <label>Quantity</label>
                       <input 
                        type="number" 
                        name="quantity" 
                        class="quantityBBQEdit{{ $getTransaction['id'] }} form-control" 
                        value="{{ $getTransaction['qty'] }}" 
                        onchange="javascript:checkPriceFoodEdit({{ $getTransaction['id'] }})" 
                        onkeypress="return isNumber(event)" 
                        autocomplete="off" />   
                    </div>
                    <div class="col-lg-4">
                        <label>Price</label>
                       <div class="priceEdit{{ $getTransaction['id'] }}"></div>
                       <div></div>
                       <input type="text"  name="price" class="originalPriceEdit{{ $getTransaction['id'] }} form-control" value="{{ $getTransaction['amount'] }}" readonly />
                       <input type="text"  name="orgPrice" class="orgPrice{{ $getTransaction['id'] }} form-control" value="{{ $getTransaction['original_price'] }}" readonly />
                       
                       <input type="hidden" id="foodNameEdit" />
                       <input type="hidden" id="pcsBbqEdit" />
                       <input type="hidden" id="foodIdEdit" />
                       <input type="hidden" id="flagEdit" />
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" id="updateBranch{{ $getTransaction['id'] }}" value="{{ Session::get('sessionBranch') }}" />
            <input type="hidden" class="mainId{{ $getTransaction['id'] }}" name="mainId" value="{{ $transaction[0]->id }}" />
            <button type="button" onclick="closeMenu('{{ $getTransaction['id'] }}')" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
            <button type="button" onclick="updateMenu('{{ $getTransaction['id']}}')" class="btn btn-success btn-lg">Update</button>
        </div>
        </div>
    </div>
    </div><!--end of MOdal -->
   @endforeach
@endsection