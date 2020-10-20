@extends('layouts.lolo-pinoy-grill-commissary-app')
@section('title', 'View Per Branches |')
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
                    <li class="breadcrumb-item active">Delivery Receipt</li>
                    <li class="breadcrumb-item active">View Per Branches</li>
                </ol>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                             <div class="card-header">
                                <i class="fas fa-building"></i> 
                                LOLO PINOY GRILL BANILAD BRANCH
                            </div>
                            <div class="card-body">
                                 <div class="table-responsive">
                                    <table class="table table-bordered display" width="100%" cellspacing="0">
                                        <thead>
					  						
				  							<th>Action</th>
											<th>Date</th>
				  							<th>DR No</th>
				  							<th>Delivered To</th>
				  							<th>Address</th>
				  							<th>Product Id</th>
				  							<th>Qty</th>
				  							<th>Unit</th>
				  							<th>Item Description</th>
				  							<th>Unit Price</th>
				  							<th>Amount</th>
					  						<th>Created By</th>
					  					</thead>
                                          <tfoot>
					  						<th>Action</th>
											<th>Date</th>
				  							<th>DR No</th>
				  							<th>Delivered To</th>
				  							<th>Address</th>
				  							<th>Product Id</th>
				  							<th>Qty</th>
				  							<th>Unit</th>
				  							<th>Item Description</th>
				  							<th>Unit Price</th>
				  							<th>Amount</th>
				  							<th>Created By</th>
					  					</tfoot>
                                        <tbody>
                                            @foreach($getBaniladBranches as $getBaniladBranch)
                                            <tr>
                                                <td>
                                                @if(Auth::user()['role_type'] !== 3)
			  										<a href="{{ url('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-delivery-receipt/'.$getBaniladBranch->id ) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
			               						 @endif
			              						@if(Auth::user()['role_type'] == 1)
					  								<a id="delete" onClick="confirmDelete('{{ $getBaniladBranch->id}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
			              						@endif
									  				<a href="{{ url('lolo-pinoy-grill-commissary/view-lolo-pinoy-grill-commissary-delivery-receipt/'.$getBaniladBranch->id)}}" title="View"><i class="fas fa-low-vision"></i></a>
						                         
                                                </td>
                                                <td>{{ $getBaniladBranch->date}}</td>
                                                <td>{{ $getBaniladBranch->module_code}}{{ $getBaniladBranch->lolo_pinoy_grill_code}}</td>
					  							<td><p style="width:180px;">{{ $getBaniladBranch->delivered_to}}</p></td>
					  							<td>{{ $getBaniladBranch->address}}</td>
                                                <td>
					  								<?php
                                                        $prodArr = $getBaniladBranch->product_id;
                                                        $prodExp = explode("-", $prodArr);
                                                        
                                                    ?>
					  								<p style="width:180px;">{{ $prodExp[1] }}</p>
				  									
				  								</td>
                                                <td>{{ $getBaniladBranch->qty}}</td>
					  							<td>{{ $getBaniladBranch->unit}}</td>
					  							<td>{{ $getBaniladBranch->item_description}}</td>
                                                <td><?php echo number_format($getBaniladBranch->unit_price, 2)?></td>
					  							<td><?php echo number_format($getBaniladBranch->amount, 2)?></td>
					  							<td>{{ $getBaniladBranch->created_by}}</td>
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
                                <i class="fas fa-building"></i> 
                                LOLO PINOY GRILL VELEZ BRANCH
                            </div>
                            <div class="card-body">
                                 <div class="table-responsive">
                                     <table class="table table-bordered display" width="100%" cellspacing="0">
                                        <thead>
					  						
				  							<th>Action</th>
											<th>Date</th>
				  							<th>DR No</th>
				  							<th>Delivered To</th>
				  							<th>Address</th>
				  							<th>Product Id</th>
				  							<th>Qty</th>
				  							<th>Unit</th>
				  							<th>Item Description</th>
				  							<th>Unit Price</th>
				  							<th>Amount</th>
					  						<th>Created By</th>
					  					</thead>
                                          <tfoot>
					  						<th>Action</th>
											<th>Date</th>
				  							<th>DR No</th>
				  							<th>Delivered To</th>
				  							<th>Address</th>
				  							<th>Product Id</th>
				  							<th>Qty</th>
				  							<th>Unit</th>
				  							<th>Item Description</th>
				  							<th>Unit Price</th>
				  							<th>Amount</t
				  							<th>Created By</th>
					  					</tfoot>
                                        <tbody>
                                             @foreach($getVelezBranches as $getVelezBranch)
                                                <tr>
                                                    <td>
                                                    @if(Auth::user()['role_type'] !== 3)
                                                        <a href="{{ url('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-delivery-receipt/'.$getVelezBranch->id ) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                    @if(Auth::user()['role_type'] == 1)
                                                        <a id="delete" onClick="confirmDelete('{{ $getVelezBranch->id}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                                                    @endif
                                                        <a href="{{ url('lolo-pinoy-grill-commissary/view-lolo-pinoy-grill-commissary-delivery-receipt/'.$getVelezBranch->id)}}" title="View"><i class="fas fa-low-vision"></i></a>
                                                    
                                                    </td>
                                                    <td>{{ $getVelezBranch->date}}</td>
                                                    <td>{{ $getVelezBranch->module_code}}{{ $getVelezBranch->lolo_pinoy_grill_code}}</td>
                                                    <td><p style="width:180px;">{{ $getVelezBranch->delivered_to}}</p></td>
                                                    <td>{{ $getVelezBranch->address}}</td>
                                                    <td>
                                                        <?php
                                                            $prodArr = $getVelezBranch->product_id;
                                                            $prodExp = explode("-", $prodArr);
                                                            
                                                        ?>
                                                        <p style="width:180px;">{{ $prodExp[1] }}</p>
                                                        
                                                    </td>
                                                    <td>{{ $getVelezBranch->qty}}</td>
                                                    <td>{{ $getVelezBranch->unit}}</td>
                                                    <td>{{ $getVelezBranch->item_description}}</td>
                                                    <td><?= number_format($getVelezBranch->unit_price, 2)?></td>
                                                    <td><?= number_format($getVelezBranch->amount, 2)?></td>
                                                    <td>{{ $getVelezBranch->created_by}}</td>
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
                                <i class="fas fa-building"></i> 
                                LOLO PINOY GRILL GQS BRANCH
                            </div>
                            <div class="card-body">
                                 <div class="table-responsive">
                                     <table class="table table-bordered display" width="100%" cellspacing="0">
                                        <thead>
					  						
				  							<th>Action</th>
											<th>Date</th>
				  							<th>DR No</th>
				  							<th>Delivered To</th>
				  							<th>Address</th>
				  							<th>Product Id</th>
				  							<th>Qty</th>
				  							<th>Unit</th>
				  							<th>Item Description</th>
				  							<th>Unit Price</th>
				  							<th>Amount</th>
					  						<th>Created By</th>
					  					</thead>
                                          <tfoot>
					  						<th>Action</th>
											<th>Date</th>
				  							<th>DR No</th>
				  							<th>Delivered To</th>
				  							<th>Address</th>
				  							<th>Product Id</th>
				  							<th>Qty</th>
				  							<th>Unit</th>
				  							<th>Item Description</th>
				  							<th>Unit Price</th>
				  							<th>Amount</th>
				  							<th>Created By</th>
					  					</tfoot>
                                        <tbody>
                                             @foreach($getGqsBranches as $getGqsBranch)
                                                <tr>
                                                    <td>
                                                    @if(Auth::user()['role_type'] !== 3)
                                                        <a href="{{ url('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-delivery-receipt/'.$getGqsBranch->id ) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                    @if(Auth::user()['role_type'] == 1)
                                                        <a id="delete" onClick="confirmDelete('{{ $getGqsBranch->id}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                                                    @endif
                                                        <a href="{{ url('lolo-pinoy-grill-commissary/view-lolo-pinoy-grill-commissary-delivery-receipt/'.$getGqsBranch->id)}}" title="View"><i class="fas fa-low-vision"></i></a>
                                                    
                                                    </td>
                                                    <td>{{ $getGqsBranch->date}}</td>
                                                    <td>{{ $getGqsBranch->module_code}}{{ $getGqsBranch->lolo_pinoy_grill_code}}</td>
                                                    <td><p style="width:180px;">{{ $getGqsBranch->delivered_to}}</p></td>
                                                    <td>{{ $getGqsBranch->address}}</td>
                                                    <td>
                                                        <?php
                                                            $prodArr = $getGqsBranch->product_id;
                                                            $prodExp = explode("-", $prodArr);
                                                            
                                                        ?>
                                                        <p style="width:180px;">{{ $prodExp[1] }}</p>
                                                        
                                                    </td>
                                                    <td>{{ $getGqsBranch->qty}}</td>
                                                    <td>{{ $getGqsBranch->unit}}</td>
                                                    <td>{{ $getGqsBranch->item_description}}</td>
                                                    <td><?php echo number_format($getGqsBranch->unit_price, 2)?></td>
                                                    <td><?php echo number_format($getGqsBranch->amount, 2)?></td>
                                                    <td>{{ $getGqsBranch->created_by}}</td>
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
                                <i class="fas fa-building"></i> 
                                LOLO PINOY GRILL URGELLO BRANCH
                            </div>
                            <div class="card-body">
                                 <div class="table-responsive">
                                     <table class="table table-bordered display" width="100%" cellspacing="0">
                                        <thead>
					  						
				  							<th>Action</th>
											<th>Date</th>
				  							<th>DR No</th>
				  							<th>Delivered To</th>
				  							<th>Address</th>
				  							<th>Product Id</th>
				  							<th>Qty</th>
				  							<th>Unit</th>
				  							<th>Item Description</th>
				  							<th>Unit Price</th>
				  							<th>Amount</th>
					  						<th>Created By</th>
					  					</thead>
                                          <tfoot>
					  						<th>Action</th>
											<th>Date</th>
				  							<th>DR No</th>
				  							<th>Delivered To</th>
				  							<th>Address</th>
				  							<th>Product Id</th>
				  							<th>Qty</th>
				  							<th>Unit</th>
				  							<th>Item Description</th>
				  							<th>Unit Price</th>
				  							<th>Amount</th>
				  							<th>Created By</th>
					  					</tfoot>
                                        <tbody>
                                             @foreach($getUrgelloBranches as $getUrgelloBranch)
                                                <tr>
                                                    <td>
                                                    @if(Auth::user()['role_type'] !== 3)
                                                        <a href="{{ url('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-delivery-receipt/'.$getUrgelloBranch->id ) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                    @if(Auth::user()['role_type'] == 1)
                                                        <a id="delete" onClick="confirmDelete('{{ $getUrgelloBranch->id}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                                                    @endif
                                                        <a href="{{ url('lolo-pinoy-grill-commissary/view-lolo-pinoy-grill-commissary-delivery-receipt/'.$getUrgelloBranch->id)}}" title="View"><i class="fas fa-low-vision"></i></a>
                                                    
                                                    </td>
                                                    <td>{{ $getUrgelloBranch->date}}</td>
                                                    <td>{{ $getUrgelloBranch->module_code}}{{ $getUrgelloBranch->lolo_pinoy_grill_code}}</td>
                                                    <td><p style="width:180px;">{{ $getUrgelloBranch->delivered_to}}</p></td>
                                                    <td>{{ $getUrgelloBranch->address}}</td>
                                                    <td>
                                                        <?php
                                                            $prodArr = $getUrgelloBranch->product_id;
                                                            $prodExp = explode("-", $prodArr);
                                                            
                                                        ?>
                                                        <p style="width:180px;">{{ $prodExp[1] }}</p>
                                                        
                                                    </td>
                                                    <td>{{ $getUrgelloBranch->qty}}</td>
                                                    <td>{{ $getUrgelloBranch->unit}}</td>
                                                    <td>{{ $getUrgelloBranch->item_description}}</td>
                                                    <td><?php echo number_format($getUrgelloBranch->unit_price, 2)?></td>
                                                    <td><?php echo number_format($getUrgelloBranch->amount, 2)?></td>
                                                    <td>{{ $getUrgelloBranch->created_by}}</td>
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
@endsection