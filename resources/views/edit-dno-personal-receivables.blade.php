@extends('layouts.dno-personal-app')
@section('title', 'Edit Receivables |')
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
     @include('sidebar.sidebar-dno-personal')
     <div id="content-wrapper"> 
        <div class="container-fluid">
             <!-- Breadcrumbs-->
             <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Dno Personal</a>
              </li>
              <li class="breadcrumb-item active">Receivables</li>
              <li class="breadcrumb-item active">Edit Receivables</li>
            </ol>
            <a href="{{ url('dno-personal/receivables/list') }}">Back to Lists</a>
            <div class="col-lg-12">
                    <img src="{{ asset('images/digitized-logos/dno-personal.png')}}" width="255" height="255" class="img-responsive mx-auto d-block" alt="DNO Personal">
  
                    <h4 class="text-center"><u>Edit Receivables </u></h4>
            </div>
            <div class="row">
                 <div class="col-lg-12">
                    <div class="card mb-3">
                         <div class="card-header">
                             <i class="fas fa-stamp"></i>
                          	  Receivables
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="form-row">
                                   
                                    <div class="col-lg-4">
                                        <label>Name of Tenant</label>
                                        <input type="text" name="nameOfTenant" class="form-control" value="{{ $receivable['name_of_tenant']}}" />
                                    </div>
                                  
                                    <div class="col-lg-2">
                                        <label>Contract Date</label>
                                        <input type="text" name="contractDate" class="form-control" value="{{ $receivable['contract_date'] }}" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Unit No</label>
                                        <input type="text" name="unitNo" class="form-control" value="{{ $receivable['unit_no'] }}" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Monthly Rent</label>
                                        <input type="text" name="monthlyRent" class="form-control" value="{{ $receivable['monthly_rent'] }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                  
                                    <div class="col-lg-4">
                                        <label>Advance Deposit</label>
                                        <input type="text" name="advanceDep" class="form-control"  value="{{ $receivable['advance_deposit'] }}" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Amount</label>
                                        <input type="text" name="amount" class="form-control" value="{{ $receivable['advance_deposit_amount'] }}" />
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-success btn-lg float-right"><i class="fas fa-edit"></i> Update</button>
                            </div>
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
                            <form action="{{ action('DnoPersonalController@addReceivables', $receivable['id']) }}" method="post">
                            {{ csrf_field() }}
                            @if(session('addNewSuccess'))
                                <p class="alert alert-success">{{ Session::get('addNewSuccess') }}</p>
                            @endif
                            <div  class="form-group">
                                <div class="form-row">
                                    @if ($errors->has('period'))
                                        <span class="alert alert-danger">
                                        <strong>{{ $errors->first('period') }}</strong>
                                        </span>
                                    @endif
                                    <div class="col-lg-12">
                                        <label>Period</label>
                                        <input type="text" name="period" class="datepicker form-control" required />
                                    </div>
                                    @if ($errors->has('amount'))
                                        <span class="alert alert-danger">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                        </span>
                                    @endif
                                    <div class="col-lg-12">
                                        <label>Amount</label>
                                        <input type="text" name="amount" class="form-control" required/>
                                    </div>
                                    <div class="col-lg-12">
                                        <br>
                                       
                                        <button type="submit" class="btn btn-primary btn-lg "> <i class="fas fa-plus" aria-hidden="true"></i> Add</button>
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
                              <i class="fas fa-plus" aria-hidden="true"></i>
                          	  Added Receivables
                        </div>
                        <div class="card-body">
                            @if(session('updateR'))
                                <p class="alert alert-success">{{ Session::get('updateR') }}</p>
                            @endif
                            @foreach($receivableDatas as $receivableData)
                            <form action="{{ action('DnoPersonalController@updateR', $receivableData['id'])}}" method="post">
                            {{csrf_field()}}
                                 <input name="_method" type="hidden" value="PATCH">
                            <div id="deletedId{{ $receivableData['id'] }}"class="form-group">
                                <div class="form-row">
                                   
                                    <div class="col-lg-4">
                                        <label>Period</label>
                                        <input type="text" name="period" class="datepicker form-control" value="{{ $receivableData['period'] }}" />
                                    </div>
                                   
                                    <div class="col-lg-4">
                                        <label>Amount</label>
                                        <input type="text" name="amount" class="form-control" value="{{ $receivableData['amount'] }}"/>
                                    </div>
                                    <div class="col-lg-4">
                                        <br>
                                        <input type="hidden" name="rId" value="{{ $receivable['id'] }}" />
                                        <button type="submit" class="btn btn-success"><i class="fas fa-edit"></i></button>
                                        <a id="delete" onclick="confirmDelete('{{ $receivableData['id'] }}')" href="javascript:void" class="btn btn-danger"><i class="fas fa-window-close" aria-hidden="true"></i> </a>
                                    </div>
                                </div>
                            </div>
                            </form>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div><!-- end of row-->
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
<script type="text/javascript">
     const confirmDelete = (id) => {
        const  x = confirm("Do you want to delete this?");
          if(x){
              $.ajax({
                type: "DELETE",
                url: '/dno-personal/receivables/delete/' + id,
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