@extends('layouts.ribos-bar-app')
@section('title', 'Utilities List |')
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
      $('table.display').DataTable( {} );
  });   
</script>
<div id="wrapper">
    @include('sidebar.sidebar-ribos-bar')
    <div id="content-wrapper">
        <div class="container-fluid">
             <!-- Breadcrumbs-->
             <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Ribo's Bar</a>
                </li>
                <li class="breadcrumb-item active">Utilities</li>
                <li class="breadcrumb-item ">Utilities List</li>
            </ol>
            <div class="row">
                <div class="col-lg-12">
                         <div class="card mb-3">
                            <div class="card-header">
                                <i class="fas fa-bolt"></i>
                                Veco
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12 ">
                                            <!-- Button trigger modal -->
                                            
                                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addVeco" >Add Veco </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                     <table class="table table-bordered display"  width="100%" cellspacing="0">
                                         <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Account ID</th>
                                                <th>Account Name</th>
                                                <th >Meter No</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Action</th>
                                                <th>Account ID</th>
                                                <th>Account Name</th>
                                                <th >Meter No</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody> 
                                            @foreach($vecoDocuments as $vecoDocument)
                                                <tr id="deletedId{{ $vecoDocument['id']}}">
                                                    <td>
                                                        @if(Auth::user()['role_type'] == 1)
                                                            <a id="delete" onClick="confirmDelete('{{ $vecoDocument['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>                                                        
                                                        @endif
                                                    </td>
                                                    <td><a href="{{ url('/ribos-bar/utilities/view-veco/'.$vecoDocument['id']) }}">{{ $vecoDocument['account_id']}}</a></td>
                                                    <td>{{ $vecoDocument['account_name']}}</td>
                                                    <td>{{ $vecoDocument['meter_no']}}</td>
                                                    <td>{{ $vecoDocument['date']}}</td>
                                                    <td></td>
                                                    <td>{{ $vecoDocument['created_by']}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                     </table>
                                </div>
                            </div>
                         </div>
                    </div>
                </div><!-- end of row -->
                <div class="row">
                    <div class="col-lg-12">
                         <div class="card mb-3">
                                <div class="card-header">
                                    <i class="fas fa-water"></i>
                                    MCWD
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="col-lg-12 ">
                                                <!-- Button trigger modal -->
                                            
                                                <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addMCWD" >Add MCWD </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                         <table class="table table-bordered display"  width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Account ID</th>
                                                    <th>Account Name</th>
                                                    <th >Meter No</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Created By</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Account ID</th>
                                                    <th>Account Name</th>
                                                    <th >Meter No</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Created By</th>
                                                </tr>
                                             </tfoot>
                                             <tbody>
                                                @foreach($mcwdDocuments as $mcwdDocument)
                                                <tr id="deletedId{{ $mcwdDocument['id']}}">
                                                    <td>
                                                        @if(Auth::user()['role_type'] == 1)
                                                            <a id="delete" onClick="confirmDelete('{{ $mcwdDocument['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>                                                        
                                                        @endif
                                                    </td>
                                                    <td><a href="{{ url('/ribos-bar/utilities/view-mcwd/'.$mcwdDocument['id']) }}">{{ $mcwdDocument['account_id']}}</a></td>
                                                    <td>{{ $mcwdDocument['account_name']}}</td>
                                                    <td>{{ $mcwdDocument['meter_no']}}</td>
                                                    <td>{{ $mcwdDocument['date']}}</td>
                                                    <td></td>
                                                    <td>{{ $mcwdDocument['created_by']}}</td>
                                                </tr>
                                                @endforeach
                                             </tbody>
                                         </table>
                                    </div>
                                </div>
                         </div> 
                    </div>
                </div><!-- end of row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                 <i class="fas fa-globe"></i>
                                Internet 
                             </div>
                             <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12 ">
                                            <!-- Button trigger modal -->
                                          
                                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addInternet" >Add Internet Account </a>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="table-responsive">
                                    <table class="table table-bordered display"  width="100%" cellspacing="0">
                                         <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Account ID</th>
                                                <th>Account Name</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                             <tr>
                                                <th>Action</th>
                                                <th>Account ID</th>
                                                <th>Account Name</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach($internetDocuments as $internetDocument)
                                            <tr id="deletedId{{ $internetDocument['id']}}">
                                                <td>
                                                    @if(Auth::user()['role_type'] == 1)
                                                        <a id="delete" onClick="confirmDelete('{{ $internetDocument['id']}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>                                                        
                                                    @endif
                                                </td>
                                                <td><a href="{{ url('/ribos-bar/utilities/view-internet/'.$internetDocument['id']) }}">{{ $internetDocument['account_id']}}</a></td>
                                                <td>{{ $internetDocument['account_name']}}</td>
                                                <td>{{ $internetDocument['date']}}</td>
                                                <td></td>
                                                <td>{{ $internetDocument['created_by']}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                 </div>
                             </div>
                        </div>
                    </div>
                </div><!-- end of row -->
        </div>
    </div>
    <!-- Modal -->
      <div class="modal fade" id="addInternet" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Internet Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-row">
                            <div id="validateInternet" class="col-lg-12">
                                <p  class="alert alert-danger">Please Fill up the fields</p>
                            </div>
                            <div id="existsInternet" class="col-lg-12"></div>
                            <div id="succAddInternet" class="col-lg-12"></div>
                            <div class="col-lg-12">
                                
                                <label>Account ID</label>
                                <input type="text" id="accountIdInternet" name="accountIdInternet" class="selcls form-control" />
                            </div>
                            <div class="col-lg-12">
                                <label>Account Name</label>
                                <input type="text" id="accountNameInternet" name="accountNameInternet" class="selcls form-control" />
                            </div>
                            <input type="hidden" id="flagInternet" value="Internet" />
                        
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeInternet()" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" onclick="saveInternet()" class="btn btn-success">Add Internet Account </button>
                </div>
            </div>
        </div>
      </div><!-- end of Modal -->
      <!-- Modal -->
      <div class="modal fade" id="addMCWD" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add MCWD Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="form-row">
                        <div id="validateMCWD" class="col-lg-12">
                            <p  class="alert alert-danger">Please Fill up the fields</p>
                        </div>
                        <div id="existsMCWD" class="col-lg-12"></div>
                        <div id="succAddMCWD" class="col-lg-12"></div>
                        <div class="col-lg-12">
                            
                            <label>Account ID</label>
                            <input type="text" id="accountIdMCWD" name="accountIdMCWD" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Account Name</label>
                            <input type="text" id="accountNameMCWD" name="accountNameMCWD" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Meter No</label>
                            <input type="hidden" id="flagMCWD" value="MCWD" />
                            <input type="text" id="meterNoMCWD" name="meterNoMCWD" class="selcls form-control" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeMCWD()" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" onclick="saveMCWD()" class="btn btn-success">Add MCWD </button>
            </div>
        </div>
    </div>
    </div><!-- end of Modal -->
     <!-- Modal -->
     <div class="modal fade" id="addVeco" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Veco Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="form-row">
                        <div id="validate" class="col-lg-12">
                            <p  class="alert alert-danger">Please Fill up the fields</p>
                        </div>
                        <div id="existsVeco" class="col-lg-12"></div>
                        <div id="succAddVeco" class="col-lg-12"></div>
                        <div class="col-lg-12">
                            
                            <label>Account ID</label>
                            <input type="text" id="accountId" name="accountId" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Account Name</label>
                            <input type="text" id="accountName" name="accountName" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Meter No</label>
                            <input type="hidden" id="flagVeco" value="Veco" />
                            <input type="text" id="meterNo" name="meterNo" class="selcls form-control" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeVeco()" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" onclick="saveVeco()" class="btn btn-success">Add Veco </button>
            </div>
        </div>
    </div>
    </div><!-- end of Modal -->
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
</div><!-- end of wrapper -->
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript">
     $("#validate").hide();  
     $("#validateMCWD").hide();
     $("#validateInternet").hide();
     
     const saveInternet = () =>{
        const accountIdInternet = $("#accountIdInternet").val();
        const accountNameInternet = $("#accountNameInternet").val();
        const flagInternet = $("#flagInternet").val();

        if(accountIdInternet == "" || accountNameInternet == ""){
            $("#validateInternet").fadeIn().delay(3000).fadeOut();
        }else{
            //make ajax call
            $.ajax({
                type: "POST",
                url: '/ribos-bar/utilities/add-internet',
                data:{
                    _method: 'post',
                    "_token": "{{ csrf_token() }}",
                    "accountIdInternet":accountIdInternet,
                    "accountNameInternet":accountNameInternet,
                    "flagInternet":flagInternet,
                },
                success:function(data){
                    console.log(data);
                    const getData = data;
                    const succData = getData.split(":");
                    const succDataArr = succData[0];
                    if(succDataArr == "Success"){
                       $("#succAddInternet").fadeIn().delay(3000).fadeOut();
                       $("#succAddInternet").html(`<p class="alert alert-success"> ${data}</p>`);
                      
                        setTimeout(function(){
                            document.location.reload();
                        }, 3000);
                    }else{
                        $("#existsInternet").fadeIn().delay(3000).fadeOut();
                        $("#existsInternet").html(`<p class="alert alert-danger">${data}</p>`);
                    }
                },
                error:function(data){
                    console.log('Error:', data);
                }
            });
        }
     }

     const saveMCWD = () =>{
        const accountIdMCWD = $("#accountIdMCWD").val();
        const accountNameMCWD = $("#accountNameMCWD").val();
        const meterNoMCWD = $("#meterNoMCWD").val();
        const flagMCWD = $('#flagMCWD').val();

        if(accountIdMCWD == "" || accountNameMCWD == "" || meterNoMCWD == ""){
            $("#validateMCWD").fadeIn().delay(3000).fadeOut();
        }else{
            //make ajax call
            $.ajax({
                type: "POST",
                url: '/ribos-bar/utilities/add-bill',
                data:{
                    _method: 'post',
                    "_token": "{{ csrf_token() }}",
                    "accountId":accountIdMCWD,
                    "accountName":accountNameMCWD,
                    "meterNo":meterNoMCWD,
                    "flag":flagMCWD,
                },
                success:function(data){
                    console.log(data);
                    const getData = data;
                    const succData = getData.split(":");
                    const succDataArr = succData[0];
                    if(succDataArr == "Success"){
                       $("#succAddMCWD").fadeIn().delay(3000).fadeOut();
                       $("#succAddMCWD").html(`<p class="alert alert-success"> ${data}</p>`);
                      
                        setTimeout(function(){
                            document.location.reload();
                        }, 3000);
                    }else{
                        $("#existsMCWD").fadeIn().delay(3000).fadeOut();
                        $("#existsMCWD").html(`<p class="alert alert-danger">${data}</p>`);
                    }
                },
                error:function(data){
                    console.log('Error:', data);
                }
            });
        }
     }

     const closeVeco = () =>{
        $("#accountId").val('');
        $("#accountName").val('');
        $("#meterNo").val('');
     }

     const saveVeco = () =>{
        const accountId = $("#accountId").val();
        const accountName = $("#accountName").val();
        const meterNo = $("#meterNo").val();
        const flag = $("#flagVeco").val();

        if(accountId == "" || accountName == "" || meterNo == ""){
            $("#validate").fadeIn().delay(3000).fadeOut();
        }else{
             //make ajax call
             $.ajax({
                type: "POST",
                url: '/ribos-bar/utilities/add-bill',
                data:{
                    _method: 'post',
                    "_token": "{{ csrf_token() }}",
                    "accountId":accountId,
                    "accountName":accountName,
                    "meterNo":meterNo,
                    "flag":flag,
                },
                success:function(data){
                    console.log(data);
                    const getData = data;
                    const succData = getData.split(":");
                    const succDataArr = succData[0];
                    if(succDataArr == "Success"){
                       $("#succAddVeco").fadeIn().delay(3000).fadeOut();
                       $("#succAddVeco").html(`<p class="alert alert-success"> ${data}</p>`);
                      
                        setTimeout(function(){
                            document.location.reload();
                        }, 3000);
                    }else{
                        $("#existsVeco").fadeIn().delay(3000).fadeOut();
                        $("#existsVeco").html(`<p class="alert alert-danger">${data}</p>`);
                    }
                },
                error:function(data){
                    console.log('Error:', data);
                }
            });

        }
     }
</script>
@endsection