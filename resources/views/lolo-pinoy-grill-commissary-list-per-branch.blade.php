@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'List Per Branches |')
@section('content')
<script>
  $(document).ready(function(){
      $('table.display').DataTable( {} );
  });   
</script>
<div id="wrapper">
     @include('sidebar.sidebar-lolo-pinoy-grill')
     <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="#">Lolo Pinoy Grill Commissary</a>
                    </li>
                    <li class="breadcrumb-item active">View List Per Branches</li>
                </ol>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <i class="fas fa-building"></i> 
                                Urgello Branch
                            </div>
                            <div class="card-body">
                                 <div class="table-responsive">
                                    <table class="table table-bordered display" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Branch</th>
                                                <th class="bg-danger" style="color:#fff;">Total Amount Of Sales</th>
                                                <th >Total Discounts (Seniors/PWD's)</th>
                                                <th >Gift Cert</th>
                                            
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>	
                                            <tr>
                                                <th>Date</th>
                                                <th>Branch</th>
                                                <th class="bg-danger" style="color:#fff;">Total Amount Of Sales</th>
                                                <th >Total Discounts (Seniors/PWD's)</th>
                                                <th >Gift Cert</th>
                                            
                                                <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach($getTransactionUrgelloBranches as $getTransactionUrgelloBranch)
                                            <tr>
                                                <td>{{ $getTransactionUrgelloBranch['date']}}</td>
                                                <td>{{ $getTransactionUrgelloBranch['branch']}}</td>
                                                <td class="bg-danger" style="color:#fff;"><?php echo number_format($getTransactionUrgelloBranch['total_amount_of_sales'], 2); ?></td>
                                                <td><?php echo number_format($getTransactionUrgelloBranch['total_discounts_seniors_pwds']); ?></td>
											    <td><?php echo number_format($getTransactionUrgelloBranch['gift_cert'], 2)?></td>
                                                <td>{{ $getTransactionUrgelloBranch['created_by']}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <table class="table table-bordered">
                                    <thead>	
                                        <tr>
                                            <th width="20%" class="bg-info" style="color:white;">TOTAL SALES </th>
                                            <th class="bg-danger" style="color:white; font-size:30px;">₱ <?php echo number_format($sumUrgello, 2)?></th>
                                        </tr>
                                    
                                    </thead>
							    </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <i class="fas fa-building"></i> 
                                Velez Branch
                            </div>
                            <div class="card-body">
                                 <div class="table-responsive">
                                    <table class="table table-bordered display" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Branch</th>
                                                <th class="bg-danger" style="color:#fff;">Total Amount Of Sales</th>
                                                <th >Total Discounts (Seniors/PWD's)</th>
                                                <th >Gift Cert</th>
                                            
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>	
                                            <tr>
                                                <th>Date</th>
                                                <th>Branch</th>
                                                <th class="bg-danger" style="color:#fff;">Total Amount Of Sales</th>
                                                <th >Total Discounts (Seniors/PWD's)</th>
                                                <th >Gift Cert</th>
                                            
                                                <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach($getTransactionVelezBranches as $getTransactionVelezBranch)
                                            <tr>
                                                <td>{{ $getTransactionVelezBranch['date']}}</td>
                                                <td>{{ $getTransactionVelezBranch['branch']}}</td>
                                                <td class="bg-danger" style="color:#fff;"><?php echo number_format($getTransactionVelezBranch['total_amount_of_sales'], 2); ?></td>
                                                <td><?php echo number_format($getTransactionVelezBranch['total_discounts_seniors_pwds']); ?></td>
                                                <td><?php echo number_format($getTransactionVelezBranch['gift_cert'], 2)?></td>
                                                <td>{{ $getTransactionVelezBranch['created_by']}}</td>
										    </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <table class="table table-bordered">
                                    <thead>	
                                        <tr>
                                            <th width="20%" class="bg-info" style="color:white;">TOTAL SALES </th>
                                            <th class="bg-danger" style="color:white; font-size:30px;">₱ <?php echo number_format($sumVelez, 2)?></th>
                                        </tr>
                                    
                                    </thead>
							    </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <i class="fas fa-building"></i> 
                                Banilad Branch
                            </div>
                            <div class="card-body">
                                 <div class="table-responsive">
                                    <table class="table table-bordered display" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Branch</th>
                                                <th class="bg-danger" style="color:#fff;">Total Amount Of Sales</th>
                                                <th >Total Discounts (Seniors/PWD's)</th>
                                                <th >Gift Cert</th>
                                            
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>	
                                            <tr>
                                                <th>Date</th>
                                                <th>Branch</th>
                                                <th class="bg-danger" style="color:#fff;">Total Amount Of Sales</th>
                                                <th >Total Discounts (Seniors/PWD's)</th>
                                                <th >Gift Cert</th>
                                            
                                                <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach($getTransactionBaniladBranches as $getTransactionBaniladBranch)
                                            <tr>
                                                <td>{{ $getTransactionBaniladBranch['date']}}</td>
                                                <td>{{ $getTransactionBaniladBranch['branch']}}</td>
                                                <td class="bg-danger" style="color:#fff;"><?php echo number_format($getTransactionBaniladBranch['total_amount_of_sales'], 2); ?></td>
                                                <td><?php echo number_format($getTransactionBaniladBranch['total_discounts_seniors_pwds']); ?></td>
                                                <td><?php echo number_format($getTransactionBaniladBranch['gift_cert'], 2)?></td>
                                                <td>{{ $getTransactionBaniladBranch['created_by']}}</td>
										    </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <table class="table table-bordered">
                                    <thead>	
                                        <tr>
                                            <th width="20%" class="bg-info" style="color:white;">TOTAL SALES </th>
                                            <th class="bg-danger" style="color:white; font-size:30px;">₱ <?php echo number_format($sumBanilad, 2)?></th>
                                        </tr>
                                    
                                    </thead>
							    </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <i class="fas fa-building"></i> 
                                GQS Branch
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered display" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Branch</th>
                                                <th class="bg-danger" style="color:#fff;">Total Amount Of Sales</th>
                                                <th >Total Discounts (Seniors/PWD's)</th>
                                                <th >Gift Cert</th>
                                            
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>	
                                            <tr>
                                                <th>Date</th>
                                                <th>Branch</th>
                                                <th class="bg-danger" style="color:#fff;">Total Amount Of Sales</th>
                                                <th >Total Discounts (Seniors/PWD's)</th>
                                                <th >Gift Cert</th>
                                            
                                                <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                              @foreach($getTransactionGqsBranches as $getTransactionGqsBranch)
                                            <tr>
                                                <td>{{ $getTransactionGqsBranch['date']}}</td>
                                                <td>{{ $getTransactionGqsBranch['branch']}}</td>
                                                <td class="bg-danger" style="color:#fff;"><?php echo number_format($getTransactionGqsBranch['total_amount_of_sales'], 2); ?></td>
                                                <td><?php echo number_format($getTransactionGqsBranch['total_discounts_seniors_pwds']); ?></td>
                                                <td><?php echo number_format($getTransactionGqsBranch['gift_cert'], 2)?></td>
                                                <td>{{ $getTransactionGqsBranch['created_by']}}</td>
										    </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <table class="table table-bordered">
                                    <thead>	
                                        <tr>
                                            <th width="20%" class="bg-info" style="color:white;">TOTAL SALES </th>
                                            <th class="bg-danger" style="color:white; font-size:30px;">₱ <?php echo number_format($sumGqs, 2)?></th>
                                        </tr>
                                    
                                    </thead>
							    </table>
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
@endsection