<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>CCCCRLUO</title>

    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Orbitron:400' rel='stylesheet' type='text/css'>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    {{--script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>--}}
    {{--script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>--}}
    <!-- Scripts -->
    <script src="//code.jquery.com/jquery.js"></script>

    <!-- jQuery UI -->
    <link href="//ajax.googleapis.com/ajax/libs/jqueryui/1/themes/smoothness/jquery-ui.css" rel="stylesheet" />
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <!-- Optional theme
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">-->
    <!-- Latest compiled and minified JavaScript -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <!-- font Awesome -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/css/AdminLTE.css">

    <!-- User CSS -->
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/user.css') }}" rel="stylesheet">
    @stack('styles')
    <!--script src="/js/jquery.fileupload.js" type="text/javascript"></script-->
    <script src="{{ asset('/js/crluo.js') }}"></script>
    <!-- Global site tag (gtag.js) - Google AdWords: 815676858 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-815676858"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'AW-815676858');
    </script>
</head>
<body class="skin-black">
<div class="container-fluid">
  <div id="loading">
    <div id="loader"></div>
    <div class="progress">
      <div class="progress-bar ui-loader-progress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
      </div>
    </div>
  </div>
</div>
<header class="header">
  <a class="logo" href="{{ Auth::guest() ? url('/') : url('/home') }}"><img src="{{url('/images/crluo_black_small.png')}}"></a>
  <!-- Add the class icon to your logo image or logo icon to add the margining -->
  @include('partials.menu_top')
</header>
  <div class="wrapper row-offcanvas row-offcanvas-left">
@if (Auth::guest())
@else

  @include('partials.menu_left')
  <div class="modal fade" id="modalWindow" tabindex="-1" role="dialog" aria-labelledby="modalCompanyLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content  ">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modalCompanyLabel"></h4>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
        </div>
      </div>
    </div>
  </div>
  <script>

  (function($){
      /* delete  message popover  */
      $('a[data-toggle=popover]').popover();
      $.crluo.messageLoad($('#chatPopover, #infoPopover'));

      /* modal dialog */
      $('.ui-modal').click(function (){
          name = $(this).attr('data-procname');
          $('.modal-title', '#modalWindow').html($(this).html());
          $('div.modal-body', '#modalWindow').load('{{ url("/") }}'+name);
      });

      $('#modalWindow').on('hidden.bs.modal', function (e) {
          $('div.modal-body', '#modalWindow').html('');
      })

      /* send crluo */
      $('span.ui-modal-message').click(function (){
            $('.modal-title', '#modalWindow').html($(this).attr('data-title'));
            $('div.modal-body', '#modalWindow').load( $(this).attr('data-procname'));
      });

    })(jQuery);

  </script>
@endif
  <aside class="right-side @if (Auth::guest())strech @endif">
    <div class='container-fluid'>
    @if (Auth::guest())
    <br><br>
    @endif
    @yield('content')
    </div>
  </aside>
</div>


<!-- Bootstrap WYSIHTML5
<script src="/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>-->
<!-- iCheck
<script src="/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>-->
<!-- AdminLTE App -->
<script src="{{ asset('js/AdminLTE/app.js') }}"></script>
@stack('scripts')

</body>
</html>
