@extends('layouts.dong-fang-corporation-app')
@section('title', 'Petty Cash List |')
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
                <li class="breadcrumb-item active">Petty Cash</li>
                <li class="breadcrumb-item ">Petty Cash List</li>
            </ol>
              <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <i class="fas fa-money-bill-alt"></i>
	    					  Petty Cash List
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                             <!-- Button trigger modal -->
                                             <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addPettyCash"><i class="fas fa-plus"></i> Add Petty Cash</a>
                                      
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
					  						<tr>
				  								<th width="10%">Action</th>
				  								<th>Date </th>
                                                <th>Petty Cash No</th>
				  								<th>Name</th>
											
												<th>Created By</th>
					  						</tr>
				  						</thead>
                                        <tfoot>
					  						<tr>
				  								<th>Action</th>
				  								<th>Date </th>
                                                <th>Petty Cash No</th>
				  								<th>Name</th>
											
												<th>Created By</th>
					  						</tr>
				  						</tfoot>
                                        <tbody>
                                             @foreach($pettyCashLists as $pettyCashList)
                                            <tr id="deletedId{{ $pettyCashList->id}}">    
                                                <td>
                                                @if(Auth::user()['role_type'] != 3)
                                                    <a href="{{ url('dong-fang-corporation/edit-petty-cash/'.$pettyCashList->id) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                @if(Auth::user()['role_type'] == 1 || Auth::user()['role_type'] == 2        )
                                                    <a id="delete" onClick="confirmDelete('{{ $pettyCashList->id}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                                                @endif
                                                </td>
                                                <td>{{ $pettyCashList->date}}</td>
                                                <td>{{ $pettyCashList->module_code}}{{ $pettyCashList->dong_fang_code}}</td>
                                                <td><a href="{{ url('dong-fang-corporation/petty-cash/view/'.$pettyCashList->id) }}">{{ $pettyCashList->petty_cash_name}}</a></td>
                                                <td>{{ $pettyCashList->created_by}}</td>
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
     <!-- Modal -->
        <div class="modal fade" id="addPettyCash" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Petty Cash</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 <div id="validate" class="col-lg-12">
                    <p class="alert alert-danger">Please Fill up the fields</p>
                </div>
                <div id="succAdd"></div>
                <div class="form-group">
                    <div class="form-row">
                       
                        <div class="col-lg-4">
                            <label>Date</label>
                            <input type="text" id="date" name="date" class="datepicker form-control"/>
                        </div>
                        <div class="col-lg-4">
                            <label>Petty Cash Name</label>
                            <input type="text" id="pettyCashName" name="pettyCashName" class="form-control" />
                        </div>
                        <div class="col-lg-4">
                            <label>Petty Cash Summary</label>
                            <input type="text" id="pettyCashSummary" name="pettyCashSummary" class="form-control" />
                        </div>
                    </div>
                </div>
              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Close</button>
                <button type="button" onclick="addPettyCash()" class="btn btn-success"><i class="fas fa-plus"></i> Add Petty Cash</button>
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
<script type="text/javascript">
    $("#validate").hide();
    const addPettyCash = () =>{
        const reqDate = $("#date").val();
        const pettyCashName = $("#pettyCashName").val();
        const pettyCashSummary = $("#pettyCashSummary").val();
       
        if(reqDate.length === 0 || pettyCashName.length === 0 || pettyCashSummary.length === 0 ){
            $("#validate").fadeIn().delay(3000).fadeOut();
        }else{
            //make ajax call
            $.ajax({
                type:"POST",
                url:'/dong-fang-corporation/petty-cash/add',
                data:{
                    _method:'post',
                    "_token":"{{ csrf_token() }}",
                    "date":reqDate,
                    "pettyCashName":pettyCashName,
                    "pettyCashSummary":pettyCashSummary,
                   
                },
                success: function(data){
                    console.log(data);
                    $("#succAdd").fadeIn().delay(3000).fadeOut();
                    $("#succAdd").html(`<p class="alert alert-success">Succesfully added.</p>`);
                    setTimeout(function(){
                        window.location = `/dong-fang-corporation/edit-petty-cash/${data}`;
                    }, 3000);
                    
                },
                error:function(data){
                    console.log('Error:', data);
                }
            });
        }
    }

    const confirmDelete = (id) => {
        const  x = confirm("Do you want to delete this?");
          if(x){
              $.ajax({
                type: "DELETE",
                url: '/dong-fang-corporation/petty-cash/delete/' + id,
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