@extends('layouts.mr-potato-app')
@section('title', 'View Purchase Order |')
@section('content')
<div id="wrapper">
	<!-- Sidebar -->
    @include('sidebar.sidebar-mr-potato')
    <div id="content-wrapper">
    	<div class="container-fluid">
    		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Mr Potato</a>
              </li>
              <li class="breadcrumb-item active">View Purchase Order</li>
            </ol>
            <a href="{{ url('mr-potato/purchase-order-lists') }}">Back to Lists</a>
             <div class="col-lg-12">
				<div style="float:left; margin-left:140px">
					<img src="{{ asset('images/digitized-logos/ribos-food-corp.png')}}" width="360" height="250" class="img-responsive mx-auto d-block" alt="Mr Potato">
				</div>
				<div style="flaot:left; margin-right:50px;">
					<img src="{{ asset('images/digitized-logos/mr-potato.png')}}" width="330" height="250" class="img-responsive mx-auto d-block" alt="Mr Potato">
				</div>
            	 <h4 class="text-center"><u>VIEW PURCHASE ORDER</u></h4>
            </div>
            <div class="row">
            	<div class="col-lg-12">
            		<div class="card mb-3">
            			 <div class="card-header">
                              <i class="fab fa-first-order" aria-hidden="true"></i>
                            View Purchase Order
							@if($purchaseOrder[0]->deleted_at == NULL)
                             <div class="float-right">
                               
                                 <a href="{{ action('MrPotatoController@printPO', $purchaseOrder[0]->id)}}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                               
                              </div>
							@endif
                        </div>
                         <div class="card-body">
						   @if($purchaseOrder[0]->deleted_at != NULL)
                              <h1 style="color:red; font-size:28px; font-weight:bold">This Item Has Been Deleted! (CLERICAL ERROR)</h1>
                              @endif
                         	<div class="form-group">
                         		<div class="form-row">
                         			  <div class="col-lg-6">
		                                    <table class="table table-bordered">
		                                        <thead>
		                                            <tr>
		                                                <th width="25%">Branch Location</th>
		                                                <th>{{ $purchaseOrder[0]->branch_location }}</th>
		                                            </tr>
		                                            
													<tr>
		                                                <th>Ordered By</th>
		                                                <th>{{ $purchaseOrder[0]->ordered_by }}</th>
		                                            </tr>
		                                        </thead>

		                                    </table>
                                   
                                 	 </div>
                                 	 <div class="col-lg-6">
	                                    <table class="table table-bordered">
	                                        <thead>
	                                            <tr>
	                                                <th width="20%">PO No</th>
	                                                <th>{{ $purchaseOrder[0]->module_code}}{{ $purchaseOrder[0]->mr_potato_code}}</th>
	                                            </tr>
	                                            <tr>
	                                                <th>Date</th>
	                                                <th> {{ $purchaseOrder[0]->date }}</th>
	                                            </tr>
	                                        </thead>
	                                    </table>
                                   
                                 	 </div>
                                 	 <table class="table table-striped">
                     	 		 		  <thead>
		                                    <tr>
		                                      <th class="bg-info" style="color:white;">PARTICULARS</th>
		                                      <th class="bg-info" style="color:white;">QTY</th>
		                                      <th class="bg-info" style="color:white;">UNIT</th>
		                                      <th class="bg-info" style="color:white;">PRICE</th>
											  <th class="bg-info" style="color:white;">SUBTOTAL</th>
		                                    </tr>
		                                  </thead>
		                                   <tbody> 
		                                   		<tr>
			                                      <td>{{ $purchaseOrder[0]->particulars}}</td>
			                                      <td>{{ $purchaseOrder[0]->qty}}</td>
			                                      <td>{{ $purchaseOrder[0]->unit}}</td>
			                                      <td><?php echo number_format($purchaseOrder[0]->price, 2); ?></td>
												  <td><?php echo number_format($purchaseOrder[0]->subtotal, 2); ?></td>
			                                    </tr>
			                                    @foreach($pOrders as $pOrder)
			                                    <tr>
			                                      <td>{{ $pOrder['particulars']}}</td>
			                                      <td>{{ $pOrder['qty']}}</td>
			                                      <td>{{ $pOrder['unit']}}</td>
			                                      <td><?php echo number_format($pOrder['price'], 2); ?></td>
												  <td><?php echo number_format($pOrder['subtotal'], 2); ?></td>
												 
			                                    </tr> 
			                                    @endforeach
			                                    <tr>
			                                      <td></td>
			                                      <td></td>
			                                      <td><strong>Total</strong></td>
			                                      <td>₱ <?php echo number_format($sum, 2)?></td>
												  <td></td>
			                                    </tr>
			                                    </tbody>
                                 	 </table>

                         		</div>
                         	</div>
                         	 <div class="form-group">
	                              <div class="form-row">
	                                  <div class="col-lg-6">
	                                    <table class="table table-bordered">
	                                        <thead>
	                                            <tr>
	                                                <th width="30%">Requested By</th>
	                                                <th></th>
	                                            </tr>
	                                             <tr>
	                                                <th>Checked By</th>
	                                                <th></th>
	                                            </tr>
	                                        </thead>
	                                    </table>
	                                   
	                                  </div>
	                                  <div class="col-lg-6">
	                                    <table class="table table-bordered">
	                                        <thead>
	                                            <tr>
	                                                <th width="20%">Prepared By</th>
	                                                <th>{{ $purchaseOrder[0]->created_by }}</th>
	                                            </tr>
	                                        </thead>
	                                    </table>
	                                   
	                                  </div>
	                              </div>
	                           </div>
                         </div>
            		</div>	
            	</div>
            </div>
    	</div>
    </div>
</div>
@endsection