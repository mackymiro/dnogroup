@extends('layouts.lolo-pinoy-lechon-de-cebu-app')
@section('title', 'Inventory Of Stocks |')
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
                <li class="breadcrumb-item ">Commissary</li>
                <li class="breadcrumb-item active">Inventory Of Stocks</li>
              </ol>
	 	</div>
	 </div>
</div>
@endsection