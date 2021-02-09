@extends('layouts.wimpys-food-express-app')
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
  	 @include('sidebar.sidebar-wimpys-food-express')
  	<div id="content-wrapper">
  		<div class="container-fluid">
  			<!-- Breadcrumbs-->
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">Wimpy's Food Express</a>
                </li>
                <li class="breadcrumb-item active">Update Statement Of Account Form</li>
              </ol>
              <a href="{{ url('wimpys-food-express/statement-of-account/lists') }}">Back to Lists</a>
              <div class="col-lg-12">
              <img src="{{ asset('images/digitized-logos/wimpys-logo1.jpg')}}" width="350" height="178" class="img-responsive mx-auto d-block" alt="Wimpy's Food Express">
            	
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
                                  
                                     <div class="col-lg-2">
                                        <label>SOA No</label>
                                        @foreach($getStatementOfAccount[0]->statement_of_accounts as $statement)
                                            @if($statement->module_name === "Statement Of Account")
                                            <input type="text" name="date" class="form-control" value="{{ $statement->dno_holdings_code }}" disabled="disabled" />
                                    
                                            @endif
                                        @endforeach
                                       </div>
                                       <div class="col-lg-2">
                                            <label>Period Covered</label>
                                            <input type="text" name="periodCover" class="form-control" value="{{ $getStatementOfAccount[0]->period_cover}}" disabled="disabled" />
                                        </div>
                                         
                                        <div class="col-lg-2">
                                            <label>Terms</label>
                                            <input type="text" name="terms" class="form-control" value="{{ $getStatementOfAccount[0]->terms}}" disabled="disabled" />
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
                                  @if($getStatementOfAccount[0]->order == $orFormCBF)
                                  <table class="table table-bordered display" width="100%" cellspacing="0">
                                          <thead>
                                              <tr>
                                                  <th>Action</th>
                                                  <th>Date Of Event</th>
                                                  <th>No Of People</th>
                                                  <th>Motiff</th>
                                                  <th>Type Of Package</th>
                                                  <th>Client</th>
                                                  <th>Place Of Event</th>
                                                  <th>Status</th>
                                                  <th>Amount</th>
                                                  <th>Paid Amount</th>
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
                                                  <th>Date Of Event</th>
                                                  <th>No Of People</th>
                                                  <th>Motiff</th>
                                                  <th>Type Of Package</th>
                                                  <th>Client</th>
                                                  <th>Place Of Event</th>
                                                 
                                                  <th>Status</th>
                                                  <th>Amount</th>
                                                  <th>Paid Amount</th>
                                                  <th>Collection Date</th>
                                                  <th>Check Number</th>
                                                  <th>Check Amount</th>
                                                  <th>OR Number</th>
                                                  <th>Payment Method</th>
                                                  <th>Created By</th>
                                              </tr>
                                          </tfoot>
                                          <tbody>
                                             @if($getStatementOfAccount[0]->status != $paid)
                                             <tr>
                                                  <td>
                                                    <!-- Button trigger modal -->
                                                
                                                    <a data-toggle="modal" data-target="#listPop{{ $getStatementOfAccount[0]->id }}" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>  
                                                  </td>
                                                  <td ><p style="width: 110px;">{{ $getStatementOfAccount[0]->date_of_event }}</p></td>
                                                  <td><p style="width: 300px;">{{ $getStatementOfAccount[0]->no_of_people}}</p></td>
                                                  <td><p style="width: 300px;">{{ $getStatementOfAccount[0]->motiff}}</p></td>
                                                  <td><p style="width: 300px;">{{ $getStatementOfAccount[0]->type_of_package}}</p></td>
                                                  <td><p style="width: 300px;">{{ $getStatementOfAccount[0]->client}}</p></td>
                                                  <td><p style="width: 300px;">{{ $getStatementOfAccount[0]->place_of_event}}</p></td>
                                                  <td>{{ $getStatementOfAccount[0]->status }}</td>
                                                  <td class="bg-danger" style="color:white;"><?= number_format($getStatementOfAccount[0]->amount, 2)?></td>
                                                  <td><?= number_format($getStatementOfAccount[0]->paid_amount, 2) ?></td>
                                                 
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
                                                  <td ><p style="width: 110px;">{{ $allAccount['date_of_event']}}</p></td>
                                                 
                                                  <td><p style="width: 300px;">{{ $allAccount['no_of_people']}}</p></td>
                                                  <td><p style="width: 300px;">{{ $allAccount['motiff']}}</p></td>
                                                  <td><p style="width: 300px;">{{ $allAccount['type_of_package']}}</p></td>
                                                  <td><p style="width: 300px;">{{ $allAccount['client']}}</p></td>
                                                  <td><p style="width: 300px;">{{ $allAccount['place_of_event']}}</p></td>
                                                  <td>{{ $allAccount['status'] }} </td>
                                                  <td class="bg-danger" style="color:white;"><?= number_format($allAccount['amount'], 2)?></td>
                                                  <td><?= number_format($allAccount['paid_amount'], 2) ?></td>
                                                  
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
                                  @elseif($getStatementOfAccount[0]->order == $orFormDR)
                                  
                                      <table class="table table-bordered display" width="100%" cellspacing="0">
                                          <thead>
                                              <tr>
                                                  <th>Action</th>
                                                  <th>Date</th>
                                                  <th>Description</th>
                                                  <th  class="bg-danger" style="color:white;">Amount</th>
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
                                                  <th  class="bg-danger" style="color:white;">Amount</th>
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
                                             @if($getStatementOfAccount[0]->status != $paid)
                                             <tr>
                                                  <td>
                                                    <!-- Button trigger modal -->
                                                
                                                    <a data-toggle="modal" data-target="#listPop{{ $getStatementOfAccount[0]->id }}" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>  
                                                  </td>
                                                  <td ><p style="width: 110px;">{{ $getStatementOfAccount[0]->date }}</p></td>
                                                  <td><p style="width: 300px;">{{ $getStatementOfAccount[0]->description}}</p></td>
                                                  <td class="bg-danger" style="color:white;"><?= number_format($getStatementOfAccount[0]->amount, 2)?></td>
                                                  <td><?= number_format($getStatementOfAccount[0]->paid_amount, 2) ?></td>
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
                                                  <td ><p style="width: 110px;">{{ $allAccount['date_of_transaction']}}</p></td>
                                                 
                                                  <td><p style="width: 300px;">{{ $allAccount['description']}}</p></td>
                                                  <td class="bg-danger" style="color:white;"><?= number_format($allAccount['amount'], 2)?></td>
                                                  <td><?= number_format($allAccount['paid_amount'], 2) ?></td>
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
                                  @endif
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
                                      @if($getStatementOfAccount[0]->order == $orFormCBF)
                                      <table class="table table-bordered display"  width="100%" cellspacing="0">
                                          <thead>
                                              <tr>
                                                 
                                                 
                                                  <th>Date Of Event</th>
                                                  <th>No Of People</th>
                                                  <th>Motiff</th>
                                                  <th>Type Of Package</th>
                                                  <th>Client</th>
                                                  <th>Place Of Event</th>
                                                  <th  class="bg-success" style="color:white;">Status</th>
                                                  <th  class="bg-success" style="color:white;">Amount</th>
                                                  <th  class="bg-success" style="color:white;">Paid Amount</th>
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
                                                 
                                                  <th>Date Of Event</th>
                                                  <th>No Of People</th>
                                                  <th>Motiff</th>
                                                  <th>Type Of Package</th>
                                                  <th>Client</th>
                                                  <th>Place Of Event</th>
                                                  <th  class="bg-success" style="color:white;">Status</th>
                                                  <th  class="bg-success" style="color:white;">Amount</th>
                                                  <th  class="bg-success" style="color:white;">Paid Amount</th>
                                                  <th>Collection Date</th>
                                                  <th>Check Number</th>
                                                  <th>Check Amount</th>
                                                  <th>OR Number</th>
                                                  <th>Payment Method</th>
                                                  <th>Created By</th>
                                              </tr>
                                          </tfoot>
                                          <tbody>
                                               @if($getStatementOfAccount[0]->status == $paid)
                                             <tr>
                                                 
                                                  <td ><p style="width: 110px;">{{ $getStatementOfAccount[0]->date_of_event }}</p></td>
                                                  <td><p style="width: 300px;">{{ $getStatementOfAccount[0]->no_of_people}}</p></td>
                                                  <td><p style="width: 300px;">{{ $getStatementOfAccount[0]->motiff}}</p></td>
                                                  <td><p style="width: 300px;">{{ $getStatementOfAccount[0]->type_of_package}}</p></td>
                                                  <td><p style="width: 300px;">{{ $getStatementOfAccount[0]->client}}</p></td>
                                                  <td><p style="width: 300px;">{{ $getStatementOfAccount[0]->place_of_event}}</p></td>
                                                  <td class="bg-success" style="color:white;">{{ $getStatementOfAccount[0]->status }}</td>
                                                  <td class="bg-success" style="color:white;"><?= number_format($getStatementOfAccount[0]->amount, 2)?></td>
                                                  <td class="bg-success" style="color:white;"><?= number_format($getStatementOfAccount[0]->paid_amount, 2) ?></td>
                                                  
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

                                                  <td ><p style="width: 110px;">{{ $allAccountsPaid['date_of_event']}}</p></td>
                                                  <td><p style="width: 300px;">{{ $getStatementOfAccount[0]->no_of_people}}</p></td>
                                                  <td><p style="width: 300px;">{{ $getStatementOfAccount[0]->motiff}}</p></td>
                                                  <td><p style="width: 300px;">{{ $getStatementOfAccount[0]->type_of_package}}</p></td>
                                                  <td><p style="width: 300px;">{{ $getStatementOfAccount[0]->client}}</p></td>
                                                  <td><p style="width: 300px;">{{ $getStatementOfAccount[0]->place_of_event}}</p></td>
                                                  <td class="bg-success" style="color:white;">{{ $allAccountsPaid['status'] }}</td>
                                                  <td class="bg-success" style="color:white;"><?= number_format($allAccountsPaid['amount'], 2)?></td>
                                                  <td class="bg-success" style="color:white;"><?= number_format($allAccountsPaid['paid_amount'], 2) ?></td>
                                                 
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
                                      @elseif($getStatementOfAccount[0]->order == $orFormDR)
                                      <table class="table table-bordered display" width="100%" cellspacing="0">
                                          <thead>
                                              <tr>
                                                  <th>Action</th>
                                                  <th>Date</th>
                                                  <th>Description</th>
                                                  <th  class="bg-success" style="color:white;">Amount</th>
                                                  <th>Paid Amount</th>
                                                  <th  class="bg-success" style="color:white;">Status</th>
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
                                                  <th  class="bg-success" style="color:white;">Amount</th>
                                                  <th>Paid Amount</th>
                                                  <th  class="bg-success" style="color:white;">Status</th>
                                                  <th>Collection Date</th>
                                                  <th>Check Number</th>
                                                  <th>Check Amount</th>
                                                  <th>OR Number</th>
                                                  <th>Payment Method</th>
                                                  <th>Created By</th>
                                              </tr>
                                          </tfoot>
                                          <tbody>
                                             @if($getStatementOfAccount[0]->status == $paid)
                                             <tr>
                                                  <td>
                                                    <!-- Button trigger modal -->
                                                
                                                    <a data-toggle="modal" data-target="#listPop{{ $getStatementOfAccount[0]->id }}" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>  
                                                  </td>
                                                  <td ><p style="width: 110px;">{{ $getStatementOfAccount[0]->date }}</p></td>
                                                  <td><p style="width: 300px;">{{ $getStatementOfAccount[0]->description}}</p></td>
                                                  <td class="bg-success" style="color:white;"><?= number_format($getStatementOfAccount[0]->amount, 2)?></td>
                                                  <td><?= number_format($getStatementOfAccount[0]->paid_amount, 2) ?></td>
                                                  <td  class="bg-success" style="color:white;">{{ $getStatementOfAccount[0]->status }}</td>
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
                                                  <td>
                                                     <!-- Button trigger modal -->
                                                     <a data-toggle="modal" data-target="#listPopUp{{ $allAccountsPaid['id']}}" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>  
                                                 
                                                  </td>
                                                  <td ><p style="width: 110px;">{{ $allAccountsPaid['date_of_transaction']}}</p></td>
                                                 
                                                  <td><p style="width: 300px;">{{ $allAccountsPaid['description']}}</p></td>
                                                  <td class="bg-success" style="color:white;"><?= number_format($allAccountsPaid['amount'], 2)?></td>
                                                  <td><?= number_format($allAccountsPaid['paid_amount'], 2) ?></td>
                                                  <td  class="bg-success" style="color:white;">{{ $allAccountsPaid['status'] }}</td>
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
                                      @endif
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
                <div id="succUp<?= $allAccount['id'] ?>" class="col-lg-12"></div>

                @if($allAccount['order'] == $orFormCBF)
                 <div class="form-group">
                    <div class="form-row">
                        <div class="col-lg-2">
                            <label>Date Of Event</label>
                            <input type="text" name="dateOfEvent" class="form-control" value="{{ $allAccount['date_of_event'] }}" disabled />
                        </div>
                      
                      
                        <div class="col-lg-4">
                            <label>No Of People</label>
                            <input type="text" name="noOfPeople" class="form-control" value="{{ $allAccount['no_of_people']}}" disabled/>
                        </div>
                        <div class="col-lg-6">
                            <label>Motiff</label>
                            <input type="text" name="motiff" class="form-control" value="{{ $allAccount['motiff']}}" disabled/>
                        </div>
                        <div class="col-lg-6">
                            <label>Type Of Package</label>
                            <input type="text" name="typeOfPackage" class="form-control" value="{{ $allAccount['type_of_package'] }}" disabled />
                        </div>
                        <div class="col-lg-6">
                            <label>Client</label>
                            <input type="text" name="client" class="form-control" value="{{ $allAccount['client'] }}" disabled />
                        </div>
                        <div class="col-lg-8">
                            <label>Place Of Event</label>
                            <input type="text" name="placeOfEvent" class="form-control" value="{{ $allAccount['place_of_event'] }}" disabled />
                        </div>
                       
                     
                        <div class="col-lg-2">
                            <label>Amount</label>
                            <input type="text" name="amount" class="form-control" value="<?= number_format($allAccount['amount'], 2)?>" disabled />
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
                @elseif($allAccount['order'] == $orFormDR)
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-lg-2">
                            <label>Date</label>
                            <input type="text" name="date" class="form-control" value="{{ $allAccount['date_of_transaction'] }}" disabled />
                        </div>
                      
                      
                        <div class="col-lg-6">
                            <label>Description</label>
                            <input type="text" name="description" class="form-control" value="{{ $allAccount['description']}}" disabled/>
                        </div>
                      
                       
                     
                        <div class="col-lg-2">
                            <label>Amount</label>
                            <input type="text" name="amount" class="form-control" value="<?= number_format($allAccount['amount'], 2)?>" disabled />
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
                @endif
            </div>
            <div class="modal-footer">
                 <input type="hidden" class="mainId{{ $allAccount['id']}}" value="{{ $getStatementOfAccount[0]->id }}" />
                <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
                <button type="button" onclick="updatePaid(<?= $allAccount['id']?>)" class="btn btn-success btn-lg">Paid</button>
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
                 <div id="succUp<?= $getStatementOfAccount[0]->id?>" class="col-lg-12"></div>

                @if($getStatementOfAccount[0]->order === $orFormCBF)
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-lg-2">
                            <label>Date Of Event</label>
                            <input type="text" name="dateOfEvent" class="form-control" value="{{ $getStatementOfAccount[0]->date_of_event }}" disabled />
                        </div>
                      
                        <div class="col-lg-4">
                            <label>No Of People (Pax)</label>
                            <input type="text" name="noOfPeople" class="form-control" value="{{ $getStatementOfAccount[0]->no_of_people}}" disabled/>
                        </div>
                     
                        <div class="col-lg-4">
                            <label>Motiff</label>
                            <input type="text" name="motiff" class="form-control" value="{{ $getStatementOfAccount[0]->motiff }}" disabled />
                        </div>
                        <div class="col-lg-6">
                            <label>Type Of Package</label>
                            <input type="text" name="typeOfPackage" class="form-control" value="{{ $getStatementOfAccount[0]->type_of_package }}" disabled />
                        </div>
                        <div class="col-lg-6">
                            <label>Client</label>
                            <input type="text" name="client" class="form-control" value="{{ $getStatementOfAccount[0]->client }}" disabled />
                        </div>
                        <div class="col-lg-8">
                            <label>Place Of Event</label>
                            <input type="text" name="placeOfEvent" class="form-control" value="{{ $getStatementOfAccount[0]->place_of_event }}" disabled />
                        </div>
                        <div class="col-lg-2">
                            <label>Amount</label>
                            <input type="text" name="amount" class="form-control" value="<?= number_format($getStatementOfAccount[0]->amount, 2)?>" disabled />
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
                @elseif($getStatementOfAccount[0]->order === $orFormDR)
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-lg-2">
                            <label>Date</label>
                            <input type="text" name="date" class="form-control" value="{{ $getStatementOfAccount[0]->date }}" disabled />
                        </div>
                      
                        <div class="col-lg-6">
                            <label>Description</label>
                            <input type="text" name="description" class="form-control" value="{{ $getStatementOfAccount[0]->description}}" disabled/>
                        </div>
                     
                        <div class="col-lg-2">
                            <label>Amount</label>
                            <input type="text" name="amount" class="form-control" value="<?= number_format($getStatementOfAccount[0]->amount, 2)?>" disabled />
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

                @endif
            </div>
            <div class="modal-footer">
                <input type="hidden"  class="mainId{{ $getStatementOfAccount[0]->id}}" value="{{ $getStatementOfAccount[0]->id }}" />
                <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
                <button type="button" onclick="updatePaid(<?= $getStatementOfAccount[0]->id ?>)" class="btn btn-success btn-lg">Paid</button>
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
                type: "PUT",
                url: '/wimpys-food-express/s-account/' + id,
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