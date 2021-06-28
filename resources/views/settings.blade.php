@extends('layouts.app')
@section('title', 'Settings |')
@section('content')
<div id="wrapper">
     <!-- Sidebar -->
     <ul class="sidebar navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="{{ url('/') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('lolo-pinoy-lechon-de-cebu') }}">
          <i class="fas fa-book"></i>
          <span>Lolo Pinoy Lechon de Cebu</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('lolo-pinoy-grill-commissary') }}">
          <i class="fas fa-book"></i>
          <span>Lolo Pinoy Grill Commissary</span>
        </a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="{{ url('lolo-pinoy-grill-branches') }}">
          <i class="fas fa-book"></i>
          <span>Lolo Pinoy Grill Branches</span>
        </a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="{{ url('mr-potato') }}">
          <i class="fas fa-book"></i>
          <span>Mr Potato</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('ribos-bar') }}">
          <i class="fas fa-book"></i>
          <span>Ribos Bar</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('dno-personal') }}">
          <i class="fas fa-book"></i>
          <span>DNO Personal</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fas fa-book"></i>
          <span>DNO Food Ventures</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fas fa-book"></i>
          <span>DNO Resources and Development Corp</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('dong-fang-corporation')}}">
          <i class="fas fa-book"></i>
          <span>Dong Fang Corporation</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('wlg-corporation') }}">
          <i class="fas fa-book"></i>
          <span>WLG Corporation</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('dino-industrial-corporation') }}">
          <i class="fas fa-book"></i>
          <span>DINO Industrial Corporation</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('local-ground') }}">
          <i class="fas fa-book"></i>
          <span>Local Ground</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('dno-holdings-co') }}">
          <i class="fas fa-book"></i>
          <span>DNO Holdings & Co</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('dno-foundation-inc') }}">
          <i class="fas fa-book"></i>
          <span>DNO Foundation Inc</span>
        </a>
      </li>
     
      <li class="nav-item">
        <a class="nav-link" href="{{ url('wimpys-food-express') }}">
          <i class="fas fa-book"></i>
          <span>Wimpy's Food Express</span>
        </a>
      </li>
     
     
    </ul>
    <div id="content-wrapper">
        <div class="container-fluid">
              <!-- Breadcrumbs-->
              <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Dashboard</a>
              </li>
              <li class="breadcrumb-item active">Settings</li>
            </ol>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-cogs"></i> 
                            Settings for Body (Lechon De Cebu)
                        </div>
                        <div class="card-body">
                           <div  class="validate col-lg-12">
                              <p class="alert alert-danger">Please Fill up the fields</p>
                          </div>
                          <div id="succAdd"></div>
                            <div class=col-lg-12>
                                <label>Body 400/kls</label>
                                <input type="text" name="settingLechon" id="settingLechon" value="{{ $getBody[0]['settings_for_body'] }}" onkeypress="return isNumber(event)" class="form-control" />
                            </div>
                            <div class=col-lg-12>
                                <br>
                                <button type="button" onclick="saveBodyPrice()" class="btn btn-success btn-lg"><i class="fas fa-save"></i> Save Body Price</button>
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-cogs"></i> 
                            Settings for Head and Feet (Lechon De Cebu)
                        </div>
                        <div class="card-body">
                             <div  class="validateHead col-lg-12">
                              <p class="alert alert-danger">Please Fill up the fields</p>
                          </div>
                          <div id="succHead"></div>
                            <div class=col-lg-12>
                                <label>Head and Feet 200/kls</label>
                                <input type="text" name="headFeet" id="headFeet" class="form-control" value="{{ $getHead[1]['settings_head_feet'] }}" onkeypress="return isNumber(event)" />
                            </div>
                            <div class=col-lg-12>
                                <br>
                                <button type="button" onclick="saveHeadFeetPrice()" class="btn btn-success btn-lg"><i class="fas fa-save"></i> Save Head & Feet Price</button>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
    <script>
         const isNumber =(evt) => {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
              return false;
            }
            return true;
          };

        $(".validate").hide();
        $(".validateHead").hide();
        const saveHeadFeetPrice = () => {
            const headFeet = $("#headFeet").val();
            if(headFeet.length === 0){
                $(".validateHead").fadeIn().delay(3000).fadeOut();
            }else{
                //make ajax call
                $.ajax({
                    type:'POST',
                    url:'/settings/head-feet/add',
                    data:{
                      _method:'put',
                      "_token":"{{ csrf_token() }}",
                      "headFeet":headFeet,
                    },
                    success:function(data){
                      $("#succHead").fadeIn().delay(3000).fadeOut();
                      $("#succHead").html(`<p class="alert alert-success">${data}</p>`);
                    },
                    error:function(data){
                      console.log('Error:', data);
                    }   
                });
            }
        };

        const saveBodyPrice = () =>{
            const settingsLechon = $("#settingLechon").val();
            if(settingsLechon.length === 0){
                $(".validate").fadeIn().delay(3000).fadeOut();
            }else{
                //make ajax call
                $.ajax({
                    type:'POST',
                    url:'/settings/body-lechon/add',
                    data:{
                      _method:'put',
                      "_token":"{{ csrf_token() }}",
                      "settingsLechon":settingsLechon,
                    },
                    success:function(data){
                      $("#succAdd").fadeIn().delay(3000).fadeOut();
                      $("#succAdd").html(`<p class="alert alert-success">${data}</p>`);
                    },
                    error:function(data){
                      console.log('Error:', data);
                    }
                });
            }
        };
    </script>
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