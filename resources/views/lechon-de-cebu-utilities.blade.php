@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
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
     @include('sidebar.sidebar')
     <div id="content-wrapper">
         <div class="container-fluid">
               <!-- Breadcrumbs-->
               <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">Lechon de Cebu</a>
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
                                        <td><a href="{{ url('/lolo-pinoy-lechon-de-cebu/utilities/view-veco/'.$vecoDocument['id']) }}">{{ $vecoDocument['account_id']}}</a></td>
                                        <td>{{ $vecoDocument['account_name']}}</td>
                                        <td>{{ $vecoDocument['meter_no']}}</td>
                                        <td>{{ $vecoDocument['date']}}</td>
                                        <?php
                                            $viewParticulars  =  DB::table(
                                                                    'lechon_de_cebu_payment_vouchers')
                                                                ->where('sub_category_account_id', $vecoDocument['id'])
                                                                ->get();
                                        ?>  
                                          <?php if($viewParticulars === ""): ?>
                                                    <td class="bg-danger " style="color:#fff;">UNPAID</td>
                                               <?php else:?>
                                                @foreach($viewParticulars as $viewParticular)
                                                <?php if($viewParticular->status == "FOR APPROVAL" ): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewParticular->status == "FOR CONFIRMATION " ): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewParticular->status == "FULLY PAID AND RELEASED" ): ?>
                                                    <td class="bg-success" style="color:#fff;">PAID</td>
                                                <?php elseif($viewParticular->status == ""):?>
                                                    <t class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php endif;?>
                                                
                                                @endforeach
                                                <?php endif;?>
                                        <td>{{ $vecoDocument['created_by']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        </div> 
                    </div>
                </div>
            </div><!-- end of row-->
          
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
                                                <td><a href="{{ url('/lolo-pinoy-lechon-de-cebu/utilities/view-internet/'.$internetDocument['id']) }}">{{ $internetDocument['account_id']}}</a></td>
                                                <td>{{ $internetDocument['account_name']}}</td>
                                                <td>{{ $internetDocument['date']}}</td>
                                                <?php
                                            $viewParticulars  =  DB::table(
                                                                    'lechon_de_cebu_payment_vouchers')
                                                                ->where('sub_category_account_id', $internetDocument['id'])
                                                                ->get();
                                             ?>  
                                          <?php if($viewParticulars === ""): ?>
                                                    <td class="bg-danger " style="color:#fff;">UNPAID</td>
                                               <?php else:?>
                                                @foreach($viewParticulars as $viewParticular)
                                                <?php if($viewParticular->status == "FOR APPROVAL" ): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewParticular->status == "FOR CONFIRMATION " ): ?>
                                                    <td class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php elseif($viewParticular->status == "FULLY PAID AND RELEASED" ): ?>
                                                    <td class="bg-success" style="color:#fff;">PAID</td>
                                                <?php elseif($viewParticular->status == ""):?>
                                                    <t class="bg-danger" style="color:#fff;">UNPAID</td>
                                                <?php endif;?>
                                                
                                                @endforeach
                                                <?php endif;?>
                                                <td>{{ $internetDocument['created_by']}}</td>
                                            </tr>
                                            @endforeach
                                                
                                             
                                        </tbody>
                                    </table>
                                </div>
                             </div>
                        </div>
                    </div>  
                </div><!-- end of row-->
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
                <button type="button" onclick="saveInternet()" class="btn btn-success">Add Internet </button>
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
</div>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript">
    $("#validate").hide();  
    $("#validateMCWD").hide();
    $("#validateInternet").hide();

    const confirmDelete = (id) =>{
        const x = confirm("Do you want to delete this?");
        if(x){
            $.ajax({
              type: "DELETE",
              url: '/lolo-pinoy-grill-commissary/utilities/delete/' + id,
              data:{
                _method: 'delete', 
                "_token": "{{ csrf_token() }}",
                "id": id,
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
    
    const saveInternet = () =>{
        const accountIdInternet = $("#accountIdInternet").val();
        const accountNameInternet = $("#accountNameInternet").val();
        const flagInternet = $("#flagInternet").val();
       
        if(accountIdInternet.length === 0 || accountNameInternet.length === 0){
            $("#validateInternet").fadeIn().delay(3000).fadeOut();
        }else{
            //make ajax call
            $.ajax({
                type: "POST",
                url: '/lolo-pinoy-lechon-de-cebu/utilities/add-internet',
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

  
    const closeVeco = () => {
        $("#accountId").val('');
        $("#accountName").val('');
        $("#meterNo").val('');
    }
    
    const saveVeco = () =>{
        const accountId = $("#accountId").val();
        const accountName = $("#accountName").val();
        const meterNo = $("#meterNo").val();
        const flag = $("#flagVeco").val();
      
        if(accountId.length === 0 || accountName.length === 0 || meterNo.length === 0){
            $("#validate").fadeIn().delay(3000).fadeOut();
        }else{

             //make ajax call
            $.ajax({
                type: "POST",
                url: '/lolo-pinoy-lechon-de-cebu/utilities/add-bill',
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