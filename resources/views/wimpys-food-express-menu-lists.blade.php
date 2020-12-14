@extends('layouts.wimpys-food-express-app')
@section('title', 'Menu Order |')
@section('content')
<script>
  $(document).ready(function(){
      $('.alert-success').fadeIn().delay(3000).fadeOut();
      $('table.display').DataTable( {} );
  });
</script>
<div id="wrapper">
	 @include('sidebar.sidebar-wimpys-food-express')
	 <div id="content-wrapper">

		<div class="container-fluid">
			 <!-- Breadcrumbs-->
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">Wimpy's Food Express</a>
                </li>
                <li class="breadcrumb-item ">Menu</li>
                <li class="breadcrumb-item active">Menu Lists</li>
              </ol>
              <div class="row">
              		<div class="col-lg-12">
              			<div class="card mb-3">
              				<div class="card-header">
          					  <i class="fa fa-hamburger" aria-hidden="true"></i>
          					  Menu for Packed Meals</div>
      					  	<div class="card-body">
								<!-- Button trigger modal -->
								<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#createRaw">
									Create Menu
								</button>
			                     <br>
                    			 <br>
                			 	<div class="table-responsive">
                			 		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                			 			<thead>
	  				  						<th>Action</th>
	  				  						<th class="bg-info" style="color:white">Name</th>
										
	  				  						<th>Created By</th>
			  						   </thead>
			  						   <tfoot>
				  							<th>Action</th>
                                              <th class="bg-info" style="color:white">Name</th>
	  				  						<th>Created By</th>
										</tfoot>
										<tbody>
                                            @foreach($getAllMenus as $getAllMenu)
                                                @if($getAllMenu['category'] === "Packed Meals")
                      					    <tr id="deletedId<?= $getAllMenu['id']?>">
                                                <td>
                                                     <!-- Button trigger modal -->
											   <a data-toggle="modal" data-target="#menu<?= $getAllMenu['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                               <a id="delete" onclick="confirmDelete('<?= $getAllMenu['id']?>')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                         
                                                </td>
                                                <td class="bg-info" style="color:white">{{ $getAllMenu['name'] }}</td>
                                                <td>{{ $getAllMenu['created_by'] }}</td>
                                            </tr>
                                              @endif
                                            @endforeach
			  							</tbody>
                			 		</table>
                			 	</div>
      					  	</div>
              			</div>
              		</div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                     <div class="card mb-3">
                        <div class="card-header">
          					  <i class="fa fa-hamburger" aria-hidden="true"></i>
          					  Soup</div>
                         <div class="card-body">
                            <div class="table-responsive">
                			 		<table class="display table table-bordered" width="100%" cellspacing="0">
                			 			<thead>
	  				  						<th>Action</th>
	  				  						<th class="bg-info" style="color:white">Name</th>
										
	  				  						<th>Created By</th>
			  						   </thead>
			  						   <tfoot>
				  							<th>Action</th>
                                              <th class="bg-info" style="color:white">Name</th>
	  				  						<th>Created By</th>
										</tfoot>
										<tbody>
                      					     @foreach($getAllMenus as $getAllMenu)
                                                @if($getAllMenu['category'] === "Soup")
                      					    <tr id="deletedId<?= $getAllMenu['id']?>">
                                                <td>
                                                     <!-- Button trigger modal -->
											   <a data-toggle="modal" data-target="#menu<?= $getAllMenu['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                               <a id="delete" onclick="confirmDelete('<?= $getAllMenu['id']?>')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                         
                                                </td>
                                                <td class="bg-info" style="color:white">{{ $getAllMenu['name'] }}</td>
                                                <td>{{ $getAllMenu['created_by'] }}</td>
                                            </tr>
                                              @endif
                                            @endforeach
			  							</tbody>
                			 		</table>
                			 	</div>
                         </div>
                     </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
          					  <i class="fa fa-hamburger" aria-hidden="true"></i>
          					  Drinks</div>
                            <div class="card-body">
							
                            <div class="table-responsive">
                                <table class="display table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                           <th>Action</th>
                                           <th class="bg-info" style="color:white">Name</th>
                                   
                                           <th>Created By</th>
                                    </thead>
                                    <tfoot>
                                         <th>Action</th>
                                         <th class="bg-info" style="color:white">Name</th>
                                           <th>Created By</th>
                                   </tfoot>
                                   <tbody>
                                          @foreach($getAllMenus as $getAllMenu)
                                           @if($getAllMenu['category'] === "Drinks")
                                         <tr id="deletedId<?= $getAllMenu['id']?>">
                                           <td>
                                                <!-- Button trigger modal -->
                                          <a data-toggle="modal" data-target="#menu<?= $getAllMenu['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                          <a id="delete" onclick="confirmDelete('<?= $getAllMenu['id']?>')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                    
                                           </td>
                                           <td class="bg-info" style="color:white">{{ $getAllMenu['name'] }}</td>
                                           <td>{{ $getAllMenu['created_by'] }}</td>
                                       </tr>
                                         @endif
                                       @endforeach
                                     </tbody>
                                </table>
                            </div>
                           </div>
                    </div>
                </div>  
              
              </div>
              <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
          					  <i class="fa fa-hamburger" aria-hidden="true"></i>
          					  Desserts</div>
                            <div class="card-body">
							
                			 	<div class="table-responsive">
                			 		<table class="display table table-bordered" width="100%" cellspacing="0">
                			 			<thead>
	  				  						<th>Action</th>
	  				  						<th class="bg-info" style="color:white">Name</th>
										
	  				  						<th>Created By</th>
			  						   </thead>
			  						   <tfoot>
				  							<th>Action</th>
                                              <th class="bg-info" style="color:white">Name</th>
	  				  						<th>Created By</th>
										</tfoot>
										<tbody>
                      					     @foreach($getAllMenus as $getAllMenu)
                                                @if($getAllMenu['category'] === "Desserts")
                      					    <tr id="deletedId<?= $getAllMenu['id']?>">
                                                <td>
                                                     <!-- Button trigger modal -->
											   <a data-toggle="modal" data-target="#menu<?= $getAllMenu['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                               <a id="delete" onclick="confirmDelete('<?= $getAllMenu['id']?>')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                         
                                                </td>
                                                <td class="bg-info" style="color:white">{{ $getAllMenu['name'] }}</td>
                                                <td>{{ $getAllMenu['created_by'] }}</td>
                                            </tr>
                                              @endif
                                            @endforeach
			  							</tbody>
                			 		</table>
                			 	</div>
      					  	</div>
                        </div>
                    </div>
              </div>
              <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
          					  <i class="fa fa-hamburger" aria-hidden="true"></i>
          					  Salads</div>
                            <div class="card-body">
							
                                <div class="table-responsive">
                                    <table class="display table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <th>Action</th>
                                            <th  class="bg-info" style="color:white">Name</th>
                                    
                                            <th>Created By</th>
                                        </thead>
                                        <tfoot>
                                            <th>Action</th>
                                            <th  class="bg-info" style="color:white">Name</th>
                                            <th>Created By</th>
                                    </tfoot>
                                    <tbody>
                                           @foreach($getAllMenus as $getAllMenu)
                                                @if($getAllMenu['category'] === "Salads")
                      					    <tr id="deletedId<?= $getAllMenu['id']?>">
                                                <td>
                                                     <!-- Button trigger modal -->
											   <a data-toggle="modal" data-target="#menu<?= $getAllMenu['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
											   <a id="delete" onclick="confirmDelete('<?= $getAllMenu['id']?>')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                         
                                                </td>
                                                <td class="bg-info" style="color:white">{{ $getAllMenu['name'] }}</td>
                                                <td>{{ $getAllMenu['created_by'] }}</td>
                                            </tr>
                                              @endif
                                            @endforeach
                                    </tbody>
                                    </table>
                                </div>
                           </div>
                        </div>
                    </div>
              </div>
              <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
          					  <i class="fa fa-hamburger" aria-hidden="true"></i>
          					  Rice</div>
                            <div class="card-body">
							
                                <div class="table-responsive">
                                    <table class="display table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <th>Action</th>
                                            <th  class="bg-info" style="color:white">Name</th>
                                    
                                            <th>Created By</th>
                                        </thead>
                                        <tfoot>
                                            <th>Action</th>
                                            <th  class="bg-info" style="color:white">Name</th>
                                            <th>Created By</th>
                                    </tfoot>
                                    <tbody>
                                            @foreach($getAllMenus as $getAllMenu)
                                                @if($getAllMenu['category'] === "Rice")
                      					    <tr id="deletedId<?= $getAllMenu['id']?>">
                                                <td>
                                                     <!-- Button trigger modal -->
											   <a data-toggle="modal" data-target="#menu<?= $getAllMenu['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
											   <a id="delete" onclick="confirmDelete('<?= $getAllMenu['id']?>')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                         
                                                </td>
                                                <td class="bg-info" style="color:white">{{ $getAllMenu['name'] }}</td>
                                                <td>{{ $getAllMenu['created_by'] }}</td>
                                            </tr>
                                              @endif
                                            @endforeach
                                    </tbody>
                                    </table>
                                </div>
                             </div>
                        </div>
                    </div>
              </div>
               <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
          					  <i class="fa fa-hamburger" aria-hidden="true"></i>
          					  Pasta</div>
                            <div class="card-body">
							
                                <div class="table-responsive">
                                    <table class="display table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <th>Action</th>
                                            <th class="bg-info" style="color:white">Name</th>
                                    
                                            <th>Created By</th>
                                        </thead>
                                        <tfoot>
                                            <th>Action</th>
                                            <th class="bg-info" style="color:white">Name</th>
                                            <th>Created By</th>
                                    </tfoot>
                                    <tbody>
                                        @foreach($getAllMenus as $getAllMenu)
                                                @if($getAllMenu['category'] === "Pasta")
                      					    <tr id="deletedId<?= $getAllMenu['id']?>">
                                                <td>
                                                     <!-- Button trigger modal -->
											   <a data-toggle="modal" data-target="#menu<?= $getAllMenu['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
											   <a id="delete" onclick="confirmDelete('<?= $getAllMenu['id']?>')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                         
                                                </td>
                                                <td class="bg-info" style="color:white">{{ $getAllMenu['name'] }}</td>
                                                <td>{{ $getAllMenu['created_by'] }}</td>
                                            </tr>
                                              @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>
              <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
          					  <i class="fa fa-hamburger" aria-hidden="true"></i>
          					  Noodles</div>
                            <div class="card-body">
							
                                <div class="table-responsive">
                                    <table class="display table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <th>Action</th>
                                            <th>Name</th>
                                    
                                            <th>Created By</th>
                                        </thead>
                                        <tfoot>
                                            <th>Action</th>
                                            <th>Name</th>
                                            <th>Created By</th>
                                    </tfoot>
                                    <tbody>
                                            @foreach($getAllMenus as $getAllMenu)
                                                @if($getAllMenu['category'] === "Noodles")
                      					    <tr id="deletedId<?= $getAllMenu['id']?>">
                                                <td>
                                                     <!-- Button trigger modal -->
											   <a data-toggle="modal" data-target="#menu<?= $getAllMenu['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                               <a id="delete" onclick="confirmDelete('<?= $getAllMenu['id']?>')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                         
                                                </td>
                                                <td class="bg-info" style="color:white">{{ $getAllMenu['name'] }}</td>
                                                <td>{{ $getAllMenu['created_by'] }}</td>
                                            </tr>
                                              @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>
              <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
          					  <i class="fa fa-hamburger" aria-hidden="true"></i>
          					  Vegetables</div>
                            <div class="card-body">
							
                                <div class="table-responsive">
                                    <table class="display table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <th>Action</th>
                                            <th class="bg-info" style="color:white">Name</th>
                                    
                                            <th>Created By</th>
                                        </thead>
                                        <tfoot>
                                            <th>Action</th>
                                            <th class="bg-info" style="color:white">Name</th>
                                            <th>Created By</th>
                                    </tfoot>
                                    <tbody>
                                          @foreach($getAllMenus as $getAllMenu)
                                                @if($getAllMenu['category'] === "Vegetables")
                      					    <tr id="deletedId<?= $getAllMenu['id']?>">
                                                <td>
                                                     <!-- Button trigger modal -->
											   <a data-toggle="modal" data-target="#menu<?= $getAllMenu['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                               <a id="delete" onclick="confirmDelete('<?= $getAllMenu['id']?>')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                         
                                                </td>
                                                <td class="bg-info" style="color:white">{{ $getAllMenu['name'] }}</td>
                                                <td>{{ $getAllMenu['created_by'] }}</td>
                                            </tr>
                                              @endif
                                            @endforeach
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>
              <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
          					  <i class="fa fa-hamburger" aria-hidden="true"></i>
          					  Seafood</div>
                            <div class="card-body">
							
                                <div class="table-responsive">
                                    <table class="display table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <th>Action</th>
                                            <th  class="bg-info" style="color:white">Name</th>
                                    
                                            <th>Created By</th>
                                        </thead>
                                        <tfoot>
                                            <th>Action</th>
                                            <th  class="bg-info" style="color:white">Name</th>
                                            <th>Created By</th>
                                    </tfoot>
                                    <tbody>
                                          @foreach($getAllMenus as $getAllMenu)
                                                @if($getAllMenu['category'] === "Seafood")
                      					    <tr id="deletedId<?= $getAllMenu['id']?>">
                                                <td>
                                                     <!-- Button trigger modal -->
											   <a data-toggle="modal" data-target="#menu<?= $getAllMenu['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                               <a id="delete" onclick="confirmDelete('<?= $getAllMenu['id']?>')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                         
                                                </td>
                                                <td class="bg-info" style="color:white">{{ $getAllMenu['name'] }}</td>
                                                <td>{{ $getAllMenu['created_by'] }}</td>
                                            </tr>
                                              @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>
              <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
          					  <i class="fa fa-hamburger" aria-hidden="true"></i>
          					  Pork</div>
                            <div class="card-body">
							
                                <div class="table-responsive">
                                    <table class="display table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <th>Action</th>
                                            <th class="bg-info" style="color:white">Name</th>
                                    
                                            <th>Created By</th>
                                        </thead>
                                        <tfoot>
                                            <th>Action</th>
                                            <th class="bg-info" style="color:white">Name</th>
                                            <th>Created By</th>
                                    </tfoot>
                                    <tbody>
                                        @foreach($getAllMenus as $getAllMenu)
                                                @if($getAllMenu['category'] === "Pork")
                      					    <tr id="deletedId<?= $getAllMenu['id']?>">
                                                <td>
                                                     <!-- Button trigger modal -->
											   <a data-toggle="modal" data-target="#menu<?= $getAllMenu['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                               <a id="delete" onclick="confirmDelete('<?= $getAllMenu['id']?>')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                         
                                                </td>
                                                <td class="bg-info" style="color:white">{{ $getAllMenu['name'] }}</td>
                                                <td>{{ $getAllMenu['created_by'] }}</td>
                                            </tr>
                                              @endif
                                            @endforeach
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>
              <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
          					  <i class="fa fa-hamburger" aria-hidden="true"></i>
          					  Chicken</div>
                            <div class="card-body">
							
                                <div class="table-responsive">
                                    <table class="display table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <th>Action</th>
                                            <th class="bg-info" style="color:white">Name</th>
                                    
                                            <th>Created By</th>
                                        </thead>
                                        <tfoot>
                                            <th>Action</th>
                                            <th class="bg-info" style="color:white">Name</th>
                                            <th>Created By</th>
                                    </tfoot>
                                    <tbody>
                                         @foreach($getAllMenus as $getAllMenu)
                                                @if($getAllMenu['category'] === "Chicken")
                      					    <tr id="deletedId<?= $getAllMenu['id']?>">
                                                <td>
                                                     <!-- Button trigger modal -->
											   <a data-toggle="modal" data-target="#menu<?= $getAllMenu['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                               <a id="delete" onclick="confirmDelete('<?= $getAllMenu['id']?>')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                         
                                                </td>
                                                <td class="bg-info" style="color:white">{{ $getAllMenu['name'] }}</td>
                                                <td>{{ $getAllMenu['created_by'] }}</td>
                                            </tr>
                                              @endif
                                            @endforeach
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>
              <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
          					  <i class="fa fa-hamburger" aria-hidden="true"></i>
          					  Beef</div>
                            <div class="card-body">
							
                                <div class="table-responsive">
                                    <table class="display table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <th>Action</th>
                                            <th class="bg-info" style="color:white">Name</th>
                                    
                                            <th>Created By</th>
                                        </thead>
                                        <tfoot>
                                            <th>Action</th>
                                            <th class="bg-info" style="color:white">Name</th>
                                            <th>Created By</th>
                                    </tfoot>
                                    <tbody>
                                         @foreach($getAllMenus as $getAllMenu)
                                                @if($getAllMenu['category'] === "Beef")
                      					    <tr id="deletedId<?= $getAllMenu['id']?>">
                                                <td>
                                                     <!-- Button trigger modal -->
											   <a data-toggle="modal" data-target="#menu<?= $getAllMenu['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                               <a id="delete" onclick="confirmDelete('<?= $getAllMenu['id']?>')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                         
                                                </td>
                                                <td class="bg-info" style="color:white">{{ $getAllMenu['name'] }}</td>
                                                <td>{{ $getAllMenu['created_by'] }}</td>
                                            </tr>
                                              @endif
                                            @endforeach
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>
              <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
          					  <i class="fa fa-tasks" aria-hidden="true"></i>
          					  Executive Menu</div>
                           
                        </div>
                    </div>
              </div>
              <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
          					  <i class="fa fa-hamburger" aria-hidden="true"></i>
          					  Executive Menu - Salad</div>
                            <div class="card-body">
							
                                <div class="table-responsive">
                                    <table class="display table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <th>Action</th>
                                            <th class="bg-info" style="color:white">Name</th>
                                    
                                            <th>Created By</th>
                                        </thead>
                                        <tfoot>
                                            <th>Action</th>
                                            <th class="bg-info" style="color:white">Name</th>
                                            <th>Created By</th>
                                    </tfoot>
                                    <tbody>
                                         @foreach($getAllMenus as $getAllMenu)
                                                @if($getAllMenu['category'] === "Executive Menu - Salad")
                      					    <tr id="deletedId<?= $getAllMenu['id']?>">
                                                <td>
                                                     <!-- Button trigger modal -->
											   <a data-toggle="modal" data-target="#menu<?= $getAllMenu['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                               <a id="delete" onclick="confirmDelete('<?= $getAllMenu['id']?>')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                         
                                                </td>
                                                <td class="bg-info" style="color:white">{{ $getAllMenu['name'] }}</td>
                                                <td>{{ $getAllMenu['created_by'] }}</td>
                                            </tr>
                                              @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>
              <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
          					  <i class="fa fa-hamburger" aria-hidden="true"></i>
          					  Executive Menu - Pasta</div>
                                <div class="card-body">
							
                                    <div class="table-responsive">
                                        <table class="display table table-bordered" width="100%" cellspacing="0">
                                            <thead>
                                                <th>Action</th>
                                                <th class="bg-info" style="color:white">Name</th>
                                        
                                                <th>Created By</th>
                                            </thead>
                                            <tfoot>
                                                <th>Action</th>
                                                <th class="bg-info" style="color:white">Name</th>
                                                <th>Created By</th>
                                        </tfoot>
                                        <tbody>
                                            @foreach($getAllMenus as $getAllMenu)
                                                @if($getAllMenu['category'] === "Executive Menu - Pasta")
                      					    <tr id="deletedId<?= $getAllMenu['id']?>">
                                                <td>
                                                     <!-- Button trigger modal -->
											   <a data-toggle="modal" data-target="#menu<?= $getAllMenu['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                               <a id="delete" onclick="confirmDelete('<?= $getAllMenu['id']?>')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                         
                                                </td>
                                                <td class="bg-info" style="color:white">{{ $getAllMenu['name'] }}</td>
                                                <td>{{ $getAllMenu['created_by'] }}</td>
                                            </tr>
                                              @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                        </div>
                    </div>
              </div>
              <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
          					  <i class="fa fa-hamburger" aria-hidden="true"></i>
          					  Executive Menu - Rice</div>

                             <div class="card-body">
							   <div class="table-responsive">
                                    <table class="display table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <th>Action</th>
                                            <th class="bg-info" style="color:white">Name</th>
                                    
                                            <th>Created By</th>
                                        </thead>
                                        <tfoot>
                                            <th>Action</th>
                                            <th class="bg-info" style="color:white">Name</th>
                                            <th>Created By</th>
                                    </tfoot>
                                    <tbody>
                                          @foreach($getAllMenus as $getAllMenu)
                                                @if($getAllMenu['category'] === "Executive Menu - Rice")
                      					    <tr id="deletedId<?= $getAllMenu['id']?>">
                                                <td>
                                                     <!-- Button trigger modal -->
											   <a data-toggle="modal" data-target="#menu<?= $getAllMenu['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                               <a id="delete" onclick="confirmDelete('<?= $getAllMenu['id']?>')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                                              
                                                </td>
                                                <td class="bg-info" style="color:white">{{ $getAllMenu['name'] }}</td>
                                                <td>{{ $getAllMenu['created_by'] }}</td>
                                            </tr>
                                              @endif
                                            @endforeach
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>
              <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
          					  <i class="fa fa-hamburger" aria-hidden="true"></i>
          					  Executive Menu - Noodles</div>
                            <div class="card-body">
							   <div class="table-responsive">
                                    <table class="display table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <th>Action</th>
                                            <th class="bg-info" style="color:white">Name</th>
                                    
                                            <th>Created By</th>
                                        </thead>
                                        <tfoot>
                                            <th>Action</th>
                                            <th class="bg-info" style="color:white">Name</th>
                                            <th>Created By</th>
                                    </tfoot>
                                    <tbody>
                                        @foreach($getAllMenus as $getAllMenu)
                                                @if($getAllMenu['category'] === "Executive Menu - Noodles")
                      					    <tr id="deletedId<?= $getAllMenu['id']?>">
                                                <td>
                                                     <!-- Button trigger modal -->
											   <a data-toggle="modal" data-target="#menu<?= $getAllMenu['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                               <a id="delete" onclick="confirmDelete('<?= $getAllMenu['id']?>')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                         
                                                </td>
                                                <td class="bg-info" style="color:white">{{ $getAllMenu['name'] }}</td>
                                                <td>{{ $getAllMenu['created_by'] }}</td>
                                            </tr>
                                              @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>
              <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
          					  <i class="fa fa-hamburger" aria-hidden="true"></i>
          					  Executive Menu - Vegetables</div>
                            <div class="card-body">
							   <div class="table-responsive">
                                    <table class="display table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <th>Action</th>
                                            <th class="bg-info" style="color:white">Name</th>
                                    
                                            <th>Created By</th>
                                        </thead>
                                        <tfoot>
                                            <th>Action</th>
                                            <th class="bg-info" style="color:white">Name</th>
                                            <th>Created By</th>
                                    </tfoot>
                                    <tbody>
                                           @foreach($getAllMenus as $getAllMenu)
                                                @if($getAllMenu['category'] === "Executive Menu - Vegetables")
                      					    <tr id="deletedId<?= $getAllMenu['id']?>">
                                                <td>
                                                     <!-- Button trigger modal -->
											   <a data-toggle="modal" data-target="#menu<?= $getAllMenu['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                               <a id="delete" onclick="confirmDelete('<?= $getAllMenu['id']?>')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                         
                                                </td>
                                                <td class="bg-info" style="color:white">{{ $getAllMenu['name'] }}</td>
                                                <td>{{ $getAllMenu['created_by'] }}</td>
                                            </tr>
                                              @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>
              <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
          					  <i class="fa fa-hamburger" aria-hidden="true"></i>
          					  Executive Menu - Seafood</div>
                            <div class="card-body">
							   <div class="table-responsive">
                                    <table class="display table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <th>Action</th>
                                            <th class="bg-info" style="color:white">Name</th>
                                    
                                            <th>Created By</th>
                                        </thead>
                                        <tfoot>
                                            <th>Action</th>
                                            <th class="bg-info" style="color:white">Name</th>
                                            <th>Created By</th>
                                    </tfoot>
                                    <tbody>
                                       @foreach($getAllMenus as $getAllMenu)
                                                @if($getAllMenu['category'] === "Executive Menu - Seafood")
                      					    <tr id="deletedId<?= $getAllMenu['id']?>">
                                                <td>
                                                     <!-- Button trigger modal -->
											   <a data-toggle="modal" data-target="#menu<?= $getAllMenu['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                               <a id="delete" onclick="confirmDelete('<?= $getAllMenu['id']?>')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                         
                                                </td>
                                                <td class="bg-info" style="color:white">{{ $getAllMenu['name'] }}</td>
                                                <td>{{ $getAllMenu['created_by'] }}</td>
                                            </tr>
                                              @endif
                                            @endforeach
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>
              <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
          					  <i class="fa fa-hamburger" aria-hidden="true"></i>
          					  Executive Menu - Pork</div>
                            <div class="card-body">
							   <div class="table-responsive">
                                    <table class="display table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <th>Action</th>
                                            <th class="bg-info" style="color:white">Name</th>
                                    
                                            <th>Created By</th>
                                        </thead>
                                        <tfoot>
                                            <th>Action</th>
                                            <th class="bg-info" style="color:white">Name</th>
                                            <th>Created By</th>
                                    </tfoot>
                                    <tbody>
                                       @foreach($getAllMenus as $getAllMenu)
                                                @if($getAllMenu['category'] === "Executive Menu - Pork")
                      					    <tr id="deletedId<?= $getAllMenu['id']?>">
                                                <td>
                                                     <!-- Button trigger modal -->
											   <a data-toggle="modal" data-target="#menu<?= $getAllMenu['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                               <a id="delete" onclick="confirmDelete('<?= $getAllMenu['id']?>')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                         
                                                </td>
                                                <td class="bg-info" style="color:white">{{ $getAllMenu['name'] }}</td>
                                                <td>{{ $getAllMenu['created_by'] }}</td>
                                            </tr>
                                              @endif
                                            @endforeach
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>
              <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
          					  <i class="fa fa-hamburger" aria-hidden="true"></i>
          					  Executive Menu - Chicken</div>
                            <div class="card-body">
							   <div class="table-responsive">
                                    <table class="display table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <th>Action</th>
                                            <th  class="bg-info" style="color:white">Name</th>
                                    
                                            <th>Created By</th>
                                        </thead>
                                        <tfoot>
                                            <th>Action</th>
                                            <th  class="bg-info" style="color:white">Name</th>
                                            <th>Created By</th>
                                    </tfoot>
                                    <tbody>
                                         @foreach($getAllMenus as $getAllMenu)
                                                @if($getAllMenu['category'] === "Executive Menu - Chicken")
                      					    <tr id="deletedId<?= $getAllMenu['id']?>">
                                                <td>
                                                     <!-- Button trigger modal -->
											   <a data-toggle="modal" data-target="#menu<?= $getAllMenu['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                               <a id="delete" onclick="confirmDelete('<?= $getAllMenu['id']?>')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                         
                                                </td>
                                                <td class="bg-info" style="color:white">{{ $getAllMenu['name'] }}</td>
                                                <td>{{ $getAllMenu['created_by'] }}</td>
                                            </tr>
                                              @endif
                                            @endforeach
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>
              <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-header">
          					  <i class="fa fa-hamburger" aria-hidden="true"></i>
          					  Executive Menu - Beef</div>
                            <div class="card-body">
							   <div class="table-responsive">
                                    <table class="display table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <th>Action</th>
                                            <th  class="bg-info" style="color:white">Name</th>
                                    
                                            <th>Created By</th>
                                        </thead>
                                        <tfoot>
                                            <th>Action</th>
                                            <th  class="bg-info" style="color:white">Name</th>
                                            <th>Created By</th>
                                    </tfoot>
                                    <tbody>
                                         @foreach($getAllMenus as $getAllMenu)
                                                @if($getAllMenu['category'] === "Executive Menu - Beef")
                      					    <tr id="deletedId<?= $getAllMenu['id']?>">
                                                <td>
                                                     <!-- Button trigger modal -->
											   <a data-toggle="modal" data-target="#menu<?= $getAllMenu['id']?>" href="#" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                               <a id="delete" onclick="confirmDelete('<?= $getAllMenu['id']?>')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                         
                                                </td>
                                                <td class="bg-info" style="color:white">{{ $getAllMenu['name'] }}</td>
                                                <td>{{ $getAllMenu['created_by'] }}</td>
                                            </tr>
                                              @endif
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
     @foreach($getAllMenus as $getAllMenu)
     <div class="modal fade" id="menu<?= $getAllMenu['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Edit Menu List </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
  			    <div class="form-group">
					<div id="success<?= $getAllMenu['id']?>"></div>
					<div class="form-row">
						<div class="col-md-6">
							<label>Name</label>
							<input type="text" id="nameUpdate<?= $getAllMenu['id']?>" name="name" class="form-control" value="<?= $getAllMenu['name'] ?>" />
							
						</div>
					
                        <div class="col-md-4">
                            <label>Category</label>
                            <select class="form-control" id="categoryUpdate<?= $getAllMenu['id'] ?>" name="category">
                                <option value="Packed Meals" {{ ( "Packed Meals"  == $getAllMenu['category']) ? 'selected' : '' }}>Packed Meals</option>
                                <option value="Soup" {{ ( "Soup"  == $getAllMenu['category']) ? 'selected' : '' }}>Packed Meals</option>
                                <option value="Drinks" {{ ( "Drinks"  == $getAllMenu['category']) ? 'selected' : '' }}>Packed Meals</option>
                               
                                <option value="Desserts" {{ ( "Desserts"  == $getAllMenu['category']) ? 'selected' : '' }}>Desserts</option>
                                <option value="Salads" {{ ( "Salads"  == $getAllMenu['category']) ? 'selected' : '' }}>Salads</option>
                                <option value="Rice" {{ ( "Rice"  == $getAllMenu['category']) ? 'selected' : '' }}>Rice</option>
                                <option value="Pasta" {{ ( "Pasta"  == $getAllMenu['category']) ? 'selected' : '' }}>Pasta</option>
                                <option value="Noodles" {{ ( "Noodles"  == $getAllMenu['category']) ? 'selected' : '' }}>Noodles</option>
                                <option value="Vegetables" {{ ( "Vegetables"  == $getAllMenu['category']) ? 'selected' : '' }}>Vegetables</option>
                                <option value="Seafood" {{ ( "Seafood"  == $getAllMenu['category']) ? 'selected' : '' }}>Seafood</option>
                                <option value="Drinks" {{ ( "Drinks"  == $getAllMenu['category']) ? 'selected' : '' }}>Drinks</option>
                                <option value="Beef" {{ ( "Beef"  == $getAllMenu['category']) ? 'selected' : '' }}>Beef</option>
                                <option value="Pork" {{ ( "Pork"  == $getAllMenu['category']) ? 'selected' : '' }}>Pork</option>
                                <option value="Chicken" {{ ( "Chicken"  == $getAllMenu['category']) ? 'selected' : '' }}>Chicken</option>
                                <option value="Executive Menu - Salad" {{ ( "Executive Menu - Salad"  == $getAllMenu['category']) ? 'selected' : '' }}>Executive Menu - Salad</option>
                                <option value="Executive Menu - Pasta" {{ ( "Executive Menu - Pasta"  == $getAllMenu['category']) ? 'selected' : '' }}>Executive Menu - Pasta</option>
                                <option value="Executive Menu - Rice" {{ ( "Executive Menu - Rice"  == $getAllMenu['category']) ? 'selected' : '' }}>Executive Menu - Rice</option>
                                <option value="Executive Menu - Noodles" {{ ( "Executive Menu - Noodles"  == $getAllMenu['category']) ? 'selected' : '' }}>Executive Menu - Noodles</option>
                                <option value="Executive Menu - Vegetables" {{ ( "Executive Menu - Vegetables"  == $getAllMenu['category']) ? 'selected' : '' }}>Executive Menu - Vegetables</option>
                                <option value="Executive Menu - Seafood" {{ ( "Executive Menu - Seafood"  == $getAllMenu['category']) ? 'selected' : '' }}>Executive Menu - Seafood</option>
                                <option value="Executive Menu - Pork" {{ ( "Executive Menu - Pork"  == $getAllMenu['category']) ? 'selected' : '' }}>Executive Menu - Pork</option>
                                <option value="Executive Menu - Chicken" {{ ( "Executive Menu - Chicken"  == $getAllMenu['category']) ? 'selected' : '' }}>Executive Menu - Chicken</option>
                                <option value="Executive Menu - Beef" {{ ( "Executive Menu - Beef"  == $getAllMenu['category']) ? 'selected' : '' }}>Executive Menu - Beef</option>
                            </select>
                        </div>				
						
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
				<button type="button" onclick="updateMenu('<?= $getAllMenu['id']?>')" class="btn btn-success btn-lg">Update</button>
			</div>
			</div>
		</div>
	</div>
    @endforeach
	<div class="modal fade" id="createRaw" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Add Menu List </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
  				<div id="succAdd"></div>
				<div id="succExists"></div>

				<div  class="validate col-lg-12">
					<p class="alert alert-danger">Please fill up the field</p>
				</div>
				<div class="form-group">
					
					<div class="form-row">
						<div class="col-md-4">
							<label>Name</label>
							<input type="text" id="name" name="name" class="form-control" required="required" />
							
						</div>
					
						
                        <div class="col-md-4">
                            <label>Category</label>
                            <select class="form-control" id="category" name="category">
                                <option value="Packed Meals">Packed Meals</option>
                                <option value="Soup">Soup</option>
                                <option value="Drinks">Drinks</option>
                                <option value="Desserts">Desserts</option>
                                <option value="Salads">Salads</option>
                                <option value="Rice">Rice</option>
                                <option value="Pasta">Pasta</option>
                                <option value="Noodles">Noodles</option>
                                <option value="Vegetables">Vegetables</option>
                                <option value="Seafood">Seafood</option>
                                <option value="Drinks">Drinks</option>
                                <option value="Beef">Beef</option>
                                <option value="Pork">Pork</option>
                                <option value="Chicken">Chicken</option>
                                <option value="Executive Menu - Salad">Executive Menu - Salad</option>
                                <option value="Executive Menu - Pasta">Executive Menu - Pasta</option>
                                <option value="Executive Menu - Rice">Executive Menu - Rice</option>
                                <option value="Executive Menu - Noodles">Executive Menu - Noodles</option>
                                <option value="Executive Menu - Vegetables">Executive Menu - Vegetables</option>
                                <option value="Executive Menu - Seafood">Executive Menu - Seafood</option>
                                <option value="Executive Menu - Pork">Executive Menu - Pork</option>
                                <option value="Executive Menu - Chicken">Executive Menu - Chicken</option>
                                <option value="Executive Menu - Beef">Executive Menu - Beef</option>
                            </select>
                        </div>				
						
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
				<button type="button" onclick="saveMenu()" class="btn btn-success btn-lg">Save</button>
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
	$(".validate").hide();
	
	const updateMenu = (id) =>{
		const name = $("#nameUpdate" +id).val();
		const category = $("#categoryUpdate" +id).val();
    
		//make ajax call
		$.ajax({
			type: "PUT",
			url: '/wimpys-food-express/update-menu/' + id,
			data:{
				_method: 'put',
				"_token": "{{ csrf_token() }}",
				"id":id,
				"name":name,
				"category":category,
			},
			success: function(data){
				console.log(data);
				const getData = data;
				const succData = getData.split(":");
				const succDataArr = succData[0];

				if(succDataArr == "Success"){
					$("#success"+id).fadeIn().delay(3000).fadeOut();
					$("#success"+id).html(`<p class="alert alert-success">${data}</p>`);
					
					setTimeout(function(){
						document.location.reload();
					}, 3000);
				}
			},
			error: function(data){
				console.log('Error:', data);
			}

		});

	}


	const saveMenu = () =>{
		const name = $("#name").val();
		const cat = $("#category").val();

		if(name.length === 0 || name.length === 0){
			$(".validate").fadeIn().delay(3000).fadeOut();
		}else{
			//make ajax call
			$.ajax({
                type:"POST",
                url:'/wimpys-food-express/add-menu-list',
                data:{
                    _method:'post',
                    "_token":"{{ csrf_token() }}",
					"name":name,
					"cat":cat,
                },
                success:function(data){
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

                        $("#name").val('');
					}else{
						$("#succExists").fadeIn().delay(3000).fadeOut();
                        $("#succExists").html(`<p class="alert alert-danger">${data}</p>`);
					}
                    
                    
                },
                error:function(data){
                    console.log('Error:', data);
                }
           });

			$("#productName").val('');
			$("#price").val('');

		}
	}

	const isNumber =(evt) => {
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}
	

	const confirmDelete = (id) =>{
        const x = confirm("Do you want to delete this?");
        if(x){
            $.ajax({
              type: "DELETE",
              url: '/wimpys-food-express/delete-menu/' + id,
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