@extends('emails.layout-html')

@section('content')

{{ $projectType }}「{{ $projectTitle }}」が公開されましたのでお知らせいたします。<br>
<br>
クルオにログインの上、内容をご確認ください。<br>
--------------------------------------  <br>
CRLUO　<a href="{{ route('login') }}">ログイン </a> <br>
--------------------------------------
@endsection
