@extends('emails.layout-html')

@section('content')
{{ $roomName }}　にメッセージが到着しております。
クルオにログインの上、内容をご確認ください。 <br>
-------------------------------------- <br>
CRLUO　<a href="{{ route('login') }}">ログイン </a> <br>
-------------------------------------- <br>
@endsection
