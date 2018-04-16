@extends('emails.layout-html')

@section('content')
{{ $userName }}様のデポジット入金をお知らせいたします。 <br>
クルオにログインの上、ご確認ください。 <br>
--------------------------------------  <br>
CRLUO　<a href="{{ route('login') }}">ログイン</a> <br>
--------------------------------------
@endsection
