@extends('layouts.lolo-pinoy-grill-branches-app')
@section('title', 'Details Transaction| ')
@section('content')

<div id="wrapper">
      <!-- Sidebar -->
      @include('sidebar.sidebar-lolo-pinoy-grill-branches')
      <div id="content-wrapper">
            <div class="container-fluid">
                  <!-- Breadcrumbs-->
                  <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                  <a href="#">Lolo Pinoy Grill Bracnhes</a>
                  </li>
                  <li class="breadcrumb-item active">{{ $data }}</li>
                  <li class="breadcrumb-item active">Sales Invoice Form Transactions</li>
                  <li class="breadcrumb-item active">Detail Transactions</li>
                  </ol>
                  <div class="col-lg-12">
                        <img src="{{ asset('images/lolo-pinoy-grill.jpeg')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lolo Pinoy Grill ">
                        
                        <h4 class="text-center"><u>DETAILS TRANSACTIONS</u></h4>
                  </div>
                  <div class="row">
                        <div class="col-lg-12">
                              <div class="card mb-3">
                                    <div class="card-header">
                                    <i class="fas fa-cash-register"></i>
                                          Cash 
                                    </div>
                                    <div class="card-body">
                                           @if(session('successPay'))
                                               <strong> <p style="font-size:20px;"class="alert alert-success">{{ Session::get('successPay') }}</p></strong>
                                          @endif 
                                          <form action="{{ action('LoloPinoyGrillBranchesController@payCash', $transaction['id'])}}" method="post">
                                          {{ csrf_field() }}

                                          <div class="form-group">
                                                <div class="form-row">
                                                      <div class="col-lg-4 ">
                                                            <label><strong>CASH</strong></label>
                                                            <input type="text" name="cash" placeholder="ENTER CASH HERE..." class="form-control form-control-lg" required />
                                                            @if ($errors->has('cash'))
                                                            <span class="alert alert-danger">
                                                                  <strong>{{ $errors->first('cash') }}</strong>
                                                            </span>
                                                            @endif
                                                            <br>
                                                      </div>
                                                      <div class="col-lg-2 ">
                                                            <label><strong>SENIOR CITIZEN</strong></label>
                                                           <div id="app-senior">
                                                                  <select name="orderedBy" class="form-control form-control-lg">
                                                                        <option v-for="senior in seniors" v-bind:value="senior.value">
                                                                        @{{ senior.text }}
                                                                        </option>
                                                                  </select>
                                                            </div>
                                                            
                                                      </div>
                                                      <div class="col-lg-4 ">
                                                            <label><strong>GIFT CERT (optional)</strong></label>
                                                            <input type="text" name="giftCert" placeholder="ENTER GIFT CERT HERE ..." class="form-control form-control-lg" />
                                                      </div>
                                                </div>
                                          
                                          </div>
                                          <div class="form-group">
                                                <div class="form-row">
                                                      <div class="col-lg-12 ">
                                                            @if($transaction['cash_amount'] != NULL)
                                                                  <button class="btn btn-success btn-lg" disabled="disabled">PAY CASH</button>
                                                            @else
                                                                  <button class="btn btn-success btn-lg">PAY CASH</button>
                                                            @endif
                                                      </div>
                                                </div>
                                          
                                          </div>
                                          </form>
                                    </div>
                              </div>
                        </div>
                  </div><!-- end of row-->
                  <div class="row">
                        <div class="col-lg-12">
                              <div class="card mb-3">
                                    <div class="card-header">
                                          <i class="fas fa-money-bill-alt"></i>
                                          Transaction Details 
                                    </div>
                                    <div class="card-body">
                                           <table id="output" class="table table-striped">
                                                <thead>
                                                      <th class="bg-success" style="color:#ffff">QTY</th>
                                                      <th class="bg-success" style="color:#ffff">ITEM DESCRIPTION</th>
                                                      <th class="bg-success" style="color:#ffff">AMOUNT</th>
                                                </thead>
                                                <tbody id="rows">
                                                      <tr>
                                                            <td>{{ $transaction['qty']}}</td>
                                                            <td>{{ $transaction['item_description']}}</td>
                                                            <td>{{ $transaction['amount']}}</td>
                                                      </tr>
                                                      @foreach($getTransactions as $getTransaction)
                                                      <tr>
                                                      <td>{{ $getTransaction['qty']}}</td>
                                                      <td>{{ $getTransaction['item_description']}}</td>
                                                      <td>{{ $getTransaction['amount']}}</td>
                                                      </tr>
                                                      @endforeach
                                                </tbody>
                                                <tr>
                                                      <td></td>
                                                      <td class="bg-success" style="color:#fff; font-size:35px; font-weight:bold">Total</td>
                                                      <td class="bg-danger" ><span id="totalCharge" style="color:#fff; font-size:35px; font-weight:bold">₱ <?php echo number_format($transaction['total_amount_of_sales'] , 2); ?></span></td>
                                                </tr>
                                                <tr>
                                                      <td></td>
                                                      <td class="bg-success" style="color:#fff; font-size:35px; font-weight:bold">Cash</td>
                                                      <td class="bg-danger" ><span id="totalCharge" style="color:#fff; font-size:35px; font-weight:bold">₱ <?php echo number_format($transaction['cash_amount'], 2);?></span></td>
                                                </tr>
                                                <tr>
                                                      <td></td>
                                                      <td class="bg-success" style="color:#fff; font-size:35px; font-weight:bold">Senior</td>
                                                      <td class="bg-danger" ><span id="totalCharge" style="color:#fff; font-size:35px; font-weight:bold">₱ </span></td>
                                                </tr>
                                                <tr>
                                                      <td></td>
                                                      <td class="bg-success" style="color:#fff; font-size:35px; font-weight:bold">Gift Cert</td>
                                                      <td class="bg-danger" ><span id="totalCharge" style="color:#fff; font-size:35px; font-weight:bold">₱ <?php echo number_format($transaction['gift_cert'], 2);?></span></td>
                                                </tr>
                                                <tr>
                                                      <td></td>
                                                      <td class="bg-success" style="color:#fff; font-size:35px; font-weight:bold">Change</td>
                                                      <td class="bg-danger" ><span id="totalCharge" style="color:#fff; font-size:35px; font-weight:bold">₱ <?php echo number_format($transaction['change'], 2);?></span></td>
                                                </tr>
                                           </table>      
                                           <div class="form-group">
                                                <div class="form-row">
                                                      <div class="col-lg-4">
                                                            <a href="{{ url('lolo-pinoy-grill-branches/sales-form') }}" class="btn btn-success btn-lg">OKAY</a>
                                                      </div>
                                                </div>
                                           </div>   
                                    </div><!-- end of card body-->
                              </div>
                        </div>
                  </div><!-- end of row -->    
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
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script>
   //senior citizen
  
   new Vue({
      el: '#app-senior',
        data: {
            seniors:[
                  { text:'NO', value: 'NO' },
                { text:'YES', value: 'YES' }
            ]
        }
    }) 

</script>
@endsection