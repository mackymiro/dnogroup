@extends('layouts.wimpys-food-express-app')
@section('title', 'View Supplier|')
@section('content')

<div id="wrapper">
     @include('sidebar.sidebar-wimpys-food-express')
     <div id="content-wrapper">
        <div class="container-fluid">
            	<!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Wimpy's Food Express</a>
                    </li>
                    <li class="breadcrumb-item active">Supplier</li>
                    <li class="breadcrumb-item active">View Supplier</li>
                   
                    
                </ol>
                <div class="row"> 
                     <div class="col-lg-12">
                        <div class="card mb-3">
                             <div class="card-header">
                                <i class="fa fa-industry" aria-hidden="true"></i>
                                View Supplier/Service Provider
                        
                             </div>
                             <div class="card-body">
                                <div class="form-group">
                                     <div class="form-row">
                                        <div class="col-lg-6">
                                            <label>Supplier Name/Service Provider</label>
                                            <input type="text" name="propertyName" class="form-control" value="{{ $viewSuppliers[0]->supplier_name }}" disabled="disabled" />
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
                                <i class="fa fa-list" aria-hidden="true"></i>

                                Lists
                                <div class="float-right">
                                    <a href="/wimpys-food-express/supplier/{{ $viewSuppliers[0]->id }}/print "><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                                </div>
                             </div>
                            
                             <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable"  width="100%" cellspacing="0">
                                         <thead>
                                            <tr>
                                                <th>Invoice</th>
                                                <th>Paid To</th>
                                              
                                                <th>Issued Date</th>
                                                <th>Status</th>
                                                <th>Amount</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                             <tr>
                                                <th>Invoice</th>
                                                <th>Paid To</th>
                                             
                                                <th>Issued Date</th>
                                                <th>Status</th>
                                                <th>Amount</th>
                                                <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach($viewSuppliers[0]->suppliers as $viewSupplier)
                                            <tr>
                                                <td>{{ $viewSupplier->invoice_number }}</td>
                                                <td>{{ $viewSupplier->paid_to }}</td>
                                               
                                                <td>{{ $viewSupplier->issued_date }}</td>
                                                <?php if($viewSupplier->status === "FOR APPROVAL"): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewSupplier->status === "FOR CONFIRMATION"): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewSupplier->status === "FULLY PAID AND RELEASED"): ?>
                                                    <td class="bg-success" style="color:#fff;">PAID</td>
                                                <?php else: ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php endif;?>
                                                <td><?= number_format($viewSupplier->amount_due, 2);?></td>
                                                <td>{{ $viewSupplier->created_by }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <br>
    					  		<table class="table table-bordered">
					  				<thead>
					  					<tr>
					  						<th width="30%" class="bg-info" style="color:white; font-size:28px;">TOTAL BALANCE DUE</th>
					  						<th class="bg-danger" style="color:white; font-size:28px;"><span id="totalDue">₱ <?= number_format($totalAmountDue, 2);?></span></th>
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