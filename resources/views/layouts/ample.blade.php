<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<!-- Favicon icon -->
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicons/apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicons/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicons/favicon-16x16.png') }}">
<link rel="manifest" href="{{ asset('images/favicons/manifest.json') }}">
<link rel="mask-icon" href="{{ asset('images/favicons/safari-pinned-tab.svg') }}" color="#5bbad5">
<meta name="theme-color" content="#ffffff">

<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('ample/images/favicon.png') }}">
<title>Crluo</title>
<!-- Bootstrap Core CSS -->
<link rel="stylesheet" href="/ample/bootstrap/dist/css/bootstrap.min.css">
{{-- {{ Html::style('/ample/bootstrap/dist/css/bootstrap.min.css') }} --}}
<!-- This is Sidebar menu CSS -->
{{ Html::style('ample/bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}
<!-- This is a Animation CSS -->
{{ Html::style('ample/css/animate.css') }}
<!-- This is a Custom CSS -->
<link rel="stylesheet" href="/ample/css/style.css?v={{VERSION_CSS_JS}}">
<link rel="stylesheet" href="/css/hung_update_home.css?v=<?= VERSION_CSS_JS ?>">
<link rel="stylesheet" href="/ample/css/luc_update.css?v={{VERSION_CSS_JS}}">
<link rel="stylesheet" href="/css/responsive_sreen.css?v={{VERSION_CSS_JS}}">
<link rel="stylesheet" href="/css/son-style.css?v={{VERSION_CSS_JS}}">
{{-- {{ Html::style('/ample/css/style.css?v={{VERSION_CSS_JS}}') }} --}}
<!-- color CSS you can use different color css from css/colors folder -->
<!-- We have chosen the skin-blue (default.css) for this starter
page. However, you can choose any other skin from folder css / colors .
-->

{{ Html::style('css/custom.css?v='.VERSION_CSS_JS) }}
{{ Html::style('css/user.css?v='.VERSION_CSS_JS) }}
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
@stack('styles')
@if (request()->is('creative-rooms/*') || request()->is('creative-rooms'))
	{{ Html::style('ample/css/colors/c-base.css?v='.VERSION_CSS_JS) }}
	{{ Html::style('/css/hung-update-c-base.css?v='.VERSION_CSS_JS) }}
	{{ Html::style('css/son-c-base-style.css?v='.VERSION_CSS_JS) }}
@else
@if ($mode == 'client')
	{{ Html::style('ample/css/colors/client.css?v='.VERSION_CSS_JS) }}
	{{ Html::style('/css/hung-update-c-base.css?v='.VERSION_CSS_JS) }}
@else
	{{ Html::style('ample/css/colors/creator.css') }}
@endif
@endif

<!-- jQuery -->
{{ Html::script('ample/bower_components/jquery/dist/jquery.min.js') }}
<?php if(isset($_GET['debug'])){?>
	<script>
		
		window.onerror = function (errorMsg, url, lineNumber) {
			alert('Error: ' + errorMsg + ' Script: ' + url + ' Line: ' + lineNumber);
		}
	</script>
<?php } ?>
<!-- Global site tag (gtag.js) - Google AdWords: 815676858 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-815676858"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-815676858');
</script>
</head>

@php
$hideLeftBar = !auth()->check() || preg_match('/creative-rooms\/\d/', request()->url()) || preg_match('/creative-rooms$/', request()->url());
@endphp

@if ($hideLeftBar)
<style media="screen">
	.navbar-static-top {
	padding-left: 0;
	}
	#page-wrapper {
	padding: 0;
	margin: 0;
	}
	.bg-title {
		border-bottom: 0;
	}
</style>
@endif
<body class="fix-sidebar">
<!-- Preloader -->
<div class="preloader">
	<svg class="circular" viewBox="25 25 50 50">
	<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
	</svg>
</div>
<div id="wrapper">
	<!-- Top Navigation -->
	<nav class="navbar navbar-default navbar-static-top m-b-0">
	<div class="navbar-header">
		<div class="top-left-part">
		<!-- Logo -->
		<a class="logo hidden-pc" href="{{ url('/') }}">
			<img src="{{ asset('images/logo_sp.svg') }}" width="48px" alt="home" />
		</a>
		<a class="logo" href="{{ url('/') }}">

			<!-- Logo text image you can use text also --><span class="hidden-xs">
			<!--This is dark logo text--><img src="{{ asset('images/crluo_logo_light.svg') }}" width="110px" alt="home" class="dark-logo" />
			<!--This is light logo text--><img src="{{ asset('images/crluo_logo.svg') }}" width="110px" alt="home" class="light-logo" />
		</span> </a>
		</div>
		<!-- /Logo -->
		@include('partials.nav.top')
	</div>
	<!-- /.navbar-header -->
	<!-- /.navbar-top-links -->
	<!-- /.navbar-static-side -->
	</nav>
	<!-- End Top Navigation -->
	<!-- Left navbar-header -->
	@if (!$hideLeftBar)
	@include('partials.nav.left')
	@include('partials.modal')
	@endif
	<!-- Left navbar-header end -->
	<!-- Page Content -->
	<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row bg-title">
		@yield('content-header')
		</div>
		<!-- .row -->
		<div class="row">
		<div class="col-md-12">
			@include('flash::message')
			@yield('content')
		</div>
		</div>
		<!-- .row -->
	</div>
	<!-- /.container-fluid -->
	<footer class="footer text-center"> <?php echo date('Y'); ?> &copy; vivito inc. </footer>
	</div>
	<!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<!-- Bootstrap Core JavaScript -->
{{ Html::script('ample/bootstrap/dist/js/bootstrap.min.js') }}
<!-- Sidebar menu plugin JavaScript -->
{{ Html::script('ample/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}
<!--Slimscroll JavaScript For custom scroll-->
{{ Html::script('ample/js/jquery.slimscroll.js') }}
<!--Wave Effects -->
{{ Html::script('ample/js/waves.js') }}
<!-- Custom Theme JavaScript -->
{{ Html::script('ample/js/custom.js?v='.VERSION_CSS_JS) }}

{{ Html::script('js/crluo.js?v='.VERSION_CSS_JS) }}

@if(Auth::check())
{{--<script src="{{ asset('adminlte/js/app.min.js') }}"></script>--}}
<script src="{{ asset('js/common.js') }}"></script>
<script type="text/javascript">
	var userId = {{ Auth::id() }};
</script>
@if(config('app.env') !== 'local')
	<script type="text/javascript">
	var pusherKey = '{{ config("broadcasting.connections.pusher.key") }}';
	var pusherCluster = '{{ config("broadcasting.connections.pusher.options.cluster") }}';
	</script>
@else
	<script type="text/javascript" src="/socket.io/socket.io.js"></script>
@endif
<script type="text/javascript" src="{{ asset('js/chat.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/notification.js') }}"></script>
@endif
{{-- <script>
var _chaq = _chaq || [];
_chaq['_accountID']=2282;
(function(D,s){
	var ca = D.createElement(s)
	,ss = D.getElementsByTagName(s)[0];
	ca.type = 'text/javascript';
	ca.async = !0;
	ca.setAttribute('charset','utf-8');
	var sr = 'https://v1.chamo-chat.com/chamovps.js';
	ca.src = sr + '?' + parseInt((new Date)/60000);
	ss.parentNode.insertBefore(ca, ss);
})(document,'script');
</script> --}}
@stack('scripts')
</body>

</html>
