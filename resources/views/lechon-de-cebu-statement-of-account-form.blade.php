@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Statment Of Account Form |')
@section('content')
<div id="wrapper">
	<!-- Sidebar -->
    @include('sidebar.sidebar')
    <div id="content-wrapper">
    	<form action="{{ action('LoloPinoyLechonDeCebuController@storeStatementAccount') }}" method="post">
    		{{ csrf_field() }}
		<div class="container-fluid">
			<!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lechon de Cebu</a>
              </li>
              <li class="breadcrumb-item active">Statement of Account Form</li>
            </ol>
            <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoys-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
            	 
            	 <h4 class="text-center"><u>STATEMENT OF ACCOUNT</u></h4>
            </div>

           <div class="row">
              <div class="col-lg-12">
                  <div class="card mb-3">
                      <div class="card-header">
                       <i class="fas fa-receipt" aria-hidden="true"></i>
                Statement Of Account</div>
                     <div class="card-body">
                           <div class="form-group">
                          <div class="form-row">
                          <div class="col-lg-6">
                          <label>Date</label>
                          <input type="text" name="date" class="form-control" required="required" />
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
                          <label>Invoice #</label>
                          <input type="text" name="invoiceNumber" class="form-control" disabled="disabled" />
                          
                          <label>Kilos</label>
                          <input type="text" name="kilos" class="form-control" required="required" />
                          @if ($errors->has('kilos'))
                                  <span class="alert alert-danger">
                                    <strong>{{ $errors->first('kilos') }}</strong>
                                  </span>
                                @endif
                          <label>Unit price</label>
                          <input type="text" name="unitPrice" class="form-control" />
                          
                          <label>Payment Method</label>
                          <div id="app-payment">
                            <select name="paymentMethod" class="form-control">
                              <option value="0">--Please Select--</option>
                              <option v-for="payment in payments" v-bind:value="payment.value">
                              @{{ payment.text }}
                            </option>
                            </select>
                          </div>
                        
                          </div>
                          <div class="col-lg-6">
                          <label>Amount</label>
                          <input type="text" name="amount" class="form-control" required="required" />
                          @if ($errors->has('amount'))
                                  <span class="alert alert-danger">
                                    <strong>{{ $errors->first('amount') }}</strong>
                                  </span>
                                @endif
                          <div id="app-status">
                            <label>Status</label>
                            <select name="status" class="form-control">
                              <option value="0">--Please Select--</option>
                            <option v-for="status in statuses" v-bind:value="status.value">
                              @{{ status.text }}
                            </option>
                            </select>
                          </div>
                          <label>Paid Amount</label>
                          <input type="text" name="paidAmount" class="form-control"  />
                          
                          <label>Collection Date</label>
                          <input type="text" name="collectionDate" class="form-control" />
                        
                          <label>Check Number</label>
                          <input type="text" name="checkNumber" class="form-control"  />
                        
                          <label>Check Amount</label>
                          <input type="text" name="checkAmount" class="form-control" required="required" />
                        @if ($errors->has('checkAmount'))
                                  <span class="alert alert-danger">
                                    <strong>{{ $errors->first('checkAmount') }}</strong>
                                  </span>
                                @endif
                          <label>OR Number</label>
                          <input type="text" name="orNumber" class="form-control"  />
                          
                          </div>
                          </div>
                          <br>
                          <div>
                              <input type="submit" class="btn btn-success float-right" value="Add Statement of Account" />
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
</script>
@endsection