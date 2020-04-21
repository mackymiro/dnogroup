@extends('layouts.dno-personal-app')
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
                  <?php if(\Request::is('dno-personal/credit-card/accounts/edit/'.$getCreditCardDetail['id'])): ?>
                     <li class="breadcrumb-item active">Edit Credit Card Accounts</li>
                  <?php else: ?>
                    <li class="breadcrumb-item active">Credit Card Accounts</li>
                  <?php endif; ?>

                  <?php if(\Request::is('dno-personal/credit-card/ald-accounts')): ?>
	                <li class="breadcrumb-item active">ALD Accounts</li>
                  <?php else:?>
                    <li class="breadcrumb-item active">MOD Accounts</li>
                  <?php endif; ?>
			</ol>
            <div class="col-lg-12">
            	 <img src="{{ asset('images/DIC-LOGO.png')}}" width="255" height="172" class="img-responsive mx-auto d-block" alt="Lechon de Cebu">
                 <?php if(\Request::is('dno-personal/credit-card/accounts/edit/'.$getCreditCardDetail['id'])): ?>
                    <h4 class="text-center"><u>EDIT CREDIT CARD ACCOUNTS</u></h4>
                  <?php else: ?>
            	    <h4 class="text-center"><u>CREDIT CARD ACCOUNTS</u></h4>
                  <?php endif; ?>
            </div>
			<div class="row">
                @if(\Request::is('dno-personal/credit-card/accounts/edit/'.$getCreditCardDetail['id']) )
				<div class="col-lg-4">
					<div class="card mb-3">
						<div class="card-header">
							<i class="fa fa-plus" aria-hidden="true"></i>
							Edit 
						</div>
						<form action="{{ action('DnoPersonalController@updateCard', $getCreditCardDetail['id']) }}" method="post">
						{{csrf_field()}}
                        <input name="_method" type="hidden" value="PATCH">
                        @if(session('updatedCard'))
                            <p class="alert alert-success">{{ Session::get('updatedCard') }}</p>
                        @endif
						<div class="card-body">
							<div class="form-group">
								<div class="form-row">
									
									<div class="col-lg-12">
										<label>Bank Name</label>
										<input type="text" name="bankName" class="selcls form-control" value="{{ $getCreditCardDetail['bank_name']}}" />
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="form-row">
									
									<div class="col-lg-12">
										<label>Account No</label>
										<input type="text" name="accountNo" class="selcls form-control" value="{{ $getCreditCardDetail['account_no'] }}" />
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="form-row">
									<div class="col-lg-12">
										<label>Account Name</label>
										<input type="text" name="accountName" class="selcls form-control" value="{{ $getCreditCardDetail['account_name'] }}" />
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
												<option v-for="card in cards" v-bind:value="card.value"
                                                :selected="card.value=={{ json_encode($getCreditCardDetail['type_of_card'])}} ? true : false ">
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
										<button type="submit" class="btn btn-success"><i class="fas fa-pencil-alt"></i> Update Credit Card Account</button>
										
									</div>
								</div>
							</div>
						</div>
						</form>
					</div>
				</div>
                @else
                <div class="col-lg-4">
					<div class="card mb-3">
						<div class="card-header">
							<i class="fa fa-plus" aria-hidden="true"></i>
							Edit 
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
                @endif
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
                                        @if (\Request::is('dno-personal/credit-card/ald-accounts'))  
                                            @foreach($getCreditCards1 as $getCreditCard1)
                                            <tr>
                                                <td>
                                                @if($user->role_type !== 3)
                                                    <a href="{{ url('dno-personal/credit-card/accounts/edit/'.$getCreditCard1['id'] ) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                @endif
                                                @if($user->role_type == 1)
                                                    <a id="delete" onClick="confirmDelete('{{ $getCreditCard1['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                                                @endif
                                                </td>
                                                <td>{{ $getCreditCard1['bank_name']}}</td>
                                                <td>{{ $getCreditCard1['account_no']}}</td>
                                                <td>{{ $getCreditCard1['account_name'] }}</td>
                                                <td>{{ $getCreditCard1['type_of_card']}}</td>
                                                <td>{{ $getCreditCard1['created_by']}}</td>
                                            </tr>
                                            @endforeach
                                        @else
                                            @foreach($getCreditCards2 as $getCreditCard2)
                                            <tr>
                                                <td>
                                                @if($user->role_type !== 3)
                                                    <a href="{{ url('dno-personal/credit-card/accounts/edit/'.$getCreditCard2['id'] ) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                @endif
                                                </td>
                                                <td>{{ $getCreditCard2['bank_name']}}</td>
                                                <td>{{ $getCreditCard2['account_no']}}</td>
                                                <td>{{ $getCreditCard2['account_name'] }}</td>
                                                <td>{{ $getCreditCard2['type_of_card']}}</td>
                                                <td>{{ $getCreditCard2['created_by']}}</td>
                                            </tr>
                                             @endforeach 

                                        @endif
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