@extends('emails.layout-html')

@section('content')
{{ $userName }}様より仕事依頼「{{ $projectTitle }}」が登録されました。
管理者が内容確認の上、公開となります。 <br>
クルオにログインの上、ご確認ください。 <br>
-------------------------------------- <br>
CRLUO　<a href="{{ route('login') }}">ログイン</a> <br>
--------------------------------------
@endsection
