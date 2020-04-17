@extends('layouts.ribos-bar-app')
@section('title', 'Edit Cashiers Form |')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });

</script>

<div id="wrapper">
    @include('sidebar.sidebar-ribos-bar')
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Ribo's Bar</a>
              </li>
              <li class="breadcrumb-item active">Update Cashier's Report Form</li>
            </ol>
            <a href="{{ url('ribos-bar/cashiers-report/inventory-list') }}">Back to Lists</a>
            <div class="col-lg-12">
            	<img src="{{ asset('images/ribos.jpg')}}" width="390" height="250" class="img-responsive mx-auto d-block" alt="Rib's Bar">
            	 
            	 <h4 class="text-center"><u>Cashier's Report Form</u></h4>
            </div>
            <div class="row">
                 <div class="col-lg-12">
                      <div class="card mb-3">
                            <div class="card-header">
                                 <i class="fas fa-receipt" aria-hidden="true"></i>
                                Edit Cashier's Report Form
                            </div>
                            <div class="card-body">
                                @if(session('cashiersSuccess'))
                                    <p class="alert alert-success">{{ Session::get('cashiersSuccess') }}</p>
                                @endif 
                                <form action="{{ action('RibosBarController@updateCashiersForm', $getCashiersReport['id']) }}" method="post">
                                    {{csrf_field()}}
                                <input name="_method" type="hidden" value="PATCH">
                                <div class="form-group">
                                    <div class="form-row">
                                          <div class="col-lg-2">
                                              <label>Date</label>
                                              <input type="text" name="date" class="form-control" value="{{ $getCashiersReport['date']}}"/>
                                          </div>
                                          <div class="col-lg-4">
                                              <label>Cashier</label>
                                              <input type="text" name="cashierName" class="form-control"  value="{{ $getCashiersReport['cashier_name']}}" />
                                          </div>
                                          <div class="col-lg-4">
                                              <label>Bar Tender</label>
                                              <input type="text" name="barTender" class="form-control" value="{{ $getCashiersReport['bar_tender_name']}}" />
                                          </div>
                                          <div class="col-lg-2">
                                              <label>Shift Schedule</label>
                                              <input type="text" name="shiftSchedule" class="form-control"  value="{{ $getCashiersReport['shifting_schedule']}}" />
                                          </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                          <div class="col-lg-2">
                                              <label>Starting OS #</label>
                                              <input type="text" name="startingOs" class="form-control"  value="{{ $getCashiersReport['starting_os'] }}" />
                                          </div>
                                          <div class="col-lg-2">
                                              <label>Closing OS #</label>
                                              <input type="text" name="closingOs" class="form-control" value="{{ $getCashiersReport['closing_os']}}" />
                                          </div>
                                          <div class="col-lg-2">
                                              <label>Cash Sales</label>
                                              <input type="text" name="cashSales" class="form-control" value="{{ $getCashiersReport['cash_sales'] }}" />
                                          </div>
                                          <div class="col-lg-2">
                                              <label>Credit Card Sales</label>
                                              <input type="text" name="ccSales" class="form-control" value="{{ $getCashiersReport['credit_card_sales'] }}" />
                                          </div>
                                          <div class="col-lg-2">
                                              <label>Signing Privilage Sales</label>
                                              <input type="text" name="privilageSales" class="form-control" value="{{ $getCashiersReport['signing_privilage_sales'] }}" />
                                          </div>
                                          <div class="col-lg-2">
                                              <label>Total Reading</label>
                                              <input type="text" name="totalReading" class="form-control"  value="{{ $getCashiersReport['total_reading'] }}" />
                                          </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12 float-right">
                                            <input type="submit" class="btn btn-success"  value="Update " />
                                            <br>
                                            <br>
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
                                <i class="fas fa-plus" aria-hidden="true"></i>
                                Add Items
                          </div>
                          <div class="card-body">
                             @if(session('cashiersAddSuccess'))
                                    <p class="alert alert-success">{{ Session::get('cashiersAddSuccess') }}</p>
                            @endif 
                            <form action="{{ action('RibosBarController@addCashiersList', $getCashiersReport['id']) }}" method="post">
                                {{csrf_field()}}
                             <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-8">
                                        <label>Items</label>
                                        <select  name="items" class="form-control">
                                            <option value="0">--Please Select--</option>
                                            <optgroup label="Juices">
                                                <option value="Pineapple">Pineapple</option>
                                                <option value="Pine-Orange">Pine-Orange</option>
                                                <option value="Ice Tea">Ice Tea</option>
                                                <option value="Watermelon">Watermelon</option>
                                                <option value="Four Seasons">Four Seasons</option>
                                            </optgroup>
                                            <optgroup label="Shakes">
                                                <option value="Mango">Mango</option>
                                                <option value="Buco">Buco</option>
                                                <option value="Strawberry">Strawberry</option>
                                                <option value="Cooks n Cream">Cookies n Cream</option>
                                            </optgroup>
                                            <optgroup label="Hot Drinks">
                                                <option value="Hot Choco">Hot Choco</option>
                                                <option value="Hot Milk">Hot Milk</option>
                                                <option value="Hot Tea">Hot Tea</option>
                                                <option value="Coffee">Coffee</option>
                                                <option value="Milk">Milk</option>
                                                <option value="Coffee No Dou">Coffee No Dou</option>
                                                <option value="Coffee Lattee">Coffee Lattee</option>

                                            </optgroup>
                                            <optgroup label="Sodas">
                                                <option value="Coke">Coke</option>
                                                <option value="Coke Zero">Coke Zero</option>
                                                <option value="Sprite">Sprite</option>
                                                <option value="Royal">Royal</option>
                                                <option value="Mineral Water">Mineral Water</option>
                                                <option value="Green Tea">Green Tea</option>
                                                <option value="Lipton Tea">Lipton Tea</option>
                                                <option value="Whole Beans">Whole Beans</option>
                                                <option value="Fronthe French">Fronthe French</option>
                                                <option value="Camomile Tea">Comomile Tea</option>
                                                <option value="Jasmine Tea">Jasmine Tea</option>
                                                <option value="Earl Gray(Decaf)">Earl Gray(Decaf)</option>
                                                <option value="Earl Gray(Regular)">Earl Gray(Regular)</option>
                                            </optgroup>
                                            <optgroup label="Nuts/Chips">
                                                <option value="Peanuts">Peanuts</option>
                                                <option value="Chips">Chips</option>
                                              
                                            </optgroup>
                                            <optgroup label="Beers">
                                                <option value="SM Light">SM Light</option>
                                                <option value="SML Pilsen">SML Pilsen</option>  
                                                <option value="Super Dry">Super Dry</option>
                                                <option value="Corona">Corona</option>
                                                <option value="Red Wine">Red Wine</option>
                                                <option value="White Wine">White Wine</option>
                                                <option value="Carlos1 (bottle)">Carlos1 (bottle)</option>
                                                <option value="Carlos1 (Per Shot)">Carlos1 (Per Shot)</option>
                                                <option value="Red Horse">Red Horse</option>
                                            </optgroup>
                                            <optgroup label="Mix Drinks">
                                                <option value="Vodka Orange">Vodka Orange</option>
                                                <option value="Vodka Tonic">SML Pilsen</option>  
                                                <option value="Gin Tonic">Gin Tonic</option>
                                                <option value="Gin Soda">Gin Soda</option>
                                                <option value="Gin Sprite">Gin Sprite</option>
                                                <option value="Rhum Coke">Rhum Coke</option>
                                            </optgroup>
                                            <optgroup label="Brandy">
                                                <option value="Fundador">Fundador</option>
                                                <option value="Gin">Gin</option>  
                                                <option value="Gilbey's Gin">Gilbey's Gin</option>    
                                            </optgroup>
                                            <optgroup label="Vodka">
                                                <option value="Boaka Vodka">Boaka Vodka</option>  
                                            </optgroup>
                                            <optgroup label="Tequila">
                                                <option value="Jose Cuervo Gold (700ml)">Jose Cuervo Gold (700ml)</option>
                                                <option value="Jose Cuervo Gold (1L)">Jose Cuervo Gold (1L)</option>
                                                  
                                            </optgroup>
                                            <optgroup label="Whiskey">
                                                <option value="Johnny Walker">Johnny Walker</option>
                                                <option value="Jack Daniels">Jack Daniels</option>
                                                  
                                            </optgroup>
                                            <optgroup label="Liquor">
                                                <option value="Baileys">Baileys</option>
                                                <option value="Kahlua">Kahlua</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="col-lg-8">
                                        <label>Opening Inventory</label>
                                        <input type="text" name="openingInventory" class="form-control" />
                                    </div>
                                    <div class="col-lg-8">
                                        <label>Sold</label>
                                        <input type="text" name="sold" class="form-control" />
                                    </div>
                                    <div class="col-lg-8">
                                        <label>Closing</label>
                                        <input type="text" name="closing" class="form-control" />
                                    </div>
                                    <div class="col-lg-8">
                                        <label>Total</label>
                                        <input type="text" name="total" class="form-control" />
                                    </div>
                                    <div class="col-lg-8">
                                        <br>
                                        <br>
                                        <input type="submit" class="btn btn-success" value="Add" />
                                    </div>
                                </div>
                             </div>
                          </div>
                          </form>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-3">
                          <div class="card-header">
                                <i class="fas fa-tasks" aria-hidden="true"></i>
                                Items List
                          </div>
                          <div class="card-body">
                            @if(session('updateItemSucc'))
                                <p class="alert alert-success">{{ Session::get('updateItemSucc') }}</p>
                            @endif 
                            <div class="form-group">
                                <div class="form-row">
                                     <div class="col-lg-4">
                                        <h5>Items</h5>
                                    </div>
                                    <div class="col-lg-2">
                                        <h5>Opening Inventory</h5>
                                    </div>
                                    <div class="col-lg-2">
                                        <h5>Sold</h5>
                                    </div>
                                    <div class="col-lg-2">
                                        <h5>Closing</h5>
                                    </div>
                                    <div class="col-lg-2">
                                        <h5>Total</h5>
                                    </div>
                                </div>
                            </div>
                          
                            @foreach($getCashiersReportItems as $getCashiersReportItem)
                            <form action ="{{ action('RibosBarController@updateItem', $getCashiersReportItem['id']) }}" method="post">
                                {{csrf_field()}}
                            <input name="_method" type="hidden" value="PATCH">
                            <div id="deletedId<?php echo $getCashiersReportItem['id']; ?>" >
                            <div class="form-group" >
                                <div class="form-row">
                                    <div class="col-lg-4">
                                       
                                        <select class="form-control" name="items">
                                        <option value="0">--Please Select--</option>
                                            <optgroup label="Juices">
                                                <option value="Pineapple" <?php echo (( "Pineapple" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Pineapple</option>
                                                <option value="Pine-Orange" <?php echo (( "Pine-Orange" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Pine-Orange</option>
                                                <option value="Ice Tea" <?php echo (( "Ice Tea" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Ice Tea</option>
                                                <option value="Watermelon" <?php echo (( "Watermelon" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Watermelon</option>
                                                <option value="Four Seasons" <?php echo (( "Four Seasons" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Four Seasons</option>
                                            </optgroup>
                                            <optgroup label="Shakes">
                                                <option value="Mango" <?php echo (( "Mango" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Mango</option>
                                                <option value="Buco" <?php echo (( "Buco" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Buco</option>
                                                <option value="Strawberry" <?php echo (( "Strawberry" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Strawberry</option>
                                                <option value="Cookies n Cream" <?php echo (( "Cookies n Cream" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Cookies n Cream</option>
                                            </optgroup>
                                            <optgroup label="Hot Drinks">
                                                <option value="Hot Choco" <?php echo (( "Hot Choco" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Hot Choco</option>
                                                <option value="Hot Milk" <?php echo (( "Hot Milk" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Hot Milk</option>
                                                <option value="Hot Tea" <?php echo (( "Hot Tea" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Hot Tea</option>
                                                <option value="Coffee" <?php echo (( "Coffee" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Coffee</option>
                                                <option value="Milk" <?php echo (( "Milk" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Milk</option>
                                                <option value="Coffee No Dou" <?php echo (( "Coffee No Dou" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Coffee No Dou</option>
                                                <option value="Coffee Lattee" <?php echo (( "ffee Lattee" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Coffee Lattee</option>

                                            </optgroup>
                                            <optgroup label="Sodas">
                                                <option value="Coke" <?php echo (( "Coke" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Coke</option>
                                                <option value="Coke Zero" <?php echo (( "Coke Zero" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Coke Zero</option>
                                                <option value="Sprite" <?php echo (( "Sprite" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Sprite</option>
                                                <option value="Royal" <?php echo (( "Royal" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Royal</option>
                                                <option value="Mineral Water" <?php echo (( "Mineral Water" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Mineral Water</option>
                                                <option value="Green Tea" <?php echo (( "Green Tea" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Green Tea</option>
                                                <option value="Lipton Tea" <?php echo (( "Lipton Tea" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Lipton Tea</option>
                                                <option value="Whole Beans" <?php echo (( "Whole Beans" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Whole Beans</option>
                                                <option value="Fronthe French" <?php echo (( "Fronthe French" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Fronthe French</option>
                                                <option value="Camomile Tea" <?php echo (( "Camomile Tea" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Comomile Tea</option>
                                                <option value="Jasmine Tea" <?php echo (( "Jasmin Tea" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Jasmine Tea</option>
                                                <option value="Earl Gray(Decaf)" <?php echo (( "Earl Gray(Decaf)" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Earl Gray(Decaf)</option>
                                                <option value="Earl Gray(Regular)" <?php echo (( "Earl Gray(Regular)" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Earl Gray(Regular)</option>
                                            </optgroup>
                                            <optgroup label="Nuts/Chips">
                                                <option value="Peanuts" <?php echo (( "Peanuts" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Peanuts</option>
                                                <option value="Chips" <?php echo (( "Chips" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Chips</option>
                                              
                                            </optgroup>
                                            <optgroup label="Beers">
                                                <option value="SM Light" <?php echo (( "SM Light" == $getCashiersReportItem['items']) ? 'selected' : '')?>>SM Light</option>
                                                <option value="SML Pilsen" <?php echo (( "SML Pilsen" == $getCashiersReportItem['items']) ? 'selected' : '')?>>SML Pilsen</option>  
                                                <option value="Super Dry" <?php echo (( "Super Dry" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Super Dry</option>
                                                <option value="Corona" <?php echo (( "Corona" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Corona</option>
                                                <option value="Red Wine" <?php echo (( "Red Wine" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Red Wine</option>
                                                <option value="White Wine" <?php echo (( "White Wine" == $getCashiersReportItem['items']) ? 'selected' : '')?>>White Wine</option>
                                                <option value="Carlos1 (bottle)" <?php echo (( "Carlos1 (bottle)" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Carlos1 (bottle)</option>
                                                <option value="Carlos1 (Per Shot)" <?php echo (( "Carlos1 (Per Shot)" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Carlos1 (Per Shot)</option>
                                                <option value="Red Horse" <?php echo (( "Red Horse" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Red Horse</option>
                                            </optgroup>
                                            <optgroup label="Mix Drinks">
                                                <option value="Vodka Orange" <?php echo (( "Vodka Orange" == $getCashiersReportItem['items']) ? 'selected' : '')?> >Vodka Orange</option>
                                                <option value="Vodka Tonic" <?php echo (( "VOdka Tonic" == $getCashiersReportItem['items']) ? 'selected' : '')?>> SML Pilsen</option>  
                                                <option value="Gin Tonic" <?php echo (( "Gin Tonic" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Gin Tonic</option>
                                                <option value="Gin Soda" <?php echo (( "Gin Soda" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Gin Soda</option>
                                                <option value="Gin Sprite" <?php echo (( "Gin Sprite" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Gin Sprite</option>
                                                <option value="Rhum Coke" <?php echo (( "Rhum Coke" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Rhum Coke</option>
                                            </optgroup>
                                            <optgroup label="Brandy">
                                                <option value="Fundador" <?php echo (( "Fundador" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Fundador</option>
                                                <option value="Gin" <?php echo (( "Gin" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Gin</option>  
                                                <option value="Gilbey's Gin" <?php echo (( "Gilbey's Gin" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Gilbey's Gin</option>    
                                            </optgroup>
                                            <optgroup label="Vodka">
                                                <option value="Boaka Vodka" <?php echo (( "Boaka Vodka" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Boaka Vodka</option>  
                                            </optgroup>
                                            <optgroup label="Tequila">
                                                <option value="Jose Cuervo Gold (700ml)" <?php echo (( "Jose Cuervo Gold (700ml)" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Jose Cuervo Gold (700ml)</option>
                                                <option value="Jose Cuervo Gold (1L)" <?php echo (( "Jose Cuervo Gold (1L)" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Jose Cuervo Gold (1L)</option>
                                                  
                                            </optgroup>
                                            <optgroup label="Whiskey">
                                                <option value="Johnny Walker" <?php echo (( "Johnny Walker" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Johnny Walker</option>
                                                <option value="Jack Daniels" <?php echo (( "Jack Daniels" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Jack Daniels</option>
                                                  
                                            </optgroup>
                                            <optgroup label="Liquor">
                                                <option value="Baileys" <?php echo (( "Baileys" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Baileys</option>
                                                <option value="Kahlua" <?php echo (( "Kahlua" == $getCashiersReportItem['items']) ? 'selected' : '')?>>Kahlua</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="text" name="openingInventory" class="form-control" value="{{ $getCashiersReportItem['opening_inventory'] }}" />
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="text" name="sold" class="form-control" value="{{ $getCashiersReportItem['sold'] }}" />  
                                    </div>
                                    <div class="col-lg-2">
                                        
                                        <input type="text" name="closing" class="form-control" value="{{ $getCashiersReportItem['closing'] }}" />  
                                    </div>
                                    <div class="col-lg-2">
                                        
                                        <input type="text" name="total" class="form-control" value="{{ $getCashiersReportItem['total']}}"  />  
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                     <div class="col-lg-4">
                                        <input type="hidden" name="cashiersId" value="{{ $getCashiersReport['id']}}" />
                                        <input type="submit" class="btn btn-success" value="Update" />
                                        @if($user->role_type == 1)
                                            <a id="delete" onClick="confirmDelete('{{ $getCashiersReportItem['id']}}')" href="javascript:void" class="btn btn-danger">Remove</a>
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
   function confirmDelete(id){
      const x = confirm("Do you want to delete this?");
        if(x){
            $.ajax({
              type: "DELETE",
              url: '/ribos-bar/cashiers-report-form/delete-item/' + id,
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