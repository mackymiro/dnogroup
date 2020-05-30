@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Edit Billing Statement |')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });

  $(function() {
        $(".datepicker").datepicker();
      });
</script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<div id="wrapper">
     @include('sidebar.sidebar')
     <div id="content-wrapper"> 
     	<div class="container-fluid">
     		<!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lechon de Cebu</a>
              </li>
              <li class="breadcrumb-item active">Update Billing Statement Form</li>
            </ol>
             <a href="{{ url('lolo-pinoy-lechon-de-cebu/billing-statement-lists') }}">Back to Lists</a>
             <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
            	 <h4 class="text-center"><u>BILLING STATEMENT/COLLECTION STATEMENT</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                         <div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            Edit Billing Statement</div>
                          <div class="card-body">
                                 @if(session('SuccessE'))
                                     <p class="alert alert-success">{{ Session::get('SuccessE') }}</p>
                                    @endif 
                                  <form action="{{ action('LoloPinoyLechonDeCebuController@updateBillingInfo', $billingStatement['id']) }}" method="post">

                                   {{csrf_field()}}
                                   <input name="_method" type="hidden" value="PATCH">
                                  <div class="form-group">
                                    <div class="form-row">
                                      <div class="col-lg-6">
                                        <label>Bill to</label>
                                        <input type="text" name="billTo" class="form-control" value="{{ $billingStatement['bill_to'] }}" />
                                        <label>Address</label>
                                        <input type="text" name="address" class="form-control" value="{{ $billingStatement['date'] }}" />
                                        <label>Period Covered</label>
                                        <input type="text" name="periodCovered" class="form-control" value="{{ $billingStatement['period_cover'] }}" />
                                          </div>
                                      <div class="col-lg-6">
                                      <label>Date</label>
                                        <input type="text" name="date" class="datepicker form-control" value="{{ $billingStatement['date'] }}" />
                                       
                                        <label>Branch</label>
                                         <div id="app-branch">
                                           <select name="branch" class="form-control">
                                               <option value="0">--Please Select--</option>
                                                <option v-for="branch in branches" v-bind:value="branch.value":selected="branch.value=={{json_encode($billingStatement['branch'])}}?true : false">
                                                  @{{ branch.text }}
                                                 </option>
                                          </select>
                                          <label>Terms</label>
                                          <input type="text" name="terms" class="form-control" required="required" value="{{ $billingStatement['terms'] }}" />
                                    
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <div class="form-row">
                                      <div class="col-lg-2">
                                        <label>Date</label>
                                        <input type="text" name="transactionDate" class="datepicker form-control" value="{{ $billingStatement['date_of_transaction'] }}" />
                                      </div>
                                      @if($billingStatement['order'] == "Private Order")
                                      <div class="col-lg-2">
                                        <label>Order</label>
                                        <input type="text" name="choose" class="form-control" disabled="disabled" value="{{ $billingStatement['order'] }}" />
                                      </div>
                                      @else
                                      <div class="col-lg-2">
                                        <label>Order</label>
                                        <input type="text" name="choose" class="form-control" value="{{ $billingStatement['order'] }}" />
                                      </div>
                                      @endif
                                      @if($billingStatement['order'] != "Private Order")
                                      <div class="col-lg-2">
                                        <label>Invoice #</label>
                                          <input type="text" name="invoiceNumber" class="form-control"  value="{{ $billingStatement['invoice_number'] }}" />
                                      </div>
                                      @endif
                                      @if($billingStatement['order'] == "Private Order")
                                      <div class="col-lg-2">
                                        <label>Whole Lechon </label>
                                        <input type="text" name="wholeLechon" class="form-control"  readonly="readonly" disabled="disabled" value="{{ $billingStatement['whole_lechon'] }}" />
                                      </div>
                                     
                                      @else
                                      <div class="col-lg-2">
                                        <label>Whole Lechon 500/KL</label>
                                        <input type="text" name="wholeLechon" class="form-control"  value="{{ $billingStatement['whole_lechon'] }}" />
                                      </div>
                                      @endif 
                                      @if($billingStatement['order'] != "Private Order")
                                      <div class="col-lg-4">
                                        <label>Description</label>
                                          <input type="text" name="description" class="form-control"  value="{{ $billingStatement['description'] }}" />
                                      </div>
                                      @else
                                      <div class="col-lg-4">
                                        <label>Description</label>
                                          <input type="text" name="descriptionDr" class="form-control"  disabled="disabled" value="{{ $billingStatement['description'] }}" />
                                      </div>
                                      @endif
                                      <div class="col-lg-1">
                                        <label>Amount</label>
                                        <input type="text" name="amount" class="form-control" disabled="disabled" value="<?php echo number_format($billingStatement['amount'], 2); ?>" />
                                      </div>
                                    <br>
                                   <div class="col-lg-12 float-right">
                                        <br>
                                        <br>
                                        <input type="submit" class="btn btn-success float-right btn-lg"  value="Update Billing Statement" />

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
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            Add</div>
                          <div class="card-body">
                               @if(session('SuccessAdd'))
                                   <p class="alert alert-success">{{ Session::get('SuccessAdd') }}</p>
                                  @endif 
                              
                                <form action="{{ action('LoloPinoyLechonDeCebuController@addNewBilling', $billingStatement['id']) }}" method="post">
                                <div class="form-group">
                                    {{csrf_field()}}
                                   

                                    <div class="form-row">
                                        <div class="col-lg-12">
                                            <label>Date</label>
                                            <input type="text" name="transactionDate" class="datepicker form-control" required />
                                        </div>
                                        <div class="col-lg-12">
                                          <label>Order</label>
                                          <select name="choose" class="chooseOption form-control" >
                                              <option value="Ssp">Ssp</option>
                                              <option value="Private Order">Private Order</option>        
                                          </select>
                                                
                                        </div>
                                        <div  id="invoiceNo" class="col-lg-12">
                                            <label>Invoice #</label>
                                            <input type="text" name="invoiceNumber" class="form-control" />
                                        </div>
                                        <div id="drNo" class="col-lg-12">
                                            <label>DR #</label>
                                            <select data-live-search="true" name="drNo" class="drSelect form-control selectpicker">
                                              <option value="0">--Please Select--</option>
                                              @foreach($drNos as $drNo)
                                              <option value="{{ $drNo['dr_no']}}">{{ $drNo['dr_no']}}</option>
                                              @endforeach
                                            </select>	
                                        </div>
                                        <div id="wholeLechon" class="col-lg-12">
                                            <label>Whole Lechon 500/KL</label>
                                            <input type="text" name="wholeLechon" class="form-control"   />
                                        </div>
                                        <div id="wholeLechon6000" class="col-lg-12">
                                            <label>Whole Lechon</label>
                                            <input type="text" name="wholeLechon6000" class="form-control"  disabled />
                                          
                                          </div>
                                        <div id="description"  class="col-lg-12">
                                            <label>Description</label>
                                            <input type="text" name="description" class="form-control"  />
                                        </div>
                                        <div id="descriptionDrNo" class="col-lg-12">
                                          <label>Description</label>
                                          <input type="text" name="descriptionDrNo" class="form-control"  disabled />
                                          
                                        </div>
                                       
                                    </div>
                                </div>
                                <div>
                                
                                <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-plus"></i> Add</button>
                     
                               </div>
                                </form>
        
                               
                          </div>
                    </div>  
                </div>

                <div class="col-lg-8">
                    <div class="card mb-3">
                          <div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            Edit Billing Statement</div>
                          <div class="card-body">
                               @if(session('SuccessEdit'))
                                   <p class="alert alert-success">{{ Session::get('SuccessEdit') }}</p>
                                  @endif 
                                @foreach($bStatements as $bStatement)
                                <form action="{{ action('LoloPinoyLechonDeCebuController@updateBillingStatement', $bStatement['id']) }}" method="post">
                                <div class="form-group">
                                    {{csrf_field()}}
                                    <input name="_method" type="hidden" value="PATCH">

                                    <div id="deletedId{{ $bStatement['id'] }}" class="form-row">
                                        @if($bStatement['order'] == "Private Order")
                                        <div class="col-lg-2">
                                            <label>Date</label>
                                            <input type="text" name="transactionDate" class="form-control" readonly="readonly" value="{{ $bStatement['date_of_transaction'] }}" />
                                        </div>
                                        @else
                                        <div class="col-lg-2">
                                            <label>Date</label>
                                            <input type="text" name="transactionDate" class="form-control" value="{{ $bStatement['date_of_transaction'] }}" />
                                        </div>
                                        @endif
                                        @if($bStatement['order'] != "Private Order")
                                        <div class="col-lg-2">
                                            <label>Invoice #</label>
                                            <input type="text" name="invoiceNumber" class="form-control" value="{{ $bStatement['invoice_number'] }}" />
                                        </div>
                                       @else  
                                    
                                       @endif
                                        @if($bStatement['order'] == "Private Order")
                                        <div class="col-lg-4">
                                            <label>Whole Lechon</label>
                                            <input type="text" name="wholeLechon" class="form-control" readonly="readonly" value="{{ $bStatement['whole_lechon'] }}" />
                                        </div>
                                        @else
                                        <div class="col-lg-4">
                                            
                                            <label>Whole Lechon 500/KL</label>
                                            <input type="text" name="wholeLechon" class="form-control"  value="{{ $bStatement['whole_lechon'] }}" />
                                        </div>
                                        @endif
                                        @if($bStatement['order'] == "Private Order")
                                        <div class="col-lg-4">
                                            <label>Description</label>
                                            <input type="text" name="description" class="form-control" readonly="readonly"  value="{{ $bStatement['description'] }}" />
                                        </div>
                                        @else
                                        <div class="col-lg-4">
                                            <label>Description</label>
                                            <input type="text" name="description" class="form-control"  value="{{ $bStatement['description'] }}" />
                                        </div>
                                        @endif
                                        <div class="col-lg-2">
                                            <label>Amount</label>
                                            <input type="text" name="amount" class="form-control" disabled="disabled" value="<?php echo number_format($bStatement['amount'], 2); ?>" />
                                        </div>
                                        <div class="col-lg-4">
                                          <br>
                                          <input type="hidden" name="billingStatementId" value="{{ $billingStatement['id'] }}" />
                                          @if($bStatement['order'] != "Private Order")
                                          <input type="submit" class="btn btn-success" value="Update" />
                                          @endif
                                          @if(Auth::user()['role_type'] == 1)
                                          <a id="delete" onClick="confirmDelete('{{ $bStatement['id'] }}')" href="javascript:void" class="btn btn-danger">Remove</a>
                                          @endif
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
<script>
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
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
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

   const confirmDelete = (id) =>{
      var x = confirm("Do you want to delete this?");
        if(x){
            $.ajax({
              type: "DELETE",
              url: '/lolo-pinoy-lechon-de-cebu/delete-billing-statement/' + id,
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