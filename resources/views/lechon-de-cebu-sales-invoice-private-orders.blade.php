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
              <li class="breadcrumb-item active">View Private Orders</li>
            </ol>
           
             <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                          <div class="card-header">
                            <i class="fa fa-cash-register" aria-hidden="true"></i>
                           Private Orders</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                           
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                            
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                         
                                        </tbody>
                                    </table>
                                    <br>
                                  
                                </div>
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

@endsection