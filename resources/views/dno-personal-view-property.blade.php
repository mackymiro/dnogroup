@extends('layouts.dno-personal-app')
@section('title', 'View Property|')
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
     @include('sidebar.sidebar-dno-personal')
     <div id="content-wrapper">
         <div class="container-fluid">
            	<!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">DNO Personal</a>
                    </li>
                    <li class="breadcrumb-item active">Properties</li>
                    @if(\Request::is('dno-personal/cebu-properties/view/'.$viewProperty['id']))
                    <li class="breadcrumb-item active">View Cebu Property</li>
                    @else
                    <li class="breadcrumb-item active">View Manila Property</li>
                    @endif
                </ol>
                <div class="row">   
                    <div class="col-lg-12">
                        <div class="card mb-3">
                             <div class="card-header">
                                <i class="fas fa-building" aria-hidden="true"></i>
                                View My Property
                        
                             </div>
                             <div class="card-body">
                                 <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-2">
                                            <label>Property Name</label>
                                            <input type="text" name="propertyName" class="selcls form-control" value="{{ $viewProperty['property_name']}}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Property Account Code</label>
                                            <input type="text" name="propertyAccountCode" class="selcls form-control" value="{{ $viewProperty['property_account_code'] }}" />
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Property Account Name</label>
                                            <input type="text" name="propertyAccountName" class="selcls form-control" value="{{ $viewProperty['property_account_name'] }}" />
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Address</label>
                                            <input type="text" name="address" class="selcls form-control" value="{{ $viewProperty['address']}}" />
                                        </div>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-2">
                                            <label>Status</label>
                                            <input type="text" name="status" class="selcls form-control" value="{{ $viewProperty['status'] }}" />
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Unit</label>
                                            <input type="text" name="unit" class="selcls form-control" value="{{ $viewProperty['unit']}}" />
                                        </div>
                                    </div>
                                 </div>
                             </div>
                        </div>
                    </div>
                </div><!-- end of row-->
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
                                                <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody> 
                                            @foreach($vecoDocuments as $vecoDocument)
                                            <tr>
                                                <td></td>
                                                <td><a href="{{ url('dno-personal/cebu-properties/view-veco/'.$vecoDocument['id']) }}">{{ $vecoDocument['account_id']}}</a></td>
                                                <td>{{ $vecoDocument['account_name']}}</td>
                                                <td>{{ $vecoDocument['meter_no']}}</td>
                                                <td>{{ $vecoDocument['date']}}</td>
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
                                                <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody> 
                                            @foreach($mcwdDocuments as $mcwdDocument)
                                            <tr>
                                                <td></td>
                                                <td><a href="{{ url('dno-personal/cebu-properties/view-mcwd/'.$mcwdDocument['id']) }}">{{ $mcwdDocument['account_id']}}</a></td>
                                                <td>{{ $mcwdDocument['account_name']}}</td>
                                                <td>{{ $mcwdDocument['meter_no']}}</td>
                                                <td>{{ $mcwdDocument['date']}}</td>
                                                <td>{{ $mcwdDocument['created_by']}}</td>
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
                               <i class="fas fa-phone"></i>
                                PLDT
                             </div>
                             <div class="card-body">
                             <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12 ">
                                            <!-- Button trigger modal -->
                                          
                                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addPLDT" >Add PLDT </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                <table class="table table-bordered display"  width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Account No</th>
                                                <th>Account Name</th>
                                              
                                                <th >Telephone No</th>
                                                <th>Date</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                             <tr>
                                                <th>Action</th>
                                                <th>Account No</th>
                                                <th>Account Name</th>
                                                
                                                <th >Telephone No</th>
                                                <th>Date</th>
                                                <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody> 
                                            @foreach($PLDTDocuments as $PLDTDocument)
                                            <tr>
                                                <td></td>
                                                <td><a href="{{ url('dno-personal/cebu-properties/view-pldt/'.$PLDTDocument['id']) }}">{{ $PLDTDocument['account_no']}}</a></td>
                                                <td>{{ $PLDTDocument['account_name']}}</td>
                                               
                                                <td>{{ $PLDTDocument['telephone_no']}}</td>
                                                <td>{{ $PLDTDocument['date']}}</td>
                                                <td>{{ $PLDTDocument['created_by']}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                             </div>
                        </div>
                    </div>
                </div><!-- end of row -->
         </div>
     </div>
      <!-- Modal -->
    <div class="modal fade" id="addPLDT" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add PLDT Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="form-row">
                        <div id="validatePLDT" class="col-lg-12">
                             <p  class="alert alert-danger">Please Fill up the fields</p>
                        </div>
                        <div id="existsPLDT" class="col-lg-12"></div>
                         <div id="succAddPLDT" class="col-lg-12"></div>
                        <div class="col-lg-12">
                           
                            <label>Account Name</label>
                            <input type="text" id="accountNamePLDT" name="accountNamePLDT" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Account No</label>
                            <input type="text" id="accountNoPLDT" name="accountNoPLDT" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Telephone No</label>
                            <input type="hidden" id="flagPLDT" value="PLDT" />
                            <input type="hidden" id="propIdPLDT" value="{{ $viewProperty['id'] }}" />
                            <input type="text" id="telephoneNO" name="telephoneNO" class="selcls form-control" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick=closePLDT() type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button onclick=savePLDT() type="button" class="btn btn-success">Add PLDT</button>
            </div>
            </div>
        </div>
    </div><!-- end of Modal -->
      <!-- Modal -->
    <div class="modal fade" id="addMCWD" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">>
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
                        <div id="exists" class="col-lg-12"></div>
                         <div id="succAdd" class="col-lg-12"></div>
                        <div class="col-lg-12">
                           
                            <label>Account ID</label>
                            <input type="text" id="accountIdMCWD" name="accountIdMCWD" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Account Name</label>
                            <input type="text" id="accountNameMCWD" name="accouaccountNameMCWDntName" class="selcls form-control" />
                        </div>
                        <div class="col-lg-12">
                            <label>Meter No</label>
                            <input type="hidden" id="flagMCWD" value="MCWD" />
                            <input type="hidden" id="propIdMCWD" value="{{ $viewProperty['id'] }}" />
                            <input type="text" id="meterNoMCWD" name="meterNo" class="selcls form-control" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick=closeMCWD() type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button onclick=saveMCWD() type="button" class="btn btn-success">Add MCWD</button>
            </div>
            </div>
        </div>
    </div><!-- end of Modal -->
    <!-- Modal -->
    <div class="modal fade" id="addVeco" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">>
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
                            <input type="hidden" id="propId" value="{{ $viewProperty['id'] }}" />
                            <input type="text" id="meterNo" name="meterNo" class="selcls form-control" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick=closeVeco() type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button onclick=saveVeco() type="button" class="btn btn-success">Add Veco</button>
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
   $("#validatePLDT").hide();

    const savePLDT = () => {
        const accountNamePLDT = $("#accountNamePLDT").val();
        const accountNoPLDT = $("#accountNoPLDT").val();
        const telephoneNO = $("#telephoneNO").val();
        const flagPLDT = $("#flagPLDT").val();
        const propIdPLDT = $("#propIdPLDT").val();

        if(accountNamePLDT == "" || accountNoPLDT == "" || telephoneNO == ""){
            $("#validatePLDT").fadeIn().delay(3000).fadeOut();
        }else{
            //make ajax call
            $.ajax({
                type: "POST",
                url: '/dno-personal/properties/add-pldt',
                data:{
                    _method: 'post',
                    "_token": "{{ csrf_token() }}",
                    "accountNamePLDT":accountNamePLDT,
                    "accountNoPLDT":accountNoPLDT,
                    "telephoneNO":telephoneNO,
                    "flagPLDT":flagPLDT,
                    "propIdPLDT":propIdPLDT
                },
                success: function(data){
                    console.log(data);
                    const getData = data;
                    const succData = getData.split(":");
                    const succDataArr = succData[0];
                    if(succDataArr == "Success"){
                       $("#succAddPLDT").fadeIn().delay(3000).fadeOut();
                       $("#succAddPLDT").html(`<p class="alert alert-success"> ${data}</p>`);
                      
                        setTimeout(function(){
                            document.location.reload();
                        }, 3000);
                    }else{
                        $("#existsPLDT").fadeIn().delay(3000).fadeOut();
                        $("#existsPLDT").html(`<p class="alert alert-danger">${data}</p>`);
                    }
                },
                error:function(data){
                    console.log('Error:', data);
                }
            });
        }
    }

    const closeMCWD = () => {
        $("#accountIdMCWD").val('');
        $("#accountNameMCWD").val('');
        $("#meterNoMCWD").val('');
    }

    const saveMCWD = () =>{
        const accountId = $("#accountIdMCWD").val();
        const accountName = $("#accountNameMCWD").val();
        const meterNo = $("#meterNoMCWD").val();
        const flag = $("#flagMCWD").val();
        const propId = $("#propIdMCWD").val();
        
        if(accountId == "" || accountName == "" || meterNo == ""){
            $("#validateMCWD").fadeIn().delay(3000).fadeOut();
        }else{
            //make ajax call
            $.ajax({
                type: "POST",
                url: '/dno-personal/properties/add-bill',
                data:{
                    _method: 'post',
                    "_token": "{{ csrf_token() }}",
                    "accountId":accountId,
                    "accountName":accountName,
                    "meterNo":meterNo,
                    "flag":flag,
                    "propId":propId
                },
                success:function(data){
                    console.log(data);
                    const getData = data;
                    const succData = getData.split(":");
                    const succDataArr = succData[0];
                    if(succDataArr == "Success"){
                       $("#succAdd").fadeIn().delay(3000).fadeOut();
                       $("#succAdd").html(`<p class="alert alert-success"> ${data}</p>`);
                      
                        setTimeout(function(){
                            document.location.reload();
                        }, 3000);
                    }else{
                        $("#exists").fadeIn().delay(3000).fadeOut();
                        $("#exists").html(`<p class="alert alert-danger">${data}</p>`);
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

    const saveVeco = () => {
        const accountId = $("#accountId").val();
        const accountName = $("#accountName").val();
        const meterNo = $("#meterNo").val();
        const flag = $("#flagVeco").val();
        const propId = $("#propId").val();
       
        if(accountId == "" || accountName == ""  || meterNo == ""){
            $("#validate").fadeIn().delay(3000).fadeOut();
        }else{  

            //make ajax call
            $.ajax({
                type: "POST",
                url: '/dno-personal/properties/add-bill',
                data:{
                    _method: 'post',
                    "_token": "{{ csrf_token() }}",
                    "accountId":accountId,
                    "accountName":accountName,
                    "meterNo":meterNo,
                    "flag":flag,
                    "propId":propId
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
