@extends('layouts.wlg-corporation-app')
@section('title', 'WLG Corporation|')
@section('content')
<div id="wrapper">
    @include('sidebar.sidebar-wlg-corporation')
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="#">WLG Corporation</a>
				</li>
				<li class="breadcrumb-item active">Invoice</li>
			
			</ol>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
							<i class="fa fa-file-invoice" aria-hidden="true"></i>
							Invoice List
                         
						</div>
                    </div>
                </div>
            </div><!-- end of row-->
        </div>
    </div>
</div>

@endsection