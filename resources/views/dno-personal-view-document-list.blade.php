@extends('layouts.dno-personal-app')
@section('title', 'View OR List|')
@section('content')
<div id="wrapper">
     @include('sidebar.sidebar-dno-personal')
     <div id="content-wrapper"> 
        <div class="container-fluid">
             <!-- Breadcrumbs-->
             <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">DNO Personal</a>
                </li>
                <li class="breadcrumb-item active">Utilties</li>
                @if (\Request::is('dno-personal/vehicles/or-list/'.$getViewDocument['id'])) 
                    <li class="breadcrumb-item ">View OR List</li>
                @else
                <li class="breadcrumb-item ">View PMS List</li>
                @endif
                
            </ol>
            @if (\Request::is('dno-personal/vehicles/or-list/'.$getViewDocument['id'])) 
            <div class="row">
                <div class="col-lg-4">
                     <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-image" aria-hidden="true"></i>
                                Document OR View
                        </div>
                        <div class="card-body">
                            <div class="col-lg-12">
                                <p>Document Name: {{ $getViewDocument['document_name']}}</p>
                            </div>
                            <div class="col-lg-12">
                                
                                <img src="/uploads/documents/<?php echo $getViewDocument['upload_document']; ?>"  width="300" height="400" class="img-responsive" alt="">
                                
                            </div>
                        </div>
                     </div>
                </div>
                <div class="col-lg-8">
                     <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-receipt" aria-hidden="true"></i>
                                View OR List
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                 <table class="table table-striped ">
                                    <thead>
                                        <tr>
                                            <th>PARTICULARS</th>
                                            <th>AMOUNT</th>
                                    
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach($getDocumentParticulars as $getDocumentParticular)
                                        <tr>
                                            <td>{{ $getDocumentParticular['particulars']}}</td>
                                            <td><?php echo number_format($getDocumentParticular['amount'], 2)?></td>
                                        </tr>
                                        @endforeach
                                    </tbody>    
                                </table>
                            </div>
                        </div>
                     </div>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-lg-4">
                     <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-image" aria-hidden="true"></i>
                                Document PMS View
                        </div>
                        <div class="card-body">
                            <div class="col-lg-12">
                                <p>Document Name: {{ $getViewDocument['document_name']}}</p>
                            </div>
                            <div class="col-lg-12">
                                
                                <img src="/uploads/documents/<?php echo $getViewDocument['upload_document']; ?>"  width="300" height="400" class="img-responsive" alt="">
                                
                            </div>
                        </div>
                     </div>
                </div>
                <div class="col-lg-8">
                     <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-receipt" aria-hidden="true"></i>
                                View PMS List
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                 <table class="table table-striped ">
                                    <thead>
                                        <tr>
                                            <th>PARTICULARS</th>
                                            <th>AMOUNT</th>
                                    
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach($getDocumentParticulars as $getDocumentParticular)
                                        <tr>
                                            <td>{{ $getDocumentParticular['particulars']}}</td>
                                            <td><?php echo number_format($getDocumentParticular['amount'], 2)?></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                     </div>
                </div>
            </div>
            @endif
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
@endsection