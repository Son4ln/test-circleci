@extends('emails.layout-html')

@section('content')
  <h3>{{ $name }} 様</h3>

  <h4>こんにちは。crluo(クルオ)です。</h4>

  crluoに登録されている{{ $name }}様のメールアドレス変更手続きを行いました。 <br>
  再度ログインいただき、ご確認よろしくお願いいたします。 <br>

  ※メールアドレス変更をリクエストされていない場合は、本メールを削除してください。 <br>
  他の方がメールアドレスを間違って入力したため本メールが送信された可能性があります。 <br>
  心当たりなく何通もメールが届く場合には、下記お電話番号までご連絡ください。 <br>
  株式会社vivito <br>
  crluo(クルオ)運営事務局 <br>
  03-6383-4725 <br>
  <a href="https://app.crluo.com">https://app.crluo.com</a>
@endsection
