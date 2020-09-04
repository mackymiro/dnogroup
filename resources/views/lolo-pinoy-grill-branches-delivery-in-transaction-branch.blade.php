@extends('layouts.lolo-pinoy-grill-branches-app')
@section('title', 'Delivery In Transaction Branch| ')
@section('content')
<script>
    $(function(){
      $( ".datepicker" ).datepicker();
      $('table.display').DataTable( {} );
    });
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div id="wrapper">
    <!-- Sidebar -->
    @include('sidebar.sidebar-lolo-pinoy-grill-branches')
    <div id="content-wrapper">
        <div class="container-fluid">
             <!-- Breadcrumbs-->
             <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lolo Pinoy Grill Branches</a>
              </li>
              <li class="breadcrumb-item active">{{ Session::get('sessionDeliveryInTransaction') }}</li>
                 
              <li class="breadcrumb-item active">Delivery In Transaction Branch</li> 
            </ol> 
            <div class="col-lg-12">
            	<img src="{{ asset('images/digitized-logos/lolo-pinoy-grill.png')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lolo Pinoy Grill ">
            	 
            	 <h4 class="text-center"><u>DELIVERY IN TRANSACTION</u></h4>
                   
            </div>   
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            {{ Session::get('sessionDeliveryInTransaction') }} Branch
                            <div class="float-right">
                                <form action="{{ action('LoloPinoyGrillBranchesController@logoutDeliveryIn') }}" method="post">
                                     {{ csrf_field() }}
                                     <button type="submit" class="btn btn-danger btn-lg"><i class="fas fa-sign-out-alt"></i> Log Out</button>
                                </form>
                            </div>  
                        </div>
                        <div class="card-body">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deliveryIn">
                              Delivery In Form
                            </button>
                            <br>
                    			 <br>
                            @if($data === "Urgello")
                			 	    <div class="table-responsive">
                                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                      <thead>
                                          <th>Action</th>
                                          <th>Date</th>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Price</th>
                                          <th>Qty</th>
                                          <th>IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </thead>
                                      <tfoot>
                                          <th>Action</th>
                                          <th>Date</th>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Price</th>
                                          <th>Qty</th>
                                          <th>IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </tfoot>
                                      <tbody>
                                          @foreach($getDeliveryBranches as $getDeliveryBranchUrgello)
                                          <tr id="{{ $getDeliveryBranchUrgello->id}}">
                                            <td>
                                            	<!-- Button trigger modal -->
									                            <a data-toggle="modal" data-target="#deliveryBranch<?php echo $getDeliveryBranchUrgello->id?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
											                        @if(Auth::user()['role_type'] != 3 && Auth::user()['role_type'] != 2)
                                              <a id="delete" href="javascript:void" onClick="confirmDelete('{{ $getDeliveryBranchUrgello->id }}')" title="Delete"><i class="fas fa-trash"></i></a>
                                              @endif
                                            </td>
                                            <td>{{ $getDeliveryBranchUrgello->date}}</td>
                                            <td>{{ $getDeliveryBranchUrgello->product_id_no}}</td>
                                            <td>{{ $getDeliveryBranchUrgello->dr_no}}</td>
                                            <td>{{ $getDeliveryBranchUrgello->supplier}}</td>
                                            <td>{{ $getDeliveryBranchUrgello->product_name}}</td>
                                            <td>₱ <?php echo number_format($getDeliveryBranchUrgello->price, 2)?></td>
                                            <td>{{ $getDeliveryBranchUrgello->qty}}</td>
                                            <td><?php echo number_format($getDeliveryBranchUrgello->product_in, 2)?></td>
                                            <td>{{ $getDeliveryBranchUrgello->unit}}</td>
                                            <td><?php echo number_format($getDeliveryBranchUrgello->amount, 2)?></td>
                                            <td>{{ $getDeliveryBranchUrgello->created_by}}</td>
                                          </tr>
                                          @endforeach
                                      </tbody>
                                  </table>
                            </div>
                            @elseif($data === "Velez")
                            <div class="table-responsive">
                                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                      <thead>
                                          <th>Action</th>
                                          <th>Date</th>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Price</th>
                                          <th>Qty</th>
                                          <th>IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </thead>
                                      <tfoot>
                                          <th>Action</th>
                                          <th>Date</th>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Price</th>
                                          <th>Qty</th>
                                          <th>IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </tfoot>
                                      <tbody>
                                          @foreach($getDeliveryBranches as $getDeliveryBranchVelez)
                                          <tr id="{{ $getDeliveryBranchVelez->id }}">
                                            <td>
                                            	<!-- Button trigger modal -->
									                            <a data-toggle="modal" data-target="#deliveryBranch<?php echo $getDeliveryBranchVelez->id?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
											                        @if(Auth::user()['role_type'] != 3 && Auth::user()['role_type'] != 2)
                                              <a id="delete" href="javascript:void" onClick="confirmDelete('{{ $getDeliveryBranchVelez->id }}')" title="Delete"><i class="fas fa-trash"></i></a>
                                              @endif
                                            </td>
                                            <td>{{ $getDeliveryBranchVelez->date}}</td>
                                            <td>{{ $getDeliveryBranchVelez->product_id_no}}</td>
                                            <td>{{ $getDeliveryBranchVelez->dr_no}}</td>
                                            <td>{{ $getDeliveryBranchVelez->supplier}}</td>
                                            <td>{{ $getDeliveryBranchVelez->product_name}}</td>
                                            <td>₱ <?php echo number_format($getDeliveryBranchVelez->price, 2)?></td>
                                            <td>{{ $getDeliveryBranchVelez->qty}}</td>
                                            <td><?php echo number_format($getDeliveryBranchVelez->product_in, 2)?></td>
                                            <td>{{ $getDeliveryBranchVelez->unit}}</td>
                                            <td><?php echo number_format($getDeliveryBranchVelez->amount, 2)?></td>
                                            <td>{{ $getDeliveryBranchVelez->created_by}}</td>
                                          </tr>
                                          @endforeach
                                      </tbody>
                                  </table>
                            </div>
                            @elseif($data == "Banilad")
                            <div class="table-responsive">
                                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                      <thead>
                                          <th>Action</th>
                                          <th>Date</th>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Price</th>
                                          <th>Qty</th>
                                          <th>IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </thead>
                                      <tfoot>
                                          <th>Action</th>
                                          <th>Date</th>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Price</th>
                                          <th>Qty</th>
                                          <th>IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </tfoot>
                                      <tbody>
                                          @foreach($getDeliveryBranches as $getDeliveryBranchBanilad)
                                          <tr id="{{ $getDeliveryBranchBanilad->id }}">
                                            <td>
                                            	<!-- Button trigger modal -->
									                            <a data-toggle="modal" data-target="#deliveryBranch<?php echo $getDeliveryBranchBanilad->id?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
											                        @if(Auth::user()['role_type'] != 3 && Auth::user()['role_type'] != 2)
                                              <a id="delete" href="javascript:void" onClick="confirmDelete('{{ $getDeliveryBranchBanilad->id }}')" title="Delete"><i class="fas fa-trash"></i></a>
                                              @endif
                                            </td>
                                            <td>{{ $getDeliveryBranchBanilad->date}}</td>
                                            <td>{{ $getDeliveryBranchBanilad->product_id_no}}</td>
                                            <td>{{ $getDeliveryBranchBanilad->dr_no}}</td>
                                            <td>{{ $getDeliveryBranchBanilad->supplier}}</td>
                                            <td>{{ $getDeliveryBranchBanilad->product_name}}</td>
                                            <td>₱ <?php echo number_format($getDeliveryBranchBanilad->price, 2)?></td>
                                            <td>{{ $getDeliveryBranchBanilad->qty}}</td>
                                            <td><?php echo number_format($getDeliveryBranchBanilad->product_in, 2)?></td>
                                            <td>{{ $getDeliveryBranchBanilad->unit}}</td>
                                            <td><?php echo number_format($getDeliveryBranchBanilad->amount, 2)?></td>
                                            <td>{{ $getDeliveryBranchBanilad->created_by}}</td>
                                          </tr>
                                          @endforeach
                                      </tbody>
                                  </table>
                            </div>
                            @elseif($data  == "GQS")
                            <div class="table-responsive">
                                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                      <thead>
                                          <th>Action</th>
                                          <th>Date</th>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Price</th>
                                          <th>Qty</th>
                                          <th>IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </thead>
                                      <tfoot>
                                          <th>Action</th>
                                          <th>Date</th>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Price</th>
                                          <th>Qty</th>
                                          <th>IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </tfoot>
                                      <tbody>
                                          @foreach($getDeliveryBranches as $getDeliveryBranchGqs)
                                          <tr id="{{ $getDeliveryBranchGqs->id }}">
                                            <td>
                                            	<!-- Button trigger modal -->
									                            <a data-toggle="modal" data-target="#deliveryBranch<?php echo $getDeliveryBranchGqs->id?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
											                        @if(Auth::user()['role_type'] != 3 && Auth::user()['role_type'] != 2)
                                              <a id="delete" href="javascript:void" onClick="confirmDelete('{{ $getDeliveryBranchGqs->id }}')" title="Delete"><i class="fas fa-trash"></i></a>
                                              @endif
                                            </td>
                                            <td>{{ $getDeliveryBranchGqs->date}}</td>
                                            <td>{{ $getDeliveryBranchGqs->product_id_no}}</td>
                                            <td>{{ $getDeliveryBranchGqs->dr_no}}</td>
                                            <td>{{ $getDeliveryBranchGqs->supplier}}</td>
                                            <td>{{ $getDeliveryBranchGqs->product_name}}</td>
                                            <td>₱ <?php echo number_format($getDeliveryBranchGqs->price, 2)?></td>
                                            <td>{{ $getDeliveryBranchGqs->qty}}</td>
                                            <td><?php echo number_format($getDeliveryBranchGqs->product_in, 2)?></td>
                                            <td>{{ $getDeliveryBranchGqs->unit}}</td>
                                            <td><?php echo number_format($getDeliveryBranchGqs->amount, 2)?></td>
                                            <td>{{ $getDeliveryBranchGqs->created_by}}</td>
                                          </tr>
                                          @endforeach
                                      </tbody>
                                  </table>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                 <div class="col-lg-12">
                     <div class="card mb-3">
                       <div class="card-header">
                            <i class="fas fa-glass-cheers"></i> 
                            Beverages
                        </div>
                        <div class="card-body">
                             <!-- Button trigger modal -->
                             <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deliveryInDrinks">
                              Delivery In Form
                            </button>
                            <br>
                            <br>
                            @if($data === "Urgello")
                            <div class="table-responsive">
                                <table class="table table-bordered display" width="100%" cellspacing="0">
                                       <thead>
                                          <th>Action</th>
                                          <th>Date</th>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Price</th>
                                          <th>Qty</th>
                                          <th>IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </thead>
                                      <tfoot>
                                          <th>Action</th>
                                          <th>Date</th>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Price</th>
                                          <th>Qty</th>
                                          <th>IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </tfoot>
                                      <tbody>
                                          @foreach($getDeliveryBranchDrinks as $getDeliveryBranchUrgello)
                                          <tr id="{{ $getDeliveryBranchUrgello->id}}">
                                            <td>
                                            	<!-- Button trigger modal -->
									                            <a data-toggle="modal" data-target="#deliveryBranch<?php echo $getDeliveryBranchUrgello->id?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
											                        @if(Auth::user()['role_type'] != 3 && Auth::user()['role_type'] != 2)
                                              <a id="delete" href="javascript:void" onClick="confirmDelete('{{ $getDeliveryBranchUrgello->id }}')" title="Delete"><i class="fas fa-trash"></i></a>
                                              @endif
                                            </td>
                                            <td>{{ $getDeliveryBranchUrgello->date}}</td>
                                            <td>{{ $getDeliveryBranchUrgello->product_id_no}}</td>
                                            <td>{{ $getDeliveryBranchUrgello->dr_no}}</td>
                                            <td>{{ $getDeliveryBranchUrgello->supplier}}</td>
                                            <td>{{ $getDeliveryBranchUrgello->product_name}}</td>
                                            <td>₱ <?php echo number_format($getDeliveryBranchUrgello->price, 2)?></td>
                                            <td>{{ $getDeliveryBranchUrgello->qty}}</td>
                                            <td><?php echo number_format($getDeliveryBranchUrgello->product_in, 2)?></td>
                                            <td>{{ $getDeliveryBranchUrgello->unit}}</td>
                                            <td><?php echo number_format($getDeliveryBranchUrgello->amount, 2)?></td>
                                            <td>{{ $getDeliveryBranchUrgello->created_by}}</td>
                                          </tr>
                                          @endforeach
                                      </tbody>
                                </table>
                            </div>
                            @elseif($data === "Velez")
                            <div class="table-responsive">
                                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                      <thead>
                                          <th>Action</th>
                                          <th>Date</th>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Price</th>
                                          <th>Qty</th>
                                          <th>IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </thead>
                                      <tfoot>
                                          <th>Action</th>
                                          <th>Date</th>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Price</th>
                                          <th>Qty</th>
                                          <th>IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </tfoot>
                                      <tbody>
                                          @foreach($getDeliveryBranchDrinks as $getDeliveryBranchVelez)
                                          <tr id="{{ $getDeliveryBranchVelez->id }}">
                                            <td>
                                            	<!-- Button trigger modal -->
									                            <a data-toggle="modal" data-target="#deliveryBranch<?php echo $getDeliveryBranchVelez->id?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
											                        @if(Auth::user()['role_type'] != 3 && Auth::user()['role_type'] != 2)
                                              <a id="delete" href="javascript:void" onClick="confirmDelete('{{ $getDeliveryBranchVelez->id }}')" title="Delete"><i class="fas fa-trash"></i></a>
                                              @endif
                                            </td>
                                            <td>{{ $getDeliveryBranchVelez->date}}</td>
                                            <td>{{ $getDeliveryBranchVelez->product_id_no}}</td>
                                            <td>{{ $getDeliveryBranchVelez->dr_no}}</td>
                                            <td>{{ $getDeliveryBranchVelez->supplier}}</td>
                                            <td>{{ $getDeliveryBranchVelez->product_name}}</td>
                                            <td>₱ <?php echo number_format($getDeliveryBranchVelez->price, 2)?></td>
                                            <td>{{ $getDeliveryBranchVelez->qty}}</td>
                                            <td><?php echo number_format($getDeliveryBranchVelez->product_in, 2)?></td>
                                            <td>{{ $getDeliveryBranchVelez->unit}}</td>
                                            <td><?php echo number_format($getDeliveryBranchVelez->amount, 2)?></td>
                                            <td>{{ $getDeliveryBranchVelez->created_by}}</td>
                                          </tr>
                                          @endforeach
                                      </tbody>
                                  </table>
                            </div>
                            @elseif($data == "Banilad")
                            <div class="table-responsive">
                                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                      <thead>
                                          <th>Action</th>
                                          <th>Date</th>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Price</th>
                                          <th>Qty</th>
                                          <th>IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </thead>
                                      <tfoot>
                                          <th>Action</th>
                                          <th>Date</th>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Price</th>
                                          <th>Qty</th>
                                          <th>IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </tfoot>
                                      <tbody>
                                          @foreach($getDeliveryBranchDrinks as $getDeliveryBranchBanilad)
                                          <tr id="{{ $getDeliveryBranchBanilad->id }}">
                                            <td>
                                            	<!-- Button trigger modal -->
									                            <a data-toggle="modal" data-target="#deliveryBranch<?php echo $getDeliveryBranchBanilad->id?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
											                        @if(Auth::user()['role_type'] != 3 && Auth::user()['role_type'] != 2)
                                              <a id="delete" href="javascript:void" onClick="confirmDelete('{{ $getDeliveryBranchBanilad->id }}')" title="Delete"><i class="fas fa-trash"></i></a>
                                              @endif
                                            </td>
                                            <td>{{ $getDeliveryBranchBanilad->date}}</td>
                                            <td>{{ $getDeliveryBranchBanilad->product_id_no}}</td>
                                            <td>{{ $getDeliveryBranchBanilad->dr_no}}</td>
                                            <td>{{ $getDeliveryBranchBanilad->supplier}}</td>
                                            <td>{{ $getDeliveryBranchBanilad->product_name}}</td>
                                            <td>₱ <?php echo number_format($getDeliveryBranchBanilad->price, 2)?></td>
                                            <td>{{ $getDeliveryBranchBanilad->qty}}</td>
                                            <td><?php echo number_format($getDeliveryBranchBanilad->product_in, 2)?></td>
                                            <td>{{ $getDeliveryBranchBanilad->unit}}</td>
                                            <td><?php echo number_format($getDeliveryBranchBanilad->amount, 2)?></td>
                                            <td>{{ $getDeliveryBranchBanilad->created_by}}</td>
                                          </tr>
                                          @endforeach
                                      </tbody>
                                  </table>
                            </div>
                            @elseif($data  == "GQS")
                            <div class="table-responsive">
                                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                      <thead>
                                          <th>Action</th>
                                          <th>Date</th>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Price</th>
                                          <th>Qty</th>
                                          <th>IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </thead>
                                      <tfoot>
                                          <th>Action</th>
                                          <th>Date</th>
                                          <th>Product ID</th>
                                          <th>DR No</th>
                                          <th>Supplier</th>
                                          <th>Product Name</th>
                                          <th>Price</th>
                                          <th>Qty</th>
                                          <th>IN</th>
                                          <th>Unit</th>
                                          <th>Amount</th>
                                          <th>Created By</th>
                                      </tfoot>
                                      <tbody>
                                          @foreach($getDeliveryBranchDrinks as $getDeliveryBranchGqs)
                                          <tr id="{{ $getDeliveryBranchGqs->id }}">
                                            <td>
                                            	<!-- Button trigger modal -->
									                            <a data-toggle="modal" data-target="#deliveryBranch<?php echo $getDeliveryBranchGqs->id?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
											                        @if(Auth::user()['role_type'] != 3 && Auth::user()['role_type'] != 2)
                                              <a id="delete" href="javascript:void" onClick="confirmDelete('{{ $getDeliveryBranchGqs->id }}')" title="Delete"><i class="fas fa-trash"></i></a>
                                              @endif
                                            </td>
                                            <td>{{ $getDeliveryBranchGqs->date}}</td>
                                            <td>{{ $getDeliveryBranchGqs->product_id_no}}</td>
                                            <td>{{ $getDeliveryBranchGqs->dr_no}}</td>
                                            <td>{{ $getDeliveryBranchGqs->supplier}}</td>
                                            <td>{{ $getDeliveryBranchGqs->product_name}}</td>
                                            <td>₱ <?php echo number_format($getDeliveryBranchGqs->price, 2)?></td>
                                            <td>{{ $getDeliveryBranchGqs->qty}}</td>
                                            <td><?php echo number_format($getDeliveryBranchGqs->product_in, 2)?></td>
                                            <td>{{ $getDeliveryBranchGqs->unit}}</td>
                                            <td><?php echo number_format($getDeliveryBranchGqs->amount, 2)?></td>
                                            <td>{{ $getDeliveryBranchGqs->created_by}}</td>
                                          </tr>
                                          @endforeach
                                      </tbody>
                                  </table>
                            </div>
                            @endif
                        </div>  
                     </div>
                 </div>
            </div>
        </div>
    </div>
       <!-- Modal -->
    @foreach($getDeliveryBranches as $getDeliveryBranchGqs)
    <div class="modal fade" id="deliveryBranch{{ $getDeliveryBranchGqs->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Edit Delivery In</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="succUp{{ $getDeliveryBranchGqs->id}}"></div>
            <div class="form-group">
              <div class="form-row"> 
                <div class="col-lg-2">
                  <label>Date</label>
                  <input type="text" id="dateUpdate{{ $getDeliveryBranchGqs->id }}" name="date" class="datepicker form-control"  value="{{ $getDeliveryBranchGqs->date}}" />
                </div>
                <div class="col-lg-2">
                  <label>Product ID</label>
                  <input type="text"  name="productId" class="form-control" value="{{ $getDeliveryBranchGqs->product_id_no}}" disabled />
                </div>
                <div class="col-lg-2">
                  <label>DR No</label>
                  <input type="text" id="drNoUpdate{{ $getDeliveryBranchGqs->id }}" name="drNo" class="form-control" value="{{ $getDeliveryBranchGqs->dr_no }}" />
                </div>
                <div class="col-lg-4">
                  <label>Supplier</label>
                  <input type="text" id="supplierUpdate{{ $getDeliveryBranchGqs->id }}" name="supplier" class="form-control" value="{{ $getDeliveryBranchGqs->supplier}}" />
                </div>
                <div class="col-lg-4">
                  <label>Product Name</label>
                  <input type="text" id="productNameUpdate{{ $getDeliveryBranchGqs->id }}" name="productName" class="form-control" value="{{ $getDeliveryBranchGqs->product_name }}" />
                </div>
                <div class="col-lg-4">
                  <label>Price</label>
                  <input type="text" id="priceUpdate{{ $getDeliveryBranchGqs->id }}" name="price" class="form-control" value="{{ $getDeliveryBranchGqs->price }}" onkeypress="return isNumber(event)" />
                </div>
                <div class="col-lg-2">
                  <label>Qty</label>
                  <input type="text" id="qtyUpdate{{ $getDeliveryBranchGqs->id}}" name="qty" class="form-control" value="{{ $getDeliveryBranchGqs->qty }}" onkeypress="return isNumber(event)" />
                </div>
                <div class="col-lg-2">
                  <label>IN</label>
                  <input type="text" id="productInUpdate{{ $getDeliveryBranchGqs->id}}" name="productIn" class="form-control" value="{{ $getDeliveryBranchGqs->product_in }}" onkeypress="return isNumber(event)" />
                </div>
                <div class="col-lg-4">
                  <label>Unit</label>
                  <input type="text" id="unitUpdate{{ $getDeliveryBranchGqs->id}}" name="unit" class="form-control" value="{{ $getDeliveryBranchGqs->unit}}" />
                </div>
                <div class="col-lg-4">
                  <label>Amount</label>
                  <input type="text" id="amountUpdate{{ $getDeliveryBranchGqs->id}}" name="amount" class="form-control" value="{{ $getDeliveryBranchGqs->amount }}" onkeypress="return isNumber(event)" />
                </div>

              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
            <button type="button" onclick="updateDeliveryIn(<?php echo $getDeliveryBranchGqs->id; ?>)" class="btn btn-success btn-lg">Update</button>
          </div>
        </div>
      </div>
    </div>  
    @endforeach
     <!-- Modal -->
     @foreach($getDeliveryBranches as $getDeliveryBranchBanilad)
    <div class="modal fade" id="deliveryBranch{{ $getDeliveryBranchBanilad->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Edit Delivery In</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="succUp{{ $getDeliveryBranchBanilad->id}}"></div>
            <div class="form-group">
              <div class="form-row"> 
                <div class="col-lg-2">
                  <label>Date</label>
                  <input type="text" id="dateUpdate{{ $getDeliveryBranchBanilad->id }}" name="date" class="datepicker form-control"  value="{{ $getDeliveryBranchBanilad->date}}" />
                </div>
                <div class="col-lg-2">
                  <label>Product ID</label>
                  <input type="text"  name="productId" class="form-control" value="{{ $getDeliveryBranchBanilad->product_id_no}}" disabled />
                </div>
                <div class="col-lg-2">
                  <label>DR No</label>
                  <input type="text" id="drNoUpdate{{ $getDeliveryBranchBanilad->id }}" name="drNo" class="form-control" value="{{ $getDeliveryBranchBanilad->dr_no }}" />
                </div>
                <div class="col-lg-4">
                  <label>Supplier</label>
                  <input type="text" id="supplierUpdate{{ $getDeliveryBranchBanilad->id }}" name="supplier" class="form-control" value="{{ $getDeliveryBranchBanilad->supplier}}" />
                </div>
                <div class="col-lg-4">
                  <label>Product Name</label>
                  <input type="text" id="productNameUpdate{{ $getDeliveryBranchBanilad->id }}" name="productName" class="form-control" value="{{ $getDeliveryBranchBanilad->product_name }}" />
                </div>
                <div class="col-lg-4">
                  <label>Price</label>
                  <input type="text" id="priceUpdate{{ $getDeliveryBranchBanilad->id }}" name="price" class="form-control" value="{{ $getDeliveryBranchBanilad->price }}" onkeypress="return isNumber(event)"/>
                </div>
                <div class="col-lg-2">
                  <label>Qty</label>
                  <input type="text" id="qtyUpdate{{ $getDeliveryBranchBanilad->id}}" name="qty" class="form-control" value="{{ $getDeliveryBranchBanilad->qty }}" onkeypress="return isNumber(event)" />
                </div>
                <div class="col-lg-2">
                  <label>IN</label>
                  <input type="text" id="productInUpdate{{ $getDeliveryBranchBanilad->id}}" name="productIn" class="form-control" value="{{ $getDeliveryBranchBanilad->product_in }}" onkeypress="return isNumber(event)" />
                </div>
                <div class="col-lg-4">
                  <label>Unit</label>
                  <input type="text" id="unitUpdate{{ $getDeliveryBranchBanilad->id}}" name="unit" class="form-control" value="{{ $getDeliveryBranchBanilad->unit}}" />
                </div>
                <div class="col-lg-4">
                  <label>Amount</label>
                  <input type="text" id="amountUpdate{{ $getDeliveryBranchBanilad->id}}" name="amount" class="form-control" value="{{ $getDeliveryBranchBanilad->amount }}" onkeypress="return isNumber(event)" />
                </div>

              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
            <button type="button" onclick="updateDeliveryIn(<?php echo $getDeliveryBranchBanilad->id; ?>)" class="btn btn-success btn-lg">Update</button>
          </div>
        </div>
      </div>
    </div>  
    @endforeach

     <!-- Modal -->
     @foreach($getDeliveryBranches as $getDeliveryBranchVelez)
    <div class="modal fade" id="deliveryBranch{{ $getDeliveryBranchVelez->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Edit Delivery In</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="succUp{{ $getDeliveryBranchVelez->id}}"></div>
            <div class="form-group">
              <div class="form-row"> 
                <div class="col-lg-2">
                  <label>Date</label>
                  <input type="text" id="dateUpdate{{ $getDeliveryBranchVelez->id }}" name="date" class="datepicker form-control"  value="{{ $getDeliveryBranchVelez->date}}" />
                </div>
                <div class="col-lg-2">
                  <label>Product ID</label>
                  <input type="text"  name="productId" class="form-control" value="{{ $getDeliveryBranchVelez->product_id_no}}" disabled />
                </div>
                <div class="col-lg-2">
                  <label>DR No</label>
                  <input type="text" id="drNoUpdate{{ $getDeliveryBranchVelez->id }}" name="drNo" class="form-control" value="{{ $getDeliveryBranchVelez->dr_no }}" />
                </div>
                <div class="col-lg-4">
                  <label>Supplier</label>
                  <input type="text" id="supplierUpdate{{ $getDeliveryBranchVelez->id }}" name="supplier" class="form-control" value="{{ $getDeliveryBranchVelez->supplier}}" />
                </div>
                <div class="col-lg-4">
                  <label>Product Name</label>
                  <input type="text" id="productNameUpdate{{ $getDeliveryBranchVelez->id }}" name="productName" class="form-control" value="{{ $getDeliveryBranchVelez->product_name }}" />
                </div>
                <div class="col-lg-4">
                  <label>Price</label>
                  <input type="text" id="priceUpdate{{ $getDeliveryBranchVelez->id }}" name="price" class="form-control" value="{{ $getDeliveryBranchVelez->price }}" onkeypress="return isNumber(event)"/>
                </div>
                <div class="col-lg-2">
                  <label>Qty</label>
                  <input type="text" id="qtyUpdate{{ $getDeliveryBranchVelez->id}}" name="qty" class="form-control" value="{{ $getDeliveryBranchVelez->qty }}" onkeypress="return isNumber(event)" />
                </div>
                <div class="col-lg-2">
                  <label>IN</label>
                  <input type="text" id="productInUpdate{{ $getDeliveryBranchVelez->id}}" name="productIn" class="form-control" value="{{ $getDeliveryBranchVelez->product_in }}" onkeypress="return isNumber(event)" />
                </div>
                <div class="col-lg-4">
                  <label>Unit</label>
                  <input type="text" id="unitUpdate{{ $getDeliveryBranchVelez->id}}" name="unit" class="form-control" value="{{ $getDeliveryBranchVelez->unit}}" />
                </div>
                <div class="col-lg-4">
                  <label>Amount</label>
                  <input type="text" id="amountUpdate{{ $getDeliveryBranchVelez->id}}" name="amount" class="form-control" value="{{ $getDeliveryBranchVelez->amount }}" onkeypress="return isNumber(event)" />
                </div>

              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
            <button type="button" onclick="updateDeliveryIn(<?php echo $getDeliveryBranchVelez->id; ?>)" class="btn btn-success btn-lg">Update</button>
          </div>
        </div>
      </div>
    </div>  
    @endforeach
    <!-- Modal -->
    @foreach($getDeliveryBranches as $getDeliveryBranchUrgello)
    <div class="modal fade" id="deliveryBranch{{ $getDeliveryBranchUrgello->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Edit Delivery In</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="succUp{{ $getDeliveryBranchUrgello->id}}"></div>
            <div class="form-group">
              <div class="form-row"> 
                <div class="col-lg-2">
                  <label>Date</label>
                  <input type="text" id="dateUpdate{{ $getDeliveryBranchUrgello->id }}" name="date" class="datepicker form-control"  value="{{ $getDeliveryBranchUrgello->date}}" />
                </div>
                <div class="col-lg-2">
                  <label>Product ID</label>
                  <input type="text"  name="productId" class="form-control" value="{{ $getDeliveryBranchUrgello->product_id_no}}" disabled />
                </div>
                <div class="col-lg-2">
                  <label>DR No</label>
                  <input type="text" id="drNoUpdate{{ $getDeliveryBranchUrgello->id }}" name="drNo" class="form-control" value="{{ $getDeliveryBranchUrgello->dr_no }}" />
                </div>
                <div class="col-lg-4">
                  <label>Supplier</label>
                  <input type="text" id="supplierUpdate{{ $getDeliveryBranchUrgello->id }}" name="supplier" class="form-control" value="{{ $getDeliveryBranchUrgello->supplier}}" />
                </div>
                <div class="col-lg-4">
                  <label>Product Name</label>
                  <input type="text" id="productNameUpdate{{ $getDeliveryBranchUrgello->id }}" name="productName" class="form-control" value="{{ $getDeliveryBranchUrgello->product_name }}" />
                </div>
                <div class="col-lg-4">
                  <label>Price</label>
                  <input type="text" id="priceUpdate{{ $getDeliveryBranchUrgello->id }}" name="price" class="form-control" value="{{ $getDeliveryBranchUrgello->price }}" onkeypress="return isNumber(event)" />
                </div>
                <div class="col-lg-2">
                  <label>Qty</label>
                  <input type="text" id="qtyUpdate{{ $getDeliveryBranchUrgello->id}}" name="qty" class="form-control" value="{{ $getDeliveryBranchUrgello->qty }}" onkeypress="return isNumber(event)" />
                </div>
                <div class="col-lg-2">
                  <label>IN</label>
                  <input type="text" id="productInUpdate{{ $getDeliveryBranchUrgello->id}}" name="productIn" class="form-control" value="{{ $getDeliveryBranchUrgello->product_in }}" onkeypress="return isNumber(event)" />
                </div>
                <div class="col-lg-4">
                  <label>Unit</label>
                  <input type="text" id="unitUpdate{{ $getDeliveryBranchUrgello->id}}" name="unit" class="form-control" value="{{ $getDeliveryBranchUrgello->unit}}" />
                </div>
                <div class="col-lg-4">
                  <label>Amount</label>
                  <input type="text" id="amountUpdate{{ $getDeliveryBranchUrgello->id}}" name="amount" class="form-control" value="{{ $getDeliveryBranchUrgello->amount }}" onkeypress="return isNumber(event)" />
                </div>

              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
            <button type="button" onclick="updateDeliveryIn(<?php echo $getDeliveryBranchUrgello->id; ?>)" class="btn btn-success btn-lg">Update</button>
          </div>
        </div>
      </div>
    </div>  
    @endforeach

     <!-- Modal -->
     <div class="modal fade" id="deliveryInDrinks" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Delivery In Beverages -  {{ Session::get('sessionDeliveryInTransaction') }} Branch</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="succAdd"></div>
            <div id="validate" class="col-lg-12">
              <p class="alert alert-danger">Please fill up field</p>
            </div>
            <div class="form-group">
              <div class="form-row">
                  <div class="col-lg-2">
                    <label>Date</label>
                    <input type="text" id="date" name="date" class="datepicker form-control" required/>
                  </div>
                  <div class="col-lg-2">
                    <label>DR No</label>
                    <input type="text" id="drNo" name="drNo" class="form-control" required />
                  </div>
                  <div class="col-lg-4">
                    <label>Supplier</label>
                    <input type="text" id="supplier" name="supplier" class="form-control" />
                  </div>
                  <div class="col-lg-4">
                    <label>Product Name</label>
                    <input type="text" id="productName" name="productName" class="form-control" />
                  </div>
                  <div class="col-lg-4">
                    <label>Price</label>
                    <input type="text" id="price" name="price" class="form-control" onkeypress="return isNumber(event)"  />
                  </div>
                  <div class="col-lg-2">
                    <label>Qty</label>
                    <input type="text" id="qty" name="qty" class="form-control" onkeypress="return isNumber(event)" />
                  </div>
                  <div class="col-lg-2">
                    <label>Unit</label>
                    <input type="text" id="unit" name="unit" class="form-control" />
                  </div>
                  <div class="col-lg-2">
                    <label>IN</label>
                    <input type="text" id="productIn" name="productIn" class="form-control" onkeypress="return isNumber(event)" />
                  </div>
                  <div class="col-lg-2">
                    <label>Amount</label>
                    <input type="text" id="amount" name="amount" class="form-control" onkeypress="return isNumber(event)"/>
                  </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" id="branchName" value="{{ Session::get('sessionDeliveryInTransaction') }}" />
            <input type="hidden" id="flag" value="Drinks" /> 
            <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
            <button type="button" onclick="saveDeliveryInDrinks()" class="btn btn-success btn-lg">Save</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="deliveryIn" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Delivery In Transaction -  {{ Session::get('sessionDeliveryInTransaction') }} Branch</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="succAdd"></div>
            <div class="validate" class="col-lg-12">
              <p class="alert alert-danger">Please fill up field</p>
            </div>
            <div class="form-group">
              <div class="form-row">
                  <div class="col-lg-2">
                    <label>Date</label>
                    <input type="text"  name="date" class="date datepicker form-control" required/>
                  </div>
                  <div class="col-lg-2">
                    <label>DR No</label>
                    <input type="text" name="drNo" class="drNo form-control" required />
                  </div>
                  <div class="col-lg-4">
                    <label>Supplier</label>
                    <input type="text" name="supplier" class="supplier form-control" />
                  </div>
                  <div class="col-lg-4">
                    <label>Product Name</label>
                    <input type="text"  name="productName" class="productName form-control" />
                  </div>
                  <div class="col-lg-4">
                    <label>Price</label>
                    <input type="text"  name="price" class="price form-control" onkeypress="return isNumber(event)"  />
                  </div>
                  <div class="col-lg-2">
                    <label>Qty</label>
                    <input type="text"  name="qty" class="qty form-control" onkeypress="return isNumber(event)" />
                  </div>
                  <div class="col-lg-2">
                    <label>Unit</label>
                    <input type="text"  name="unit" class="unit form-control" />
                  </div>
                  <div class="col-lg-2">
                    <label>IN</label>
                    <input type="text" name="productIn" class="productIn form-control" onkeypress="return isNumber(event)" />
                  </div>
                  <div class="col-lg-2">
                    <label>Amount</label>
                    <input type="text"  name="amount" class="amount form-control" onkeypress="return isNumber(event)"/>
                  </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" class="branchName" value="{{ Session::get('sessionDeliveryInTransaction') }}" />
            <input type="hidden" class="flag" value="Foods"/>
            <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
            <button type="button" onclick="saveDeliveryIn()" class="btn btn-success btn-lg">Save</button>
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
    $(".validate").hide();

    const saveDeliveryInDrinks = () =>{
        const date = $("#date").val();
        const drNo = $("#drNo").val();
        const supplier = $("#supplier").val();
        const productName = $("#productName").val();
        const price = $("#price").val();
        const qty = $("#qty").val();
        const unit = $("#unit").val();
        const productIn = $("#productIn").val();
        const amount = $("#amount").val();
        const branchName = $("#branchName").val();
        const flag = $("#flag").val();

        if(date.length === 0 || supplier.length === 0){
          $("#validate").fadeIn().delay(3000).fadeOut();
        }else{
            //make ajax call
            $.ajax({
                type: "POST",
                url: '/lolo-pinoy-grill-branches/store-delivery-in',
                data:{
                  _method: 'post',
                  "_token": "{{ csrf_token() }}",
                  "date":date,
                  "drNo":drNo,
                  "supplier":supplier,
                  "productName":productName,
                  "price":price,
                  "qty":qty,
                  "unit":unit,
                  "productIn":productIn,
                  "amount":amount,
                  "branchName":branchName,
                  "flag":flag,
                },
                success: function(data){
                  console.log(data);
                  const getData = data;
                  const succData = getData.split(":");
                  const succDataArr = succData[0];

                  if(succDataArr == "Success"){
                      $("#succAdd").fadeIn().delay(3000).fadeOut();
                      $("#succAdd").html(`<p class="alert alert-success">${data}</p>`);
                    
                      setTimeout(function(){
                        document.location.reload();
                      }, 3000);
                  }

                  $("#date").val('');
                  $("#drNo").val('');
                  $("#supplier").val('');
                  $("#productName").val('');
                  $("#price").val('');
                  $("#qty").val('');
                  $("#unit").val('');
                  $("#productIn").val('');
                  $("#amount").val('');

                },
                error: function (data){

                }
            });
        }

    }

    const updateDeliveryIn = (id) =>{
      const dateUpdate = $("#dateUpdate"+id).val();
      const drNoUpdate = $("#drNoUpdate"+id).val();
      const supplierUpdate = $("#supplierUpdate"+id).val();
      const productNameUpdate = $("#productNameUpdate"+id).val();
      const priceUpdate = $("#priceUpdate"+id).val();
      const qtyUpdate = $("#qtyUpdate"+id).val();
      const productInUpdate = $("#productInUpdate"+id).val();
      const unitUpdate = $("#unitUpdate"+id).val();
      const amountUpdate = $("#amountUpdate"+id).val();

      //make ajax call
      $.ajax({
              type: "PATCH",
              url: '/lolo-pinoy-grill-branches/update-store-delivery-in/'+id,
              data:{
                _method: 'patch',
                "_token": "{{ csrf_token() }}",
                "dateUpdate":dateUpdate,
                "drNoUpdate":drNoUpdate,
                "supplierUpdate":supplierUpdate,
                "productNameUpdate":productNameUpdate,
                "priceUpdate":priceUpdate,
                "qtyUpdate":qtyUpdate,
                "productInUpdate":productInUpdate,
                "unitUpdate":unitUpdate,
                "amountUpdate":amountUpdate,
              },
              success: function(data){
                console.log(data);
                const getData = data;
                const succData = getData.split(":");
                const succDataArr = succData[0];

                if(succDataArr == "Success"){
                  $("#succUp"+id).fadeIn().delay(3000).fadeOut();
                  $("#succUp"+id).html(`<p class="alert alert-success">${data}</p>`);
                  
                  setTimeout(function(){
                    document.location.reload();
                  }, 3000);
                }
              },
              error: function (data){
                  console.log('Error:', data);
              }
          });
     
    }

    const isNumber =(evt) => {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
          return false;
        }
        return true;
    }

    const saveDeliveryIn = () =>{
        const date = $(".date").val();
        const drNo = $(".drNo").val();
        const supplier = $(".supplier").val();
        const productName = $(".productName").val();
        const price = $(".price").val();
        const qty = $(".qty").val();
        const unit = $(".unit").val();
        const productIn = $(".productIn").val();
        const amount = $(".amount").val();
        const branchName = $(".branchName").val();
        const flag = $(".flag").val(); 

        if(date.length === 0 || supplier.length === 0){
          $(".validate").fadeIn().delay(3000).fadeOut();
        }else{
          //make ajax call
          $.ajax({
              type: "POST",
              url: '/lolo-pinoy-grill-branches/store-delivery-in',
              data:{
                _method: 'post',
                "_token": "{{ csrf_token() }}",
                "date":date,
                "drNo":drNo,
                "supplier":supplier,
                "productName":productName,
                "price":price,
                "qty":qty,
                "unit":unit,
                "productIn":productIn,
                "amount":amount,
                "branchName":branchName,
                "flag":flag,
              },
              success: function(data){
                console.log(data);
                const getData = data;
                const succData = getData.split(":");
                const succDataArr = succData[0];

                if(succDataArr == "Success"){
                  $(".succAdd").fadeIn().delay(3000).fadeOut();
                  $(".succAdd").html(`<p class="alert alert-success">${data}</p>`);
                  
                  setTimeout(function(){
                    document.location.reload();
                  }, 3000);
                }
              },
              error: function (data){
                  console.log('Error:', data);
              }
          });

        }
    }
</script>
@endsection