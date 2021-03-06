@extends('layouts.dno-personal-app')
@section('title', 'Transactions|')
@section('content')
<div id="wrapper">
    @include('sidebar.sidebar-dno-personal')
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
			<ol class="breadcrumb">
	              <li class="breadcrumb-item">
	                <a href="#">DNO Personal</a>
	              </li>
                  <li class="breadcrumb-item active">Credit Card</li>
                  <li class="breadcrumb-item active">Transactions</li>
                  @if (\Request::is('dno-personal/credit-card/ald-accounts/transactions/'.$creditCardDetail['id'])) 
                     <li class="breadcrumb-item active">ALD Accounts</li>
                  @elseif(\Request::is('dno-personal/credit-card/mod-accounts/transactions/'.$creditCardDetail['id']))
                  <li class="breadcrumb-item active">MOD Accounts</li>
                  @endif
                 
			</ol>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                         <div class="card-header">
							<i class="fa fa-file-invoice" aria-hidden="true"></i>
							Transaction List
                         
						</div>
                        <div class="card-body">
                            <table class="table table-bordered"  width="100%" cellspacing="0">
                                <thead>
                                    <th class="bg-info" style="color:#fff;" width="15%">ACCOUNT NO</th>
                                    <th class="bg-success" style="color:#fff;" >{{ $creditCardDetail['account_no']}}</th>
                                </thead>
                            </table>
                            
                            @if (\Request::is('dno-personal/credit-card/ald-accounts/transactions/'.$creditCardDetail['id'])) 
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                           
                                            <th>Invoice #</th>
                                            <th>Voucher Ref #</th>
                                            <th>Paid To</th>
                                            <th>Bank Name</th>
                                            <th>Account Name</th>
                                            <th >Issued Date</th>
                                            <th >Delivered Date</th>
                                            <th class="bg-danger" style="color:white;">Amount Due</th>
                                            <th >Status</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            
                                            <th>Invoice #</th>
                                            <th>Voucher Ref #</th>
                                            <th>Paid To</th>
                                            <th>Bank Name</th>
                                          
                                            <th>Account Name</th>
                                            <th >Issued Date</th>
                                            <th >Delivered Date</th>
                                            <th class="bg-danger" style="color:white;">Amount Due</th>
                                            
                                            <th >Status</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($getTransactions as $getTransaction)
                                        <?php $id = $getTransaction['id']; ?>
                                        <?php
												$amount1 = DB::table('dno_personal_payment_vouchers')
															->select('*')
															->where('id', $id)
															->sum('amount');
												
												$amount2 = DB::table('dno_personal_payment_vouchers')
															->select('*')
															->where('pv_id', $id)
															->sum('amount');
												$compute = $amount1 + $amount2;
											?>
                                        <tr>
                                            
                                            
                                           
                                            <td> 
                                                <a href="{{ url('dno-personal/credit-card/ald-accounts/view/'
                                                .$getTransaction['id'])}}">{{ $getTransaction['invoice_number']}}</a>
                                                
                                            </td>
                                         
                                            <td>{{ $getTransaction['voucher_ref_number']}}</td>
                                            <td>{{ $getTransaction['paid_to']}}</td>
                                            <td>
                                                <?php
                                                    $exp = explode('-', $getTransaction['bank_card']);
                                                    echo $exp[1];
                                                ?>
                                            </td>
                                            <td>{{ $getTransaction['account_name']}}</td>
                                            <td>{{ $getTransaction['issued_date']}}</td>
                                            <td>{{ $getTransaction['delivered_date']}}</td>
                                            <?php if($getTransaction['status'] == "FOR APPROVAL"): ?>
                                            <td class="bg-danger" style="color:white;"> <?php echo number_format($compute, 2);?></td>
                                            <?php elseif($getTransaction['status'] == "FOR CONFIRMATION"): ?>
                                            <td class="bg-danger" style="color:white;"> <?php echo number_format($compute, 2);?></td>
                                            <?php elseif($getTransaction['status'] == ""): ?>
                                            <td class="bg-danger" style="color:white;"> <?php echo number_format($compute, 2);?></td>
                                            <?php else: ?>
                                            <td class="bg-success" style="color:white;"> <?php echo number_format($compute, 2);?></td>
                                          
                                            <?php endif; ?>
                                           <?php if($getTransaction['status'] == "FOR APPROVAL"): ?>
                                            <td class="bg-danger" style="color:white;">UNPAID</td>
                                           <?php elseif($getTransaction['status'] == "FOR CONFIRMATION"): ?>
                                            <td class="bg-danger" style="color:white;">UNPAID</td>
                                           <?php elseif($getTransaction['status'] == ""): ?>
                                            <td class="bg-danger" style="color:white;">UNPAID</td>
                                           <?php else: ?>
                                            <td class="bg-success " style="color:white;">PAID</td>
                                           <?php endif; ?>
                                           
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="20%" class="bg-info" style="color:white;">TOTAL BALANCE DUE</th>
                                        <th class="bg-danger" style="color:white;"><?php echo number_format($totalAmountDue, 2);?></th>
                                    </tr>

                                </thead>
                            </table>	

                        </div>
                        @else
                        <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                           
                                            <th>Invoice #</th>
                                            <th>Bank Name</th>
                                            <th>Account Name</th>
                                            <th >Issued Date</th>
                                            <th >Delivered Date</th>
                                            <th class="bg-danger" style="color:white;">Amount Due</th>
                                            <th >Status</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            
                                            <th>Invoice #</th>
                                           
                                            <th>Bank Name</th>
                                          
                                            <th>Account Name</th>
                                            <th >Issued Date</th>
                                            <th >Delivered Date</th>
                                            <th class="bg-danger" style="color:white;">Amount Due</th>
                                            
                                            <th >Status</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($getTransactions as $getTransaction)
                                        <?php $id = $getTransaction['id']; ?>
                                        <?php
												$amount1 = DB::table('dno_personal_payment_vouchers')
															->select('*')
															->where('id', $id)
															->sum('amount');
												
												$amount2 = DB::table('dno_personal_payment_vouchers')
															->select('*')
															->where('pv_id', $id)
															->sum('amount');
												$compute = $amount1 + $amount2;
											?>
                                        <tr>
                                            
                                            <td> <a href="{{ url('dno-personal/credit-card/mod-accounts/view/'
                                                .$getTransaction['id'])}}">{{ $getTransaction['invoice_number']}}</a></td>
                                               
                                            </td>
                                            <td>{{ $getTransaction['voucher_ref_number']}}</td>
                                            <td>{{ $getTransaction['paid_to']}}</td>
                                            <td>{{ $getTransaction['account_name']}}</td>
                                            <td>{{ $getTransaction['issued_date']}}</td>
                                            <td>{{ $getTransaction['delivered_date']}}</td>
                                            <?php if($getTransaction['status'] == "FOR APPROVAL"): ?>
                                            <td class="bg-danger" style="color:white;"> <?php echo number_format($compute, 2);?></td>
                                            <?php elseif($getTransaction['status'] == "FOR CONFIRMATION"): ?>
                                            <td class="bg-danger" style="color:white;"> <?php echo number_format($compute, 2);?></td>
                                            <?php elseif($getTransaction['status'] == ""): ?>
                                            <td class="bg-danger" style="color:white;"> <?php echo number_format($compute, 2);?></td>
                                            <?php else: ?>
                                            <td class="bg-success" style="color:white;"> <?php echo number_format($compute, 2);?></td>
                                          
                                            <?php endif; ?>
                                            <?php if($getTransaction['status'] == "FOR APPROVAL"): ?>
                                            <td class="bg-danger" style="color:white;">UNPAID</td>
                                           <?php elseif($getTransaction['status'] == "FOR CONFIRMATION"): ?>
                                            <td class="bg-danger" style="color:white;">UNPAID</td>
                                           <?php elseif($getTransaction['status'] == ""): ?>
                                            <td class="bg-danger" style="color:white;">UNPAID</td>
                                           <?php else: ?>
                                            <td class="bg-success " style="color:white;">PAID</td>
                                           <?php endif; ?>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="20%" class="bg-info" style="color:white;">TOTAL BALANCE DUE</th>
                                        <th class="bg-danger" style="color:white;"><?php echo number_format($totalAmountDue, 2);?></th>
                                    </tr>

                                </thead>
                            </table>	

                        </div>

                        @endif
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
@endsection
