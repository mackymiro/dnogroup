@extends('layouts.lolo-pinoy-grill-branches-app')
@section('title', 'Sales Form Login| ')
@section('content')
<div id="wrapper">
    <!-- Sidebar -->
     @include('sidebar.sidebar-lolo-pinoy-grill-branches')
     <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Lolo Pinoy Grill Branches</a>
              </li>
              <li class="breadcrumb-item active">Branch Login</li>

            </ol>
            <div class="col-lg-12">
            	<img src="{{ asset('images/lolo-pinoy-grill.jpeg')}}" width="366" height="178" class="img-responsive mx-auto d-block" alt="Lolo Pinoy Grill ">
            	 
            	 <h4 class="text-center"><u>BRANCH LOGIN</u></h4>
            </div>
            <div class="row">
                 <div class="col-lg-12">
                     <div class="card mb-3">
                        <div class="card-header">
                             <i class="fas fa-sign-in-alt"></i>
                            Login Branch 
                        </div>
                        <div class="card-body">         
                           <div class="form-group">
                                <div class="form-row">
                                    <div class="col-lg-4"> </div>
                                    <div class="col-lg-4">
                                         <div class="card mb-3">
                                            <div class="card-header">
                                                <i class="fas fa-sign-in-alt"></i>
                                                Login Branch Here
                                            </div>
                                            <div class="card-body">
                                                <form action="" method="post">
                                                <div class="form-group">
                                                    <div class="form-row">
                                                        <div class="col-lg-12">
                                                            <label>Select Branch</label>
                                                            <div id="app-branches"> 
                                                                <select name="selectBranch" class="form-control">
                                                                    <option v-for="branch in branches" v-bind:value="branch.value">
                                                                        @{{ branch.text }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <label>Password</label>
                                                            <input type="password" name="password" class="form-control" required />
                                                        </div>
                                                        <div>
                                                            <br>
                                                            <button type="submit" class="btn btn-success" > <i class="fas fa-sign-in-alt"></i> Login</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                         </div>
                                    </div>
                                    <div class="col-lg-4"></div>
                                </div>
                           </div>
                        </div><!-- end of car body-->
                     </div>
                 </div>
            </div><!-- end of row-->
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
<script>
    //branches
    new Vue({
        el: '#app-branches',
            data:{
                branches:[
                    {text:'Urgello', value:'Urgello'},
                    {text:'Velez', value:'Velez'},
                    {text:'Banilad', value:'Banilad'},
                    {text:'GQS', value:'GQS' }
                ]
            }
    });
</script>
@endsection