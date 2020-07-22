@extends('layouts.dno-personal-app')
@section('title', 'Payment Voucher Form |')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
      
  });
  $(function() {
    $( ".datepicker" ).datepicker();
  });
</script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css" >
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<div id="wrapper">
	<!-- Sidebar -->
    @include('sidebar.sidebar-dno-personal')
    <div id="content-wrapper">
    	<div class="container-fluid">
    		 <!-- Breadcrumbs-->
	            <ol class="breadcrumb">
	              <li class="breadcrumb-item">
	                <a href="#">DNO Personal</a>
	              </li>
                <li class="breadcrumb-item active">Payables</li>
	              <li class="breadcrumb-item ">Payment Voucher Form</li>
	            </ol>
	            <div class="col-lg-12">
	            	  <img src="{{ asset('images/digitized-logos/dno-personal.png')}}" width="255" height="255" class="img-responsive mx-auto d-block" alt="DNO Personal">
	            
	            	 <h4 class="text-center"><u>PAYMENT VOUCHER</u></h4>
	            </div>
	            <div class="row">
	            	<div class="col-lg-12">
	            		<div class="card mb-3">
	            			        <div class="card-header">
                              <i class="fas fa-file-invoice" aria-hidden="true"></i>
                          	  Payment Voucher
                            </div>
                              <form action="{{ action('DnoPersonalController@paymentVoucherStore') }}" method="post">
                                {{ csrf_field() }}
                          	  <div class="card-body">
                                  
                                    @if(session('error'))
                                        <p class="alert alert-danger">{{ Session::get('error') }}</p>
                                    @endif
                          	  		<div class="form-group">
                      	  				<div class="form-row">
                                      <div class="col-lg-2">
                                          <label>Payment Method</label>
                                          <div id="app-payment-method">
                                              <select name="paymentMethod" class="payment form-control">
                                                  <option value="0">--Please Select--</option>
                                                  <option v-for="payment in payments" v-bind:value="payment.value">
                                                    @{{ payment.text }}
                                                  </option>
                                              </select>
                                          </div>
                                      </div>
                                      <div class="col-lg-2">
                                          <label>Use Credit Card</label>
                                          <div id="app-use-card">
                                              <select name="useCC" class="use-card form-control"> 
                                                  <option v-for="card in cards" v-bind:value="card.value">
                                                    @{{ card.text }}
                                                  </option>
                                              </select>
                                          </div>
                                      </div>
                                      <div class="col-lg-2">
                      	  							<label>Invoice #</label>
                      	  						  <input type="text" name="invoiceNumber" class="selcls form-control" />
                      	  						</div>
                                      <div id="paidToCash" class="col-lg-2">
                      	  							<label>Paid To</label>
                      	  						  <input type="text" name="paidToCash" class="selcls form-control"  />
                      	  						</div>
                                     
                      	  						<div id="paidTo" class="col-lg-4">
                      	  							<label>Bank Card</label>
                      	  						  <select  data-live-search="true"  name="bankName" class="change selectpicker form-control">
                                            <option value="0">--Please Select--</option>
                                            @foreach($getCreditCards as $getCreditCard)
                                            <option value="{{ $getCreditCard['id'] }}-{{ $getCreditCard['bank_name']}}">{{ $getCreditCard['bank_name'] }}</option>
                                            @endforeach
                                        </select>
                                        
                      	  						</div>
                                    
                    	  						  <div id="acctNum" class="col-md-2">
                                         <label>Account #</label>
                                         <div id="accountNoHide">
                                            <input type="text" name="accountNo" class="selcls form-control"  readonly="readonly" />
                                         </div>
                                         <div id="accountNo"></div> 
                                      </div>
                                      
                                      <div id="acctName" class="col-md-4">
                                         <label>Account Name</label>
                                          <div id="accountNameHide">
                                            <input type="text" name="accountName" class="selcls form-control"  readonly="readonly" />
                                          </div>
                                          <div id="accountName"></div>
                                      </div>
                                      <div id="acctNameCash" class="col-md-4">
                                         <label>Account Name</label>
                                          <div id="accountNameHide">
                                            <input type="text" name="accountNameCash" class="selcls form-control" />
                                          </div>
                                          <div id="accountName"></div>
                                      </div>
                                      <div id="typeOfCC" class="col-md-4">
                                         <label>Type Of Card</label>
                                         <div id="typeOfCardHide">
                                            <input type="text" name="typeOfCard" class="selcls form-control"  readonly="readonly" />
                                         </div>
                                         <div id="typeOfCard"></div>
                                      </div>
                      	  						<div class="col-md-2">
                                          <label>Issued Date </label>
                                          <input type="text" id="issuedDate" name="issuedDate" class="datepicker selcls form-control"  />
                                      </div>                                     
                      	  				</div>
                          	  		</div>
                                  <div class="form-group">
                                      <div class="form-row">
                                          <div  class="col-md-4">
                                              <label>Category</label>
                                              <select  name="category" class="category selcls form-control" > 
                                                <option value="0">--Please Select--</option>
                                                <optgroup label="Personal Expenses">
                                                  <option value="ALD Accounts">ALD Accounts</option>
                                                  <option value="MOD Accounts">MOD Accounts</option>
                                                </optgroup>
                                                <optgroup label="Credit Cards">
                                                   <option value="ALD Accounts">ALD Accounts</option>
                                                   <option value="MOD Accounts">MOD Accounts</option>
                                                </optgroup>
                                                <optgroup label="Properties">
                                                  <option value="Cebu Properties">Cebu Properties</option>
                                                  <option value="Manila Properties">Manila Properties</option>
                                                </optgroup>
                                                <optgroup label="Transportation">
                                                  <option value="Vehicles">Vehicles</option>
                                                  
                                                </optgroup>
                                                <option value="Petty Cash">Petty Cash</option>
                                                <option value="Payroll">Payroll</option>
                                               
                                              </select>
                                          </div>
                                          <div id="cebuProp" class="col-lg-4">
                                              <label>Sub Category</label>
                                              <select id="cebuPropId" name="subCatCebu" class="selcls form-control" >
                                                  <option value="0">--Please Select--</option>
                                                  @foreach($getCebuProperties as $getCebuProperty)
                                                  <option value="{{ $getCebuProperty['id']}}-{{ $getCebuProperty['property_name']}}">{{ $getCebuProperty['property_name']}}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                          <div id="manilaProp" class="col-lg-4">
                                              <label>Sub Category</label>
                                              <select name="subCatManila" class="selcls form-control">
                                                  <option value="0">--Please Select--</option>
                                                  @foreach($getManilaProperties as $getManilaProperty)
                                                  <option value="{{ $getManilaProperty['id']}}-{{ $getManilaProperty['property_name']}}">{{ $getManilaProperty['property_name']}}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                          <div class="bills" class="col-lg-2">
                                              <label>&nbsp</label>
                                              <select  name="otherBills" class="otherBills selcls form-control">
                                                  <option value="0">--Please Select --</option>
                                                  <option value="Veco">Veco</option>
                                                  <option value="Meralco">Meralco</option>
                                                  <option value="MCWD">MCWD</option>
                                                  <option value="PLDT">PLDT</option>
                                                  <option value="SKYCABLE">SKYCABLE</option>
                                                  <option value="Service Provider">Service Provider</option>
                                              </select>
                                          </div>
                                       
                                          <div id="selectAccountID" class="col-lg-2">
                                            <label >Please Select Account ID</label>
                                              <select data-live-search="true" name="selectAccountID" class="form-control selectpicker">
                                                @foreach($getAllFlags as $getAllFlag)
                                                <option value="{{ $getAllFlag['id']}}">{{ $getAllFlag['account_id']}}</option>
                                                @endforeach
                                              </select>
                                          </div>
                                          <div id="utility" class="col-lg-2">
                                              <label>Sub Category</label>
                                              <select id="util" name="subCatUtility" class="selcls form-control">
                                                  <option value="0">--Please Select--</option>
                                                  @foreach($getUtilities as $getUtility)
                                                  <option value="{{ $getUtility['id']}}-{{ $getUtility['vehicle_unit']}}">{{ $getUtility['vehicle_unit']}}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                          <div id="documentList" class="col-lg-2">
                                              <label>Document List</label>
                                              <select id="docu" name="documentList" class="form-control">
                                              </select>
                                          </div>
                                          <div id="supplierList" class="col-lg-2">
                                              <label>Supplier Name</label>
                                              <select data-live-search="true" id="supplierName" name="supplierName" class="form-control selectpicker">
                                                  @foreach($suppliers as $supplier)
                                                    <option value="{{ $supplier['id']}}-{{ $supplier['supplier_name']}}">{{ $supplier['supplier_name']}}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                          
                                      </div>
                                  </div>
                                
                                  <div class="form-group">
                                      <div class="form-row">
                                          <div class="col-lg-4">
                                              <label>Particulars</label>
                                              <input type="text" name="particulars" class=" form-control" required="required"/>
                                          </div>
                                          <div class="col-lg-2">
                                              <label>Currency</label>
                                              <div id="app-currency">
                                                  <select name="currency" class=" form-control"> 
                                                      <option v-for="currency in currencies" v-bind:value="currency.value">
                                                        @{{ currency.text }}
                                                      </option>
                                                  </select>
                                              </div>
                                          </div>
                                          <div class="col-lg-2">
                                              <label>Amount</label>
                                              <input type="text" name="amount" class=" form-control"  required="required"/>
                                          </div>
                                      </div>
                                  </div>
                                  <div>
                                      <button type="submit" class="btn btn-success float-right btn-lg"><i class="fas fa-save"></i> Save Payment Voucher</button>
                                      <br>
                                      
                                  </div>
                                  <br>
                          	  </div>
                            </form>
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
    $(document).ready(function(){
      $("#paidTo").hide();
      $("#acctNo").hide();
      $("#acctNum").hide();
      $("#typeOfCC").hide();
      $("#acctName").hide();
      $("#documentList").hide();
      $(".bills").hide();
      $("#supplierList").hide();
  
      $("#selectAccountID").hide();

      //for categories
      $("#cebuProp").hide();
      $("#manilaProp").hide();
      $("#utility").hide();
      
      $("#cebuPropId").change(function(){
          const cebuProp = $(this).children("option:selected").val();
          const cebuPropSplit = cebuProp.split("-");
          const cebuPropArr = cebuPropSplit[0];
        
          //make ajax call
          $.ajax({
              type: "GET",
              url:'/dno-personal/get-cebu-properties/' + cebuPropArr,
              data:{
                  _method:'get',
                  "id":cebuPropArr,
              },
              success:function(data){
                  console.log(data);
              },
              error:function(data){
                  console.log('Error:', data);
              }
          });
      }); 


      $(".otherBills").change(function(){
         const bills = $(this).children("option:selected").val();
         if(bills == "Veco"){
             $("#selectAccountID").show();
             $("#supplierList").hide();
         }else if(bills == "Meralco"){
             $("#selectAccountID").show();
             $("#supplierList").hide();
         }else if(bills == "MCWD"){
             $("#selectAccountID").show();
             $("#supplierList").hide();
         }else if(bills == "PLDT"){
             $("#selectAccountID").show();
             $("#supplierList").hide();
         }else if(bills == "SKYCABLE"){
             $("#selectAccountID").show();
             $("#supplierList").hide();
         }else if(bills == "Service Provider"){
            $("#supplierList").show();

            $("#selectAccountID").hide();
         }else{
            $("#selectAccountID").hide();
            $("#supplierList").hide();
         }
      });

      $("#util").change(function(){
          const util =  $(this).children("option:selected").val();
        
          //make ajax call
          $.ajax({
              type: "GET",
              url:'/dno-personal/get-data/' + util,
              data:{
                _method: 'get',
                "id":util
              },
              success:function(data){
                  var docu = $('#docu');
                  console.log(data);
                  data.forEach(function(val, index){
                      console.log(val.document_name);
                      docu.append(
                                  $('<option ></option>').val(val.id).html(val.document_name)
                            );
                  });
                  
              },
              error:function(data){
                  console.log('Error:', data);
              }

          });
      });

      $(".category").change(function(){
          const cat  = $(this.options[this.selectedIndex]).closest('option:selected').val();

          if(cat === "Cebu Properties"){
              $("#cebuProp").show();
              $(".bills").show();

              $("#manilaProp").hide();
              $("#utility").hide();
              $("#documentList").hide();
              $("#selectAccountID").hide();
              

              $("#documentList").val('');
          }else if(cat === "Manila Properties"){
              $("#manilaProp").show();

              $("#cebuProp").hide();
              $("#utility").hide();
              $("#documentList").hide();
              $(".bills").show();
              $("#selectAccountID").hide();
             

              $("#documentList").val('');
          }else if(cat === "Vehicles"){
              $("#utility").show();
              $("#documentList").show();

              $("#cebuProp").hide();
              $(".bills").hide();
              $("#manilaProp").hide();
              $("#selectAccountID").hide();
            
               
          }else{
            $("#cebuProp").hide();
            $(".bills").hide();
            $("#manilaProp").hide();
            $("#utility").hide();
            $("#documentList").hide();
            $("#selectAccountID").hide();
          } 


      });

      $(".use-card").change(function(){
          const useCard = $(this).children("option:selected").val();
   
          if(useCard == "No"){
             $("#paidTo").hide();
             $("#acctName").hide();
             $("#typeOfCC").hide();
             $("#acctNum").hide();

             $("#acctNameCash").show();

              $("#acct").val('');
              $("#actName").val('');
              $("#typeCC").val('');
              $(".change").val('');
              $("#issuedDate").val('');
          }else{
             $("#paidTo").show();
             $("#acctName").show();
             $("#typeOfCC").show();
             $("#acctNum").show();
             $("#acctNameCash").hide();
          }
      });

      $(".payment").change(function(){
          const payment = $(this).children("option:selected").val();
          
          if(payment === "Cash"){
              
              $("#paidTo").hide();
              $("#acctNo").hide();
              $("#acctNum").hide();
              $("#typeOfCC").hide();
              $("#acctName").hide();
              $("#acctNameCash").show();
              $("#paidToCash").show();

              $("#paidTo").val('');
              $("#acctNo").val('');
              $("#acctNum").val('');
              $("#typeOfCC").val('');
              $("#acctName").val('');

              $("#acct").val('');
              $("#actName").val('');
              $("#typeCC").val('');
              $(".change").val('0');
              $("#issuedDate").val('');
              $(".use-card").val('No');

          }else if( payment === "Cheque"){
              
              $("#paidTo").hide();
              $("#acctNo").hide();
              $("#acctNum").hide();
              $("#typeOfCC").hide();
              $("#acctName").hide();
              $("#acctNameCash").show();
              $("#paidToCash").show();
              $("#actName").show(); 

              $(".use-card").val('No');
          }
      });

      $(".change").change(function(){
             
             const bankName =   $(this).children("option:selected").val();
             const bankNameSplit  = bankName.split("-");
             const bankNameSplitArr = bankNameSplit[0];

             if(bankNameSplitArr != 0){
                  <?php
                    $getCreditCards = DB::table(
                                      'dno_personal_credit_cards')
                                      ->get();  ?>

                  <?php foreach($getCreditCards as $getCreditCard): ?>
                        var paidTo =  $(this).children("option:selected").val();
                      
                        var paidToSplit = paidTo.split("-");
                        var paidToSplitArr = paidToSplit[0];

                        if(paidToSplitArr === "<?php echo $getCreditCard->id ?>"){
                          <?php
                                $getId = DB::table(
                                              'dno_personal_credit_cards')
                                            ->where('id', $getCreditCard->id)
                                            ->get();
                            ?>
                          
                            $("#accountNo").html('<input type="text" id="acct" name="accountNo" class="selcls  form-control" value="<?php echo $getId[0]->account_no?>" readonly="readonly">');
                            $("#accountNoHide").hide();

            
                            $("#accountName").html('<input type="text" id="actName" name="accountName" class="selcls form-control" value="<?php echo $getId[0]->account_name; ?>" readonly="readonly"> ');
                            $("#accountNameHide").hide();

                            $("#typeOfCard").html('<input type="text" id="typeCC" name="typeOfCard" class="selcls form-control" value="<?php echo $getId[0]->type_of_card?>" readonly="readonly">');
                            $("#typeOfCardHide").hide();
                        }

                  <?php endforeach; ?>

             }else{
                  $("#acct").val('');
                  $("#actName").val('');
                  $("#typeCC").val('');
             }
             
             
        });

    });
</script>

<script>
  //payment method
  new Vue({
  el: '#app-payment-method',
    data: {
      payments:[
        { text:'CASH', value:'CASH' },
        { text:'CHECK', value:'CHECK'}
      ]
    }
  })  

  //credit card
  new Vue({
  el: '#app-use-card',
    data:{
      cards:[
        {text: 'No', value: 'No'},
        {text: 'Use Card', value: 'Use Card'}
      ]
    }
  })

  //currency 
  new Vue({
    el: '#app-currency',
      data:{
        currencies:[
          {text: '₱-PHP', value:"PHP"},
          {text: '$-USD', value:'USD'}
        ]
      }
  })

</script>

@endsection