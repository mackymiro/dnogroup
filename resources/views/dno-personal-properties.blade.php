@extends('layouts.dno-personal-app')
@if(\Request::is('dno-personal/cebu-properties'))
    @section('title', 'Cebu Properties|')
@else
    @section('title', 'Manila Properties|')
@endif
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
                    <li class="breadcrumb-item active">Properties</li>
                    @if(\Request::is('dno-personal/cebu-properties'))
                    <li class="breadcrumb-item active">Cebu Properties</li>
                    @else
                    <li class="breadcrumb-item active">Manila Properties</li>
                    @endif
                </ol>
                <div class="row">
                     @if(\Request::is('dno-personal/cebu-properties'))
                    <div class="col-lg-4">
                        <div class="card mb-3">
                             <div class="card-header">
                                <i class="fas fa-plus" aria-hidden="true"></i>
                                Add Properties
                         
						    </div>
                            <div class="card-body">
                                <form action="{{ action('DnoPersonalController@storeProperties')}}" method="post">
                                {{csrf_field()}}
                                @if(session('addProperty'))
                                    <p class="alert alert-success">{{ Session::get('addProperty') }}</p>
                                @endif 
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                            <label>Property Name</label>
                                            <input type="text" name="propName" class="selcls form-control"  required/>
                                        </div>
                                        @if ($errors->has('propName'))
		                                  <span class="alert alert-danger">
		                                    <strong>{{ $errors->first('propName') }}</strong>
		                                  </span>
		                                @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                    <div class="col-lg-12">
                                        <label>Property Account Code</label>
                                        <input type="text" name="propAccountCode" class="selcls form-control" required />
                                    </div>
                                    @if ($errors->has('propAccountCode'))
                                        <span class="alert alert-danger">
                                        <strong>{{ $errors->first('propAccountCode') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                            <label>Property Account Name</label>
                                            <input type="text" name="propAccountName" class="selcls form-control" required />
                                        </div>
                                        @if ($errors->has('propAccountName'))
                                            <span class="alert alert-danger">
                                            <strong>{{ $errors->first('propAccountName') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                            <label>Address</label>
                                            <input type="text" name="address" class="selcls form-control" required />
                                        </div>
                                        @if ($errors->has('address'))
		                                  <span class="alert alert-danger">
		                                    <strong>{{ $errors->first('address') }}</strong>
		                                  </span>
		                                @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                            <label>Unit </label>
                                            <input type="text" name="unit" class="selcls form-control" required />
                                        </div>
                                        @if ($errors->has('unit'))
		                                  <span class="alert alert-danger">
		                                    <strong>{{ $errors->first('unit') }}</strong>
		                                  </span>
		                                @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                            <label>Status</label>
                                            <input type="text" name="status" class="selcls form-control"  />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-8">
                                           
                                            <input type="hidden" name="flag" value="Manila Properties" />
                                            <input type="submit" class="btn btn-success" value="Add Property" />
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="col-lg-4">
                        <div class="card mb-3">
                             <div class="card-header">
                                <i class="fas fa-plus" aria-hidden="true"></i>
                                Add Properties
                         
						    </div>
                            <div class="card-body">
                                <form action="{{ action('DnoPersonalController@storeProperties')}}" method="post">
                                {{csrf_field()}}
                                @if(session('addProperty'))
                                    <p class="alert alert-success">{{ Session::get('addProperty') }}</p>
                                @endif 
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                            <label>Property Name</label>
                                            <input type="text" name="propName" class="selcls form-control"  required/>
                                        </div>
                                        @if ($errors->has('propName'))
		                                  <span class="alert alert-danger">
		                                    <strong>{{ $errors->first('propName') }}</strong>
		                                  </span>
		                                @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                    <div class="col-lg-12">
                                        <label>Property Account Code</label>
                                        <input type="text" name="propAccountCode" class="selcls form-control" required />
                                    </div>
                                    @if ($errors->has('propAccountCode'))
                                        <span class="alert alert-danger">
                                        <strong>{{ $errors->first('propAccountCode') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                            <label>Property Account Name</label>
                                            <input type="text" name="propAccountName" class="selcls form-control" required />
                                        </div>
                                        @if ($errors->has('propAccountName'))
                                            <span class="alert alert-danger">
                                            <strong>{{ $errors->first('propAccountName') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                            <label>Address</label>
                                            <input type="text" name="address" class="selcls form-control" required />
                                        </div>
                                        @if ($errors->has('address'))
		                                  <span class="alert alert-danger">
		                                    <strong>{{ $errors->first('address') }}</strong>
		                                  </span>
		                                @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                            <label>Unit </label>
                                            <input type="text" name="unit" class="selcls form-control" required />
                                        </div>
                                        @if ($errors->has('unit'))
		                                  <span class="alert alert-danger">
		                                    <strong>{{ $errors->first('unit') }}</strong>
		                                  </span>
		                                @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-12">
                                            <label>Status</label>
                                            <input type="text" name="status" class="selcls form-control"  />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-lg-8">
                                           
                                            <input type="hidden" name="flag" value="Manila Properties" />
                                            <input type="submit" class="btn btn-success" value="Add Property" />
                                        </div>
                                    </div>
                                </div>
                              
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if(\Request::is('dno-personal/cebu-properties'))
                        <img src="" />
                        <div class="col-lg-8">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <i class="fas fa-building" aria-hidden="true"></i>
                                    Cebu Properties
                            
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                
                                                    <th>Action</th>
                                                    <th>Property Name</th>
                                                    
                                                    <th>Property Account Code</th>
                                                    <th >Property Account Name</th>
                                                    <th >Address</th>
                                                    <th>Unit</th>
                                                    <th >Status</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                <th>Action</th>
                                                    <th>Property Name</th>
                                                    
                                                    <th>Property Account Code</th>
                                                    <th >Property Account Name</th>
                                                    <th >Address</th>
                                                    <th>Unit</th>
                                                    <th >Status</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @foreach($getCebuProperties as $getCebuProperty)
                                                <tr>
                                                    <td></td>
                                                    <td><a href=""><p style="width:160px;">{{ $getCebuProperty['property_name'] }}</p></a></td>
                                                    <td><p style="width:200px;">{{ $getCebuProperty['property_account_code']}}</p></td>
                                                    <td><p style="width:200px;">{{ $getCebuProperty['property_account_name'] }}</p></td>
                                                    <td><p style="width:200px;">{{ $getCebuProperty['address']}}</p></td>
                                                    <td>{{ $getCebuProperty['unit']}}</td>
                                                    <td>{{ $getCebuProperty['status']}}</td>
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
                                    <i class="fas fa-building" aria-hidden="true"></i>
                                    Manila Properties
                            
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                
                                                    <th>Action</th>
                                                    <th>Property Name</th>
                                                    
                                                    <th>Property Account Code</th>
                                                    <th >Property Account Name</th>
                                                    <th >Address</th>
                                                    <th>Unit</th>
                                                    <th >Status</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                <th>Action</th>
                                                    <th>Property Name</th>
                                                    
                                                    <th>Property Account Code</th>
                                                    <th >Property Account Name</th>
                                                    <th >Address</th>
                                                    <th>Unit</th>
                                                    <th >Status</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                 @foreach($getManilaProperties as $getManilaProperty)
                                                    <tr>
                                                        <td>

                                                        </td>
                                                        
                                                        <td><a href=""><p style="width:160px;">{{ $getManilaProperty['property_name'] }}</p></a></td>
                                                        <td><p style="width:200px;">{{ $getManilaProperty['property_account_code']}}</p></td>
                                                        <td><p style="width:200px;">{{ $getManilaProperty['property_account_name'] }}</p></td>
                                                        <td><p style="width:200px;">{{ $getManilaProperty['address']}}</p></td>
                                                        <td>{{ $getManilaProperty['unit']}}</td>
                                                        <td>{{ $getManilaProperty['status']}}</td>
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
</div>
@endsection