@extends('layouts.lolo-pinoy-grill-branches-app')
@section('title', 'Edit Requisition Slip |')
@section('content')
<script>
	function addFunction(){
	    var table = document.getElementById("textbox");
	  	var rowlen = table.rows.length;
	  	var row = table.insertRow(rowlen);
	  	row.id = rowlen;
	  	var arr = ['Quantity'];
	  	for (i = 0; i < 2; i++) {
	  		 var x = row.insertCell(i)
	  		 if (i == 1) {
	  		 	x.innerHTML = "<input class='btn btn-danger' type='button' onclick='removeCell(" + row.id + ")' value=Remove>"
  		  	}else{
  		  		x.innerHTML = "<div class='col-lg-12'><label>" + arr[i] + ":</label><br><input class='form-control' type='textbox' name='quantity[]'><label>Description</label><input type='textbox' class='form-control' name='description[]' ><label>Unit Price</label><input type='textbox' class='form-control' name='unitPrice[]' ><label>Amount</label><input type='textbox' class='form-control' name='amount[]' ></div>"
  	
  		  	}
  		}
	}



	function removeCell(rowid) {
      var table = document.getElementById(rowid).remove();
	}
</script>
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
  });
</script>
<div id="wrapper">
	 @include('sidebar.sidebar-lolo-pinoy-grill-branches')

    <div id="content-wrapper">   
     
    	<div class="container-fluid">
    		 <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lolo Pinoy Grill Branches</a>
              </li>
              <li class="breadcrumb-item active">Update Requisition Slip</li>
            </ol>
            <a href="{{ url('lolo-pinoy-grill-branches/requisition-slip-lists') }}">Back to Lists</a>
            <div class="col-lg-12">
            	 <img src="{{ asset('images/lolo-pinoy-grill.jpeg')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lolo Pinoy Grill Branches">
               
            	 
            	 <h4 class="text-center"><u>REQUISITION SLIP</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                         <div class="card-header">
                       <i class="fab fa-first-order" aria-hidden="true"></i>
                         Edit Requisition Slip</div>
                         <div class="card-body">
                               @if(session('SuccessE'))
                                 <p class="alert alert-success">{{ Session::get('SuccessE') }}</p>
                                @endif 
                               <form action="{{ action('LoloPinoyGrillBranchesController@update', $requisitionSlip['id']) }}" method="post">
                               {{csrf_field()}}
                              <input name="_method" type="hidden" value="PATCH">
                              <div class="form-group">
                                <div class="form-row">
                                   <div class="form-group">
                                      <div class="form-row">
                                          <div class="col-lg-4">
                                              <label>Requesting Department</label>
                                              <input type="text" name="requestingDept" class="form-control" value="{{ $requisitionSlip['requesting_department']}}" />
                                          </div>
                                          <div class="col-lg-2">
                                              <label>Request Date</label>
                                              <input type="text" name="requestDate" class="form-control" value="{{ $requisitionSlip['request_date']}}" />
                                          </div>
                                          <div class="col-lg-2">
                                              <label>Date Released</label>
                                              <input type="text" name="dateReleased" class="form-control" value="{{ $requisitionSlip['date_released'] }}" />
                                          </div>
                                      </div>
                                  </div>
                               
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="form-row">
                                  <div class="col-lg-2">
                                    <label>Quantity Requested</label>
                                    <input type="text" name="quantityRequested" class="form-control" value="{{ $requisitionSlip['quantity_requested']}}" />
                                  
                                  </div>
                                  <div class="col-lg-2">
                                    <label>Unit</label>
                                    <input type="text" name="unit" class="form-control" value="{{ $requisitionSlip['unit']}}" />
                                  
                                  </div>
                                 
                                  <div class="col-lg-2">
                                    <label>Item</label>
                                    <input type="text" name="item" class="form-control" value="{{ $requisitionSlip['item'] }}" />
                                  
                                  </div>
                                  <div class="col-lg-2">
                                    <label>Quantity Given</label>
                                    <input type="text" name="quantityGiven" class="form-control" value="{{ $requisitionSlip['quantity_given']}}" />
                                    
                                  </div>   
                                  <br>
                                  <div class="col-lg-12 float-right">
                                    <br>
                                    <br>
                                    <input type="submit" class="btn btn-success"  value="Update Purchase Order" />
                                  </div>
                                </div>  
                              </div>
                              
                              </form>
                         </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                     <div class="card mb-3">
                        <div class="card-header">
                       <i class="fab fa-first-order" aria-hidden="true"></i>
                          Edit Requistion Slip</div>
                        <div class="card-body">
                            @if(session('SuccessEdit'))
                               <p class="alert alert-success">{{ Session::get('SuccessEdit') }}</p>
                              @endif 
                            @foreach($rSlips as $rSlip)
                            <form action="{{ action('LoloPinoyGrillBranchesController@updateRs', $rSlip['id']) }}" method="post">
                            <div class="form-group">
                                 {{csrf_field()}}
                                 <input name="_method" type="hidden" value="PATCH">

                                    <div id="deletedId{{ $rSlip['id'] }}" class="form-row">
                                      <div class="col-lg-2">
                                        <label>Quantity Requested</label>
                                        <input type="text" name="quantityRequested" class="form-control" value="{{ $rSlip['quantity_requested']}}" />
                                      
                                      </div>
                                      <div class="col-lg-2">
                                        <label>Unit</label>
                                        <input type="text" name="unit" class="form-control" value="{{ $rSlip['unit']}}" />
                                      
                                      </div>
                                     
                                      <div class="col-lg-2">
                                        <label>Item</label>
                                        <input type="text" name="item" class="form-control" value="{{ $rSlip['item']}}" />
                                      
                                      </div>
                                      <div class="col-lg-2">
                                        <label>Quantity Given</label>
                                        <input type="text" name="quantityGiven" class="form-control"  value="{{ $rSlip['quantity_given']}}" />
                                        
                                      </div> 
                                     <div class="col-lg-2">
                                      <br>
                                      <input type="hidden" name="rsId" value="{{ $requisitionSlip['id'] }}" />
                                      <input type="submit" class="btn btn-success" value="Update" />
                                      @if($user->role_type == 1)
                                      <a id="delete" onClick="confirmDelete('{{ $rSlip['id'] }}')" href="javascript:void" class="btn btn-danger">Remove</a>
                                      @endif
                                    </div>
                                </div>
                               
                            </div>
                          </form>
                            @endforeach
                            <div>
                              @if($user->role_type == 1)
                              <a href="{{ url('lolo-pinoy-grill-branches/add-new/'.$requisitionSlip['id']) }}" class="btn btn-primary">Add New</a>
                              @endif
                            </div>
                            
                            <br>
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
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript">
   function confirmDelete(id){
      var x = confirm("Do you want to delete this?");
        if(x){
            $.ajax({
              type: "DELETE",
              url: '/lolo-pinoy-grill-branches/delete/' + id,
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