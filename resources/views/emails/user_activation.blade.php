@extends('emails.layout-html')

@section('content')
  <p>クルオへのご登録ありがとうございます。</p>
  <p></p>
  <p>会員登録を完了するために、こちらのリンクからアクセスをお願いします。</p>
  <a href="{!! url(config('app.url').route('activate', compact('email', 'token'), false)) !!}">登録する</a>
@endsection
