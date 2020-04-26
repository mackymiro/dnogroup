@extends('layouts.dno-personal-app')
@section('title', 'Utilitie|')
@section('content')
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
                    <li class="breadcrumb-item active">Utilties</li>
                    <li class="breadcrumb-item ">Vehicles</li>
                   
                </ol>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card mb-3">
                            <div class="card-header">
                            <i class="fas fa-plus" aria-hidden="true"></i>
                                Add Vehicles
                         
						    </div>
                            <div class="card-body">
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card mb-3">
                            <div class="card-header">
                            <i class="fas fa-tools" aria-hidden="true"></i>
                                Utilities
						    </div>
                            <div class="card-body">
                                
                            </div>
                        </div>
                    </div>
                </div>
         </div>
      </div>

</div>
@endsection