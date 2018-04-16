@extends('emails.layout-html')

@section('content')
  <p>クルオをご利用いただき、ありがとうございます。<br>
    以下のリンクよりパスワード再設定手続きにお進みください。</p>
  <br>
  <p>--------------------------------------<br>
    CRLUO　パスワード再設定<br>
    <a href="{{route('password.reset', $token)}}">{{route('password.reset', $token)}}</a><br>
    --------------------------------------</p>
  <br>
  <p>■このメールに覚えのない方<br>
    他のお客様が誤ってメールアドレスを入力し、メールが誤配信された可能性がございます。<br>
    お手数ですが、このメールは破棄していただきますようお願いいたします。</p>
@endsection
