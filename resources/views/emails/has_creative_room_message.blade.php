@extends('emails.layout-html')

@section('content')
{{ $creativeRoom->title }}　にメッセージが到着しております。
クルオにログインの上、内容をご確認ください。 <br>
-------------------------------------- <br>
CRLUO　ログイン <br>
--------------------------------------

@endsection
