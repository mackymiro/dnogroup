@extends('layouts.dong-fang-corporation-app')
@section('title', 'Edit Billing Statement |')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
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
    @include('sidebar.sidebar-dong-fang-corporation') 
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                <a href="#">Dong Fang Corporation</a>
                </li>
                <li class="breadcrumb-item active">Edit Billing Statement</li>
            </ol>
            <a href="{{ url('dong-fang-corporaton/billing-statement/lists') }}">Back to Lists</a>
            <div class="col-lg-12">
                <img src="{{ asset('images/dong-fang-corporation.png')}}" width="277" height="139" class="img-responsive mx-auto d-block" alt="DNO Personal">
	             
                <h4 class="text-center"><u>BILLING STATEMENT</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-receipt" aria-hidden="true"></i>
                            Billing Statement
                    </div>
                    <div class="card-body">
                        <form action="{{ action('DongFangCorporationController@storeBillingStamtement') }}" method="post">
                        {{ csrf_field() }}
                        
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-lg-2">
                                    <label>Date</label>
                                    <input type="text" name="date" class="datepicker form-control"  value="{{ $billingStatement['date'] }}" />
                                </div>
                                
                                <div class="col-lg-2">
                                    <label>Account No</label>
                                    <input type="text" name="accountNo" class="form-control"  value="{{ $billingStatement['account_no'] }}" />
                                </div>
                                <div class="col-lg-4">
                                    <label>Company Name</label>
                                    <input type="text" name="companyName" class="form-control"  value="{{ $billingStatement['company_name'] }}" />
                                </div>
                                <div class="col-lg-4">
                                    <label>Address</label>
                                    <input type="text" name="address" class="form-control" value="{{ $billingStatement['address'] }}" />
                                </div>
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                    <div class="col-lg-2">
                                    <label>Billing Statement No</label>
                                    <input type="text" name="billingStatementNo" class="form-control"  value="{{ $billingStatement['billing_statement_no'] }}" />
                                </div>
                                <div class="col-lg-2">
                                    <label>Attention</label>
                                    <input type="text" name="attention" class="form-control"   value="{{ $billingStatement['attention'] }}"/>
                                </div>
                                <div class="col-lg-2">
                                    <label>Ref #</label>
                                    <input type="text" name="refNumber" class="form-control"  value="{{ $billingStatement['ref_no'] }}" />
                                </div>
                                <div class="col-lg-2">
                                    <label>PO #</label>
                                    <input type="text" name="poNumber" class="form-control"  value="{{ $billingStatement['po_no'] }}" />
                                </div>
                                <div class="col-lg-2">
                                    <label>Terms</label>
                                    <input type="text" name="terms" class="form-control"  value="{{ $billingStatement['terms'] }}" />
                                </div>
                                <div class="col-lg-2">
                                    <label>Due Date</label>
                                    <input type="text" name="dueDate" class="datepicker form-control"  value="{{ $billingStatement['due_date'] }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-lg-2">
                                    <label>Date</label> 
                                    <input type="text" name="dateDetails" class="datepicker form-control"  value="{{ $billingStatement['date_detail'] }}"/>
                                </div>
                                <div class="col-lg-2">
                                    <label>No of Pax</label> 
                                    <input type="text" name="noPax" class="form-control"  value="{{ $billingStatement['no_pax'] }}" />
                                </div>
                                
                                <div class="col-lg-4">
                                    <label>Particular</label> 
                                    <input type="text" name="particular" class="form-control"  value="{{ $billingStatement['particular'] }}" />
                                </div>
                                    <div class="col-lg-2">
                                    <label>Price Per Pax</label> 
                                    <input type="text" name="pricePerPax" class="form-control"  value="{{ $billingStatement['price_per_pax'] }}" />
                                </div>
                                <div class="col-lg-2">
                                    <label>Amount</label> 
                                    <input type="text" name="amount" class="form-control" value="{{ $billingStatement['amount'] }}" />
                                </div>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-success float-right"><i class="fas fa-edit" aria-hidden="true"></i> Update Billing Statement</button>
                            <br>
                        </div>
                        </form>
                    </div>
                    </div>
            </div>
        </div><!-- end of row-->
        <div class="row">
                <div class="col-lg-4">
                     <div class="card mb-3">
                        <div class="card-header">
                              <i class="fas fa-plus" aria-hidden="true"></i>
                          	  Add
                        </div>
                        <div class="card-body">
                             <form action="{{ action('DongFangCorporationController@addNewBillingStatement', $billingStatement['id'] ) }}" method="post">
                             {{ csrf_field() }}
                             @if(session('billingsAdded'))
	                             	<p class="alert alert-success">{{ Session::get('billingsAdded') }}</p>
	                            @endif
                             <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-12">
                                        <label>Date</label> 
                                        <input type="text" name="dateDetails" class="datepicker form-control" />
                                    </div>
                                    <div class="col-lg-12">
                                        <label>No of Pax</label> 
                                        <input type="text" name="noPax" class="form-control"  />
                                    </div>
                                    
                                    <div class="col-lg-12">
                                        <label>Particular</label> 
                                        <input type="text" name="particular" class="form-control"   required/>
                                    </div>
                                        <div class="col-lg-12">
                                        <label>Price Per Pax</label> 
                                        <input type="text" name="pricePerPax" class="form-control"  />
                                    </div>
                                    <div class="col-lg-12">
                                        <label>Amount</label> 
                                        <input type="text" name="amount" class="form-control"  />
                                    </div>
                                    <div class="col-lg-12">
                                        <br>
                                       
                                        <button type="submit" class="btn btn-primary"> <i class="fas fa-plus" aria-hidden="true"></i> Add</button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                     </div> 
                </div>
                <div class="col-lg-8">
                    <div class="card mb-3">
                         <div class="card-header">
                              <i class="fas fa-file-invoice" aria-hidden="true"></i>
                          	  Summary
                        </div>
                        <div class="card-body">
                             @if(session('updateBilling'))
                                <p class="alert alert-success">{{ Session::get('updateBilling') }}</p>
                            @endif
                            @foreach($billingLists as $billingList)
                            <form action="{{ action('DongFangCorporationController@updateBL', $billingList['id'] ) }}" method="post">
                             {{csrf_field()}}
                             <input name="_method" type="hidden" value="PATCH">
                            <div id="deletedId{{ $billingList['id'] }}">
                            <div class="form-group">
                                <div class="form-row">
                                     <div class="col-lg-2">
                                        <label>Date</label> 
                                        <input type="text" name="dateDetails" class="datepicker form-control" value="{{ $billingList['date'] }}" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>No of Pax</label> 
                                        <input type="text" name="noPax" class="form-control"  value="{{ $billingList['no_pax'] }}"/>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <label>Particular</label> 
                                        <input type="text" name="particular" class="form-control"  value="{{ $billingList['particular'] }}"/>
                                    </div>
                                        <div class="col-lg-2">
                                        <label>Price Per Pax</label> 
                                        <input type="text" name="pricePerPax" class="form-control"  value="{{ $billingList['price_per_pax'] }}"/>
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Amount</label> 
                                        <input type="text" name="amount" class="form-control"  value="{{ $billingList['amount'] }}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-12">
                                          <input type="hidden" name="bsId" value="{{ $billingStatement['id']}}" />
                                        <button type="submit" class="btn btn-success"><i class="fas fa-edit"></i></button>
                                        <a id="delete" onclick="confirmDelete('{{ $billingList['id']}}')" href="javascript:void" class="btn btn-danger"><i class="fas fa-window-close" aria-hidden="true"></i> </a>
                                    
                                    </div>                        
                                </div>
                            </div><!-- end of form group -->
                            </div>
                            </form>
                            @endforeach
                        </div>
                    </div>
                 </div>
                </div><!-- end of row-->
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
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript">
    const confirmDelete = (id) =>{
        const  x = confirm("Do you want to delete this?");
          if(x){
              $.ajax({
                type: "DELETE",
                url: '/dong-fang-corporation/billing-statement/delete/' + id,
                data:{
                  _method: 'delete', 
                  "_token": "{{ csrf_token() }}",
                  "id": id
                },
                success: function(data){
                  console.log(data);
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
@endsection