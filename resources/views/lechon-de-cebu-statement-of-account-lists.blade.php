@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Statement Of Account Lists |')
@section('content')
<script>
  $(document).ready(function(){
      $('table.display').DataTable( {} );
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
                <li class="breadcrumb-item active">Statement Of Account All Lists</li>
              </ol>
              <div class="row">
              		<div class="col-lg-12">
              			<div class="card mb-3">
              			<div class="card-header">
                        <i class="fa fa-tasks" aria-hidden="true"></i>
          					   SSP - Orders
                       <div class="float-right">
                          <a href="{{ action('LoloPinoyLechonDeCebuController@printSOAListsSsp') }}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                        </div>
                    </div>
    					  <div class="card-body">
    					  		<div class="table-responsive">
      				  				<table class="table table-bordered display"  width="100%" cellspacing="0">
      				  					<thead>
      			  							<th>Action</th>
      			  							<th>Date</th>
                            <th>Invoice No</th>
                            <th>SOA No</th>
                            <th>Order</th>
                            <th>Bill To</th>
                            <th>BS No</th>
                            <th>Delivered To</th>
                            <th  class="bg-info" style="color:white;">Period Covered</th>
                            <th class="bg-success" style="color:white;">Status</th>
                            <th>Total Amount</th>
                            <th>Total Remaining Balance</th>
      			  							<th>Created By</th>

      				  					</thead>
      				  					<tfoot>
      			  							<th>Action</th>
                            <th>Date</th>
                            <th>Invoice No</th>
                            <th>SOA No</th>
                            <th>Order</th>
                            <th>Bill To</th>
                            <th>BS No</th>
                            <th>Delivered To</th>
                            <th  class="bg-info" style="color:white;">Period Covered</th>
                            <th class="bg-success" style="color:white;">Status</th>
                            <th>Total Amount</th>
                            <th>Total Remaining Balance</th>
                            <th>Created By</th>
      				  					</tfoot>
      				  					<tbody>
                            @foreach($statementOfAccounts as $statementOfAccount)
      				  						<tr id="deletedId{{ $statementOfAccount->id}}">
                              <td>
                                 @if(Auth::user()['role_type'] !== 3)
                                  <a href="{{ url('lolo-pinoy-lechon-de-cebu/edit-statement-of-account/'.$statementOfAccount->id ) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                  @endif
                                
                                  <a href="{{ url('lolo-pinoy-lechon-de-cebu/view-statement-account/'.$statementOfAccount->id) }}" title="View"><i class="fas fa-low-vision"></i></a>

                              </td>
                              <td>{{ $statementOfAccount->date }}</td>
                              <td>{{ $statementOfAccount->invoice_number}}</td>
                              <td>SOA-{{ $statementOfAccount->lechon_de_cebu_code}}</td>
                              <td>{{ $statementOfAccount->order }}</td>
                              <td>{{ $statementOfAccount->bill_to}}</td> 
                              <td><p style="width:140px;">{{ $statementOfAccount->bs_no }}</p></td>
                              <td>{{ $statementOfAccount->address}}</td>
                              <td class="bg-info" style="color:white;">{{ $statementOfAccount->period_cover}}</td>
                             
                              <td class="bg-success" style="color:white;">
                                 @if($statementOfAccount->total_remaining_balance == 0.00)
                                    PAID
                                 @endif
                              </td>
                              
                              <td><?= number_format($statementOfAccount->total_amount, 2)?></td>
                              <td><?= number_format($statementOfAccount->total_remaining_balance, 2)?></td>
                              <td>{{ $statementOfAccount->created_by}}</td>
                            </tr>
                            @endforeach
      				  					</tbody>
      				  				</table>
    					  		</div>
                    <br>
    					  		<table class="table table-bordered">
					  				<thead>
					  					<tr>
					  						<th width="30%" class="bg-info" style="color:white; font-size:28px;">TOTAL PAID AMOUNT</th>
					  						<th class="bg-danger" style="color:white; font-size:28px;"><span id="totalDue">₱ <?php echo number_format($totalAmount, 2);?></span></th>
					  					</tr>
                      <tr>
					  						<th width="30%" class="bg-info" style="color:white; font-size:28px;">TOTAL UNPAID AMOUNT</th>
					  						<th class="bg-danger" style="color:white; font-size:28px;"><span id="totalDue">₱ <?php echo number_format($totalRemainingBalance, 2);?></span></th>
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
                          <i class="fa fa-tasks" aria-hidden="true"></i>
                        Private - Orders
                        <div class="float-right">
                            <a href="{{ action('LoloPinoyLechonDeCebuController@printSOAListsPO') }}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                          </div>
                      </div>
                      <div class="card-body">
                          	<div class="table-responsive">
                                <table class="table table-bordered display" width="100%" cellspacing="0">
                                  <thead>
                                    <th>Action</th>
                                    <th>Date</th>
                                    <th>Ref DR No</th>
                                    <th>SOA No</th>
                                    <th>Order</th>
                                    <th>Bill To</th>
                                    <th>BS No</th>
                                    <th>Delivered To</th>
                                    <th  class="bg-info" style="color:white;">Period Covered</th>
                                    <th class="bg-success" style="color:white;">Status</th>
                                    <th>Total Amount</th>
                                    <th>Total Remaining Balance</th>
                                    <th>Created By</th>

                                  </thead>
                                  <tfoot>
                                    <th>Action</th>
                                    <th>Date</th>
                                    <th>Ref DR No</th>
                                    <th>SOA No</th>
                                    <th>Order</th>
                                    <th>Bill To</th>
                                    <th>BS No</th>
                                    <th>Delivered To</th>
                                    <th  class="bg-info" style="color:white;">Period Covered</th>
                                    <th class="bg-success" style="color:white;">Status</th>
                                    <th>Total Amount</th>
                                    <th>Total Remaining Balance</th>
                                    <th>Created By</th>
                                  </tfoot>
                                  <tbody>
                                      @foreach($privateOrders as $privateOrder)
                                      <tr id="deletedId{{ $privateOrder->id}}">
                                          <td>
                                            @if(Auth::user()['role_type'] !== 3)
                                              <a href="{{ url('lolo-pinoy-lechon-de-cebu/edit-statement-of-account/'.$privateOrder->id ) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                              @endif
                                            
                                              <a href="{{ url('lolo-pinoy-lechon-de-cebu/view-statement-account/'.$privateOrder->id) }}" title="View"><i class="fas fa-low-vision"></i></a>

                                          </td>
                                          <td>{{ $privateOrder->date }}</td>
                                          <td>{{ $privateOrder->dr_no}}</td>
                                          <td>SOA-{{ $privateOrder->lechon_de_cebu_code}}</td>
                                          <td>{{ $privateOrder->order }}</td>
                                          <td>{{ $privateOrder->bill_to}}</td> 
                                          <td><p style="width:140px;">{{ $privateOrder->bs_no }}</p></td>
                                          <td>{{ $privateOrder->address }}</td>
                                          <td class="bg-info" style="color:white;">{{ $privateOrder->period_cover}}</td>
                                        
                                          <td class="bg-success" style="color:white;">
                                            @if($privateOrder->total_remaining_balance == 0.00)
                                                PAID
                                            @endif
                                          </td>
                                          
                                          <td><?php echo number_format($privateOrder->total_amount, 2)?></td>
                                          <td><?php echo number_format($privateOrder->total_remaining_balance, 2)?></td>
                                          <td>{{ $privateOrder->created_by}}</td>
                                        </tr>
                                      @endforeach
                                  </tbody>
                                </table>
                                 <br>
                                  <table class="table table-bordered">
                                  <thead>
                                    <tr>
                                      <th width="30%" class="bg-info" style="color:white; font-size:28px;">TOTAL PAID AMOUNT</th>
                                      <th class="bg-danger" style="color:white; font-size:28px;"><span id="totalDue">₱ <?php echo number_format($totalAmountPO, 2);?></span></th>
                                    </tr>
                                    <tr>
                                      <th width="30%" class="bg-info" style="color:white; font-size:28px;">TOTAL UNPAID AMOUNT</th>
                                      <th class="bg-danger" style="color:white; font-size:28px;"><span id="totalDue">₱ <?php echo number_format($totalRemainingBalancePo, 2);?></span></th>
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