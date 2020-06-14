@extends('layouts.dno-personal-app')
@section('title', 'Edit Petty Cash |')
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
              <li class="breadcrumb-item active">Petty Cash</li>
              <li class="breadcrumb-item active">Edit Petty Cash</li>
            </ol>
            <a href="{{ url('dno-personal/petty-cash-list') }}">Back to Lists</a>
            <div class="col-lg-12">
                    <img src="{{ asset('images/digitized-logos/dno-personal.png')}}" width="255" height="255" class="img-responsive mx-auto d-block" alt="DNO Personal">
   
                    <h4 class="text-center"><u>Edit Petty Cash </u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                              <i class="fas fa-file-invoice" aria-hidden="true"></i>
                          	  Petty Cash
                        </div>
                        <div class="card-body">
                            <form action="{{ action('DnoPersonalController@updatePettyCash', $pettyCash['id'])}}" method="post">
                            {{csrf_field()}}
                                <input name="_method" type="hidden" value="PATCH">
                                @if(session('editSuccess'))
                                        <p class="alert alert-success">{{ Session::get('editSuccess') }}</p>
                                    @endif
                            <div class="form-group">
                                <div class="form-row">
                                    
                                    <div class="col-lg-2">
                                        <label>Petty Cash No</label>
                                        <input type="text" name="pettyCashNo" class="form-control" value="{{ $pettyCash['petty_cash_no']}}" disabled="disabled"/>
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Date</label>
                                        <input type="text" name="date" class="datepicker form-control" value="{{ $pettyCash['date']}}"/>
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Petty Cash Name</label>
                                        <input type="text" name="pettyCashName" class="form-control" value="{{ $pettyCash['petty_cash_name']}}"/>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Petty Cash Summary</label>
                                        <input type="text" name="pettyCashSummary" class="form-control" value="{{ $pettyCash['petty_cash_summary']}}"/>
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Amount</label>
                                        <input type="text" name="amount" class="form-control" value="{{ $pettyCash['amount'] }}"/>
                                    </div>
                                    
                                </div>
                            </div>
                            <br>
                            <div>
                                <button type="submit" class="btn btn-success btn-lg float-right"><i class="fas fa-edit"></i> Update</button>
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
                            <div class="form-group">
                                @if(session('addNewSuccess'))
	                             	<p class="alert alert-success">{{ Session::get('addNewSuccess') }}</p>
	                            @endif
                                <form action ="{{ action('DnoPersonalController@addNewPettyCash', $pettyCash['id']) }}" method="post">
                                {{csrf_field()}}
                                <div class="form-row">
                                     <div class="col-lg-12">
                                        <label>Date</label>
                                        <input type="text" name="date" class="datepicker form-control" required/>
                                    </div>
                                    <div class="col-lg-12">
                                        <label>Petty Cash Summary</label>
                                        <input type="text" name="pettyCashSummary" class="form-control" />
                                    </div>
                                    <div class="col-lg-12">
                                        <label>Amount</label>
                                        <input type="text" name="amount" class="form-control" />
                                    </div>
                                    <div class="col-lg-12">
                                        <br>
                                       
                                        <button type="submit" class="btn btn-primary btn-lg "> <i class="fas fa-plus" aria-hidden="true"></i> Add</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                           
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
                             @if(session('updatePC'))
                                <p class="alert alert-success">{{ Session::get('updatePC') }}</p>
                            @endif
                             @foreach($pettyCashSummaries as $pettyCashSummary) 
                             <form action="{{ action('DnoPersonalController@updatePC', $pettyCashSummary['id']) }}" method="post">
                                 {{csrf_field()}}
                                 <input name="_method" type="hidden" value="PATCH">
                                
                                <div id="deletedId{{ $pettyCashSummary['id']}}" class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-2">
                                            <label>Date</label>
                                            <input type="text" name="date" class="datepicker form-control" value="{{ $pettyCashSummary['date']}}"/>
                                        </div>
                                    
                                        <div class="col-lg-4">
                                            <label>Petty Cash Summary</label>
                                            <input type="text" name="pettyCashSummary" class="form-control" value="{{ $pettyCashSummary['petty_cash_summary'] }}"/>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Amount</label>
                                            <input type="text" name="amount" class="form-control" value="{{ $pettyCashSummary['amount']}}"/>
                                        </div>
                                        <div class="col-lg-4">
                                            <br>
                                            <input type="hidden" name="pcId" value="{{ $pettyCash['id'] }}" />
                                            <button type="submit" class="btn btn-success"><i class="fas fa-edit"></i></button>
                                            <a id="delete" onclick="confirmDelete('{{ $pettyCashSummary['id'] }}')" href="javascript:void" class="btn btn-danger"><i class="fas fa-window-close" aria-hidden="true"></i> </a>
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
                url: '/dno-personal/petty-cash/delete/' + id,
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