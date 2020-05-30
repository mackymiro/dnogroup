@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Billing Statement Form |')
@section('content')
<script>
     $(function() {
        $(".datepicker").datepicker();
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
    @include('sidebar.sidebar')
    <div id="content-wrapper">
      <form action="{{ action('LoloPinoyLechonDeCebuController@storeBillingStatement') }}" method="post">
          {{csrf_field()}}
    	<div class="container-fluid">
    		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lechon de Cebu</a>
              </li>
              <li class="breadcrumb-item active">Billing Statement Form</li>
            </ol>
            <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
            	 <h4 class="text-center"><u>BILLING STATEMENT</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            Billing Statement</div>
                          <div class="card-body">
                            <div class="form-group">
                            <div class="form-row">
                              <div class="col-lg-6">
                               
                                <label>Bill To</label>
                                <input type="text" name="billTo" class="form-control" required="required" />
                                @if ($errors->has('billTo'))
                                    <span class="alert alert-danger">
                                      <strong>{{ $errors->first('billTo') }}</strong>
                                    </span>
                                @endif
                                <label>Address</label>
                                <input type="text" name="address" class="form-control" required="required" />
                                @if ($errors->has('address'))
                                    <span class="alert alert-danger">
                                      <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                  @endif
                                <label>Period Covered</label>
                                <input type="text" name="periodCovered" class="form-control" required="required" />
                                @if ($errors->has('periodCovered'))
                                    <span class="alert alert-danger">
                                      <strong>{{ $errors->first('periodCovered') }}</strong>
                                    </span>
                                  @endif
                                
                              </div>
                              <div class="col-lg-6">
                                <label>Date</label>
                                <input type="text" name="date" class="datepicker form-control" required="required" autocomplete="off" />
                                @if ($errors->has('date'))
                                    <span class="alert alert-danger">
                                      <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                                  @endif
                            
                               
                                <label>Branch</label>
                                <div id="app-branch">
                                  <select name="branch" class="form-control">
                                      <option value="0">--Please Select--</option>
                                      <option v-for="branch in branches" v-bind:value="branch.value">
                                          @{{ branch.text }}
                                      </option>
                                  </select>
                                </div>
                                <label>Terms</label>
                                <input type="text" name="terms" class="form-control" required="required" />
                                @if ($errors->has('terms'))
                                    <span class="alert alert-danger">
                                      <strong>{{ $errors->first('terms') }}</strong>
                                    </span>
                                  @endif
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="form-row">
                                  <div class="col-lg-2">
                                    <label>Date</label>
                                    <input type="text" name="transactionDate" class="datepicker form-control" required="required" />
                                    @if ($errors->has('transactionDate'))
                                      <span class="alert alert-danger">
                                        <strong>{{ $errors->first('transactionDate') }}</strong>
                                      </span>
                                    @endif
                                  </div>
                                  <div class="col-lg-2">
                                      <label>Order</label>
                                        <select name="choose" class="chooseOption form-control" >
                                        <option value="Ssp">Ssp</option>
                                          <option value="Private Order">Private Order</option>
                                          
                                        </select>
                                      
                                  </div>
                                  
                                  <div id="invoiceNo" class="col-lg-2">
                                      <label>Invoice #</label>
                                      <input type="text" name="invoiceNumber" class="form-control"  />
                                  </div>
                                  <div id="drNo" class="col-lg-2">
                                      <label>DR #</label>
                                      <select data-live-search="true" name="drNo" class="drSelect form-control selectpicker">
                                        <option value="0">--Please Select--</option>
                                        @foreach($drNos as $drNo)
                                        <option value="{{ $drNo['dr_no']}}">{{ $drNo['dr_no']}}</option>
                                        @endforeach
                                      </select>	
                                  </div>
                                <div id="wholeLechon" class="col-lg-4">
                                  <label>Whole Lechon 500/KL</label>
                                  <input type="text" name="wholeLechon" class="form-control" />
                               
                                </div>
                                <div id="wholeLechon6000" class="col-lg-4">
                                  <label>Whole Lechon</label>
                                  <input type="text" name="wholeLechon6000" class="form-control"  disabled />
                                 
                                </div>
                                <div id="description" class="col-lg-4">
                                  <label>Description</label>
                                  <input type="text" name="description" class="form-control" />
                                
                                </div>
                                <div id="descriptionDrNo" class="col-lg-4">
                                  <label>Description</label>
                                  <input type="text" name="descriptionDrNo" class="form-control"  disabled />
                                  
                                </div>
                                
                               
                            </div>
                            <br>
                            <div>
                            <button type="submit" class="btn btn-success btn-lg float-right"><i class="fas fa-save"></i> Save Billing</button>
										        <br>
                            </div>
                          </div>
                          </div>
                    </div>
                </div>
            </div>      
    	</div>
     </form>  
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
    $("#drNo").hide();
    $("#wholeLechon6000").hide();
    $("#descriptionDrNo").hide();
    $(".chooseOption").change(function(){
         const cat  = $(this.options[this.selectedIndex]).closest('option:selected').val();
         if(cat === "Ssp"){
             $("#invoiceNo").show();
             $("#wholeLechon").show();
             $("#description").show();

             $("#drNo").hide();
             $("#wholeLechon6000").hide();
             $("#descriptionDrNo").hide();
         }else if(cat === "Private Order"){
             $("#drNo").show();
             $("#wholeLechon6000").show();
             $("#descriptionDrNo").show();
             $("#invoiceNo").hide();
             $("#wholeLechon").hide();
             $("#description").hide();
         }  
    });

    $(".drSelect").change(function(){
         <?php
          $getDrNos = DB::table(
                        'lechon_de_cebu_delivery_receipts')
                        ->where('dr_id', NULL)
                        ->get();?>
        var dr = $(this).children("option:selected").val();
        <?php foreach($getDrNos as $key=>$getDrNo ): ?>
             if(dr === "<?php echo $getDrNo->dr_no?>"){
                $("#wholeLechon6000").html('<label>Whole Lechon</label><input type="text" name="wholeLechon6000" value="<?php echo $getDrNo->price; ?>" class="form-control" readonly="readonly" />');
                $("#descriptionDrNo").html('<label>Description</label><input type="text" name="descriptionDrNo" value="<?php echo $getDrNo->description; ?>" class="form-control" readonly="readonly" />');
             }
           
        <?php endforeach; ?>
    });
</script>
<script>
  //choose
  new Vue({
  el: '#app-choose',

    data: {
      statuses:[
        { text:'Private-orders', value: 'Private-orders' },
        { text:'Ssp', value: 'Spp'}
      ]
    }
  })  

   //branch data
  new Vue({
  el: '#app-branch',
    data: {
      branches:[
        { text:'Terminal 1', value: 'Terminal 1' },
        { text:'Terminal 2', value: 'Terminal 2'}
      ]
    }
  })  
  
</script>
@endsection