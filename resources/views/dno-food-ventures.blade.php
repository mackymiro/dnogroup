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
				<li class="breadcrumb-item active">Food Venture</li>			
			</ol>
        </div>
    </div>
</div>
@endsection