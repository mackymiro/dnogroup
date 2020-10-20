@extends('layouts.lolo-pinoy-grill-branches-app')
@section('content')
<div id="wrapper">
     @include('sidebar.sidebar-lolo-pinoy-grill-branches')
     <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="#">Lolo Pinoy Grill Branches</a>
                    </li>
                    @if(!empty($data))
                    <li class="breadcrumb-item active">
                    {{ $data }}
                    </li>
                    @endif
                    <li class="breadcrumb-item active">View Transaction Details</li>
                
            </ol>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
							<i class="fa fa-file-invoice" aria-hidden="true"></i>
							View Transaction Details
                            <div class="float-right">
                                <a href="{{ action('LoloPinoyGrillBranchesController@printReceipt', $getOrder[0]->id)}}" ><i class="fa fa-print fa-4x" aria-hidden="true"></i></a>
                            </div>
						</div>
                        <div class="card-body">
                              <table class="table table-bordered"  width="100%" cellspacing="0">
                                <thead>
                                    <th class="bg-info" style="color:#fff; " width="15%">INVOICE NO</th>
                                    <th class="bg-success" style="color:#fff; font-size:35px;" >{{ $getOrder[0]->invoice_number}}</th>
                                    <th class="bg-info" style="color:#fff;" width="15%">ORDERED BY</th>
                                    <th class="bg-success" style="color:#fff; font-size:35px;" >{{ $getOrder[0]->ordered_by }}</th>
                                </thead>
                                <tr>
                                    <th class="bg-info" style="color:#fff;" width="15%">TABLE NO</th>
                                    <th class="bg-success" style="color:#fff; font-size:35px;" >{{ $getOrder[0]->table_no }}</th>
                                    <th class="bg-info" style="color:#fff;" width="15%">TRANSACTION ID</th>
                                    <th class="bg-success" style="color:#fff; font-size:35px;" >{{ $getOrder[0]->id }}</th>
                             
                                </tr>
                               
                                <tr>
                                   
                                    <th class="bg-info" style="color:#fff;" width="15%">SENIOR CITIZEN</th>
                                    <th class="bg-success" style="color:#fff; font-size:35px;" >{{ $getOrder[0]->senior_citizen_label}}</th>
                                    <th class="bg-info" style="color:#fff;" width="15%">SENIOR CITIZEN ID</th>
                                    <th class="bg-success" style="color:#fff; font-size:35px;" >{{ $getOrder[0]->senior_citizen_id}}</th>
                                </tr>
                            </table>
                            <table id="output" class="table table-striped">
                                <thead>
                                        @if(Auth::user()['role_type'] != 4)
                                        <th class="bg-success" style="color:#ffff">ACTION</th>
                                        @endif
                                        <th class="bg-success" style="color:#ffff">QTY</th>
                                        <th class="bg-success" style="color:#ffff">ITEM DESCRIPTION</th>
                                        <th class="bg-success" style="color:#ffff">AMOUNT</th>
                                </thead>
                                <tbody id="rows">
                                        @if($getOrder[0]->deleted_at == NULL)
                                        <tr>
                                            @if(Auth::user()['role_type'] != 4)
                                            <td>
                                                <form action="{{ action('LoloPinoyGrillBranchesController@voidItem', $getOrder[0]->id ) }}" method="post">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="mainId" value="{{ $getOrder[0]->id}}" />
                                                    <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-cog"></i> VOID</button>
                                                </form>
                                            </td>
                                            @endif
                                            <td style="font-size:35px;">{{ $getOrder[0]->qty }}</td>
                                            <td style="font-size:35px;">{{ $getOrder[0]->item_description}}</td>
                                            <td style="font-size:35px;"><?php echo number_format($getOrder[0]->amount, 2) ?></td>
                                        </tr>
                                        @endif
                                        @foreach($getTransactions as $getTransaction)
                                        @if($getTransaction->deleted_at == NULL)
                                        <tr>
                                             @if(Auth::user()['role_type'] != 4)
                                            <td>
                                                <form action="{{ action('LoloPinoyGrillBranchesController@voidItemSecond', $getTransaction->id) }}" method="post">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="mainId" value="{{ $getOrder[0]->id}}" />
                                                    <button class="btn btn-primary btn-lg"><i class="fas fa-cog"></i> VOID</button>
                                                </form>
                                            </td>
                                            @endif
                                            <td style="font-size:35px;">{{ $getTransaction->qty}}</td>
                                            <td style="font-size:35px;">{{ $getTransaction->item_description}}</td>
                                            <td style="font-size:35px;">{{ $getTransaction->amount}}</td>
                                        </tr>
                                        @endif
                                        @endforeach
                                       
                                </tbody>
                                <tr>
                                    @if(Auth::user()['role_type'] != 4)
                                    <td></td>
                                    @endif 
                                    <td></td>
                                    <td class="bg-success" style="color:#fff; font-size:35px; font-weight:bold">Total</td>
                                    <td class="bg-danger" ><span id="totalCharge" style="color:#fff; font-size:35px; font-weight:bold">₱ <?php echo number_format($getOrder[0]->total_amount_of_sales , 2); ?></span></td>
                                </tr>
                                <tr>
                                    @if(Auth::user()['role_type'] != 4)
                                    <td></td>
                                    @endif  
                                    <td></td>
                                    <td class="bg-success" style="color:#fff; font-size:35px; font-weight:bold">Cash</td>
                                    <td class="bg-danger" ><span id="totalCharge" style="color:#fff; font-size:35px; font-weight:bold">₱ <?php echo number_format($getOrder[0]->cash_amount, 2);?></span></td>
                                </tr>
                                <tr>
                                    @if(Auth::user()['role_type'] != 4)
                                    <td></td>
                                    @endif 
                                    <td></td>
                                    <td class="bg-success" style="color:#fff; font-size:35px; font-weight:bold">Senior</td>
                                    <td class="bg-danger" ><span id="totalCharge" style="color:#fff; font-size:35px; font-weight:bold">₱ <?php echo number_format($getOrder[0]->senior_amount, 2) ?> </span></td>
                                </tr>
                                <tr>
                                    @if(Auth::user()['role_type'] != 4)
                                    <td></td>
                                    @endif 
                                    <td></td>
                                    <td class="bg-success" style="color:#fff; font-size:35px; font-weight:bold">Gift Cert</td>
                                    <td class="bg-danger" ><span id="totalCharge" style="color:#fff; font-size:35px; font-weight:bold">₱ <?php echo number_format($getOrder[0]->gift_cert, 2);?></span></td>
                                </tr>
                                <tr>
                                    @if(Auth::user()['role_type'] != 4)
                                    <td></td>
                                    @endif 
                                    <td></td>
                                    <td class="bg-success" style="color:#fff; font-size:35px; font-weight:bold">Change</td>
                                    <td class="bg-danger" ><span id="totalCharge" style="color:#fff; font-size:35px; font-weight:bold">₱ <?php echo number_format($getOrder[0]->change, 2);?></span></td>
                                </tr>
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