@extends('layouts.dno-personal-app')
@section('title', 'Credit Card Details|')
@section('content')
<style>
.selcls { 
    padding: 9px; 
    border: solid 1px #517B97; 
    outline: 0; 
    background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #CAD9E3), to(#FFFFFF)); 
    background: -moz-linear-gradient(top, #FFFFFF, #CAD9E3 1px, #FFFFFF 25px); 
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px; 
    -moz-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px; 
    -webkit-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px; 
	} 
</style> 
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
</script>
<div id="wrapper">
	@include('sidebar.sidebar-dno-personal')
	<div id="content-wrapper">
		<div class="container-fluid">
			<!-- Breadcrumbs-->
			<ol class="breadcrumb">
	              <li class="breadcrumb-item">
	                <a href="#">DNO Personal</a>
	              </li>
                  <li class="breadcrumb-item active">Credit Card Accounts</li>
                  <?php if(Request::is('dno-personal/credit-card/ald-accounts')): ?>
	                <li class="breadcrumb-item active">ALD Accounts</li>
                  <?php else:?>
                    <li class="breadcrumb-item active">MOD Accounts</li>
                  <?php endif; ?>
			</ol>
            <div class="col-lg-12">
				<img src="{{ asset('images/digitized-logos/dno-personal.png')}}" width="255" height="255" class="img-responsive mx-auto d-block" alt="DNO Personal">
    
            	 <h4 class="text-center"><u>CREDIT CARD ACCOUNTS</u></h4>
            </div>
			<div class="row">
					
				<div class="col-lg-4">
					<div class="card mb-3">
						<div class="card-header">
							<i class="fa fa-plus" aria-hidden="true"></i>
							All 
						</div>
						<form action="{{ action('DnoPersonalController@storeCreditCard') }}" method="post">
						{{csrf_field()}}
                        @if(session('cardAdded'))
                            <p class="alert alert-success">{{ Session::get('cardAdded') }}</p>
                        @endif
						<div class="card-body">
							<div class="form-group">
								<div class="form-row">
									@if ($errors->has('bankName'))
									<span class="alert alert-danger">
										<strong>{{ $errors->first('bankName') }}</strong>
									</span>
									@endif
									<div class="col-lg-12">
										<label>Bank Name</label>
										<input type="text" name="bankName" class="selcls form-control" required="required" />
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="form-row">
									@if ($errors->has('accountNo'))
									<span class="alert alert-danger">
										<strong>{{ $errors->first('accountNo') }}</strong>
									</span>
									@endif
									<div class="col-lg-12">
										<label>Account No</label>
										<input type="text" name="accountNo" class="selcls form-control" required="required" />
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="form-row">
									<div class="col-lg-12">
										<label>Account Name</label>
										<input type="text" name="accountName" class="selcls form-control" required="required" />
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="form-row">
									<div class="col-lg-12">
										<label>Type Of Card</label>
										<div id="app-credit-card">
											<select name="typeOfCard" class="selcls form-control">
												<option value="0">--Please Select--</option>
												<option v-for="card in cards" v-bind:value="card.value">
													@{{ card.text }}
												</option>
											</select>
											
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="form-row">
									<div class="col-lg-8 ">
										<button type="submit" class="btn btn-success"><i class="fas fa-credit-card"></i> Add Credit Card Account</button>
										
									</div>
								</div>
							</div>
						</div>
						</form>
					</div>
				</div>
				@if (\Request::is('dno-personal/credit-card/ald-accounts'))  
				<div class="col-lg-8">
					<div class="card mb-3">
						<div class="card-header">
							<i class="fa fa-tasks" aria-hidden="true"></i>
							All Lists
						</div>
						<div class="card-body">
                            
							<div  class="table-responsive">
								<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
									<thead>
										<tr>
											<th>Action</th>
											<th width="160px;">Bank Name</th>
											<th>Account No</th>
											<th>Account Name</th>
											<th width="320px;">Type Of Card</th>
                                            <th width="320px;">Created By</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Action</th>
											<th width="160px;">Bank Name</th>
											<th>Account No</th>
											<th >Account Name</th>
											<th width="320px;"> Type Of Card</th>
                                            <th width="320px;">Created By</th>
										</tr>
									</tfoot>
                                    <tbody>
                                        
										@foreach($getCreditCards1 as $getCreditCard1)
										<tr id="deletedId{{ $getCreditCard1['id'] }}">
											<td>
											@if(Auth::user()['role_type'] != 3)
												<!-- Button trigger modal -->
											<a data-toggle="modal" data-target="#creditCard<?php echo $getCreditCard1['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
											@endif
											@if(Auth::user()['role_type'] == 1 || Auth::user()['role_type']  === 2)
												<a id="delete" onClick="confirmDelete('{{ $getCreditCard1['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
											@endif
											</td>
											<td><p style="width:180px;">{{ $getCreditCard1['bank_name']}}</p></td>
											<td><a href="{{ url('dno-personal/credit-card/ald-accounts/transactions/'.$getCreditCard1['id']) }}">{{ $getCreditCard1['account_no']}}</a></td>
											<td><p style="width:180px;">{{ $getCreditCard1['account_name'] }}</p></td>
											<td><p style="width:380px;">{{ $getCreditCard1['type_of_card']}}</p></td>
											<td><p style="width:200px;">{{ $getCreditCard1['created_by']}}</p></td>
										</tr>
										@endforeach
                                     
                                    </tbody>
								</table>	
							</div>
						</div>
					</div>
				</div>
				@else
				<div class="col-lg-8">
					<div class="card mb-3">
						<div class="card-header">
							<i class="fa fa-tasks" aria-hidden="true"></i>
							All Lists
						</div>
						<div class="card-body">
                            
							<div  class="table-responsive">
								<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
									<thead>
										<tr>
											<th>Action</th>
											<th width="160px;">Bank Name</th>
											<th>Account No</th>
											<th>Account Name</th>
											<th width="320px;">Type Of Card</th>
                                            <th width="320px;">Created By</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Action</th>
											<th width="160px;">Bank Name</th>
											<th>Account No</th>
											<th >Account Name</th>
											<th width="320px;"> Type Of Card</th>
                                            <th width="320px;">Created By</th>
										</tr>
									</tfoot>
                                    <tbody>
                                    
                                            @foreach($getCreditCards2 as $getCreditCard2)
                                            <tr id="deletedId{{ $getCreditCard2['id'] }}">
                                                <td>
                                                @if(Auth::user()['role_type'] !== 3)
														<!-- Button trigger modal -->
													<a data-toggle="modal" data-target="#creditCard<?php echo $getCreditCard2['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
											
												@endif
												@if(Auth::user()['role_type'] == 1 || Auth::user()['role_type'] == 2)
                                                    <a id="delete" onClick="confirmDelete('{{ $getCreditCard2['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                                                @endif
                                                </td>
                                                <td><p style="width:180px;">{{ $getCreditCard2['bank_name']}}</p></td>
												<td><a href="{{ url('dno-personal/credit-card/ald-accounts/transactions/'.$getCreditCard2['id']) }}">{{ $getCreditCard2['account_no']}}</a></td>
												<td><p style="width:200px;">{{ $getCreditCard2['account_name'] }}</p></td>
												<td><p style="width:380px;">{{ $getCreditCard2['type_of_card']}}</p></td>
												<td><p style="width:200px;">{{ $getCreditCard2['created_by']}}</p></td>
                                            </tr>
                                             @endforeach 

                                    
                                    </tbody>
								</table>	
							</div>
						</div>
					</div>
				</div>
				@endif
			</div>
		</div>
	</div>
	@if (\Request::is('dno-personal/credit-card/ald-accounts'))  
		<!-- Modal -->
		@foreach($getCreditCards1 as $getCreditCard1)
		<div class="modal fade" id="creditCard<?php echo $getCreditCard1['id']?>" tabindex="<?php echo $getCreditCard1['id']?>" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Update Credit Card Account</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<div class="form-row">
							<div class="col-lg-12">
								<label>Bank Name</label>
								<input type="text" id="bankName<?php echo $getCreditCard1['id']?>" name="bankName" class="selcls form-control" value="{{ $getCreditCard1['bank_name']}}" />
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="form-row">
							<div class="col-lg-12">
								<label>Account No</label>
								<input type="text" id="accountNumber<?php echo $getCreditCard1['id']?>" name="accountNumber" class="selcls form-control" value="{{ $getCreditCard1['account_no']}}"  />
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="form-row">
							<div class="col-lg-12">
								<label>Account Name</label>
								<input type="text" id="accountName<?php echo $getCreditCard1['id']?>" name="accountName" class="selcls form-control" value="{{ $getCreditCard1['account_name'] }}" disabled="disabled" />
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="form-row">
							<div class="col-lg-12">
								<label>Type Of Card</label>
								<div id="app-credit-card-update">
									<select id="typeOfCard<?php echo $getCreditCard1['id']?>" name="typeOfCard" class="selcls form-control">
										<option value="0">--Please Select--</option>
										<option value="HAS PESO & DOLLAR ACCOUNT" <?php echo("HAS PESO & DOLLAR ACCOUNT" == $getCreditCard1['type_of_card'] ? 'selected' : '') ?>>HAS PESO & DOLLAR ACCOUNT</option>
										<option value="CATHAY PACIFIC ELITE/AMEX/PESO" <?php echo("CATHAY PACIFIC ELITE/AMEX/PESO" == $getCreditCard1['type_of_card'] ? 'selected' : '') ?>>CATHAY PACIFIC ELITE/AMEX/PESO</option>
										<option value="PLATINUM MASTERCARD /PESO & DOLLAR" <?php echo("PLATINUM MASTERCARD /PESO & DOLLAR" == $getCreditCard1['type_of_card'] ? 'selected' : '') ?>>PLATINUM MASTERCARD /PESO & DOLLAR</option>
										<option value="DINERS CLUB PREMIERE(USD)" <?php echo("DINERS CLUB PREMIERE(USD)T" == $getCreditCard1['type_of_card'] ? 'selected' : '') ?>>DINERS CLUB PREMIERE(USD)</option>
										<option value="PLATINUM VISA CARD" <?php echo("PLATINUM VISA CARD" == $getCreditCard1['type_of_card'] ? 'selected' : '') ?>>PLATINUM VISA CARD</option>
										<option value="CITI PREMIERMILES CARD" <?php echo("CITI PREMIERMILES CARD" == $getCreditCard1['type_of_card'] ? 'selected' : '') ?>>CITI PREMIERMILES CARD</option>
										<option value="MASTERCARD" <?php echo("MASTERCARD" == $getCreditCard1['type_of_card'] ? 'selected' : '') ?>>MASTERCARD</option>
										<option value="MASTERCARD PLATINUM" <?php echo("MASTERCARD PLATINUM" == $getCreditCard1['type_of_card'] ? 'selected' : '') ?>>MASTERCARD PLATINUM</option>
										<option value="VISA INFINITE" <?php echo("VISA INFINITE" == $getCreditCard1['type_of_card'] ? 'selected' : '') ?>>VISA INFINITE</option>
										<option value="PLATINUM" <?php echo("PLATINUM" == $getCreditCard1['type_of_card'] ? 'selected' : '') ?>>PLATINUM</option>
										<option value="VISA" <?php echo("VISA" == $getCreditCard1['type_of_card'] ? 'selected' : '') ?>>VISA</option>
										<option value="CREDIT GOLD MASTERCARD" <?php echo("CREDIT GOLD MASTERCARD" == $getCreditCard1['type_of_card'] ? 'selected' : '') ?>>CREDIT GOLD MASTERCARD</option>
										<option value="CITI PREMIERMILES" <?php echo("CITI PREMIERMILES" == $getCreditCard1['type_of_card'] ? 'selected' : '') ?>>CITI PREMIERMILES </option>
										<option value="GOLD CARD" <?php echo("GOLD CARD" == $getCreditCard1['type_of_card'] ? 'selected' : '') ?>>GOLD CARD</option>
										<option value="CITI REWARDS CARD" <?php echo("CITI REWARDS CARD" == $getCreditCard1['type_of_card'] ? 'selected' : '') ?>>CITI REWARDS CARD</option>
										<option value="GOLD MASTERCARD" <?php echo("GOLD MASTERCARD" == $getCreditCard1['type_of_card'] ? 'selected' : '') ?>>GOLD MASTERCARD</option>
										<option value="VISA PLATINUM" <?php echo("VISA PLATINUM" == $getCreditCard1['type_of_card'] ? 'selected' : '') ?>>VISA PLATINUM</option>
										<option value="PLATINUM VISA" <?php echo("PLATINUM VISA" == $getCreditCard1['type_of_card'] ? 'selected' : '') ?>>PLATINUM VISA</option>
										<option value="MANGO MASTERCARD" <?php echo("MANGO MASTERCARD" == $getCreditCard1['type_of_card'] ? 'selected' : '') ?>>MANGO MASTERCARD</option>
									</select>
									
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button onclick=saveChanges(<?php echo $getCreditCard1['id']?>) type="button" class="btn btn-success">Save changes</button>
				</div>
				</div>
			</div>
	</div>
	@endforeach
	@else
		<!-- Modal -->
		@foreach($getCreditCards2 as $getCreditCard2)
		<div class="modal fade" id="creditCard<?php echo $getCreditCard2['id']?>" tabindex="<?php echo $getCreditCard2['id']?>" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Update Credit Card Account</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<div class="form-row">
							<div class="col-lg-12">
								<label>Bank Name</label>
								<input type="text" id="bankName<?php echo $getCreditCard2['id']?>" name="bankName" class="selcls form-control" value="{{ $getCreditCard2['bank_name']}}" />
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="form-row">
							<div class="col-lg-12">
								<label>Account No</label>
								<input type="text" id="accountNumber<?php echo $getCreditCard2['id']?>" name="accountNumber" class="selcls form-control" value="{{ $getCreditCard2['account_no']}}"  />
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="form-row">
							<div class="col-lg-12">
								<label>Account Name</label>
								<input type="text" id="accountName<?php echo $getCreditCard2['id']?>" name="accountName" class="selcls form-control" value="{{ $getCreditCard2['account_name'] }}" disabled="disabled" />
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="form-row">
							<div class="col-lg-12">
								<label>Type Of Card</label>
								<div id="app-credit-card-update">
									<select id="typeOfCard<?php echo $getCreditCard2['id']?>" name="typeOfCard" class="selcls form-control">
										<option value="0">--Please Select--</option>
										<option value="HAS PESO & DOLLAR ACCOUNT" <?php echo("HAS PESO & DOLLAR ACCOUNT" == $getCreditCard2['type_of_card'] ? 'selected' : '') ?>>HAS PESO & DOLLAR ACCOUNT</option>
										<option value="CATHAY PACIFIC ELITE/AMEX/PESO" <?php echo("CATHAY PACIFIC ELITE/AMEX/PESO" == $getCreditCard2['type_of_card'] ? 'selected' : '') ?>>CATHAY PACIFIC ELITE/AMEX/PESO</option>
										<option value="PLATINUM MASTERCARD /PESO & DOLLAR" <?php echo("PLATINUM MASTERCARD /PESO & DOLLAR" == $getCreditCard2['type_of_card'] ? 'selected' : '') ?>>PLATINUM MASTERCARD /PESO & DOLLAR</option>
										<option value="DINERS CLUB PREMIERE(USD)" <?php echo("DINERS CLUB PREMIERE(USD)T" == $getCreditCard2['type_of_card'] ? 'selected' : '') ?>>DINERS CLUB PREMIERE(USD)</option>
										<option value="PLATINUM VISA CARD" <?php echo("PLATINUM VISA CARD" == $getCreditCard2['type_of_card'] ? 'selected' : '') ?>>PLATINUM VISA CARD</option>
										<option value="CITI PREMIERMILES CARD" <?php echo("CITI PREMIERMILES CARD" == $getCreditCard2['type_of_card'] ? 'selected' : '') ?>>CITI PREMIERMILES CARD</option>
										<option value="MASTERCARD" <?php echo("MASTERCARD" == $getCreditCard2['type_of_card'] ? 'selected' : '') ?>>MASTERCARD</option>
										<option value="MASTERCARD PLATINUM" <?php echo("MASTERCARD PLATINUM" == $getCreditCard2['type_of_card'] ? 'selected' : '') ?>>MASTERCARD PLATINUM</option>
										<option value="VISA INFINITE" <?php echo("VISA INFINITE" == $getCreditCard2['type_of_card'] ? 'selected' : '') ?>>VISA INFINITE</option>
										<option value="PLATINUM" <?php echo("PLATINUM" == $getCreditCard2['type_of_card'] ? 'selected' : '') ?>>PLATINUM</option>
										<option value="VISA" <?php echo("VISA" == $getCreditCard2['type_of_card'] ? 'selected' : '') ?>>VISA</option>
										<option value="CREDIT GOLD MASTERCARD" <?php echo("CREDIT GOLD MASTERCARD" == $getCreditCard2['type_of_card'] ? 'selected' : '') ?>>CREDIT GOLD MASTERCARD</option>
										<option value="CITI PREMIERMILES" <?php echo("CITI PREMIERMILES" == $getCreditCard2['type_of_card'] ? 'selected' : '') ?>>CITI PREMIERMILES </option>
										<option value="GOLD CARD" <?php echo("GOLD CARD" == $getCreditCard2['type_of_card'] ? 'selected' : '') ?>>GOLD CARD</option>
										<option value="CITI REWARDS CARD" <?php echo("CITI REWARDS CARD" == $getCreditCard2['type_of_card'] ? 'selected' : '') ?>>CITI REWARDS CARD</option>
										<option value="GOLD MASTERCARD" <?php echo("GOLD MASTERCARD" == $getCreditCard2['type_of_card'] ? 'selected' : '') ?>>GOLD MASTERCARD</option>
										<option value="VISA PLATINUM" <?php echo("VISA PLATINUM" == $getCreditCard2['type_of_card'] ? 'selected' : '') ?>>VISA PLATINUM</option>
										<option value="PLATINUM VISA" <?php echo("PLATINUM VISA" == $getCreditCard2['type_of_card'] ? 'selected' : '') ?>>PLATINUM VISA</option>
										<option value="MANGO MASTERCARD" <?php echo("MANGO MASTERCARD" == $getCreditCard2['type_of_card'] ? 'selected' : '') ?>>MANGO MASTERCARD</option>
									</select>
									
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button onclick=saveChangesMod(<?php echo $getCreditCard2['id']?>) type="button" class="btn btn-success">Save changes</button>
				</div>
				</div>
			</div>
	</div>
	@endforeach
	@endif
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
	const saveChangesMod = (id) => {
		const bankName = $("#bankName"+id).val();
		const accountNumber= $("#accountNumber"+id).val();
		const accountName = $("#accountName"+id).val();
		const typeOfCard= $("#typeOfCard"+id).val();

		$.ajax({
			type: "PATCH",
			url: '/dno-personal/credit-card/accounts/edit/' + id,
			data:{
				_method: 'patch',
				"_token": "{{ csrf_token() }}",
				"id": id,
				"bankName":bankName,
				"accountNumber":accountNumber,
				"accoutName":accountName,
				"typeOfCard":typeOfCard
			},
			success: function(data){
				location.reload('/dno-personal/credit-card/mod-accounts');
			},
			error: function(data){
				console.log('Error:', data);
			}

		});

	}

	const saveChanges = (id) => {
		const bankName = $("#bankName" +id).val();
		const accountNumber= $("#accountNumber"+id).val();
		const accountName = $("#accountName"+id).val();
		const typeOfCard= $("#typeOfCard"+id).val();
	
		$.ajax({
			type: "PATCH",
			url: '/dno-personal/credit-card/accounts/edit/' + id,
			data:{
				_method: 'patch',
				"_token": "{{ csrf_token() }}",
				"id": id,
				"bankName":bankName,
				"accountNumber":accountNumber,
				"accoutName":accountName,
				"typeOfCard":typeOfCard
			},
			success: function(data){
				location.reload();
			},
			error: function(data){
				console.log('Error:', data);
			}

		});
		

	}

	const confirmDelete = (id) => {
		const x = confirm("Do you want to delete this?");
          if(x){
              $.ajax({
                type: "DELETE",
                url: '/dno-personal/credit-card/delete/' + id,
                data:{
                  _method: 'delete', 
                  "_token": "{{ csrf_token() }}",
                  "id": id
                },
                success: function(data){
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
	//type of cards
	new Vue({
	el: '#app-credit-card',
		data:{
			cards:[
				{text:'HAS PESO & DOLLAR ACCOUNT', value:'HAS PESO & DOLLAR ACCOUNT'},
				{text:'CATHAY PACIFIC ELITE/AMEX/PESO', value:'CATHAY PACIFIC ELITE/AMEX/PESO'},
				{text:'PLATINUM MASTERCARD /PESO & DOLLAR', value:'PLATINUM MASTERCARD /PESO & DOLLAR'},
				{text:'DINERS CLUB PREMIERE(USD)', value: 'DINERS CLUB PREMIERE(USD)'},
				{text:'PLATINUM VISA CARD', value:'PLATINUM VISA CARD'},
				{text:'CITI PREMIERMILES CARD', value:'CITI PREMIERMILES CARD'},
				{text:'MASTERCARD', value:' MASTERCARD'},
				{text:'MASTERCARD PLATINUM', value:'MASTERCARD PLATINUM'},
				{text:'VISA INFINITE', value:'VISA INFINITE'},
				{text:'PLATINUM', value:'PLATINUM'},
				{text:'VISA', value:'VISA'},
                {text:'CREDIT GOLD MASTERCARD', value:'CREDIT GOLD MASTERCARD'},
                {text:'CITI PREMIERMILES ', value:'CITI PREMIERMILES '},
                {text:'GOLD CARD', value:'GOLD CARD'},
                {text:'CITI REWARDS CARD', value:'CITI REWARDS CARD'},
                {text:'GOLD MASTERCARD', value:'GOLD MASTERCARD'},
                {text:'VISA PLATINUM', value:'VISA PLATINUM'},
                {text:'PLATINUM VISA', value:'PLATINUM VISA'},
                {text:'MANGO MASTERCARD', value:'MANGO MASTERCARD'}
			]
		}
	});

	
</script>
@endsection