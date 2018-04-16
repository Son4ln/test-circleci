@extends('emails.layout-html')

@section('content')
<p>{{$inviter->name}}のProjectへご招待されましたので、お知らせいたします。<br>
  クルオにログインの上、ご確認ください。</p>
<br>
<p>--------------------------------------<br>
  CRLUO　ログイン<br>
  <a href="{{route('accept', ['email' => $invitee->email, 'token' => $token])}}">
    {{route('accept', ['email' => $invitee->email, 'token' => $token])}}</a><br>
  --------------------------------------</p>
@endsection
