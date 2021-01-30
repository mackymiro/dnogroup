@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'View Contractor|')
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
     @include('sidebar.sidebar')
     <div id="content-wrapper">
        <div class="container-fluid">
            	<!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Lechon de Cebu</a>
                    </li>
                    <li class="breadcrumb-item active">Conrractor</li>
                    <li class="breadcrumb-item active">View Contractor</li>         
                </ol>
                <div class="row"> 
                     <div class="col-lg-12">
                        <div class="card mb-3">
                             <div class="card-header">
                                <i class="fa fa-industry" aria-hidden="true"></i>
                                View Contractor
                        
                             </div>
                             <div class="card-body">
                                <div class="form-group">
                                     <div class="form-row">
                                        <div class="col-lg-6">
                                            <label>Contractor Name</label>
                                            <input type="text" name="contractorName" class="form-control" value="{{ $viewContractor[0]->contractor_name }}" disabled="disabled" />
                                        </div>
                                     </div>
                                </div>
                             </div>
                        </div>
                     </div>
                </div>
                <div class="row">
                     <div class="col-lg-12">
                        <div class="card mb-3">
                             <div class="card-header">
                                <i class="fa fa-list" aria-hidden="true"></i>

                                Lists
                                <div class="float-right">
                                    <a href="{{ url('lolo-pinoy-lechon-de-cebu/supplier/print/'.$viewContractor[0]->id) }}"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                                </div>
                             </div>
                            
                             <div class="card-body">
                                <div class="form-group">
                                        <div class="form-row">
                                            <div class="col-lg-12">
                                                <!-- Button trigger modal -->
                                                <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#add"><i class="fas fa-plus"></i> Add </a>
                                        
                                            </div>
                                        </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable"  width="100%" cellspacing="0">
                                         <thead>
                                            <tr>
                                                <th>Contractor No</th>
                                                <th>Contract Date</th>
                                                <th>Status</th>
                                                <th>Amount</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                             <tr>
                                                <th>Invoice</th>
                                                <th>Issued Date</th>
                                                <th>Status</th>
                                                <th>Amount</th>
                                                <th>Created By</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                         
                                        </tbody>
                                    </table>
                                </div>
                                <br>
    					  		<table class="table table-bordered">
					  				<thead>
					  					<tr>
					  						<th width="30%" class="bg-info" style="color:white; font-size:28px;">TOTAL BALANCE DUE</th>
					  						<th class="bg-danger" style="color:white; font-size:28px;"><span id="totalDue">₱ <?php //echo number_format($totalAmountDue, 2);?></span></th>
					  					</tr>

					  				</thead>
    					  		</table>	
                                
                             </div>
                        </div>
                     </div>
                </div>
        </div>
     </div>
      <!-- Modal -->
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 <div id="validate" class="col-lg-12">
                    <p class="alert alert-danger">Please Fill up the fields</p>
                </div>
                <div id="succAdd"></div>
                <div id="succExists"></div>
                <div class="form-group">
                    <div class="form-row">
                       
                        <div class="col-lg-4">
                            <label>Date</label>
                            <input type="text" id="date" name="date" class="datepicker form-control"/>
                        </div>
                        <div class="col-lg-4">
                            <label>Contractor No</label>
                            <input type="text" id="contractorNo" name="contractorNo" class="form-control"/>
                        </div>
                      
                        <div class="col-lg-4">
                            <label>Amount</label>
                            <input type="text" id="amount" name="amount" class="form-control" />
                        </div>
                        <div class="col-lg-4">
                            <label>Contract Date</label>
                            <input type="text" id="contractDate" name="contractDate" class="datepicker form-control" />
                        </div>
                       
                    </div>
                </div>
              
            </div>
            <div class="modal-footer">
                <input type="hidden" id="mainId" value="{{ $viewContractor[0]->id }}" />
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Close</button>
                <button type="button" onclick="addDetails()" class="btn btn-success"><i class="fas fa-plus"></i> Add </button>
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
    $("#validate").hide();

    const addDetails = () => {
        
    }
</script>
@endsection