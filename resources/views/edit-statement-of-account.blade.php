@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Edit Statment Of Account|')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
</script>
<div id="wrapper">
	 @include('sidebar.sidebar')
	<div id="content-wrapper">
		<div class="container-fluid">
			<!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lechon de Cebu</a>
              </li>
              <li class="breadcrumb-item active">Update Statement Of Account Form</li>
            </ol>
            <a href="{{ url('lolo-pinoy-lechon-de-cebu/statement-of-account/lists') }}">Back to Lists</a>
            <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
            	 <h4 class="text-center"><u>STATEMENT OF ACCOUNT</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                              <i class="fas fa-receipt" aria-hidden="true"></i>
                            Edit Statement Of Account</div>
                        <div class="card-body">
                              @if(session('SuccessE'))
                                 <p class="alert alert-success">{{ Session::get('SuccessE') }}</p>
                                @endif 
                              <form action="{{ action('LoloPinoyLechonDeCebuController@updateStatementInfo', $getStatementOfAccount['id']) }}" method="post">
                                 {{csrf_field()}}
                               <input name="_method" type="hidden" value="PATCH">
                              <div class="form-group">
                                <div class="form-row">
                                  <div class="col-lg-4">
                                      <label>Bill To</label>
                                      <input type="text" name="billTo" class="form-control" value="{{ $getStatementOfAccount['bill_to']}}" disabled="disabled" /> 
                                  </div>
                                  <div class="col-lg-2">
                                      <label>Date</label>
                                      <input type="text" name="date" class="form-control" value="{{ $getStatementOfAccount['date']}}" disabled="disabled" />
                                  </div>
                                   <div class="col-lg-4">
                                      <label>Address</label>
                                      <input type="text" name="address" class="form-control" value="{{ $getStatementOfAccount['address']}}" disabled="disabled" /> 
                                  </div>
                                   <div class="col-lg-2">
                                      <label>Reference #</label>
                                      <input type="text" name="date" class="form-control" value="{{ $getStatementOfAccount['reference_number'] }}" disabled="disabled" />
                                  </div>
                                </div>
                                
                              </div>
                              <div class="form-group">
                                  <div class="form-row">
                                      <div class="col-lg-2">
                                          <label>Period Covered</label>
                                          <input type="text" name="periodCover" class="form-control" value="{{ $getStatementOfAccount['period_cover']}}" disabled="disabled" />
                                      </div>
                                      <div class="col-lg-2">
                                          <label>PO Number</label>
                                          <input type="text" name="poNumber" class="form-control" value="{{ $getStatementOfAccount['p_o_number']}}" disabled="disabled" />
                                      </div>
                                      <div class="col-lg-2">
                                          <label>Terms</label>
                                          <input type="text" name="terms" class="form-control" value="{{ $getStatementOfAccount['terms']}}" disabled="disabled" />
                                      </div>
                                       <div class="col-lg-2">
                                           <label>Branch</label>
                                          <select name="branch" class="form-control">
                                              <option value="0">--Please Select--</option>
                                              <option value="Terminal 1" <?php echo ("Terminal 1" == $getStatementOfAccount['branch']) ? 'selected="selected"' : '' ?> >Terminal 1</option>
                                              <option value="Terminal 2" <?php echo ("Terminal 2" == $getStatementOfAccount['branch']) ? 'selected="selected"' : '' ?> >Terminal 2</option>
                                            </option>
                                          </select>
                                      </div>
                                      <div class="col-lg-2">
                                          <label>Payment Method</label>
                                           <select name="paymentMethod" class="form-control">
                                              <option value="0">--Please Select--</option>
                                              <option value="CHEQUE" <?php echo ("CHEQUE" == $getStatementOfAccount['payment_method']) ? 'selected="selected"' : '' ?>>CHEQUE</option>
                                              <option value="ACCOUNT"  <?php echo ("ACCOUNT" == $getStatementOfAccount['payment_method']) ? 'selected="selected"' : '' ?>>ACCOUNT</option>
                                            </option>
                                            </select>

                                      </div>
                                      <div class="col-lg-2">
                                          <label>Total Amount</label>
                                          <p class="bg-success" style="color:white; border-radius: 3px; padding:5px;"><?php echo number_format($sum, 2);?></p>
                                         
                                      </div>
                                  </div>
                              </div>
                              
                              <div class="form-group">
                                  <div class="form-row">
                                      <div class="col-lg-2">
                                          <label>Status</label>
                                            <select name="status" class="form-control">
                                              <option value="0">--Please Select--</option>
                                              <option value="Unpaid"  <?php echo ("Unpaid" == $getStatementOfAccount['status']) ? 'selected="selected"' : '' ?>>Unpaid</option>
                                              <option value="Paid"  <?php echo ("Paid" == $getStatementOfAccount['status']) ? 'selected="selected"' : '' ?>>Paid</option>
                                            </select>
                                      </div>
                                      <div class="col-lg-2">
                                          <label>Paid Amount</label>
                                          <input type="text" name="paidAmount" class="form-control" value="{{ $getStatementOfAccount['paid_amount']}}" />
                                      </div>
                                      <div class="col-lg-2">
                                          <label>Collection Date</label>
                                          <input type="text" name="collectionDate" class="form-control" value="{{ $getStatementOfAccount['collection_date']}}" />
                                      </div>
                                      <div class="col-lg-2">
                                          <label>Cheque Number</label>
                                          <input type="text" name="chequeNumber" class="form-control" value="{{ $getStatementOfAccount['check_number']}}" />
                                      </div>
                                      <div class="col-lg-2">
                                          <label>Cheque Amount</label>
                                          <input type="text" name="chequeAmount" class="form-control" value="{{ $getStatementOfAccount['check_amount']}}" />
                                      </div>
                                      <div class="col-lg-2">
                                          <label>OR Number</label>
                                          <input type="text" name="orNumber" class="form-control" value="{{ $getStatementOfAccount['or_number']}}" />
                                      </div>
                                        
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <div class="form-row">
                                        <div class="col-lg-12 float-right">
                                  
                                            <input type="submit" class="btn btn-success"  value="Update Statement Of Account" />
                                        </div>       
                                      </div>
                                  </div>
                                   
                              </div>
                              
                            </form>
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
        var x = confirm("Do you want to delete this?");
        if(x){
             $.ajax({
              type: "DELETE",
              url: '/lolo-pinoy-lechon-de-cebu/delete-statement-account/' + id,
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
<script>
	

	//status data
	new Vue({
	el: '#app-status',
		data: {
			statuses:[
				{ text:'Unpaid', value: 'Unpaid' },
				{ text:'Paid', value: 'Paid'}
			]
		}
	})	

	//payment data
	new Vue({
	el: '#app-payment',
		data: {
			payments:[
				{ text:'CHEQUE', value: 'CHEQUE' },
				{ text:'ACCOUNT', value: 'ACCOUNT'}
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