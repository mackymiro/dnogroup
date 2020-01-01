<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>@yield('title')</title>

  <!-- Custom fonts for this template-->
  <link href="{{ asset('vendor/all.min.css') }} " rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="{{ asset('css/sb-admin.css') }} " rel="stylesheet">

</head>

<body class="bg-dark">

   @yield('loginContent')

  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('vendor/jquery/jquery.min.js') }} "></script>
  <script src="{{ asset('vendor/bootstrap.bundle.min.js') }} "></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset('vendor/jquery.easing.min.js') }} "></script>

</body>

</html>
