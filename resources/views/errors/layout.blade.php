<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
<title>@lang('errors.layout.title')</title>
<!-- Bootstrap Core CSS -->
<link rel="stylesheet" href="/ample/bootstrap/dist/css/bootstrap.min.css">
<!-- animation CSS -->

<!-- Custom CSS -->
{{ Html::style('ample/css/style.css') }}
<!-- color CSS -->
{{ Html::style('ample/css/colors/default.css') }}
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>
<body>
<!-- Preloader -->

<section id="wrapper" class="error-page">
  <div class="error-box">
    <div class="error-body text-center">
      @yield('content')
      <a href="{{ route('home') }}" class="btn btn-danger btn-rounded waves-effect waves-light m-b-40">@lang('errors.layout.back')</a> </div>
    <footer class="footer text-center">@lang('errors.layout.footer')</footer>
  </div>
</section>
</body>
</html>
