@extends('layouts.dno-food-ventures-app')
@section('title', 'DNO Food Ventures|')
@section('content')
<div id="wrapper">
    @include('sidebar.sidebar-dno-food-ventures')
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="#">DNO Food Ventures</a>
				</li>
				<li class="breadcrumb-item active">Sales All Lists</li>			
			</ol>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            All Lists
                        </div>
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
                                        <th>Amount</th>
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
                                        <th>Amount</th>
                                        <th>Created By</th>
                                    </tfoot>
                                    <tbody>
                                    </tbody>
                                </table>
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

</div>
@endsection