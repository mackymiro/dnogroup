@extends('layouts.lolo-pinoy-grill-branches-app')
@section('title', 'View Supplier|')
@section('content')

<div id="wrapper">
     @include('sidebar.sidebar-lolo-pinoy-grill-branches')
     <div id="content-wrapper">
        <div class="container-fluid">
            	<!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Lolo Pinoy Grill Branches</a>
                    </li>
                    <li class="breadcrumb-item active">Supplier</li>
                    <li class="breadcrumb-item active">View Supplier</li>         
                </ol>
                <div class="row"> 
                     <div class="col-lg-12">
                        <div class="card mb-3">
                             <div class="card-header">
                                <i class="fa fa-industry" aria-hidden="true"></i>
                                View Supplier
                        
                             </div>
                             <div class="card-body">
                                <div class="form-group">
                                     <div class="form-row">
                                        <div class="col-lg-6">
                                            <label>Supplier Name</label>
                                            <input type="text" name="propertyName" class="form-control" value="{{ $viewSupplier[0]->supplier_name }}" disabled="disabled" />
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
                                    <a href="{{ url('lolo-pinoy-grill-branches/supplier/print/'.$viewSupplier[0]->id) }}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
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
                                           @foreach($supplierLists as $supplierList)
                                            <tr>
                                                <td>{{ $supplierList->invoice_number }}</td>
                                                <td>{{ $supplierList->paid_to }}</td>
                                                <td>{{ $supplierList->issued_date }}</td>
                                                <?php if($supplierList->status === "FOR APPROVAL"): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($supplierList->status === "FOR CONFIRMATION"): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($supplierList->status === "FULLY PAID AND RELEASED"): ?>
                                                    <td class="bg-success" style="color:#fff;">PAID</td>
                                                <?php else: ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php endif;?>
                                                <td><?php echo number_format($supplierList->amount_due, 2);?></td>
                                                <td>{{ $supplierList->created_by }}</td>
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
					  						<th class="bg-danger" style="color:white; font-size:28px;"><span id="totalDue">₱ <?php echo number_format($totalAmountDue, 2);?></span></th>
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