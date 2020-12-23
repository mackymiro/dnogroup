@extends('layouts.wimpys-food-express-app')
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

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css" >
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>


<div id="wrapper">
     @include('sidebar.sidebar-wimpys-food-express')
     <div id="content-wrapper"> 
     	<div class="container-fluid">
     		<!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Wimpy's Food Express</a>
              </li>
              <li class="breadcrumb-item active">Update Billing Statement Form</li>
            </ol>
             <a href="{{ url('wimpys-food-express/billing-statement-lists') }}">Back to Lists</a>
             <div class="col-lg-12">
             <img src="{{ asset('images/digitized-logos/wimpys-logo1.jpg')}}" width="350" height="178" class="img-responsive mx-auto d-block" alt="Wimpy's Food Express">
            	 
            	  
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
                                  <form action="{{ action('WimpysFoodExpressController@updateBillingInfo', $billingStatement['id']) }}" method="post">

                                   {{csrf_field()}}
                                   <input name="_method" type="hidden" value="PUT">
                                   <div class="form-group">
                                     <div class="form-row">
                                            <div class="col-lg-2">
                                            <label>Bill To</label>
                                            <input type="text" name="billTo" class="form-control" value="{{ $billingStatement['bill_to']}}" />
                                        
                                            </div>	
                                            <div class="col-lg-2">
                                                <label>Date</label>
                                                <input type="text" name="date" class="datepicker form-control" value="{{ $billingStatement['date']}}" />
                                            
                                            </div>
                                            <div class="col-lg-4">
                                                <label>Address</label>
                                                <input type="text" name="address" class="form-control" value="{{ $billingStatement['address']}}" />
                                            
                                            </div>
                                            <div class="col-lg-4">
                                                <label>Period Covered</label>
                                                <input type="text" name="periodCovered" class="form-control" value="{{ $billingStatement['period_cover']}}" />
                                            
                                            </div>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <div class="form-row">
                                    <div class="col-lg-2">
                                        <label>Terms</label>
                                        <input type="text" name="terms" class="form-control" value="{{ $billingStatement['terms'] }}" />
                                       
                                    </div>
                                    </div>
                    	 		          </div>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="col-lg-2">
                                                <label>Date</label>
                                                <input type="text" name="transactionDate" class="datepicker form-control" value="{{ $billingStatement['date_of_transaction']}}"  />

                                            </div>
                                      
                                            <div class="col-lg-2">
                                            <label>DR #</label>
                                            <input type="text" name="drNo" class="form-control"  value="{{ $billingStatement['dr_no'] }}" />
                                            
                                            </div>
                                      <div  class="col-lg-4">
                                        <label>Item Description</label>
                                        <input type="text" name="description" class="form-control" value="{{ $billingStatement['description'] }}" />
                                      
                                        </div>
                                        <div  class="col-lg-2">
                                          <label>Unit Price</label>
                                          <input type="text" name="unitPrice" class="form-control" value="{{ $billingStatement['unit_price'] }}" />
                                          
                                        </div>
                                        <div  class="col-lg-2">
                                          <label>Amount</label>
                                          <input type="text" name="amount" class="form-control" value="{{ $billingStatement['amount'] }}" />
                                          
                                        </div>	
                                        </div>
                                        <br>
                                          <div>
                                              <button type="submit" class="btn btn-success btn-lg float-right">Update Billing</button>
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
                            Add</div>
                          <div class="card-body">
                               @if(session('SuccessAdd'))
                                   <p class="alert alert-success">{{ Session::get('SuccessAdd') }}</p>
                                  @endif 
                              
                                <form action="{{ action('WimpysFoodExpressController@addNewBilling', $billingStatement['id']) }}" method="post">
                                <div class="form-group">
                                    {{csrf_field()}}
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                                <label>Date</label>
                                                <input type="text" name="transactionDate" class="datepicker form-control"  required  />

            	 						                  </div>
                                      
                                            <div class="col-lg-12">
                                            <label>DR #</label>
                                            <input type="text" name="drNo" class="form-control"  required />
                                            
                                          </div>
                                        <div  class="col-lg-12">
                                          <label>Item Description</label>
                                          <input type="text" name="description" class="form-control" required />
                                        
                                          </div>
                                          <div  class="col-lg-12">
                                            <label>Unit Price</label>
                                            <input type="text" name="unitPrice" class="form-control" required />
                                            
                                          </div>
                                          <div  class="col-lg-12">
                                            <label>Amount</label>
                                            <input type="text" name="amount" class="form-control" required />
                                            
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
                                    <input name="_method" type="hidden" value="PUT">

                                    <div id="deletedId{{ $bStatement['id'] }}" class="form-row">
                                       
                                        <div class="col-lg-2">
                                            <label>Date</label>
                                            <input type="text" name="transactionDate" class="form-control" disabled="disabled" value="{{ $bStatement['date_of_transaction'] }}" />
                                        </div>
                                        <div class="col-lg-4">
                                            <label>DR #</label>
                                            <input type="text" name="drNo" class="form-control"  disabled="disabled" value="{{ $bStatement['dr_no'] }}" />
                                            
                                        </div>                
                                      
                                        <div class="col-lg-6">
                                            <label>Item Description</label>
                                            <input type="text" name="description" class="form-control"  disabled="disabled" value="{{ $bStatement['description'] }}" />
                                        </div>
                                       
                                        <div class="col-lg-2">
                                            <label>Amount</label>
                                            <input type="text" name="amount" class="form-control" disabled="disabled" value="<?= number_format($bStatement['amount'], 2); ?>" />
                                        </div>
                                        <div class="col-lg-4">
                                          <br>
                                          <input type="hidden" id="billingStatementId" name="billingStatementId" value="{{ $billingStatement['id'] }}" />
                                         
                                          @if(Auth::user()['role_type'] == 1)
                                         
                                          <a id="delete" onclick="confirmDelete('{{ $bStatement['id'] }}')" href="javascript:void" class="btn btn-danger">Remove</a>
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

<script type="text/javascript">

   const confirmDelete = (id) =>{
     const billingStatementId =  $("#billingStatementId").val();
      var x = confirm("Do you want to delete this?");
        if(x){
            $.ajax({
              type: "DELETE",
              url: '/wimpys-food-express/delete-data-billing-statement/' + id,
              data:{
                _method: 'delete', 
                "_token": "{{ csrf_token() }}",
                "id": id,
                "billingStatementId":billingStatementId,
                
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