<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <style>
    * {
      font-family: Helvetica, Arial, sans-serif;
    }

    .demo1 {
      display: inline-block;
      padding: 15px 15px;
    / / border: solid 2 px #fff;
      border-radius: 3px;
      background: rgba(28, 165, 182, 0.5);
      color: #fff;
      text-decoration: none;
      font-weight: bold;
      font-family: Helvetica, Arial, sans-serif;
    }

    .demo1:hover {
      color: #fff;
      background: rgba(28, 165, 182, 0.8);;
    }

    a[href^="mailto:"] {
      color: #fff;
      text-decoration: underline;
    }

    a.original:link {
      color: #ffffff;
      text-decoration: underline;
      font-weight: bold;
    }

    a.original:visited {
      color: #ffffff;
      text-decoration: underline;
      font-weight: bold;
    }

    #main {
      width: 100%;
      color: #efefef;
      background-color: #333;
    }

    .title-logo-left {
      padding: 15px;
    }

    .mail-compe-image {
      text-align: center;
    }

    .content-compe-head {
      color: #333;
      background-color: #efefef;
      padding-top: 60px;
      padding-left: 60px;
      padding-right: 60px;
      padding-bottom: 40px;
      width: 80%;
      margin: 0 auto;
    }

    .content-main {
      color: #333;
      background-color: #efefef;
      padding-right: 60px;
      padding-left: 60px;
      padding-bottom: 60px;
      padding-top: 60px;
      width: 80%;
      margin: 0 auto;
    }

    .mail-footer {
      padding: 20px;

    }

    h1 {
      margin-bottom: 0;
      padding-bottom: 0;

    }

    p {
      margin-top: 0;
      padding-top: 0;
    }

  </style>
</head>
<body>
<div id="main">
  <div class="title-logo-left" style="display: inline-block; background-color: #367fa9; padding: 7px 30px; margin-bottom: 15px;">
    <img src="{{asset("images/crluo_logo_2.png")}}">
  </div>
  <br>
  @yield('content')
  <div class="mail-footer">
    <p>
      <a href="{{ route('home') }}" class="original">CRLUO</a>
      Powered by <strong>Vivito</strong><br>
      <a href="mailto:info@vi-vito.com" class="original">お問い合わせ</a>
    </p>
  </div>
</div>
</body>
</html>
