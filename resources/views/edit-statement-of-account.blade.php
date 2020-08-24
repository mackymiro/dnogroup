  @extends('layouts.lolo-pinoy-lechon-de-cebu-app')
  @section('title', 'Edit Statment Of Account|')
  @section('content')
  <script>
    $(document).ready(function(){
        $('.alert-success').fadeIn().delay(3000).fadeOut();
        $('table.display').DataTable( {} );
    });

    $(function() {
        $( ".datepicker" ).datepicker();
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
                <li class="breadcrumb-item active">Update Statement Of Account Form</li>
              </ol>
              <a href="{{ url('lolo-pinoy-lechon-de-cebu/statement-of-account/lists') }}">Back to Lists</a>
              <div class="col-lg-12">
              	 <img src="{{ asset('images/digitized-logos/lolo-pinoy-lechon-de-cebu.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
              	 
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
                                              <label><strong style="font-size: 20px;">Total Balance</strong></label>
                                              <p class="bg-success" style="color:white; border-radius: 3px; padding:5px;">₱ <?php echo number_format($sum, 2);?></p>
                                             
                                          </div>       
                                    </div>
                                 </div>
                                 
                                <div class="form-group">
                                  <div class="form-row">
                                    <div class="col-lg-4">
                                        <label>Bill To</label>
                                        <input type="text" name="billTo" class="form-control" value="{{ $getStatementOfAccount[0]->bill_to }}" disabled="disabled" /> 
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Date</label>
                                        <input type="text" name="date" class="form-control" value="{{ $getStatementOfAccount[0]->date }}" disabled="disabled" />
                                    </div>
                                     <div class="col-lg-4">
                                        <label>Address</label>
                                        <input type="text" name="address" class="form-control" value="{{ $getStatementOfAccount[0]->address}}" disabled="disabled" /> 
                                    </div>
                                     <div class="col-lg-2">
                                        <label>SOA No</label>
                                        <input type="text" name="date" class="form-control" value="{{ $getStatementOfAccount[0]->lechon_de_cebu_code }}" disabled="disabled" />
                                    </div>
                                  </div>
                                  
                                </div>
                                <div class="form-group">  
                                    <div class="form-row">
                                         <div class="col-lg-2">
                                            <label>Period Covered</label>
                                            <input type="text" name="periodCover" class="form-control" value="{{ $getStatementOfAccount[0]->period_cover}}" disabled="disabled" />
                                        </div>
                                       
                                        <div class="col-lg-2">
                                            <label>Terms</label>
                                            <input type="text" name="terms" class="form-control" value="{{ $getStatementOfAccount[0]->terms}}" disabled="disabled" />
                                        </div>
                                         <div class="col-lg-2">
                                             <label>Branch</label>
                                             <input type="text" name="branch" class="form-control" value="{{ $getStatementOfAccount[0]->branch}}" disabled="disabled" />
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
                                    <i class="fas fa-tasks" aria-hidden="true"></i>
                                  Lists (Unpaid)</div>
                              <div class="card-body">
                                  <div class="table-responsive">
                                      <table class="table table-bordered display" width="100%" cellspacing="0">
                                          <thead>
                                              <tr>
                                                  <th>Action</th>
                                                  <th>Date</th>
                                                  <th>Description</th>
                                                  <th>Amount</th>
                                                  <th>Paid Amount</th>
                                                  <th>Status</th>
                                                  <th>Collection Date</th>
                                                  <th>Check Number</th>
                                                  <th>Check Amount</th>
                                                  <th>OR Number</th>
                                                  <th>Payment Method</th>
                                                  <th>Created By</th>
                                              </tr>
                                          </thead>
                                           <tfoot>
                                              <tr>
                                                  <th>Action</th>
                                                  <th>Date</th>
                                                  <th>Description</th>
                                                  <th>Amount</th>
                                                  <th>Paid Amount</th>
                                                  <th>Status</th>
                                                  <th>Collection Date</th>
                                                  <th>Check Number</th>
                                                  <th>Check Amount</th>
                                                  <th>OR Number</th>
                                                  <th>Payment Method</th>
                                                  <th>Created By</th>
                                              </tr>
                                          </tfoot>
                                          <tbody>
                                             @if($getStatementOfAccount[0]->status != "PAID")
                                             <tr>
                                                  <td>
                                                    <!-- Button trigger modal -->
                                                
                                                    <a data-toggle="modal" data-target="#listPop{{ $getStatementOfAccount[0]->id }}" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>  
                                                  </td>
                                                  <td ><p style="width: 110px;">{{ $getStatementOfAccount[0]->date }}</p></td>
                                                  <td><p style="width: 300px;">{{ $getStatementOfAccount[0]->description}}</p></td>
                                                  <td class="bg-danger" style="color:white;"><?php echo number_format($getStatementOfAccount[0]->amount, 2)?></td>
                                                  <td><?php echo number_format($getStatementOfAccount[0]->paid_amount, 2) ?></td>
                                                  <td>{{ $getStatementOfAccount[0]->status }}</td>
                                                  <td>{{ $getStatementOfAccount[0]->collection_date}}</td>
                                                  <td>{{ $getStatementOfAccount[0]->check_number}}</td>
                                                  <td>{{ $getStatementOfAccount[0]->check_amount}}</td>
                                                  <td>{{ $getStatementOfAccount[0]->or_number}}</td>
                                                  <td><p style="width:110px;">{{ $getStatementOfAccount[0]->payment_method}}</p></td>
                                                  <td>{{ $getStatementOfAccount[0]->created_by }}</td>
                                              </tr>
                                              @endif
                                              @foreach($allAccounts as $allAccount)
                                              <tr>
                                                  <td>
                                                     <!-- Button trigger modal -->
                                                     <a data-toggle="modal" data-target="#listPopUp{{ $allAccount['id']}}" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>  
                                                 
                                                  </td>
                                                  <td ><p style="width: 110px;">{{ $allAccount['transaction_date']}}</p></td>
                                                 
                                                  <td><p style="width: 300px;">{{ $allAccount['description']}}</p></td>
                                                  <td class="bg-danger" style="color:white;"><?php echo number_format($allAccount['amount'], 2)?></td>
                                                  <td><?php echo number_format($allAccount['paid_amount'], 2) ?></td>
                                                  <td>{{ $allAccount['status'] }}</td>
                                                  <td>{{ $allAccount['collection_date']}}</td>
                                                  <td>{{ $allAccount['check_number']}}</td>
                                                  <td>{{ $allAccount['check_amount']}}</td>
                                                  <td>{{ $allAccount['or_number']}}</td>
                                                  <td><p style="width:110px;">{{ $allAccount['payment_method']}}</p></td>
                                                  <td>{{ $allAccount['created_by']}}</td>
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
                                      <table class="table table-bordered display"  width="100%" cellspacing="0">
                                          <thead>
                                              <tr>
                                                
                                                  <th>Date</th>
                                                  <th>Description</th>
                                                  <th>Amount</th>
                                                  <th>Paid Amount</th>
                                                  <th>Status</th>
                                                  <th>Collection Date</th>
                                                  <th>Check Number</th>
                                                  <th>Check Amount</th>
                                                  <th>OR Number</th>
                                                  <th>Payment Method</th>
                                                  <th>Created By</th>
                                              </tr>
                                          </thead>
                                           <tfoot>
                                              <tr>
                                                  <th>Date</th>
                                                  <th>Description</th>
                                                  <th>Amount</th>
                                                  <th>Paid Amount</th>
                                                  <th>Status</th>
                                                  <th>Collection Date</th>
                                                  <th>Check Number</th>
                                                  <th>Check Amount</th>
                                                  <th>OR Number</th>
                                                  <th>Payment Method</th>
                                                  <th>Created By</th>
                                              </tr>
                                          </tfoot>
                                          <tbody>
                                               @if($getStatementOfAccount[0]->status == "PAID")
                                             <tr>
                                                  <td ><p style="width: 110px;">{{ $getStatementOfAccount[0]->date}}</p></td>
                                                  <td><p style="width: 300px;">{{ $getStatementOfAccount[0]->description}}</p></td>
                                                  <td class="bg-success" style="color:white;"><?php echo number_format($getStatementOfAccount[0]->amount, 2)?></td>
                                                  <td><?php echo number_format($getStatementOfAccount[0]->paid_amount, 2) ?></td>
                                                  <td class="bg-success" style="color:white;">{{ $getStatementOfAccount[0]->status }}</td>
                                                  <td>{{ $getStatementOfAccount[0]->collection_date}}</td>
                                                  <td>{{ $getStatementOfAccount[0]->check_number}}</td>
                                                  <td>{{ $getStatementOfAccount[0]->check_amount}}</td>
                                                  <td>{{ $getStatementOfAccount[0]->or_number}}</td>
                                                  <td><p style="width:110px;">{{ $getStatementOfAccount[0]->payment_method}}</p></td>
                                                  <td>{{ $getStatementOfAccount[0]->created_by }}</td>
                                              </tr>
                                              @endif
                                              @foreach($allAccountsPaids as $allAccountsPaid)
                                              <tr>

                                                  <td ><p style="width: 110px;">{{ $allAccountsPaid['transaction_date']}}</p></td>
                                                
                                                  <td><p style="width: 300px;">{{ $allAccountsPaid['description']}}</p></td>
                                                  <td class="bg-success" style="color:white;"><?php echo number_format($allAccountsPaid['amount'], 2)?></td>
                                                  <td><?php echo number_format($allAccountsPaid['paid_amount'], 2) ?></td>
                                                  <td class="bg-success" style="color:white;">{{ $allAccountsPaid['status'] }}</td>
                                                  <td>{{ $allAccountsPaid['collection_date']}}</td>
                                                  <td>{{ $allAccountsPaid['check_number']}}</td>
                                                  <td>{{ $allAccountsPaid['check_amount']}}</td>
                                                  <td>{{ $allAccountsPaid['or_number']}}</td>
                                                  <td><p style="width:110px;">{{ $allAccountsPaid['payment_method']}}</p></td>
                                                  <td>{{ $allAccountsPaid['created_by']}}</td>
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
     <!-- Modal -->
     @foreach($allAccounts as $allAccount)
     <div class="modal fade" id="listPopUp{{ $allAccount['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Lists (Unpaid)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 <div  class="validate col-lg-12">
                    <p class="alert alert-danger">Please Fill up the fields</p>
                </div>
                <div id="succUp<?php echo $allAccount['id'] ?>" class="col-lg-12"></div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-lg-2">
                            <label>Date</label>
                            <input type="text" name="date" class="form-control" value="{{ $allAccount['transaction_date'] }}" disabled />
                        </div>
                        @if($allAccount['order'] != "Private Order")
                        <div class="col-lg-4">
                            <label>Invoice</label>
                            <input type="text" name="invoice" class="form-control" value="{{ $allAccount['invoice_number']}}" disabled />
                        </div>
                        @endif
                        @if($allAccount['order'] === "Private Order")
                        <div class="col-lg-2">
                            <label>Dr No</label>
                            <input type="text" name="drNo" class="form-control" value="{{ $allAccount['dr_no'] }}" disabled />
                        </div>
                        @endif
                        <div class="col-lg-6">
                            <label>Description</label>
                            <input type="text" name="description" class="form-control" value="{{ $allAccount['description']}}" disabled/>
                        </div>
                        @if($allAccount['order'] === "Private Order")
                        <div class="col-lg-2">
                            <label>Whole Lechon</label>
                            <input type="text" name="wholeLechon" class="form-control" value="{{ $allAccount['whole_lechon'] }}" disabled />
                        </div>
                        
                        @endif
                        <div class="col-lg-2">
                            <label>QTY</label>
                            <input type="text" name="qty" class="form-control" value="{{ $allAccount['qty'] }}" disabled />
                        </div>
                       
                        @if($allAccount['order'] === "Ssp")
                        <div class="col-lg-2">
                            <label>Body</label>
                            <input type="text" name="body" class="form-control" value="{{ $allAccount['body'] }}" disabled />
                        </div>
                        <div class="col-lg-4">
                            <label>Head and Feet 200/kls</label>
                            <input type="text" name="body" class="form-control" value="{{ $allAccount['head_and_feet'] }}" disabled />
                        </div>
                        @endif
                        <div class="col-lg-2">
                            <label>Amount</label>
                            <input type="text" name="amount" class="form-control" value="<?php echo number_format($allAccount['amount'], 2)?>" disabled />
                        </div>
                        <div class="col-lg-2">
                            <label>Paid Amount</label>
                            <input type="text" name="paidAmount" class="paidAmount{{ $allAccount['id'] }} form-control"  />
                        </div>
                        <div class="col-lg-2">
                            <label>Status</label>
                           
                            <select name="status" class="status{{ $allAccount['id'] }} form-control"> 
                                <option value="UNPAID">UNPAID</option>
                                <option value="PAID">PAID</option>
                            </select>
                          
                        </div>
                        <div class="col-lg-2">
                            <label>Collection Date</label>
                            <input type="text"  name="collectionDate" class="collectionDate{{ $allAccount['id'] }} datepicker form-control"  />
                        </div>
                        <div class="col-lg-4">
                            <label>Check Number</label>
                            <input type="text"  name="checkNumber" class="checkNumber{{ $allAccount['id'] }} form-control"  />
                        </div>
                        <div class="col-lg-4">
                            <label>Check Amount</label>
                            <input type="text"  name="checkAmount" class="checkAmount{{ $allAccount['id'] }} form-control"  />
                        </div>
                        <div class="col-lg-4">
                            <label>OR Number</label>
                            <input type="text"  name="orNumber" class="orNumber{{ $allAccount['id']}} form-control"  />
                        </div>
                        <div class="col-lg-4">
                            <label>Payment Method</label>
                           
                                <select  name="payment" class="payment{{ $allAccount['id'] }} form-control"> 
                                    <option value="CHECK">CHECK</option>
                                    <option value="CASH">CASH</option>
                                </select>
                          
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                 <input type="hidden" class="mainId{{ $allAccount['id']}}" value="{{ $getStatementOfAccount[0]->id }}" />
                <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
                <button type="button" onclick="updatePaid(<?php echo $allAccount['id']?>)" class="btn btn-success btn-lg">Paid</button>
            </div>
            </div>
        </div>
    </div>
    @endforeach
    <!-- Modal -->
    <div class="modal fade" id="listPop{{ $getStatementOfAccount[0]->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Lists (Unpaid)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">    
                <div  class="validate col-lg-12">
                    <p class="alert alert-danger">Please Fill up the fields</p>
                </div>
                 <div id="succUp<?php echo $getStatementOfAccount[0]->id?>" class="col-lg-12"></div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-lg-2">
                            <label>Date</label>
                            <input type="text" name="date" class="form-control" value="{{ $getStatementOfAccount[0]->date }}" disabled />
                        </div>
                        @if($getStatementOfAccount[0]->order != "Private Order")
                        <div class="col-lg-4">
                            <label>Invoice</label>
                            <input type="text" name="invoice" class="form-control" value="{{ $getStatementOfAccount[0]->invoice_number}}" disabled />
                        </div>
                        @endif
                        @if($getStatementOfAccount[0]->order === "Private Order")
                        <div class="col-lg-2">
                            <label>Dr No</label>
                            <input type="text" name="drNo" class="form-control" value="{{ $getStatementOfAccount[0]->dr_no }}" disabled />
                        </div>
                        @endif
                        <div class="col-lg-6">
                            <label>Description</label>
                            <input type="text" name="description" class="form-control" value="{{ $getStatementOfAccount[0]->description}}" disabled/>
                        </div>
                        @if($getStatementOfAccount[0]->order === "Private Order")
                        <div class="col-lg-2">
                            <label>Whole Lechon</label>
                            <input type="text" name="wholeLechon" class="form-control" value="{{ $getStatementOfAccount[0]->whole_lechon }}" disabled />
                        </div>
                        <div class="col-lg-2">
                            <label>Unit</label>
                            <input type="text" name="unit" class="form-control" value="{{ $getStatementOfAccount[0]->unit }}" disabled />
                        </div>
                        @endif
                        <div class="col-lg-2">
                            <label>Amount</label>
                            <input type="text" name="amount" class="form-control" value="<?php echo number_format($getStatementOfAccount[0]->amount, 2)?>" disabled />
                        </div>
                        <div class="col-lg-2">
                            <label>Paid Amount</label>
                            <input type="text"  name="paidAmount" class="paidAmount{{ $getStatementOfAccount[0]->id}} form-control"  />
                        </div>
                        <div class="col-lg-2">
                            <label>Status</label>
                            <div id="app-status">
                                <select  name="status" class="status{{ $getStatementOfAccount[0]->id }} form-control"> 
                                    <option v-for="status in statuses" v-bind:value="status.value">
                                    @{{ status.text }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <label>Collection Date</label>
                            <input type="text"  name="collectionDate" class="collectionDate{{ $getStatementOfAccount[0]->id }} datepicker form-control"  />
                        </div>
                        <div class="col-lg-4">
                            <label>Check Number</label>
                            <input type="text" name="checkNumber" class="checkNumber{{ $getStatementOfAccount[0]->id }} form-control" />
                        </div>
                        <div class="col-lg-4">
                            <label>Check Amount</label>
                            <input type="text" name="checkAmount" class="checkAmount{{ $getStatementOfAccount[0]->id }} form-control"   />
                        </div>
                        <div class="col-lg-4">
                            <label>OR Number</label>
                            <input type="text"  name="orNumber" class="orNumber{{ $getStatementOfAccount[0]->id }} form-control"  />
                        </div>
                        <div class="col-lg-4">
                            <label>Payment Method</label>
                            <div id="app-payment">
                                <select  name="payment" class="payment{{ $getStatementOfAccount[0]->id }} form-control"> 
                                    <option v-for="payment in payments" v-bind:value="payment.value">
                                    @{{ payment.text }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden"  class="mainId{{ $getStatementOfAccount[0]->id}}" value="{{ $getStatementOfAccount[0]->id }}" />
                <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
                <button type="button" onclick="updatePaid(<?php echo $getStatementOfAccount[0]->id ?>)" class="btn btn-success btn-lg">Paid</button>
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
     $(".validate").hide();
     
     const updatePaid = (id) =>{
        const paidAmount = $(".paidAmount"+id).val();
        const status = $(".status"+id).val();
        const collectionDate = $(".collectionDate"+id).val();
        const checkNumber = $(".checkNumber"+id).val();
        const checkAmount = $(".checkAmount"+id).val();
        const orNumber = $(".orNumber"+id).val();
        const payment = $(".payment"+id).val();
        const mainId = $(".mainId"+id).val();

        if(paidAmount.length === 0 || collectionDate.length === 0){
            $(".validate").fadeIn().delay(3000).fadeOut();
        }else{
              //make ajax call
            $.ajax({
                type: "PATCH",
                url: '/lolo-pinoy-lechon-de-cebu/s-account/' + id,
                data:{
                    _method: 'patch', 
                    "_token": "{{ csrf_token() }}",
                    "id":id,
                    "mainId":mainId,
                    "paidAmount":paidAmount,
                    "status":status,
                    "collectionDate":collectionDate,
                    "checkNumber":checkNumber,
                    "checkAmount":checkAmount,
                    "orNumber":orNumber,
                    "payment":payment,
                },
                success: function(data){
                    console.log(data);
                    const getData = data;
                    const succData = getData.split(":");
                    const succDataArr = succData[0];
                    if(succDataArr == "Success"){
                        $("#succUp"+id).fadeIn().delay(3000).fadeOut();
                        $("#succUp"+id).html(`<p class="alert alert-success"> ${data}</p>`);
                        
                        setTimeout(function(){
                            document.location.reload();
                        }, 3000);
                    }
                
                },
                error: function(data){
                    console.log('Error:', data);
                }

                });
        }
      
     }

      const confirmDelete = (id) =>{
          const x = confirm("Do you want to delete this?");
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
                { text:'UNPAID', value: 'UNPAID' },
  				{ text:'PAID', value: 'PAID'}
  			]
  		}
  	})	
    
  
    //payment method
    new Vue({
  	el: '#app-payment',
  		data: {
  			payments:[
  				{ text:'CHECK', value: 'CHECK' },
  				{ text:'CASH', value: 'CASH'}
  			]
  		}
  	})

    new Vue({
  	el: '#app-payment1',
  		data: {
  			payments1:[
  				{ text:'CHECK', value: 'CHECK' },
  				{ text:'CASH', value: 'CASH'}
  			]
  		}
  	})	

  </script>
  @endsection