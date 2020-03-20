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
                             
                               <div class="form-group"> 
                                  <div class="form-row">
                                       <div class="col-lg-4">
                                            <label><strong style="font-size: 20px;">Total Remaining Balance</strong></label>
                                            <p class="bg-danger" style="color:white; border-radius: 3px; padding:5px;">₱ <?php echo number_format($computeAll, 2);?></p>
                                           
                                        </div>
                                         <div class="col-lg-4">
                                            <label><strong style="font-size: 20px;">Total  Balance</strong></label>
                                            <p class="bg-success" style="color:white; border-radius: 3px; padding:5px;">₱ <?php echo number_format($sum, 2);?></p>
                                           
                                        </div>       
                                  </div>
                               </div>
                               
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
                                           <input type="text" name="branch" class="form-control" value="{{ $getStatementOfAccount['branch']}}" disabled="disabled" />
                                      </div>
                                    
                                     
                                  </div>
                              </div>
                            
                        </div>
                    </div>  
                </div>
              </div>
                <div class="row">
                    <div class="col-lg-12">
                          <div class="card mb-3">
                                 <div class="card-header">
                                  <i class="fas fa-receipt" aria-hidden="true"></i>
                                Statement Of Account (Unpaid)</div>
                                <div class="card-body">
                                      @if(session('sAccountUpdate'))
                                         <p class="alert alert-success">{{ Session::get('sAccountUpdate') }}</p>
                                      @endif 
                                      @foreach($sAccounts as $sAccount)
                                      <form  action="{{ action('LoloPinoyLechonDeCebuController@sAccountUpdate', $sAccount['id']) }}" method="post">
                                         {{csrf_field()}}
                                 <input name="_method" type="hidden" value="PATCH">
                                      <div class="form-group">
                                          <div class="form-row">
                                              <div class="col-lg-1">
                                                  <label>Date</label>
                                                  <input type="text" name="date" class="form-control" value="{{ $sAccount['transaction_date'] }}"  disabled="disabled" />
                                              </div>
                                               <div class="col-lg-2">
                                                  <label>Invoice</label>
                                                  <input type="text" name="invoiceNumber" class="form-control" value="{{ $sAccount['invoice_number'] }}" disabled="disabled" />
                                              </div>
                                              <div class="col-lg-2">
                                                  <label>Whole Lechon 500/KL</label>
                                                  <input type="text" name="wholeLechon" class="form-control"value="{{ $sAccount['whole_lechon']}}" disabled="disabled" />
                                              </div>
                                              <div class="col-lg-4">
                                                  <label>Description</label>
                                                  <input type="text" name="description" class="form-control" value="{{ $sAccount['description']}}" disabled="disabled" />
                                              </div>
                                              <div class="col-lg-1">
                                                  <label>Amount</label>
                                                  <input type="text" name="amount" class="bg-danger form-control" style="color:white;" value="<?php echo number_format($sAccount['amount'], 2)?>" disabled="disabled"/>
                                              </div>
                                              <div class="col-lg-2">
                                                  <label>Paid Amount</label>
                                                  <input type="text" name="paidAmount" class="form-control" value="{{ $sAccount['paid_amount']}}" />
                                              </div>
                                              
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <div class="form-row">
                                              <div class="col-lg-2">
                                                  <label>Status</label>
                                                  <input type="text" name="status" class="form-control" value="{{ $sAccount['status'] }}" />
                                              </div>
                                              <div class="col-lg-2">
                                                  <label>Collection Date</label>
                                                  <input type="text" name="collectionDate" class="form-control" value="{{ $sAccount['collection_date']}}" />
                                              </div>
                                              <div class="col-lg-2">
                                                  <label>Cheque Number</label>
                                                  <input type="text" name="chequeNumber" class="form-control"value="{{ $sAccount['check_number']}}" value="{{ $sAccount['check_number'] }}" />
                                              </div>
                                              <div class="col-lg-2">
                                                  <label>Cheque Amount</label>
                                                  <input type="text" name="chequeAmount" class="form-control"value="{{ $sAccount['check_amount'] }}" />
                                              </div>
                                              <div class="col-lg-2">
                                                  <label>OR Number</label>
                                                  <input type="text" name="orNumber" class="form-control" value="{{ $sAccount['or_number'] }}" />
                                              </div>
                                              <div class="col-lg-2">
                                                  <label>Payment Method</label>
                                                 <select class="form-control" name="paymentMethod">
                                                      <option value="0">--Please Select--</option>
                                                      <option value="CHEQUE">CHEQUE</option>
                                                      <option value="ACCOUNT">ACCOUNT</option>
                                                 </select>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <div class="form-row">
                                              <div class="col-lg-2">
                                                  <input type="hidden" name="soaId" value="{{ $getStatementOfAccount['id'] }}" />
                                                  <input type="submit" class="btn btn-success" value="Paid" />
                                              </div>
                                          </div>  
                                      </div>
                                    </form>
                                    @endforeach
                            </div>
                      </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12"> 
                      <div class="card mb-3">
                           <div class="card-header">
                                  <i class="fas fa-tasks" aria-hidden="true"></i>
                                Lists (Unpaid)</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Invoice #</th>
                                                <th >Whole Lechon 500/KL</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                                <th>Paid Amount</th>
                                                <th>Status</th>
                                                <th>Collection Date</th>
                                                <th>Cheque Number</th>
                                                <th>Cheque Amount</th>
                                                <th>OR Number</th>
                                                <th>Payment Method</th>
                                            </tr>
                                        </thead>
                                         <tfoot>
                                            <tr>
                                                <th>Date</th>
                                                <th>Invoice #</th>
                                                <th>Whole Lechon 500/KL</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                                <th>Paid Amount</th>
                                                <th>Status</th>
                                                <th>Collection Date</th>
                                                <th>Cheque Number</th>
                                                <th>Cheque Amount</th>
                                                <th>OR Number</th>
                                                <th>Payment Method</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach($allAccounts as $allAccount)
                                            <tr>
                                                <td ><p style="width: 110px;">{{ $allAccount['transaction_date']}}</p></td>
                                                <td>{{ $allAccount['invoice_number'] }}</td>
                                                <td>{{ $allAccount['whole_lechon']}}</td>
                                                <td><p style="width: 300px;">{{ $allAccount['description']}}</p></td>
                                                <td class="bg-danger" style="color:white;"><?php echo number_format($allAccount['amount'], 2)?></td>
                                                <td><?php echo number_format($allAccount['paid_amount'], 2) ?></td>
                                                <td>{{ $allAccount['status'] }}</td>
                                                <td>{{ $allAccount['collection_date']}}</td>
                                                <td>{{ $allAccount['check_number']}}</td>
                                                <td>{{ $allAccount['check_amount']}}</td>
                                                <td>{{ $allAccount['or_number']}}</td>
                                                <td><p style="width:110px;">{{ $allAccount['payment_method']}}</p></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                      </div>         
                </div>
            </div>
              <div class="row">
                <div class="col-lg-12"> 
                      <div class="card mb-3">
                           <div class="card-header">
                                  <i class="fas fa-tasks" aria-hidden="true"></i>
                                Lists (Paid)</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Invoice #</th>
                                                <th >Whole Lechon 500/KL</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                                <th>Paid Amount</th>
                                                <th>Status</th>
                                                <th>Collection Date</th>
                                                <th>Cheque Number</th>
                                                <th>Cheque Amount</th>
                                                <th>OR Number</th>
                                                <th>Payment Method</th>
                                            </tr>
                                        </thead>
                                         <tfoot>
                                            <tr>
                                                <th>Date</th>
                                                <th>Invoice #</th>
                                                <th>Whole Lechon 500/KL</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                                <th>Paid Amount</th>
                                                <th>Status</th>
                                                <th>Collection Date</th>
                                                <th>Cheque Number</th>
                                                <th>Cheque Amount</th>
                                                <th>OR Number</th>
                                                <th>Payment Method</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach($allAccountsPaids as $allAccountsPaid)
                                            <tr>
                                                <td ><p style="width: 110px;">{{ $allAccountsPaid['transaction_date']}}</p></td>
                                                <td>{{ $allAccountsPaid['invoice_number'] }}</td>
                                                <td>{{ $allAccountsPaid['whole_lechon']}}</td>
                                                <td><p style="width: 300px;">{{ $allAccountsPaid['description']}}</p></td>
                                                <td class="bg-success" style="color:white;"><?php echo number_format($allAccountsPaid['amount'], 2)?></td>
                                                <td><?php echo number_format($allAccountsPaid['paid_amount'], 2) ?></td>
                                                <td class="bg-success" style="color:white;">{{ $allAccountsPaid['status'] }}</td>
                                                <td>{{ $allAccountsPaid['collection_date']}}</td>
                                                <td>{{ $allAccountsPaid['check_number']}}</td>
                                                <td>{{ $allAccountsPaid['check_amount']}}</td>
                                                <td>{{ $allAccountsPaid['or_number']}}</td>
                                                <td><p style="width:110px;">{{ $allAccountsPaid['payment_method']}}</p></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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