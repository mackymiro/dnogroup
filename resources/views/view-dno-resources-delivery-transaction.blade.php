@extends('layouts.dno-resources-development-corp-app')
@section('title', 'View Delivery Transaction |')
@section('content')
<div id="wrapper">
    <!-- Sidebar -->
    @include('sidebar.sidebar-dno-resources-development-corp')
    <div id="content-wrapper">
        <div class="container-fluid">
             <!-- Breadcrumbs-->
             <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">DNO Resources and Development Corp</a>
              </li>
              <li class="breadcrumb-item active">View Delivery Transaction</li>
            </ol>
            <a href="{{ url('dno-resources-development/delivery-transaction/records') }}">Back to Lists</a>
            <div class="col-lg-12">
                 <img src="{{ asset('images/dno-resources.jpg')}}" width="420" height="250" class="img-responsive mx-auto d-block" alt="DNO Resources and Development Corp">
	             <h4 class="text-center"><u>VIEW DELIVERY TRANSACTION</u></h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                         <div class="card-header">
                              <i class="fab fa-first-order" aria-hidden="true"></i>
                            View Delivery Transaction
                             <div class="float-right">
                               
                                 <a href=""><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                               
                              </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="form-row">
                                     <div class="col-lg-6">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="25%">Supplier Name</th>
                                                    <th>{{ $deliveryTransaction['supplier_name'] }}</th>
                                                </tr>
                                                        
                                                <tr>
                                                    <th>Delivery Date</th>
                                                    <th>{{ $deliveryTransaction['delivery_date']}}</th>
                                                </tr>
                                            </thead>

                                        </table>
                                    
                                    </div>
                                    <div class="col-lg-6">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="20%">Delivered To</th>
                                                    <th><a href="#">{{ $deliveryTransaction['delivered_to'] }}</a></th>
                                                </tr>
                                                <tr>
                                                    <th>DR No</th>
                                                    <th> {{ $deliveryTransaction['dr_no'] }}</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    
                                    </div>
                                </div>
                               
                            </div>
                            <table class="table table-striped">
                                 <thead>
                                    <tr>
                                        <th class="bg-info" style="color:white;">DELIVERY DESCRIPTION</th>
                                        <th class="bg-info" style="color:white;">QTY</th>
                                        <th class="bg-info" style="color:white;">AMOUNT</th>
											                 
                                    </tr>
                                  </thead>
                                  <tbody>
                                        <tr>
                                            <td>{{ $deliveryTransaction['delivery_description']}}</td>
                                            <td>{{ $deliveryTransaction['qty']}}</td>
                                            <td><?php echo number_format($deliveryTransaction['total'], 2); ?></td>
                                                                    
                                        </tr>
                                        @foreach($dTransactions as $dTransaction)
                                            <tr>
                                                <td>{{ $dTransaction['delivery_description']}}</td>
                                                <td>{{ $dTransaction['qty']}}</td>
                                                <td><?php echo number_format($dTransaction['total'], 2); ?></td>
                                            </tr> 
                                        @endforeach
                                        <tr>  
                                            <td></td>
                                            <td><strong>Total</strong></td>
                                            <td>₱ <?php echo number_format($sum, 2)?></td>
                                            
                                            </tr>
                                  </tbody>
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
</div>

@endsection