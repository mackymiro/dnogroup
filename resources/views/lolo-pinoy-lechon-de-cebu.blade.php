@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Sales |')
@section('content')
<div id="wrapper">
    @include('sidebar.sidebar')
    <div id="content-wrapper">
        <div class="container-fluid">
             <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lechon de Cebu</a>
              </li>
              <li class="breadcrumb-item ">Sales Invoice</li>
              <li class="breadcrumb-item active">View Sales By Outlets</li>
            </ol>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                          <div class="card-header">
                            <i class="fa fa-cash-register" aria-hidden="true"></i>
                            All Lists</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                      <thead>
                                        <th>Action</th>
                                        <th>Invoice #</th>
                                        <th>SI No</th>
                                        <th>Date</th>
                                        <th>Ordered By</th>
                                        <th>Address</th>
                                        <th>QTY</th>
                                        <th>Total KLS</th>
                                        <th>Item Description</th>
                                        <th>Unit Price</th>
                                        <th class="bg-danger" style="color:#fff;">Amount</th>
                                        <th>Created By</th>
                                    </thead>
                                    <tfoot>
                                         <th>Action</th>
                                        <th>Invoice #</th>
                                        <th>SI No</th>
                                        <th>Date</th>
                                        <th>Ordered By</th>
                                        <th>Address</th>
                                        <th>QTY</th>
                                        <th>Total KLS</th>
                                        <th>Item Description</th>
                                        <th>Unit Price</th>
                                        <th class="bg-danger" style="color:#fff;">Amount</th>
                                        <th>Created By</th>
                                    </tfoot>
                                    <tbody>
                                          @foreach($getAllSalesInvoices as $getAllSalesInvoice)
                                          <tr id="deletedId{{ $getAllSalesInvoice->id}}">
                                          <td>
                                          
                                            <a href="{{ url('lolo-pinoy-lechon-de-cebu/edit-sales-invoice/'.$getAllSalesInvoice->id ) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                            
                                            @if(Auth::user()['role_type'] == 1)
                                            <a id="delete" onClick="confirmDelete('{{ $getAllSalesInvoice->id}}')" href="javascript:void" title="Delete"><i class="fas fa-trash"></i></a>
                                            @endif
                                            <a href="{{ url('lolo-pinoy-lechon-de-cebu/view-sales-invoice/'.$getAllSalesInvoice->id) }}" title="View"><i class="fas fa-low-vision"></i></a>
                                           
                                          </td>
                                          <td><p style="width:130px;">{{ $getAllSalesInvoice->invoice_number}}</p></td>
                                          <td><p style="width:130px;">{{ $getAllSalesInvoice->module_code}}{{ $getAllSalesInvoice->lechon_de_cebu_code}}</p></td>
                                          <td>{{ $getAllSalesInvoice->date }}</td>
                                          <td><p style="width:230px;">{{ $getAllSalesInvoice->ordered_by }}</p></td>
                                          <td><p style="width:300px;">{{ $getAllSalesInvoice->address}}</p></td>
                                          <td>{{ $getAllSalesInvoice->qty}}</td>
                                          <td><?php echo number_format($getAllSalesInvoice->total_kls, 2); ?></td>
                                          <td><p style="width:190px;">{{ $getAllSalesInvoice->item_description}}</p></td>
                                          <td><?php echo number_format($getAllSalesInvoice->unit_price, 2);?></td>
                                          <td class="bg-danger" style="color:#fff;"><?php echo number_format($getAllSalesInvoice->amount, 2); ?></td>
                                          <td><p style="width:130px;">{{ $getAllSalesInvoice->created_by}}</p></td>
                                          </tr>
                                          @endforeach

                                    </tbody>
                                    </table>
                                </div>
                                <br>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="15%" class="bg-info" style="color:white;">Total:</th>
                                            <th class="bg-success" style="color:white"><?php echo number_format($total, 2);?></th>
                                        </tr>
                                    </thead>
                                </table>
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

    <!-- /.content-wrapper -->
</div>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript">
   function confirmDelete(id){
      var x = confirm("Do you want to delete this?");
     
      if(x){
        $.ajax({
                type: "DELETE",
                url: '/lolo-pinoy-lechon-de-cebu/delete/SI/' + id,
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